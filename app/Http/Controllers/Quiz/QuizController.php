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
        ]);

        $quiz = Quiz::create($request->all());

        return redirect()->route('quizzes.show', $quiz->id);
    }

    public function show(Quiz $quiz){

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

        return view('Quiz.Results', compact('quizId', 'score', 'quiz', 'totalQuestions'));
    }

}
