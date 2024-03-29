<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href= "{{ asset ('assets/css/styles.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>


     <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>
<body>

    @include('layouts.inc.admin-navbar')

    <div id="layoutSidenav">

        @include('layouts.inc.admin-sidebar')

        <div id="layoutSidenav_content">
            
            <main class="py-4">
                @yield('content')
            </main>
            @include('layouts.inc.admin-footer')
        </div>

    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" ></script>
    <script src="{{ asset('assets/js/scripts.js') }}" ></script>
</body>
</html>