@extends('layouts.app')

@section('title', 'FAQs')
@section('css', 'faqs.css')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('usersidebar')
        </div>
        <div class="col-md-8">

            <div class="justify-content-between mb-3">
                <div class="d-flex justify-content-between top">
                    <span class="me-2 filter-link {{ request()->is('faqs') ? 'active-link' : '' }}">Frequently Asked Questions (FAQs)</span>
                </div>
            </div>

            <div class="card-body">
                <!-- Frequently Asked Question 1 -->
                <div class="card mb-3 faq">
                    <div class="card-header faq-header">
                        <!-- Question 1 -->
                        1. How do I sign up for an account?
                        <button class="btn btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#answer1" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div id="answer1" class="collapse">
                        <div class="card-body faq-body">
                            <!-- Answer 1 -->
                            If you want to sign up for a new account, all you need to do is log out first and then click on "Sign Up" in the navigation bar or on the left side of the page. Thank you!
                        </div>
                    </div>
                </div>

                <!-- Frequently Asked Question 2 -->
                <div class="card mb-3 faq">
                    <div class="card-header faq-header">
                        <!-- Question 2 -->
                        2. How do I sign in to my account?
                        <button class="btn btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#answer2" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div id="answer2" class="collapse">
                        <div class="card-body faq-body">
                            <!-- Answer 2 -->
                            You can sign in by using your Facebook, Google, or LINE accounts directly, or if you already have an existing account, you can input your details instead.
                        </div>
                    </div>
                </div>

                <!-- Frequently Asked Question 3 -->
                <div class="card mb-3 faq">
                    <div class="card-header faq-header">
                        <!-- Question 3 -->
                        3. I forgot my password. How can I reset it?
                        <button class="btn btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#answer3" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div id="answer3" class="collapse">
                        <div class="card-body faq-body">
                            <!-- Answer 3 -->
                            You can edit request for a password reset via the login page.
                        </div>
                    </div>
                </div>

                <!-- Frequently Asked Question 4 -->
                <div class="card mb-3 faq">
                    <div class="card-header faq-header">
                        <!-- Question 4 -->
                        4. How can I post on the website?
                        <button class="btn btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#answer4" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div id="answer4" class="collapse">
                        <div class="card-body faq-body">
                            <!-- Answer 4 -->
                            <p>To create a post on our website, please adhere to the following guidelines:</p>
                            <p>• Sign in to your account.</p>
                            <p>• Navigate to the desired section or page where you want to create the post.</p>
                            <p>• Look for the "Create Post" or "New Post" button.</p>
                            <p>• Click on the button and enter the required details, such as the title, description or content, and any accompanying media.</p>
                            <p>• Once you have filled out the necessary information, click on the "Submit" or "Post" button to publish your post.</p>
                        </div>
                    </div>
                </div>

                <!-- Frequently Asked Question 5 -->
                <div class="card mb-3 faq">
                    <div class="card-header faq-header">
                        <!-- Question 5 -->
                        5. How do I contact customer support?
                        <button class="btn btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#answer5" aria-expanded="false">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div id="answer5" class="collapse">
                        <div class="card-body faq-body">
                            <!-- Answer 5 -->
                            You can contact our customer support team by emailing support@example.com or using the "Contact Us" page.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js', 'faqs.js')
@endsection
