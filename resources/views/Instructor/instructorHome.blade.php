@extends('layouts.Main')

@section('title', 'Home')

@section('content')
    <!-- Hero Image Start -->
    <div class="hero-image">
        <div class="overlay"></div> 
        <img src="{{ asset('images/carousel-3.png') }}" alt="Hero Image">
        <div class="hero-text">
            <h1>Welcome to Our E-Learning Platform</h1>
            <p>Discover a World of Knowledge at Your Fingertips</p>
        </div>
    </div>
    <!-- Hero Image End -->

    <!-- About Us Section Start -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h2 class="mb-4" style="color: #007bff; font-weight: bold;">About Us</h2>
                <p>
                    Welcome to our innovative e-learning platform, where we believe that education should be accessible to everyone, everywhere. 
                    Our mission is to provide a diverse range of high-quality courses, taught by industry experts, to empower you on your learning journey.
                </p>
                <p>
                    Whether you're a student, a professional looking to upskill, or someone eager to explore new interests, our platform offers a dynamic and 
                    engaging learning experience. Join us and embark on a path of continuous growth and knowledge acquisition.
                </p>
            </div>
        </div>
    </div>
    <hr>
    <!-- About Us Section End -->

    <!-- Featured Courses Section Start -->
    <div class="container mt-5">
        <h2 class="text-center mb-4" style="color: #007bff; font-weight: bold;">Featured Courses</h2>
        <div class="row">

            @php
                // Retrieve up to three active courses ordered by enrollment count
                $featuredCourses = App\Models\Course::withCount('users')
                    ->where('status', true)
                    ->orderByDesc('users_count')
                    ->take(3)
                    ->get();
            @endphp

            @foreach ($featuredCourses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card fade-in">
                        <img src="{{ asset('storage/' . $course->background_image) }}" class="card-img-top" alt="Course Image">
                        <div class="card-body">
                            <h5 class="card-title" href="/courses">{{ $course->title }}</h5>
                            <p class="card-text"><small class="text-muted">Creator: {{ $course->creator->name }}</small></p>
                            <p class="card-text"><small class="text-muted">Enrollments: {{ $course->users_count }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <hr>
    <!-- Featured Courses Section End -->

    <!-- Contact Us Section Start -->
<div class="container mt-5">
    <h2 class="text-center mb-4" style="color: #007bff; font-weight: bold;">Contact Us</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf

                <!-- Name Input -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Message Input -->
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
  </div>
  <hr>
 <!-- Contact Us Section End -->


@endsection
