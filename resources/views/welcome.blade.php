<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- <link href= "{{ asset ('assets/css/styles.css') }}" rel="stylesheet"> -->
    <link href= "{{ asset ('assets/css/styles.css') }}" rel="stylesheet">
    <link href= "{{ asset ('assets/css/styles2.css') }}" rel="stylesheet">
    <!-- Linking Google font link for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.234/pdf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  </head>
<body>
  <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                  SmartStudy Central
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    <ul>
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" style="text-decoration: none; color: inherit;">Home</a>
                    @else
                       
                        <p>---</p>
                    @endauth
                </div>
            @endif
            </ul>

                </div>
            </div>
        </nav>
</div>
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
    </body>
</html>
