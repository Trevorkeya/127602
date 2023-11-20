@extends('layouts.Main')

@section('title', 'Profile page')

@section('content')

<div>
  <div class="container py-5" style="background-color: #eee;">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
          @if (Auth::user()->profile && Auth::user()->profile->image)
            <img src="{{ asset('storage/images/'.Auth::user()->profile->image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid" style="width: 150px;">
          @endif
            <h5 class="my-3">{{ Auth::user()->name}}</h5>
            <p class="text-muted mb-1"></p>
            <div class="d-flex justify-content-center mb-2">
              <a href="{{ url('profile/edit')}}" class="btn btn-warning">Edit profile</a>
              <button type="button" class="btn btn-outline-warning ms-1">Message</button>
            </div>
          </div>
        </div>
        
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ Auth::user()->name}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ Auth::user()->email}}</p>
              </div>
            </div>
            <hr>

            {{-- Render these fields only for students --}}
            @if(Auth::user()->type == 'user')
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Admission Number</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ Auth::user()->student->admission_number ?? ''}}</p>
                    </div>
                </div>
                <hr>
            @endif

            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                @if(Auth::user()->type == 'user')
                    <p class="text-muted mb-0">{{ Auth::user()->profile->student->phone_number ?? ''}}</p>
                @elseif(Auth::user()->type == 'instructor')
                    <p class="text-muted mb-0">{{ Auth::user()->profile->instructor->phone_number ?? ''}}</p>
                @elseif(Auth::user()->type == 'admin')
                    <p class="text-muted mb-0">{{ Auth::user()->profile->administrators->phone_number ?? ''}}</p>
                @else
                    <p class="text-muted mb-0">Phone number not available</p>
                @endif
              </div>
            </div>
            <hr>
          </div>
        </div>

        {{-- Display Quiz Results for User --}}
        @if(Auth::user()->type == 'user')
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">Quiz Results</h5>

            @foreach($user->courses as $course)
            <h6 class="mt-3">{{ $course->name }}</h6>

            @foreach($course->quizzes ?? [] as $quiz)
              @php
                $latestResult = $user->quizResults()
                  ->where('quiz_id', $quiz->id)
                  ->orderByDesc('created_at')
                  ->first();
              @endphp

              @if($latestResult)
                <div class="row">
                  <div class="col-sm-6">
                    <p class="mb-0">{{ $quiz->name }}</p>
                  </div>
                  <div class="col-sm-6">
                    <p class="text-muted mb-0">Results: {{ $latestResult->score }} / {{ $quiz->questions->count() }}</p>
                  </div>
                </div>
                <hr>
              @endif
            @endforeach

            @endforeach

           
          </div>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>

@endsection
