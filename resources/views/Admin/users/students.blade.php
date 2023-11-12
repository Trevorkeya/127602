@extends('layouts.master')

@section('title', 'Students')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message')}}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Students</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Admission Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date of Birth</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->admission_number }}</td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->user->email }}</td>
                                    <td>{{ $student->date_of_birth }}</td>
                                    <td>{{ $student->phone_number }}</td>
                                    <td>
                                        <a href="{{ url('admin/students/' . $student->id . '/edit') }}" class="btn btn-sm btn-success">Edit</a> 
                                        <a href="{{ url('admin/students/' . $student->id . '/destroy') }}" onclick="return confirm('Are you sure you want to delete Student?')" class="btn btn-sm btn-danger">Delete</a> 
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No Students Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{$students->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
