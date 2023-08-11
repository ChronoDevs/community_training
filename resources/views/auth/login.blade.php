@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="display: flex; justify-content: center; align-items: center;">
                <div class="card-body" id="card-body">
                    <div class="intro" style="text-align: center;">
                        <h1>
                            <span id="chronostep-text" class="styled-text">
                                Chronostep
                            </span>
                            <span id="community-text" class="styled-text">
                                Community
                            </span>
                        </h1>
                        <div id="introtwo" class="small-font">Welcome to the amazing community of engineers in Chronostep Inc.</div>
                    </div>
                    <br>
                    <div class="social-login" style="text-align: center;">
                        <button class="btn btn-primary" id="fb-button">Continue with Facebook</button>
                        <button class="btn btn-danger" id="google-button">Continue with Google</button>
                    </div>
                    <div class="email-login" style="text-align: center;">
                        <p class="email-login-text">Have a password? Continue with your email address</p>
                        <form method="POST" action="{{ route('login') }}" style="width: 100%; max-width: 400px; margin: 0 auto;">
                            @csrf

                            <div class="mb-3">
                                <label id="email-text" for="email" class="form-label text-start">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="someemail@domain.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label id="password-text" for="password" class="form-label text-start">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" toggle="#password">
                                            <i class="fa fa-fw fa-eye field-icon"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" id="form-check-label-text" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
