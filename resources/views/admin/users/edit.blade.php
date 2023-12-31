@extends('layouts.app')
@section('css', 'admin_userlist.css')
@section('title', 'Edit User')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('templates.admin_sidebar')
        </div>
        <div class="col-md-9">
            <div class="edit-user-title">
                    Update User
            </div>
            <form method="POST" action="{{ route('admin.updateUser', ['user' => $user]) }}">
                @csrf
                @method('PUT')
                <div class="row user-container">
                    <div class="col-md-6 text-center avatar-col">
                        <img src="{{ $user->avatar }}" alt="Avatar" class="avatar-img">
                        <div class="user-btn">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-danger mr-2">Cancel</a>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </div>
                    <div class="col-md-6 user-details-col">
                    <!-- User Details -->
                        <p><label for="name">Name:</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="userlist_label"></p>
                        <p><label for="middle_name">Middle Name:</label>
                        <input type="text" name="middle_name" value="{{ $user->middle_name }}" class="userlist_label"></p>
                        <p><label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" value="{{ $user->last_name }}" class="userlist_label"></p>
                        <p><label for="gender">Gender:</label>
                            <select name="gender" class="userlist_label">
                                <option value="male" @if($user->gender === 'male') selected @endif>Male</option>
                                <option value="female" @if($user->gender === 'female') selected @endif>Female</option>
                            </select></p>
                        <p><label for="email">Email:</label>
                        <input type="text" name="email" value="{{ $user->email }}" class="userlist_label"></p>
                        <p><label for="user_name">User Name:</label>
                        <input type="text" name="user_name" value="{{ $user->user_name }}" class="userlist_label"></p>
                        <p><label for="nickname">Nickname:</label>
                        <input type="text" name="nickname" value="{{ $user->nickname }}" class="userlist_label"></p>
                        <p><label for="date_of_birth">Birthday:</label>
                        <input type="date" name="date_of_birth" value="{{ $user->date_of_birth }}" class="userlist_label"></p>
                        <p><label for="contact_number">Contact Number:</label>
                        <input type="text" name="contact_number" value="{{ $user->contact_number }}" class="userlist_label"></p>
                        <p><label for="zip_code">Zipcode:</label>
                        <input type="text" name="zip_code" value="{{ $user->zip_code }}" class="userlist_label"></p>
                        <p><label for="address">Address:</label>
                        <input type="text" name="address" value="{{ $user->address }}" class="userlist_label"></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
