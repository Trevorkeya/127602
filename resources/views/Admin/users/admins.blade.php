@extends('layouts.master')

@section('title', 'Administrators')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message')}}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Admins</h3>
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
                            @forelse ($administrators as $administrator)
                                <tr>
                                    <td>{{ $administrator->id }}</td>
                                    <td>{{ $administrator->user->name }}</td>
                                    <td>{{ $administrator->user->email }}</td>
                                    <td>{{ $administrator->phone_number }}</td>
                                    <td>
                                        <a href="{{ url('admin/administrators/' . $administrator->id . '/edit') }}" class="btn btn-sm btn-success">Edit</a> 
                                        <a href="{{ url('admin/administrators/' . $administrator->id . '/destroy') }}" onclick="return confirm('Are you sure you want to delete Student?')" class="btn btn-sm btn-danger">Delete</a> 
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No Administrators Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{$administrators->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
