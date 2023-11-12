@extends('layouts.Main')

@section('title', 'Quiz Result')

@section('content')

<div class="container">
    <h2>Quiz Result</h2>
    <p>You scored: {{ $score }} out of {{ $totalQuestions }}</p>
    <a href="{{ route('courses.show', $quiz->topic->course->id) }}" class="btn btn-primary">Proceed to Course</a>
</div>

@endsection
