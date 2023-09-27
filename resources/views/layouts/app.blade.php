<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/ds5rb5j6z00v2kgr52c49cosjp4ede73q728yd5oy8slmby6/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="{{ asset('js/adminsearch.js') }}" defer></script>
    @if (trim($__env->yieldContent('js')))
    <script src="{{ url('js') }}/@yield('js')" defer></script>
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/searchbar.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    @if (trim($__env->yieldContent('css')))
    <link rel="stylesheet" href="{{ url('css') }}/@yield('css')">
    @endif
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light sticky-top shadow-sm" id="header">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse">
            <!-- Left Side Of Navbar -->
            <div class="me-auto">
                @auth
                <form action="{{ route('listings.search') }}" method="GET" class="search-bar">
                    @csrf
                    <div class="align-items-center">
                        <input type="text" name="search" placeholder="Search...">
                        <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                @endauth
            </div>

            <!-- Right Side Of Navbar -->
            <div class="ms-auto">
                <!-- Authentication Links -->
                @guest
                <div class="nav-item d-flex align-items-center">
                    @if (Route::has('login'))
                    <div class="signin">
                        <a class="nav-link" href="{{ route('login') }}">
                            <button class="btn signintext-btn">{{ __('Sign In') }}</button>
                        </a>
                    </div>
                    @endif

                    @if (Route::has('register'))
                    <div class="signup">
                        <a class="nav-link" href="{{ route('register') }}">
                            <button class="btn signuptext-btn">{{ __('Sign Up') }}</button>
                        </a>
                    </div>
                    @endif
                </div>
                @endguest

                @auth
                <div class="ms-auto d-flex align-items-center">
                    <div>
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" id="nav-avatar" style="border: 2px solid var(--skyblue, #00BDFE); border-radius: 50px; height: 50px; width: 50px; margin-right: 10px;">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" id="nav-avatar" style="border: 2px solid var(--skyblue, #00BDFE); border-radius: 50px; height: 50px; width: 50px; margin-right: 10px;">
                        @endif
                    </div>
                    <div>
                        <button class="btn btn-secondary dropdown-toggle" id="avatar-name-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" id="dropdown-actions" aria-labelledby="avatar-name-button">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Sign Out') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
