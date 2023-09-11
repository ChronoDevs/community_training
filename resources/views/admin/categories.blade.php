@extends('layouts.app')
@section('css', 'admin_categories.css')
@section('title', 'Categories')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('adminsidebar')
        </div>
        <div class="col-md-9">
            <div class="admin-header">
                <div class="admin-title">
                    Categories
                </div>
                <div class="search-export">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search...">
                    <i class="fa fa-search"></i>
                </div>
                <div id="suggestionsDropdown" class="dropdown-menu" style="display: none;"></div>
                    <button class="new-category-button" id="newCategoryButton">
                        <span class="category-text">New Category</span>
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="admin-card">
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Created At</th>
                            <th>Actions</th> <!-- Add a column for actions -->
                        </tr>
                        </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->created_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Edit Category Button -->
                                        <a href="{{ route('admin.editCategory', ['category' => $category->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                        <!-- Delete Category Button -->
                                        <form method="POST" action="{{ route('admin.deleteCategory', ['category' => $category]) }}">
                                            @csrf
                                            @method('DELETE') <!-- Add this line to set the method to DELETE -->
                                            <button class="btn btn-danger btn-sm fas fa-trash" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $categories->links('pagination::bootstrap-4') }} <!-- Add pagination links at the bottom -->
            </div>
            <div class="admin-form" id="newCategoryForm">
                <div class="form-header">
                    <span class="form-title">New Category</span>
                    <button class="close-button" id="closeButton">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.createCategory') }}">
                    @csrf
                    <div class="form-group">
                        <label for="categoryTitle" class="category-label">Title</label>
                        <input type="text" name="category_title" class="category-input" id="categoryTitle" placeholder="Title">
                    </div>
                    <!-- Add more form fields if needed -->
                    <button type="submit" class="create-button">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@section('js', 'categories.js')
@endsection