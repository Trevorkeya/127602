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
                </div>
            </div>
        </nav>

    <aside class="sidebar">
      <ul class="links">
        <h4>Main Menu</h4>
          <li>
            <span class="material-symbols-outlined">home</span>
            <a class="navbar-brand" href="{{ url('/home') }}">home</a>
          </li>
        @if(auth()->check() && (auth()->user()->type === 'admin' || auth()->user()->type === 'instructor'))
          <li>
            <span class="material-symbols-outlined">dashboard</span>
            <a href="{{ url('/admin/dashboard') }}">Dashboard</a>
          </li>
        @endif
        <li>
        <span class="material-symbols-outlined">account_circle</span>
          <a href="{{ route('profile.show') }}">Profile</a>
        </li>
        <hr>
        <h4>Content</h4>
        <li>
          <span class="material-symbols-outlined">school</span>
          <a href="{{ url('/mycourses') }}">My Courses</a>
        </li>
        <li>
          <span class="material-symbols-outlined">Library_books</span>
          <a href="{{ url('/materials') }}">Library</a>
        </li>
        <li>
        <span class="material-symbols-outlined">edit_note</span>
          <a href="/courses">Courses</a>
        </li>
        <li>
          <span class="material-symbols-outlined">show_chart</span>
          <a href="{{ isset($course) ? route('quizzes.userResults', ['courseId' => $course->id]) : '#' }}">Results</a>
        </li>
        <hr>
        <!-- <h4>Account</h4>
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
        </li> -->
      </ul>
    </aside>
    </div> 
      <div> 
        <main class="main-content">
          @yield('content')
        </main>
        <!-- Include the chatbot button and modal -->
         @include('partials.chatbot')
      </div>
      <style>
        
      </style>
       <!-- Footer -->
        <footer class="text-center text-lg-start bg-dark text-white">
         <section class="d-flex justify-content-center justify-content-lg-between p-3 border-bottom"></section>
          <!-- Section: Links  -->
            <section class="">
              <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                  <!-- Grid column -->
                  <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold mb-4">
                      <i class="fas fa-gem me-3"></i>SmartStudy Central
                    </h6>
                    <p>
                    Join us and embark on a path of continuous growth and knowledge acquisition.
                    </p>
                  </div>
                  
                  <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                  <!-- Links -->
                  <h6 class="text-uppercase fw-bold mb-4">
                    Common Go to
                  </h6>
                  <p>
                    <a href="{{ url('/home') }}" class="text-reset">Home</a>
                  </p>
                  <p>
                    <a href="/courses" class="text-reset">Courses</a>
                  </p>
                  <p>
                    <a href="#!" class="text-reset">About us</a>
                  </p>
                  <p>
                    <a href="{{ route('logout') }}" class="text-reset">logout</a>
                  </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                  <!-- Links -->
                  <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                  <p><span class="material-symbols-outlined">home</span> Off Waiyaki Way Lavington Nairobi, Kenya</p>
                  <p><span class="material-symbols-outlined">mail</span>trevor.anjere@strathmore.edu</p>
                  <p><span class="material-symbols-outlined">call</span></i> + 254 712345678</p>
                  <p><span class="material-symbols-outlined">phone_iphone</span> + 254 787654321</p>
                </div>
                <!-- Grid column -->
              </div>
     
            
            </section>
          <!-- Section: Links  -->
        </footer>
      <!-- Footer -->
    
  </div>
</body>
</html>
