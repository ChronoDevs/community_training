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
                            @if($users->isEmpty())
                                <tr>
                                    <td colspan="7">No records found.</td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->user_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->nickname }}</td>
                                        <td>
                                            <a href="{{ route('admin.editUser', ['user' => $user]) }}" class="btn btn-primary">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                        </td>
                                        <!-- Add more table cells for other user details -->
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
