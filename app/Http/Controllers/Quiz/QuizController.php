<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Quiz;
use App\Models\Topic;
use App\Models\Course;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

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
    public function maxAttemptsReached(Quiz $quiz)
    {
        return view('Quiz.MaxAttemptsReached', compact('quiz'));
    }

    public function finish(Request $request, $quizId)
    {
        $selectedAnswers = $request->input('answers');

        $correctAnswers = DB::table('answers')
            ->whereIn('id', $selectedAnswers)
            ->where('is_correct', true)
            ->pluck('id');

        $score = count($correctAnswers);

        QuizResult::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quizId,
            'score' => $score,
        ]);

        $userMessage = "I completed the quiz with a score of $score";
       $response = Http::post('http://127.0.0.1:5000/ask', ['message' => $userMessage]);

       if ($response->successful()) {
           $botResponse = $response->json('response');
       } else {
        // Log the error for debugging
        \Log::error("Error in communication with Flask server: " . $response->body());
        $botResponse = "Error communicating with the chatbot server.";
       }

        return redirect()->route('quizzes.result', ['quizId' => $quizId, 'score' => $score, 'botResponse' => $botResponse]);
    }

    public function result(Request $request, $quizId, $score)
    {
        $quiz = Quiz::findOrFail($quizId);
        $totalQuestions = $quiz->questions->count();
        $courseId = $quiz->topic->course->id; 

        $botResponse = $request->input('botResponse');

        return view('Quiz.Results', compact('quizId', 'score', 'quiz', 'totalQuestions','courseId','botResponse'));
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

   public function courseResults()
   {
    $courses = Course::with('quizzes', 'users')->get();

    $results = collect();

    foreach ($courses as $course) {
        $courseData = [
            'course' => $course,
            'enrolledUsers' => $course->users,
            'quizResults' => $this->getQuizResultsForCourse($course),
        ];

        $results->push($courseData);
    }

    return view('Quiz.CourseResults', compact('results'));
   }

   private function getQuizResultsForCourse(Course $course)
   {
    $quizResults = collect();

    foreach ($course->quizzes as $quiz) {
        $quizResultsData = [
            'quiz' => $quiz,
            'results' => $this->getQuizResultsForQuiz($course, $quiz),
        ];

        $quizResults->push($quizResultsData);
    }

    return $quizResults;
   }

   private function getQuizResultsForQuiz(Course $course, Quiz $quiz)
   {
    $results = collect();

    foreach ($course->users as $user) {
        $latestResult = $user->quizResults()
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('created_at')
            ->first();

        $results->push([
            'user' => $user,
            'score' => $latestResult ? $latestResult->score : null,
        ]);
    }

    return $results;
   }

   public function getQuizResult(Request $request)
   {
    $user_name = $request->input('user_name');
    $quiz_result = QuizResult::where('user_name', $user_name)->orderBy('created_at', 'desc')->first();

    return response()->json($quiz_result);
   }
}
