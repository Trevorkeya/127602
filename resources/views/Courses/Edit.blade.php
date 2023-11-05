@extends('layouts.Main')

@section('title', 'Home')

@section('content')
<style>
    .containers {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;

    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1)
   }
</style>

<div class="containers">
    <form action="{{ route('courses.update', $course->id) }}" method="post">
        @csrf
        @method('PUT')
        <input type="text" name="course_code" value="{{ $course->course_code }}">
        <textarea name="description">{{ $course->description }}</textarea>
        <input type="text" name="title" value="{{ $course->title }}">
        <button type="submit">Update Course</button>
    </form>
</div>

@endsection