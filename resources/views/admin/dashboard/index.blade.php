@extends('layouts.app')
@section('css', 'dashboard.css')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('templates.admin_sidebar')
        </div>
        <div class="col-md-9">
            <div class="dashboard-header">
                <div class="dashboard-title">
                    Dashboard
                </div>
                <div class="dropdowns">
                    <select class="dropdown" name="month">
                        <option value="january">January</option>
                        <option value="febuary">Febuary</option>
                        <!-- ... add more months as options ... -->
                    </select>
                    <select class="dropdown" name="year">
                        <option value="2023">2023</option>
                        <!-- ... add more years as options ... -->
                    </select>
                </div>
            </div>
            <div class="stats-boxes">
                <div class="stats-box">
                    <div class="stats-label">Posts</div>
                    <div class="stats-value">251,984</div>
                </div>
                <div class="stats-box">
                    <div class="stats-label">Likes</div>
                    <div class="stats-value">22,335</div>
                </div>
                <div class="stats-box">
                    <div class="stats-label">Favorites</div>
                    <div class="stats-value">54,120</div>
                </div>
            </div>
            <div class="graph-box">
                <canvas id="chart-line" class="chart-canvas"></canvas>
            </div>
        </div>
    </div>
</div>
@section('js', 'adminchart.min.js')
@endsection
