<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

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
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  </head>
<body>
<div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    E-Learning
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
                </div>
            </div>
        </nav>

    <aside class="sidebar">
      <ul class="links">
        <h4>Main Menu</h4>
        <li>
          <span class="material-symbols-outlined">dashboard</span>
          <a href="{{ url('/admin/home') }}">Dashboard</a>
        </li>
        <li>
          <span class="material-symbols-outlined">show_chart</span>
          <a href="#">my Courses</a>
        </li>
        <li>
          <span class="material-symbols-outlined">flag</span>
          <a href="#">Reports</a>
        </li>
        <hr>
        <h4>Advanced</h4>
        <li>
          <span class="material-symbols-outlined">Library_books</span>
          <a href="{{ url('/materials') }}">Library</a>
        </li>
        <li>
        <span class="material-symbols-outlined">edit_note</span>
          <a href="/courses">Courses</a>
        </li>
        <li>
          <span class="material-symbols-outlined">quiz</span>
          <a href="#">Assessments</a>
        </li>
        <li>
          <span class="material-symbols-outlined">pacemaker</span>
          <a href="/student/profile">Profile</a>
        </li>
        <li>
          <span class="material-symbols-outlined">monitoring</span>
          <a href="#">Analytic</a>
        </li>
        <hr>
        <h4>Account</h4>
        <li>
          <span class="material-symbols-outlined">bar_chart</span>
          <a href="#">Overview</a>
        </li>
        <li>
          <span class="material-symbols-outlined">mail</span>
          <a href="#">Message</a>
        </li>
        <li>
          <span class="material-symbols-outlined">settings</span>
          <a href="#">Settings</a>
        </li>
        <li class="logout-link">
          <span class="material-symbols-outlined">logout</span>
          <a href="#">Logout</a>
        </li>
      </ul>
    </aside>
    </div> 
      <div> 
        <main class="main-content">
          @yield('content')
        </main>
      </div>
</body>
</html>
