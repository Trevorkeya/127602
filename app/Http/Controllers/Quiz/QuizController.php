<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Topic;
use App\Models\Course;
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

        return redirect()->route('questions.create', $quiz->id);
    }

    public function show($id){
        $quiz = Quiz::with('questions.answers')->find($id);
        return view('Quiz.Show', compact('quiz'));
    }

    public function finish(Request $request, $id){
        $quiz = Quiz::with('questions.answers')->find($id);

        // Validate if all questions have been answered
        $request->validate([
            'answers.*' => 'required',
        ]);

            // Initialize variables for score calculation
            $totalQuestions = $quiz->questions->count();
            $correctAnswers = 0;

            // Check each question's correct answer
            foreach ($quiz->questions as $question) {
            $userAnswer = $request->input('answers.' . $question->id);

            // Check if the user's answer is correct
            if ($question->answers->where('id', $userAnswer)->first()->is_correct) {
                $correctAnswers++;
            }
        }

        // Calculate the score
        $score = ($correctAnswers / $totalQuestions) * 100;

        // Additional logic if needed (e.g., storing the user's answers)

        return view('quizzes.finish', compact('quiz', 'score', 'totalQuestions'));
    }
}
