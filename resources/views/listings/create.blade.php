@extends('layouts.app')

@section('title', 'Create Listing')
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

        <!-- Column 2: Listing Creation Form Section -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <div class="d-flex justify-content-between top">
                    <span class="me-2 filter-link {{ request()->is('listings/create') ? 'active-link' : '' }}">New Listing</span>
                </div>
            </div>


                    <form method="POST" action="{{ route('listings.store') }}">
                        @csrf

                        <!-- User's Photo (You can add this if needed) -->
                        <div class="mb-3">
                            <label for="title" class="form-label" id="title-text">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required placeholder="Title">
                        </div>

                        <!-- Listing Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label" id="desc-text">Description</label>
                            <textarea id="description" name="description"></textarea>
                        </div>

                        <!-- Category Selection -->
                        <div class="mb-3">
                            <label for="category" class="form-label" id="category-text">Category</label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="" selected disabled>Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tags Input -->
                        <div class="mb-3">
                            <label for="tags" class="form-label" id="tags-text">Tags</label>
                            <div id="selected-tags" class="my-2">
                                <!-- Selected tags will be displayed here as labels -->
                            </div>
                            <select id="tags" name="tags[]" class="form-select" multiple>
                                <option value="" selected disabled>Select tags</option>
                                @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" id="post-button">Post</button>
                        </div>
                    </form>

        </div>
    </div>
</div>

<script>
// JavaScript code to display selected tags as labels
document.addEventListener('DOMContentLoaded', function() {
    const tagsSelect = document.getElementById('tags');
    const selectedTagsDiv = document.getElementById('selected-tags');

    tagsSelect.addEventListener('change', function() {
        selectedTagsDiv.innerHTML = ''; // Clear existing labels

        for (const option of this.selectedOptions) {
            const tagLabel = document.createElement('span');
            tagLabel.classList.add('badge', 'bg-secondary', 'me-2');
            tagLabel.textContent = option.textContent;

            selectedTagsDiv.appendChild(tagLabel);
        }
    });
});
</script>

@section('js', 'listings_create.js')
@endsection
