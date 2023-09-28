@extends('layouts.app')

@section('title', 'Favorites')
@section('css', 'favorites.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: User Interaction Section -->
        @auth
        <div class="col-md-3">
            @include('usersidebar')
        </div>
        @endauth

        <!-- Column 2: Favorite Listings -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <div class="d-flex justify-content-between top">
                    <span class="me-2 filter-link {{ request()->is('favorites') ? 'active-link' : '' }}">Favorites</span>
                </div>
            </div>

            @if (count($favorites) > 0)
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach ($favorites as $favorite)
                        <div class="col">
                            <div class="card invi">
                                <div class="card-body" id="card-body">
                                    <form method="POST" action="{{ route('favorites.remove', $favorite->listing_id) }}" class="form">
                                        @csrf
                                        @method('DELETE')
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="text-warning float-end">
                                            <i class="fas fa-star"></i>
                                        </a>
                                    </form>
                                    <div class="d-flex align-items-center">
                                        <!-- User's Photo -->
                                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" alt="User Photo" class="rounded-circle listing-avatar" width="50">

                                        <!-- User's Name and Date/Time -->
                                        <div class="ms-3">
                                            @if ($favorite->listing->user)
                                                <h5 class="card-title" id="listing-user-name">{{ $favorite->listing->user->name }}</h5>
                                            @endif
                                            <p class="card-text" id="listing-user-position">Software Engineer</p>
                                            <p class="card-text" id="listing-datetime">Posted on: {{ $favorite->listing->created_at->format('F d, Y H:i:s') }}</p>
                                        </div>
                                    </div>

                                    <!-- Post Title -->
                                    <div class="listing-title">
                                        <a href="{{ route('listings.show', $favorite->listing->id) }}" class="card-subtitle mt-3 clickable-link" id="listing-title">{{ $favorite->listing->title }}</a>
                                    </div>

                                    <!-- Tags -->
                                    <div class="mt-3">
                                        @foreach($favorite->listing->tags as $tag)
                                            <a href="#" class="text-decoration-none me-2" id="listing-tags">#{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-4 notice">You haven't added any listings to your favorites yet. <a href="{{ route('home.index') }}">Browse listings</a> to find your favorites.</p>
            @endif
        </div>
    </div>
</div>

@section('js', 'scripts.js')
@endsection
