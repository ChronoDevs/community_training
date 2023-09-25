@extends('layouts.app')
@section('title', 'Edit Tag')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('templates.admin_sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Edit Tag</div>

                <div class="card-body">
                <form method="POST" action="{{ route('admin.updateTag', ['tag' => $tag]) }}">
                    @csrf

                    {{-- Define the HTTP method using the 'method' attribute --}}
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-group">
                        <label for="name">Tag Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tag->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Add more fields or customize the form as needed -->

                    <div class="form-group">
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
