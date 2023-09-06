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
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">Create a New Listing</h2>
                    <form method="POST" action="{{ route('listings.store') }}">
                        @csrf

                        <!-- User's Photo (You can add this if needed) -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <!-- Listing Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description"></textarea>
                        </div>

                        <!-- Category Selection -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="" selected disabled>Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tags Input -->
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter tags (comma-separated)" value="{{ old('tags') }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Create Listing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js', 'listings_create.js')
@endsection
