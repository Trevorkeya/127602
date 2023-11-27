@extends('layouts.Main')

@section('title', 'Quiz')

@section('content')
    <div class="container mt-4">
        <h1>Quiz Result</h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Score: {{ $score }} / {{ $totalQuestions }}</h5>
                
                
                @if (isset($quiz))
                    <p>Quiz Details:</p>
                    <ul>
                        <li>Quiz Name: {{ $quiz->name }}</li>
                    </ul>
                @endif

                <h3>Chatbot Feedback:</h3>
                <p>{{ $botResponse }}</p>

            </div>
            @if (isset($courseId))
                <a href="{{ route('courses.show', $courseId) }}" class="btn btn-primary">Back to Course</a>
            @endif
        </div>
        
    </div>
@endsection