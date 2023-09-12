@extends('layouts.app')

@section('title', 'Home')
@section('css', 'home_index.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: User Interaction Section -->
        @auth
        <div class="col-md-3">
            @include('usersidebar')
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
                    <span class="me-2 filter-link {{ request()->is('home') ? 'active-link' : '' }}">Relevant</span>
                    <span class="me-2 filter-link {{ request()->is('listing') ? 'active-link' : '' }}">Latest</span>
                    <span class="filter-link {{ request()->is('tags') ? 'active-link' : '' }}">Top</span>
                </div>
                @auth
                <a href="{{ route('listings.create') }}" class="btn btn-primary">New Listing</a>
                @endauth
            </div>

            @foreach($listings as $listing)
            @if($listing->status === 'published')
            <div class="card mb-3 invi">
                <div class="card-body" id="card-body">
                    <div class="d-flex align-items-center">
                        <!-- User's Photo -->
                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" alt="User Photo" class="rounded-circle listing-avatar" width="50">

                        <!-- User's Name and Date/Time -->
                        <div class="ms-3">
                            @if ($listing->user)
                            <h5 class="card-title" id="listing-user-name">{{ $listing->user->name }}</h5>
                            @endif
                            <p class="card-text" id="listing-user-position">Software Engineer</p>
                            <p class="card-text" id="listing-datetime">Posted on: {{ $listing->created_at->format('F d, Y H:i:s') }}</p>
                        </div>
                    </div>

                    <!-- Post Title -->
                    <div>
                        <a href="{{ route('listings.show', $listing->id) }}" class="card-subtitle mt-3 clickable-link" id="listing-title">{{ $listing->title }}</a>
                    </div>

                    <!-- Tags -->
                    <div class="mt-3">
                        @foreach($listing->tags as $tag)
                        <a href="#" class="text-decoration-none me-2" id="listing-tags">#{{ $tag->name }}</a>
                        @endforeach
                    </div>

                    <!-- Like, Comment, and Favorite Links -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            @auth
                            <!-- Like Link with Icon and Text -->
                            @if (!$listing->likes()->where('user_id', auth()->id())->exists())
                                <form method="POST" action="{{ route('listings.like', $listing->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="me-3 action-link">
                                        <i class="far fa-thumbs-up"></i>
                                    </button>
                                </form>
                            @else
                                <!-- Unlike Link with Icon and Text -->
                                <form method="POST" action="{{ route('listings.unlike', $listing->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="me-3 action-link">
                                        <i class="fas fa-thumbs-up"></i>
                                    </button>
                                </form>
                            @endif

                            <!-- Display likes text based on the number of likes -->
                            <span class="me-3 likes-text" style="font-size: 12px; color: white;">{{ $listing->likesText }}</span>

                            <!-- Comment Link with Icon -->
                            <a href="#" class="me-3 action-button">
                                <i class="far fa-comment"></i> Comment
                            </a>

                            <!-- Favorite Link with Icon and Text -->
                            @if ($listing->isFavoritedBy(auth()->user()))
                                <form method="POST" action="{{ route('favorites.remove', $listing->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="me-3 action-link">
                                        <i class="fas fa-star"></i> Remove from Favorites
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('favorites.add', $listing->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="action-link">
                                        <i class="far fa-star"></i> Add to Favorites
                                    </button>
                                </form>
                            @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $listings->links('pagination.default') }}
            </div>
        </div>

        <!-- Column 3: Categories and Popular Tags -->
        <div class="col-md-3">
            <h5 class="card-title mb-3 column3">Categories</h5>
            <div class="card mb-3 column3-cards">
                <div class="card-body categories-list" id="categories">
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                        <li><a href="#" class="text-decoration-none">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <h5 class="card-title mb-3 column3">Popular Tags</h5>
            <div class="card mb-3 column3-cards">
                <div class="card-body tags-list">
                    <ul class="list-unstyled">
                        @foreach($popularTags as $tag)
                        <li><a href="#" class="text-decoration-none">#{{ $tag->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js', 'home_index.js')
@endsection
