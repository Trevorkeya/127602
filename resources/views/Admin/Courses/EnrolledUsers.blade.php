<!-- EnrolledUsers.blade.php -->
@extends('layouts.master')

@section('title', 'Enrolled Users')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Enrolled Users for Course: {{ $course->course_code }} - {{ $course->title }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($enrolledUsers as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <!-- Add more columns as needed -->
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No Enrolled Users for this Course</td>
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
