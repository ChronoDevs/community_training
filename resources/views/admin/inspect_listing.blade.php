@extends('layouts.app')
@section('title', 'Inspect Listing')
@section('css', 'posts_lists.css')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('adminsidebar')
        </div>
        <div class="col-md-9"> <!-- Increase the column size for the card -->
            <div class="card">
                <div class="card-header">Inspect Listing</div>

                <div class="card-body">
                    <h2>{{ $listing->title }}</h2>
                    <p>{{ $listing->description }}</p>
                    <p>Status: {{ $listing->status }}</p>
                    <p>Tags:
                        @foreach ($listing->tags as $tag)
                            <span class="badge badge-custom">{{ $tag->name }}</span>
                        @endforeach
                    </p>

                    <form method="POST" action="{{ route('admin.updateListingStatus', ['listing' => $listing->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="status">Change Status:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="published" {{ $listing->status === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="unpublished" {{ $listing->status === 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="action">Choose Action:</label>
                            <select class="form-control" id="action" name="action">
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.posts') }}" class="btn btn-secondary mr-2">Return to Posts</a>
                            <button type="submit" class="btn btn-primary">Update Listing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
