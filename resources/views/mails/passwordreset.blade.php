@extends('mails.layouts.mail')

@section('content')
# You are receiving this email because we received a password reset request for your account.

Click the button below to proceed on resetting
your password<br>
If you did not request a password reset, no further action is required.

@component('mail::button', ['url' => $reset_url])
Reset Pasword
@endcomponent

@endsection
