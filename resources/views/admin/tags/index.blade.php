@extends('layouts.app')
@section('css', 'admin_tagslist.css')
@section('title', 'Tags')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('adminsidebar')
        </div>
        <div class="col-md-9"> <!-- Adjust the column width as needed -->
            <div class="admin-header">
                <div class="admin-title">
                    Tags
                </div>
                <div class="search-export">
                    <div class="search-bar">
                        <input type="text" placeholder="Search...">
                        <i class="fa fa-search"></i>
                    </div>
                    <button class="new-category-button" id="newCategoryButton">
                        <span class="category-text">New Tag</span>
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="admin-card">
            <table class="table table-striped table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tag Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->created_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.editTag', ['tag' => $tag->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.deleteTag', ['tag' => $tag]) }}" id="deleteTagForm_{{ $tag->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm fas fa-trash" type="button" onclick="confirmDeleteTag({{ $tag->id }})">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
                {{ $tags->links('pagination::bootstrap-4') }} <!-- Add pagination links at the bottom -->
            </div>
            <div class="admin-form" id="newCategoryForm">
                <div class="form-header">
                    <span class="form-title">New Tag</span>
                    <button class="close-button" id="closeButton">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.createTag') }}">
                    @csrf
                    <div class="form-group">
                        <label for="tagTitle" class="category-label">Title</label>
                        <input type="text" name="tag_title" class="category-input @error('tag_title') is-invalid @enderror" id="categoryTitle" placeholder="Title" value="{{ old('tag_title') }}">
                        @error('tag_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="create-button">Create</button>
                </form>
            </div>
        </div>
    </div>
@section('js', 'categories.js')
@endsection
