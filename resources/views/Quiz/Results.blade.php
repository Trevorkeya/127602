@extends('layouts.Main')

@section('title', 'Quiz')

@section('content')
    <div class="container mt-4">
        <h1>Quiz Result</h1>
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Score: {{ $score }} / {{ $totalQuestions }}</h5>
                
                <!-- Additional content based on your application's needs -->
                
                <!-- Example: Display quiz details -->
                @if (isset($quiz))
                    <p>Quiz Details:</p>
                    <ul>
                        <li>Quiz Name: {{ $quiz->name }}</li>
                        <!-- Add more details as needed -->
                    </ul>
                @endif
            </div>
        </div>
        
        <!-- You can add more content here based on your application's needs -->
    </div>
@endsection