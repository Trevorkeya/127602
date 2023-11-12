@extends('layouts.Main')

@section('title', 'Create Quiz')

@section('content')

<div class="container">
@if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
        @endif

    <h2>Create Quiz</h2>
    <form action="{{ url('quizzes') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name">Quiz Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="deactivated">Deactivate</option>
            </select>
        </div>

        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        
        <button type="submit" class="btn btn-primary">Create Quiz</button>
    </form>
  </div>

@endsection
