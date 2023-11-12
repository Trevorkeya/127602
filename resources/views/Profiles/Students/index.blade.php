@extends('layouts.Main')

@section('title', 'Profile page')

@section('content')

<div style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        @if (Auth::user()->profile && Auth::user()->profile->image)
                            <img src="{{ asset('images/'.(Auth::user()->profile->image) ) }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid" style="width: 150px;">
                        @endif
                        <h5 class="my-3">{{ Auth::user()->name }}</h5>
                        <!-- You may modify the displayed information as per your needs -->
                        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                        <p class="text-muted mb-4">{{ Auth::user()->student->phone_number ?? '' }}</p>
                        <div class="d-flex justify-content-center mb-2">
                            <a href="{{ url('/student/{id}/edit') }}" class="btn btn-warning">Edit profile</a>
                            <button type="button" class="btn btn-outline-warning ms-1">Message</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Display student details -->
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Date of Birth</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ Auth::user()->student->date_of_birth ?? '' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ Auth::user()->student->phone_number ?? '' }}</p>
                            </div>
                        </div>
                        <!-- You can include other fields as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
