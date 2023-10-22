@extends('layouts.master')

@section('title', 'Edit User')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message')}}</div>
        @endif

        @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach ($errors->all() as $error)
                   <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Edit Users
                    <a href="{{ url('admin/users')}}" class="btn btn-danger btn-sm float-end">
                        Back
                    </a>
                </h3>
            </div>
            <div class="card-body">

                <form action="{{ url('admin/users/'.$user->id) }}" method="post">
                @csrf
                @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control"/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="text" name="email" readonly value="{{ $user->email }}" class="form-control"/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control"/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Select Role</label>
                            <select name="type" class="form-control">
                                <option value="">Select Role</option>
                                <option value="0" {{ $user->type== '0' ? 'selected':'' }} >User</option>
                                <option value="1" {{ $user->type== '1' ? 'selected':'' }} >Admin</option>
                                <option value="2" {{ $user->type== '2' ? 'selected':'' }}>Instructor</option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection