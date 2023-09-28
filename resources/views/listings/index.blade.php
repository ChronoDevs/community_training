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
                <a href="{{ route('listings.create') }}" class="btn btn-primary" id="new-listing-button">New Listing</a>
            </div>

            @foreach($listings as $listing)
                @if($listing->status === \App\Enums\ListingAction::PUBLISH)
                <div class="card mb-3 invi">
                    <div class="card-body" id="card-body">
                        @auth
                        @if (Gate::allows('delete-listing', $listing))
                        <!-- Delete Icon (Form) -->
                        <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="float-end" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @endif
                        @if (Gate::allows('update-listing', $listing))
                        <!-- Edit Icon -->
                        <a href="{{ route('listings.edit', $listing->id) }}" class="btn edit-btn btn-sm float-end">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        @endauth

                        <div class="d-flex align-items-center">
                            <!-- User's Photo -->
                            @if ($listing->user && $listing->user->avatar)
                                <img src="{{ $listing->user->avatar }}" alt="{{ $listing->user->name }}" alt="User Photo" class="rounded-circle listing-avatar" width="50">
                            @else
                                <!-- Handle the case when the user doesn't have an avatar -->
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="rounded-circle listing-avatar" width="50">
                            @endif

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
                        <div class="listing-title">
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
