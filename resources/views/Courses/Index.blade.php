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
        height: 180px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        text-align: left;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
        justify-content: center; /* Vertical centering */
        background-size: cover;
        
        
    }

    .course-image {
    background-size: cover;
    background-position: center;
    border-radius: 8px 8px 0 0; 
    height: 70%; 
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5); 
        pointer-events: none;
    }

    .course-card a {
        display: block;
        text-decoration: none;
        color: #E8E8E8;
        margin-bottom: 10px;
        z-index: 0;
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
        padding-bottom:5px;
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
        background-color: #f9f9f9;
        min-height: 47px; /* Set a minimum height to the course-options */

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
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <a href="{{ url('/course/create')}}" class= "float-end"> 
    @if(auth()->user()->type === 'admin' || auth()->user()->type === 'instructor')
        <span class="material-symbols-outlined">
            add_circle
        </span>
    @endif
    </a>
    
    <div class="course-container">
        @foreach($courses as $key => $course)
            <div class="course-card" style="background-image: url('{{ asset('storage/' . $course->background_image) }}');">
            <div class="overlay"></div> 
                <a href="{{ route('courses.show', $course->id) }}">
                    <h5>{{ $course->course_code }}</h5>
                    <h5>{{ $course->title }}</h5>
                    <h6>{{ $course->creator->name }}</h6>
                </a></br>
                <div class="course-options">
                @if(auth()->check() && auth()->user()->type === 'user' && !$course->users->contains(auth()->user()))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enrollModal{{ $course->id }}">
                        Enroll
                    </button>
                    <!-- Enroll Modal -->
                    <div class="modal fade" id="enrollModal{{ $course->id }}" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="enrollModalLabel">Enrollment Key</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('enroll', $course->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="enrollmentKey" class="form-label">Enter Enrollment Key:</label>
                                            <input type="text" class="form-control" id="enrollmentKey" name="enrollment_key" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Enroll</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Enroll Modal -->
                @endif
                @if(auth()->user()->id === $course->user_id || auth()->user()->type === 'admin')

                    <a  href="{{ route('courses.edit', $course->id) }}"><span class="material-symbols-outlined">edit</span></a>
                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete?')"><span class="material-symbols-outlined">delete_forever</span></button>
                    </form>
                @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection