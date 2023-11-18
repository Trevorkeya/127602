@extends('layouts.Main')

@section('title', 'Home')

@section('content')

<style>
    .course-details {
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
        margin-top: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .course-detail {
        background: #5c8ab9;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .topic-heading {
        margin-bottom: 10px;
    }

    .topic-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .topic-title h3 {
        margin: 0;
    }

    .topic-dropdown {
        display: none;
    }

    .topic-dropdown.active {
        display: block;
        margin-top: 10px;
    }

    .topic-dropdown ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .topic-dropdown ul li {
        padding: 5px 0;
    }

    .topic-dropdown ul li a {
        text-decoration: none;
        color: #333;
    }

    .topic-dropdown ul li a:hover {
        color: #007bff;
    }
    .course-m{
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
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
    <div class="course-details">
        <h2>{{ $course->course_code }} {{ $course->title }}</h2>
        <p>{{ $course->description }}<a href="{{ url('courses/'.$course->id.'/topics/create')}}" class="float-end">
            <span class="material-symbols-outlined">
                add_circle
            </span>
        </a></p>
        
    </div>
    <div class="course-detail">
        @foreach ($course->topics as $topic)
          <div class="course-details">
            <div class="topic-heading">
                <div class="topic-title">
                    <span class="material-symbols-outlined topic-dropdown-toggle"><h3>{{ $topic->title }}</h3></span>
                </div>
                
                <div class="topic-dropdown">
                <a href="{{ route('topics.addMaterials', ['course' => $course->id, 'topic' => $topic->id]) }}" class="float-end">
                    <span class="material-symbols-outlined">add_circle</span>
                </a>
                <!-- Modal Trigger-->
                <a href="#" class="float-end" data-bs-toggle="modal" data-bs-target="#createQuizModal{{ $topic->id }}">
                    <span class="material-symbols-outlined">new_window</span>
                </a>
                <!-- Quiz Modal -->
                 <div class="modal fade" id="createQuizModal{{ $topic->id }}" tabindex="-1" aria-labelledby="createQuizModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createQuizModalLabel">Create Quiz</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <!-- Quiz create form -->
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
                                    <div class="mb-3">
                                        <label for="max_attempts">Maximum Attempts</label>
                                        <input type="number" name="max_attempts" class="form-control" min="1" value="1" required>
                                    </div>

                                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
        
                                    <button type="submit" class="btn btn-primary">Create Quiz</button>
                                </form>
                            </div>
                        </div>
                    </div>
                 </div>   
                <!-- Quiz Modal -->        
                <ul>
                    @forelse ($topic->materials as $material)
                        <li>
                            <div class="course-m">
                                @if($material->type === 'pdf')
                                    <a class="" href="#" onclick="viewPDF('{{ asset($material->file_path) }}')">
                                        {{ $material->title }}. {{ $material->type }}
                                    </a>
                                @else
                                    <a class="" href="{{ asset($material->file_path) }}" target="_blank">
                                        {{ $material->title }}. {{ $material->type }}
                                    </a>
                                @endif
                            </div>
                        </li>
                        @empty
                            <li>No materials added for this topic</li>
                    @endforelse
    
                    @foreach ($topic->quizzes as $quiz)
                        <li>
                            <div class="course-m">
                                <a href="{{ route('quizzes.show', $quiz->id) }}">{{ $quiz->name }}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
          </div>
        @endforeach
    </div>
</div>

<script>
    const dropdownToggles = document.querySelectorAll('.topic-dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const dropdown = this.parentElement.nextElementSibling;
            dropdown.classList.toggle('active');
        });
    });
</script>

@endsection
