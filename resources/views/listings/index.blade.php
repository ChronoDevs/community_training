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
            <div class="card mb-3 invi">
                <div class="card-body" id="card-body">
                    @auth
                    @if (Gate::allows('update-listing', $listing))
                    <!-- Edit Icon -->
                    <a href="{{ route('listings.edit', $listing->id) }}" class="btn btn-sm float-end">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endif
                    @if (Gate::allows('delete-listing', $listing))
                    <!-- Delete Icon (Form) -->
                    <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="float-end" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    @endif
                    @endauth

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
                    <h2 class="card-subtitle mt-3" id="listing-title">{{ $listing->title }}</h2>

                    <!-- Post Content (if needed) -->
                    <p class="card-text mt-3">{{ $listing->description }}</p>

                    <!-- Tags -->
                    <div class="mt-3">
                        @foreach($listing->tags as $tag)
                        <a href="#" class="text-decoration-none me-2" id="listing-tags">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $listings->links('pagination.default') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js', 'listings_index.js')
@endsection
