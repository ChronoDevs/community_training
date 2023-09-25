@extends('layouts.app')
@section('title', 'Posts')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('templates.admin_sidebar')
        </div>
        <div class="col-md-9">
            <div class="admin-header">
                <div class="admin-title">
                    Posts
                </div>
                <div class="search-export">
                    <div class="search-bar">
                        <input type="text" placeholder="Search...">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="dropdowns">
                        <select class="dropdown" name="status">
                            <option value="" disabled selected>Status</option>
                            <option value="published">Published</option>
                            <option value="unpublished">Unpublished</option>
                            <!-- ... add more months as options ... -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="admin-card">
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Tags</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listings as $listing)
                            <tr>
                                <td>{{ $listing->title }}</td>
                                <td>{{ $listing->description }}</td>
                                <td>{{ $listing->user->name }}</td>
                                <td>{{ $listing->status }}</td>
                                <td>
                                    @foreach ($listing->tags as $tag)
                                        {{ $tag->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.inspectListing', ['listing' => $listing]) }}" class="btn btn-primary">
                                        <i class="fas fa-search"></i> <!-- Font Awesome magnifying glass icon -->
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $listings->links('pagination::bootstrap-4') }} <!-- Add pagination links at the bottom -->
            </div>
        </div>
    </div>
</div>
@section('js', 'post_status.js')
@endsection
