@extends('layouts.app')

@section('title', 'Login')
@section('css', 'login.css')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card-body" id="card-body">
                <div class="intro">
                    <h1>
                        <span id="chronostep-text" class="styled-text">Chronostep</span>
                        <span id="community-text" class="styled-text">Community</span>
                    </h1>
                    <div id="introtwo" class="small-font">Welcome to the amazing community of engineers in Chronostep Inc.</div>
                </div>
                <br>
                <div class="social-login">
                    <a href="{{ route('login.facebook') }}" class="btn btn-primary" id="facebook-button">
                        <img src="images/facebook_icon.png" alt="Facebook Icon" class="button-icon">Continue with Facebook
                    </a>
                </div>
                <div class="social-login">
                    <a href="{{ route('login.google') }}" class="btn btn-danger" id="google-button">
                        <img src="images/google_icon.png" alt="Google Icon" class="button-icon">Continue with Google
                    </a>
                </div>
                <div class="social-login">
                    <a href="{{ route('login.line') }}" class="btn btn-success" id="line-button">
                        <img src="images/line_icon.png" alt="LINE Icon" class="line-icon">Continue with LINE
                    </a>
                </div>
                <div class="email-login">
                    <p class="email-login-text">----- Have a password? Continue with your email address -----</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="login-forms">
                            <div class="mb-3 email">
                                <label id="email-text" for="email" class="form-label text-start">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="someemail@domain.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="login-forms">
                            <div class="mb-3 password">
                                <div class="password-container">
                                    <label id="password-text" class="form-label text-start">{{ __('Password') }}</label>
                                    <div class="input-with-eye">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="****************">
                                        <span class="eye-icon input-group-text toggle-password">
                                            <i class="fa fa-fw fa-eye field-icon text-white"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" id="form-check-label-text" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>

                        <div class="mb-0 text-center">
                            <button class="btn btn-primary" type="submit" id="continue-button">
                                {{ __('Continue') }}
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" id="forget-password-text" href="{{ route('password.request') }}">
                                    {{ __('Forget Password?') }}
                                </a>
                            @endif
                                <a  class="btn btn-link" href="{{ route('admin.login') }}" id="admin-login-button">
                                    Admin Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js', 'scripts.js')
@endsection
