@extends('layouts.app')

@section('css', 'admin_login.css')
@section('title', 'Admin Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
                <div class="card-body" id="card-body">
                    <div class="admin-login-title">
                        Admin Login
                    </div>
                    <div class="intro">
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
                    <form method="POST" class="admin-login-form" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="user_name" class="form-label form-title">Username</label>
                            <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus>
                            @error('user_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label form-title">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label form-check-title" for="remember">Remember Me</label>
                        </div>

                        <div class="mb-0 text-center">
                                <button class="btn btn-primary" type="submit" id="continue-button">
                                    {{ __('Continue') }}
                                </button>
                            <a  class="btn btn-link" href="{{ route('login') }}" id="user-login-button">
                                User Login
                            </a>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>

@section('js', 'scripts.js')
@endsection
