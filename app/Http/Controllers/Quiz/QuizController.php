<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Quiz;
use App\Models\Topic;
use App\Models\Course;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function create($courseId, $topicId){

        $topic = Topic::find($topicId);
        $course = Course::find($courseId);
        return view('Quiz.Create', compact('topic', 'course'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'topic_id' => 'required',
            'course_id' => 'required',
            'status' => 'required|in:active,deactivated',
            'max_attempts' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create($request->all());

        return redirect()->route('quizzes.show', $quiz->id);
    }

    public function show(Quiz $quiz){

        $userAttempts = $quiz->quizResults()->where('user_id', auth()->id())->count();

        if ($userAttempts >= $quiz->max_attempts) {
            return redirect()->route('quizzes.maxAttemptsReached', ['quiz' => $quiz->id]);
        }

        $quiz->load('questions.answers');

        return view('Quiz.Show', compact('quiz'));
    }

    public function finish(Request $request, $quizId)
    {
        // Get the selected answers from the form
        $selectedAnswers = $request->input('answers');

        // Get the correct answers from the database
        $correctAnswers = DB::table('answers')
            ->whereIn('id', $selectedAnswers)
            ->where('is_correct', true)
            ->pluck('id');

        // Calculate the user's score
        $score = count($correctAnswers);

        // Save the score to the database
        QuizResult::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quizId,
            'score' => $score,
        ]);

        // Redirect to a result page or do any other action
        return redirect()->route('quizzes.result', ['quizId' => $quizId, 'score' => $score]);
    }

    public function result(Request $request, $quizId, $score)
    {
        $quiz = Quiz::findOrFail($quizId);
        $totalQuestions = $quiz->questions->count();
        $courseId = $quiz->topic->course->id; 

        return view('Quiz.Results', compact('quizId', 'score', 'quiz', 'totalQuestions','courseId'));
    }

    public function userResults($courseId)
{
    $user = auth()->user();
    $course = Course::findOrFail($courseId);
    $course->load('topics.quizzes', 'quizzes');

    $results = [];

    foreach ($course->quizzes as $quiz) {
        $latestResult = $user->quizResults()
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('created_at')
            ->first();

        if ($latestResult) {
            $results[] = [
                'quiz' => $quiz,
                'score' => $latestResult->score,
                'totalQuestions' => $quiz->questions->count(),
            ];
        }
    }

    return view('Quiz.QuizResults', compact('results','user', 'course'));
}



}
