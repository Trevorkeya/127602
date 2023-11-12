@extends('layouts.Main')

@section('title', 'Quiz')

@section('content')

<div class="container">
@if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    <h2>{{ $quiz->name }}</h2>
    <p>Status: {{ $quiz->status }}</p>

    <h3>Questions</h3>
    <form action="{{ route('quizzes.finish', $quiz->id) }}" method="POST">
        @csrf
        @foreach($quiz->questions as $question)
            <fieldset>
                <legend>{{ $question->question }}</legend>
                @foreach($question->answers as $answer)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" required>
                        <label class="form-check-label">{{ $answer->answer }}</label>
                    </div>
                @endforeach
            </fieldset>
        @endforeach

        <button type="submit" class="btn btn-primary">Finish Quiz</button>
    </form>
</div>

@endsection
