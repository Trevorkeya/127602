@extends('layouts.Main')

@section('title', 'E-Learning Library')

@section('content')

<style>
    .course-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin: 20px 0;
    }

    .course-card {
        position: relative;
        width: 30%; 
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        text-align: center;
        background-color: #f9f9f9;
    }

    .course-card a {
        display: block;
        text-decoration: none;
        color: #333;
        margin-bottom: 10px;
    }

    .course-card a:hover {
        color: #007bff;
    }

    .course-options {
        display: flex;
        flex-wrap: wrap; 
        justify-content: flex-end; 
        align-items: flex-end; 
        gap: 10px; 
        border-top: 1px solid #ccc;
        padding-top: 10px;
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        width: calc(100% - 20px);
    }

    .course-options a, 
    .course-options button {
        text-decoration: none;
        margin: 0 5px;
        color: #007bff;
        cursor: pointer;
        display: inline-flex;
        align-items: center; 
        gap: 5px; 
    }

    .course-options button {
        background: none;
        border: none;
        align-self: flex-end;
    }
</style>

<div class="container">
   <a href="{{ url('/courses/create')}}" class="float-end">
        <span class="material-symbols-outlined">
            add_circle
        </span>
    </a>
    <div class="course-container">
        @foreach($courses as $key => $course)
            <div class="course-card">
                <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></br>
                <div class="course-options">
                    <a  href="{{ route('courses.edit', $course->id) }}"><span class="material-symbols-outlined">edit</span></a>
                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete?')"><span class="material-symbols-outlined">delete_forever</span></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection