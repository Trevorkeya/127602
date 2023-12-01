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
                <h3>Instructors</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($instructors as $instructor)
                                <tr>
                                <td>{{ $instructor->user->id }}</td>
                                <td>{{ $instructor->user->name }}</td>
                                <td>{{ $instructor->user->email }}</td>
                                <td>
                                    <a href="{{ url('admin/instructors/'.$instructor->id.'/edit') }}" class="btn btn-sm btn-success">Edit</a>
                                    <a href="{{ url('admin/instructors/destroy/'.$instructor->id.'/destroy') }}" onclick="return confirm('Are you sure you want to delete this Instructor?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </a>
                                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No Instructors Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $instructors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
