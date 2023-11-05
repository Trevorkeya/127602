@extends('layouts.Main')

@section('title', 'Home')

@section('content')
<div class="container">
    <h2>Create New Topic for Course: {{ $course->title }}</h2>

    <form action="{{ route('topics.store', $course->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Topic Title:</label>
            <input type="text" name="title" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create Topic</button>
    </form>
</div>
@endsection
