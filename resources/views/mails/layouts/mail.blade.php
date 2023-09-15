@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="width:auto;height:7vh;">
    @endcomponent
@endslot

# @yield('title')

@yield('content')


<br>

---

This email has been sent automatically<br>
It is sent from a dedicated email address, so even if you reply directly, we will not be able to respond.<br>
Thank you for your understanding in advance.<br>

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{config('app.name')}}. All rights reserved.
    @endcomponent
@endslot
@endcomponent
