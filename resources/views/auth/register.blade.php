@extends('layouts.app')
@section('css', 'register.css')
@section('title', 'Register')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-body" id="card-body">
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
                    <br>
                    <div class="social-login">
                        <button class="btn btn-primary" id="fb-button" data-oauth-provider="facebook">Continue with Facebook</button>
                        <button class="btn btn-danger" id="google-button" data-oauth-provider="google">Continue with Google</button>
                    </div>
                    <div class="email-register">
                        <p class="email-register-text">Already have an account? <a href="{{ route('login') }}">Log in</a>.</p>
                    </div>


                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="register-form">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label register-text">{{ __('First Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror fill_regis" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="First Name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="middle_name" class="form-label register-text">{{ __('Middle Name (optional)') }}</label>
                            <input id="middle-name" type="text" class="form-control @error('middle_name') is-invalid @enderror fill_regis" name="middle_name" value="{{ old('middle_name') }}" autofocus placeholder="Middle Name (optional)">
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label register-text">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror fill_regis" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Last Name">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="user_name" class="form-label text-md-end register-text">{{ __('Username') }}</label>
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror fill_regis_s" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus placeholder="Username">
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nickname" class="form-label register-text">{{ __('Nickname') }}</label>
                                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror fill_regis_s" name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus placeholder="Nickname">
                                @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label register-text">{{ __('Gender') }}</label>
                                <div class="select-wrapper">
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror fill_regis_s" name="gender" required autocomplete="gender" autofocus>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male"{{ old('gender') === 'male' ? ' selected' : '' }}>Male</option>
                                    <option value="female"{{ old('gender') === 'female' ? ' selected' : '' }}>Female</option>
                                </select>
                            </div>

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label register-text">{{ __('Date of Birth') }}</label>
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror fill_regis_s" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="contact_number" class="form-label register-text">{{ __('Contact Number') }}</label>
                                <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror fill_regis_s" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" autofocus placeholder="+639 xx-xxx-xxxx">
                                    @error('contact_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="zip_code" class="form-label register-text">{{ __('Zip Code') }}</label>
                                <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror fill_regis_s" name="zip_code" value="{{ old('zip_code') }}" required autocomplete="zip_code" autofocus placeholder="Zipcode">
                                    @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label register-text">{{ __('Address') }}</label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror fill_regis" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus placeholder="Address">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label register-text">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror fill_regis" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label register-text">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror fill_regis" name="password" required autocomplete="new-password" placeholder="Password">
                                <div class="input-group">    
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" toggle="#password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">  
                            <label for="password-confirm" class="form-label register-text">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control fill_regis" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Pasword">
                               
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center"> <!-- Adjust alignment if needed -->
                                <button type="submit" class="btn btn-primary btn-lg btn-block register-btn">
                                    {{ __('Continue') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
