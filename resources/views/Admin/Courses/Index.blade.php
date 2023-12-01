@extends('layouts.master')

@section('title', 'Courses')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success')}}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Courses
                    <a href="{{ url('/course/create') }}" class="btn btn-primary btn-sm float-end">
                        Add Course
                    </a>
                    <a href="{{ route('courses.generate-pdf') }}" class="btn btn-info btn-sm">Generate PDF</a>
                    <a href="{{ route('view-pdf') }}" class="btn btn-success btn-sm">View PDF</a>
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Code</th>
                                <th>Title</th>
                                <th>Enrollment key</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td><a href="{{ url('/courses/'.$course->id.'/topics/table') }}" class="btn">{{ $course->course_code }}</a></td>
                                    <td><a href="{{ route('courses.enrolled-users', $course->id) }}" class="btn">{{ $course->title }}</a></td>
                                    <td>{{$course->enrollment_key}}</td>
                                    <td>{{ $course->status ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                    @if(auth()->user()->id === $course->user_id || auth()->user()->type === 'admin')

                                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-success">Edit</a>
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this course?')" class="btn btn-sm btn-danger">Delete</button>
                                        </form>

                                        <!-- Button to toggle course status -->

                                        <a href="{{ route('courses.toggle-status', $course->id) }}" class="btn btn-warning btn-sm" onclick="event.preventDefault(); document.getElementById('toggle-status-form{{ $course->id }}').submit();">
                                            {{ $course->status ? 'Deactivate' : 'Activate' }}
                                        </a>
                                        <form id="toggle-status-form{{ $course->id }}" action="{{ route('courses.toggle-status', $course->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Courses Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
