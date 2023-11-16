@extends('layouts.Main')

@section('title', 'Edit Profile')

@section('content')

<div>
    <div class="container">
        
        @if(session('messsage'))
             <p class="alert alert-success">{{ session('message') }}</p>
        @endif

        @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        <div class="row">
            <div class="card shadow">
                <div class="card-header bg-success">
                    Profile
                </div>
                <div class="card-body">
                        <form action="{{ url('/profile/update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Username</label>
                                        <input type="text" name="username" value="{{ Auth::user()->name}}" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Email Address</label>
                                        <input type="text"readonly value="{{ Auth::user()->email}}" class="form-control"/>
                                    </div>
                                </div>

                                {{-- Render these fields only for students --}}
                                @if(Auth::user()->type == 'user')
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Admission Number</label>
                                            <input type="text" readonly value="{{ Auth::user()->student->admission_number ?? '' }}" class="form-control"/>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Phone number</label>
                                        <input type="text" name="phone" value="{{ Auth::user()->profile->phone ?? ''}}" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="image">
                                        <label for="image">Add image</label>
                                        <input type="file" class="form-control" name="image" id="image" required>
                                    </div>
                                </div>
                                <div class="c0l-md-12">
                                    <button type="submit" class="btn btn-success">Save Profile</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
