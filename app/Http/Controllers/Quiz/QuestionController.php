<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create($quizId)
    {
        $quiz = Quiz::find($quizId);
        return view('Quiz.addQuestions', compact('quiz'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'answers.*.answer' => 'required|string', 
        ]);

        // Store the question
        $question = Question::create([
            'quiz_id' => $request->input('quiz_id'),
            'question' => $request->input('question'),
        ]);

        // Store the answers
        foreach ($request->input('answers') as $answerData) {
            $answer = Answer::create([
                'question_id' => $question->id,
                'answer' => $answerData['answer'],
                'is_correct' => isset($answerData['is_correct']),
            ]);
            
            if (isset($answerData['is_correct']) && $answerData['is_correct']) {
                $question->answers()->where('id', '<>', $answer->id)->update(['is_correct' => false]);
            }
        }

        return back();
    }


    
}
