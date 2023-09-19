@extends('layouts.app')

@section('title', 'Listings')
@section('css', 'listings_index.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: User Interaction Section -->
        @auth
        <div class="col-md-3">
            @include('usersidebar')
        </div>
        @endauth

        <!-- Column 2: Post Filtering and Display Section -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <div class="d-flex justify-content-between top">
                    <span class="me-2 filter-link {{ request()->is('listings') ? 'active-link' : '' }}">Listings</span>
                </div>
                <a href="{{ route('listings.create') }}" class="btn btn-primary">New Listing</a>
            </div>

            @foreach($listings as $listing)
                @if($listing->status === \App\Enums\ListingAction::PUBLISH)
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
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $listings->links('pagination.default') }}
            </div>
        </div>
    </div>
</div>

@section('js', 'scripts.js')
@endsection
