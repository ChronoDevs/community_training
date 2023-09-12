@extends('layouts.app')

@section('title', $listing->title)
@section('css', 'listings_show.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: Icons and Likes -->
        <div class="col-md-1">
            <div class="d-flex flex-column align-items-center">
                <!-- Like Icon and Likes Count -->
                <form method="POST" action="{{ route('listings.like', $listing->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-button">
                        <i class="far fa-thumbs-up"></i> Like
                    </button>
                </form>
                <span class="likes-count">{{ $listing->likes->count() }} {{ Str::plural('Like', $listing->likes->count()) }}</span>

                <!-- Comment Icon -->
                <a href="#" class="action-button mt-3">
                    <i class="far fa-comment"></i> Comment
                </a>

                <!-- Favorite Icon -->
                @auth
                <form method="POST" action="{{ route('favorites.add', $listing->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-button mt-3">
                        <i class="far fa-star"></i> Favorite
                    </button>
                </form>
                @endauth
            </div>
        </div>

        <!-- Column 2: Listing Content -->
        <div class="col-md-11">
            <div class="card">
                <div class="card-body" id="card-body">
                    <!-- Listing Title -->
                    <h2 class="card-title">{{ $listing->title }}</h2>

                    <!-- Listing User, Date/Time, and Description -->
                    <div class="d-flex align-items-center">
                        <img src="{{ $listing->user->avatar }}" alt="{{ $listing->user->name }}" class="rounded-circle listing-avatar" width="50">
                        <div class="ms-3">
                            <h5 class="card-subtitle">{{ $listing->user->name }}</h5>
                            <p class="card-text">Posted on: {{ $listing->created_at->format('F d, Y H:i:s') }}</p>
                        </div>
                    </div>

                    <p class="card-text mt-3">{{ $listing->description }}</p>

                    <!-- Tags -->
                    <div class="mt-3">
                        @foreach($listing->tags as $tag)
                        <a href="#" class="text-decoration-none me-2">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js', 'listings_show.js')
@endsection
