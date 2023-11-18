@extends('layouts.Main')

@section('title', 'Max Attempts Reached')

@section('content')
    <div class="container">
        <div class="alert alert-warning">
            <h4 class="alert-heading">Maximum Attempts Reached!</h4>
            <p>You have reached the maximum allowed attempts for this quiz. If you have any concerns, please contact the administrator.</p>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>

    </div>
@endsection
