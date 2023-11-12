@extends('layouts.Main')

@section('title', 'Home')

@section('content')
<style>
    .containers {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh; /* Adjusted the height */
        margin: 0 auto;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 80%; /* Set the width of the container */
        max-width: 600px; /* Add a max-width for responsiveness */
        margin-top: 50px; /* Added margin-top for better positioning */
    }

    .containers form {
        width: 100%; /* Make the form width 100% */
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .containers form input,
    .containers form textarea {
        margin-bottom: 10px;
        width: 100%; /* Make inputs and textarea width 100% */
        box-sizing: border-box; /* Include padding and border in the element's total width and height */
    }

    .containers form button {
        width: 100%;
        padding: 8px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background: #27ae60;
        color: #fff;
    }

    .containers form button:hover {
        background: #219d53;
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