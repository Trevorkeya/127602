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
                    <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm float-end">
                        Add Course
                    </a>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->course_code }}</td>
                                    <td>{{ $course->title }}</td>
                                    <td>
                                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-success">Edit</a>
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this course?')" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No Courses Available</td>
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