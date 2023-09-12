@extends('layouts.app')

@section('title', $listing->title)
@section('css', 'listings_show.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: Icons and Likes/Dislikes -->
        <div class="col-md-2">
            <div class="d-flex flex-column align-items-center">
                <!-- Like or Unlike Icon and Likes Count -->
                @auth
                @if(auth()->user()->hasLiked($listing))
                <form method="POST" action="{{ route('listings.unlike', $listing->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-button">
                        <i class="far fa-thumbs-down"></i> Unlike
                    </button>
                </form>
                @else
                <form method="POST" action="{{ route('listings.like', $listing->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="action-button">
                        <i class="far fa-thumbs-up"></i> Like
                    </button>
                </form>
                @endif
                @else
                @endauth
                <!-- Show likes count for non-authenticated users -->
                <span class="likes-count count">{{ $listing->likes->count() }} {{ Str::plural('Like', $listing->likes->count()) }}</span>

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
        <div class="col-md-10">
            <div class="card invi">
                <div class="card-body" id="card-body">

                    <!-- Listing User, Date/Time, and Description -->
                    <div class="d-flex align-items-center">
                        <img src="{{ $listing->user->avatar }}" alt="{{ $listing->user->name }}" class="rounded-circle listing-avatar" width="50">
                        <div class="ms-3">
                            <h5 class="card-subtitle" id="listing-user-name">{{ $listing->user->name }}</h5>
                            <p class="card-text" id="listing-datetime">Posted on: {{ $listing->created_at->format('F d, Y H:i:s') }}</p>
                        </div>
                    </div>

                    <!-- Listing Title -->
                    <h2 class="card-title" id="listing-title">{{ $listing->title }}</h2>

                    <!-- Tags -->
                    <div class="mt-3">
                        @foreach($listing->tags as $tag)
                        <a href="#" class="text-decoration-none me-2" id="listing-tags">#{{ $tag->name }}</a>
                        @endforeach
                    </div>

                    <p class="card-text mt-3" id="listing-desc">{{ $listing->description }}</p>

                </div>
            </div>
        </div>
    </div>
</div>

@section('js', 'listings_show.js')
@endsection
