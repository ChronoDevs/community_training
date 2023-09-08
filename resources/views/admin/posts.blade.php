@extends('layouts.app')
@section('title', 'Posts')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('adminsidebar')
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
                            <option value="posted">Posted</option>
                            <option value="deleted">Deleted</option>
                            <option value="draft">Draft</option>
                            <!-- ... add more months as options ... -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="admin-card">
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
