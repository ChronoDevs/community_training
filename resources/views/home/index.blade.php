@extends('layouts.app')
@section('title', 'Home')
@section('css', 'home_index.css')
@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: User Interaction Section -->
        @auth
        <div class="col-md-3">
            <!-- @include('sidebar') -->
        </div>
        @endauth
        @guest
        <div class="col-md-3">
            <div class="row" id="auth-container">
                <div>
                    <h2>
                        <span id="chronostep-text" class="styled-text">
                            Chronostep
                        </span>
                        <span id="community-text" class="styled-text">
                            Community
                        </span>
                    </h2>
                    <p class="text"><strong>is a community of all talented and passionate engineers from the Philippines and Japan</strong></p>
                    <p class="text">We're a place where engineers share, stay up-to-date and grow their careers.</p>
                    <a class="btn signintext-btn" href="{{ route('login') }}">Sign In</a>
                    <a class="btn signuptext-btn" href="{{ route('register') }}">Sign Up</a>
                </div>
            </div>
        </div>
        @endguest

        <!-- Column 2: Post Filtering and Display Section -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex justify-content-between top">
                    <a href="#" class="me-2 filter-link {{ request()->is('home') ? 'active-link' : '' }}">Relevant</a>
                    <a href="#" class="me-2 filter-link {{ request()->is('listing') ? 'active-link' : '' }}">Latest</a>
                    <a href="#" class="filter-link {{ request()->is('tags') ? 'active-link' : '' }}">Top</a>
                </div>
            </div>

            <!-- Sample Post Cards -->
            @if (isset($listings) && $listings->count() > 0)
                @foreach ($listings as $listing)
                    <div class="card mb-3" id="listing-card">
                        <div class="card-body">
                            <!-- Post details here -->
                            <div class="d-flex align-items-center">
                                <img src="{{ $listing->user->avatar }}" alt="User Avatar" class="rounded-circle me-2" id="post_avatar">
                                <div>
                                    @if ($listing->user)
                                        <h5 class="card-title" id="listing-user-name">{{ $listing->user->name }}</h5>
                                    @endif
                                    <p class="card-text" id="listing-user-position">Software Engineer</p>
                                    <p class="card-text" id="listing-datetime">Posted on {{ $listing->created_at->format('F d, Y \a\t h:i A') }}</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('listings.show', ['listing' => $listing->id]) }}" class="card-title" id="listing-title">
                                    {{ $listing->title }}
                                </a>
                            </div>
                            <div class="d-flex">
                                @if ($listing->tags)
                                    @foreach ($listing->tags as $tag)
                                        <span class="mr-1" id="listing-tags">#{{ $tag->name }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <!-- Only show these elements if the user is authenticated -->
                                @auth
                                <div class="btn-group">
                                    @php
                                        $userLikesListing = $listing->likes()->pluck('user_id')->contains(auth()->id());
                                        $likeCount = $listing->likesCount; // Use the accessor method
                                    @endphp
                                    <button class="btn btn-link like-btn" data-listing-id="{{ $listing->id }}" data-user-likes="{{ $userLikesListing }}">
                                        <i class="far fa-thumbs-up listing-icons"></i>
                                    </button>
                                    <button class="btn btn-link liked-btn" data-listing-id="{{ $listing->id }}" data-user-likes="{{ $userLikesListing }}">
                                        <i class="fas fa-thumbs-up listing-icons"></i>
                                    </button>
                                    <span class="like-count" data-listing-id="{{ $listing->id }}">
                                        {{ $likeCount }} {{ $likeCount === 1 ? 'like' : 'likes' }}
                                    </span>
                                </div>
                                <button class="btn btn-link comment-button">
                                    <a href="{{ route('listings.show', ['listing' => $listing->id]) }}" class="card-title comment-count">
                                        <i class="far fa-comment listing-icons"></i> Comment
                                    </a>
                                </button>
                                <button class="btn btn-link favorite-button">
                                    <i class="far fa-star listing-icons"></i> Favorite
                                </button>
                                @else
                                    <p id="notice">Please log in to perform these actions.</p>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="pagination-links">
                    {{ $listings->links() }} <!-- Pagination links -->
                </div>
            @else
                <p class="text">No listings available.</p>
            @endif
        </div>

        <!-- Column 3: Categories and Popular Tags -->
        <div class="col-md-3">
            <h5 class="card-title mb-3 column3">Categories</h5>
            <div class="card mb-3 column3-cards">
                <div class="card-body categories-list" id="categories">
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none">Web Development</a></li>
                        <!-- Add more categories here -->
                    </ul>
                </div>
            </div>
            <h5 class="card-title mb-3 column3">Popular Tags</h5>
            <div class="card mb-3 column3-cards">
                <div class="card-body tags-list">
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none" id="multipletags">#javascript</a></li>
                        <li><a href="#" class="text-decoration-none" id="multipletags">#vuejs</a></li>
                        <li><a href="#" class="text-decoration-none" id="multipletags">#laravel</a></li>
                        <li><a href="#" class="text-decoration-none" id="multipletags">#eksdi</a></li>
                        <!-- Add more popular tags here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js', 'home_index.js')
@endsection
