@extends('layouts.app')

@section('title', 'Edit Listing')
@section('css', 'listings_create.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: User Interaction Section -->
        @auth
        <div class="col-md-3">
            @include('usersidebar')
        </div>
        @endauth

        <!-- Column 2: Listing Edit Form Section -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <div class="d-flex justify-content-between top">
                    <span class="me-2 filter-link {{ request()->is('listings/*/edit') ? 'active-link' : '' }}">Edit Listing</span>
                </div>
            </div>

            <form method="POST" action="{{ route('listings.update', $listing->id) }}">
                @csrf
                @method('PUT')

                <!-- User's Photo (You can add this if needed) -->
                <div class="mb-3">
                    <label for="title" class="form-label" id="title-text">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $listing->title }}" required>
                </div>

                <!-- Listing Description -->
                <div class="mb-3">
                    <label for="description" class="form-label" id="desc-text">Description</label>
                    <textarea id="description" name="description">{{ $listing->description }}</textarea>
                </div>

                <!-- Category Selection -->
                <div class="mb-3">
                    <label for="category" class="form-label" id="category-text">Category</label>
                    <select id="category" name="category" class="form-select" required>
                        <option value="" selected disabled>Select a category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $listing->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tags Input -->
                <div class="mb-3">
                    <label for="tags" class="form-label" id="tags-text">Tags</label>
                    <div id="selected-tags" class="mt-2">
                        @foreach($listing->tags as $tag)
                            <span class="badge bg-primary me-2 mb-2 tag-label">
                                {{ $tag->name }}
                                <span class="tag-remove-button" data-tag-id="{{ $tag->id }}" data-listing-id="{{ $listing->id }}">&times;</span>
                            </span>
                        @endforeach
                    </div>
                    <select id="tags" name="tags[]" class="form-select" multiple>
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Listing</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js', 'listings_create.js')
@endsection
