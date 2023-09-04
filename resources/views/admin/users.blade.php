@extends('layouts.app')
@section('css', 'admin_userlist.css')
@section('title', 'Users')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('adminsidebar')
        </div>
        <div class="col-md-9">
            <div class="admin-header">
                <div class="admin-title">
                    Users
                </div>
                <div class="search-export">
                    <form action="{{ route('admin.users.search') }}" method="GET" class="search-bar">
                        @csrf
                        <div>
                            <input type="text" name="search" placeholder="Search...">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                        </div>
                    <button class="export-button">
                        <a href="{{ route('export.users') }}" class="export-text">Export
                            <i class="fa fa-download"></i>
                        </a>
                    </button>
                </div>
            </div>
            <div class="admin-card">
                    <table class="table table-striped table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Nickname</th>
                                <th>Action</th>
                                <!-- Add more table headers as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->nickname }}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal{{ $user->id }}">
                                            <i class="fa fa-search btn-lg"></i>
                                        </button>
                                    </td>
                                    <!-- Add more table cells for other user details -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <!-- Modal -->
                        @foreach ($users as $user)
                        <div class="modal fade" id="myModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit User Details</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.updateUser', ['id' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-md-6 text-center avatar-col">
                                                    <img src="{{ $user->avatar }}" alt="Avatar" class="avatar-img">
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
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
