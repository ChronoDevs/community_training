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
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@5.15.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<style>
    body{
        background: var(--bg-color, #18191A);
    }
    #container{
        background-color: #242526;
        box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.25);
        width: 100%;
        height: 100px;
        padding: 20px 70px;
        justify-content: center;
        align-items: center;
    }
    .signintext-btn{
        border-radius: 15px;
        margin: 10px;
        background: #18328D;
        color: #FFF;
        text-align: center;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        padding: 13px 40px 14px 40px;
        justify-content: center;
        align-items: center;
    }
    .signuptext-btn{
        border-radius: 15px;
        border: 2px solid #18328D;
        margin: 10px;
        color: #284CC8;
        text-align: center;
        font-family: Inter;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        padding: 13px 40px 14px 40px;
        justify-content: center;
        align-items: center;
    }
    #email-text, #password-text, #form-check-label-text{
        float: left;
    }
    #card-body{
        border-radius: 10px;
        border: 1px solid #3D3F41;
        background: var(--card, #242526);
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        width: 600px;
    }
    #chronostep-text{
        color: var(--skyblue, #00BDFE);
        text-align: center;
        font-family: Inter;
        font-size: 30px;
        font-style: normal;
        font-weight: 900;
        line-height: normal;
    }
    #community-text{
        color: var(--primary-2, #18328D);
        font-family: Inter;
        font-size: 30px;
        font-style: normal;
        font-weight: 900;
        line-height: normal;
    }
    #introtwo{
        color: #FFF;
        text-align: center;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
    #fb-button{
        width: 500px;
        height: 60px;
        padding: 13px 130px 14px 131px;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        border-radius: 15px;
        border: 2px solid var(--primary-2, #18328D);
        background: #FFF;
        color: var(--primary-2, #18328D);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
    #google-button{
        width: 500px;
        height: 60px;
        padding: 13px 130px 14px 131px;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        border-radius: 15px;
        border: 2px solid var(--skyblue, #00BDFE);
        background: #FFF;
        color: var(--skyblue, #00BDFE);
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
    .email-login-text{
        color: var(--text-color, #A5A8AC);
        text-align: center;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }
    #email{
        width: 400px;
        height: 60px;
        padding: 12px 25px;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        border-radius: 15px;
        border-color: #3A3B3C;
        background: #3A3B3C;
        color: var(--text-color, #A5A8AC);
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    #password{
        width: 400px;
        height: 60px;
        flex-shrink: 0;
        border-radius: 15px;
        border-color: #3A3B3C;
        background: #3A3B3C;
        color: var(--text-color, #A5A8AC);
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    #email-text, #password-text, #form-check-label-text{
        color: #FFF;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
    #continue-button{
        display: flex;
        width: 400px;
        height: 60px;
        padding: 14px 153px 13px 153px;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        border-radius: 15px;
        background: var(--primary-2, #18328D);
        color: #FFF;
        text-align: center;
        font-family: Inter;
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
    #forget-password-text{
        color: var(--skyblue, #00BDFE);
        text-align: center;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm" id="container">
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
                                <a class="nav-link" href="{{ route('login') }}">
                                    <button class="btn signintext-btn">{{ __('Sign In') }}</button>
                                </a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item signup">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <button class="btn signuptext-btn">{{ __('Sign Up') }}</button>
                                </a>
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
