@extends('layouts.master')

@section('title', 'Course Results')

@section('content')
    <h3>Course Results</h3>

    @foreach($results as $courseData)
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Course: {{ $courseData['course']->title }}</h4>
            </div>
            
            @if(count($courseData['quizResults']) > 0)
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student</th>
                                @foreach($courseData['quizResults'] as $quizResult)
                                    <th>{{ $quizResult['quiz']->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courseData['enrolledUsers'] as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    @foreach($courseData['quizResults'] as $quizResult)
                                        <td>{{ $quizResult['results']->where('user', $user)->first()['score'] ?? '' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-body">
                    <p class="mb-0">No quizzes available for this course. No students attempted.</p>
                </div>
            @endif
        </div>
    @endforeach
@endsection
