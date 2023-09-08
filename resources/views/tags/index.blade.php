@extends('layouts.app')

@section('title', 'Tags')
@section('css', 'tags.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: User Interaction Section -->
        @auth
        <div class="col-md-3">
            @include('usersidebar')
        </div>
        @endauth

        <!-- Column 2: Tags and Associated Listings -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <div class="d-flex justify-content-between top">
                    <span class="me-2 filter-link {{ request()->is('tags') ? 'active-link' : '' }}">Tags</span>
                </div>
            </div>

            <div class="row">
                @foreach($tags->chunk(10) as $tagChunk)
                @foreach($tagChunk as $tag)
                <div class="col-md-6 mb-3">
                    <div class="card invi">
                        <div class="card-body" id="card-body">
                            <h2 class="card-title tag-name">#{{ $tag->name }}</h2>

                            <!-- Listings with this tag -->
                            <h4 class="mt-3 tag-desc">Listings with this tag:</h4>
                            <ul class="tag-listings">
                                @if($tag->listings->isEmpty())
                                    <span class="info">No Listing has used this tag yet</span>
                                @else
                                    @foreach($tag->listings as $listing)
                                        <li><a href="{{ route('listings.show', $listing->id) }}" class="tag-lists">{{ $listing->title }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $tags->links('pagination.default') }}
            </div>
        </div>
    </div>
</div>
@endsection
