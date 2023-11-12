<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create($quizId)
    {
        $quiz = Quiz::find($quizId);
        return view('Quiz.addQuestions', compact('quiz'));
    }

    public function store(Request $request, $quizId){

        $request->validate([
            'questions' => 'required|array',
            'questions.*' => 'required|string',
            'answers' => 'required|array',
            'correctAnswers' => 'required|array',
        ]);

        $quiz = Quiz::find($quizId);

        foreach ($request->input('questions') as $index => $questionText) {
            $question = $quiz->questions()->create([
                'question' => $questionText,
            ]);
        
            if (
                isset($request->input('answers')[$index]) &&
                isset($request->input('correctAnswers')[$index])
            ) {
                foreach ($request->input('answers')[$index] as $answerIndex => $answerText) {
                    $question->answers()->create([
                        'answer' => $answerText,
                        'is_correct' => $answerIndex == $request->input('correctAnswers')[$index],
                    ]);
                }
            }
        }

        return redirect()->route('quizzes.show', $quizId);
    }

    
}
