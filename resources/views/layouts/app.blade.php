<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        body{
            display: inline;
            width: 1440px;
            padding-bottom: 0px;
            flex-direction: column;
            align-items: center;
            gap: 40px;
            background: var(--bg-color, #18191A);
        }
        .navmargin{
            display: flex;
            width: 1440px;
            height: 100px;
            padding: 20px 70px;
            justify-content: center;
            align-items: center;
            background: #242526;
            box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);
        }
        .signin{
            display: flex;
            width: 244px;
            height: 60px;
            padding: 13px 40px 14px 40px;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            border-radius: 15px;
            background: #18328D;
        }
        .signintext{
            display: flex;
            width: 164px;
            height: 33px;
            flex-direction: column;
            justify-content: center;
            flex-shrink: 0;
            color: #FFF;
            text-align: center;
            font-family: Inter;
            font-size: 20px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;
        }
        .signup{
            display: flex;
            width: 244px;
            height: 60px;
            padding: 13px 40px 14px 40px;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            border-radius: 15px;
            border: 2px solid #18328D;
        }
        .signuptext{
            display: flex;
            width: 164px;
            height: 33px;
            flex-direction: column;
            justify-content: center;
            flex-shrink: 0;
            color: #284CC8;
            text-align: center;
            font-family: Inter;
            font-size: 20px;
            font-style: normal;
            font-weight: 700;
            line-height: normal;
        }
        .intro{
            display: flex;
            width: 500px;
            height: 36px;
            flex-direction: column;
            justify-content: center;
            flex-shrink: 0;
        }
        #email, #password{
            width: 500px;
            height: 60px;
            flex-shrink: 0;
            border-radius: 15px;
            background: #3A3B3C;
        }
        .email, .password{
            color: var(--text-color, #A5A8AC);
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container navmargin">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
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
                                <li class="nav-item signin">
                                    <a class="nav-link signintext" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item signup">
                                    <a class="nav-link signuptext" href="{{ route('register') }}">{{ __('Register') }}</a>
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.querySelector(".toggle-password");
            const passwordField = document.querySelector("#password");

            togglePassword.addEventListener("click", function() {
                const fieldType = passwordField.getAttribute("type");
                passwordField.setAttribute("type", fieldType === "password" ? "text" : "password");
                togglePassword.classList.toggle("fa-eye-slash");
            });
        });
    </script>
</body>
</html>
