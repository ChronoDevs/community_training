@extends('layouts.app')

@section('title', $listing->title)
@section('css', 'listings_show.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: Icons and Likes/Dislikes -->
        <div class="col-md-2">
            <div class="d-flex flex-column align-items-center set-aside">
                <!-- Like or Unlike Icon and Likes Count -->
                @auth
                    @if(auth()->user()->hasLiked($listing))
                        <form method="POST" action="{{ route('listings.unlike', $listing->id) }}" class="show-icons">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link like-button">
                                <i class="fas fa-thumbs-up text-primary"></i>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('listings.like', $listing->id) }}" class="show-icons">
                            @csrf
                            <button type="submit" class="btn btn-link like-button">
                                <i class="far fa-thumbs-up"></i>
                            </button>
                        </form>
                    @endif
                @endauth

                <!-- Show likes count for non-authenticated users -->
                @guest
                    <button class="btn btn-link like-button">
                        <i class="far fa-thumbs-up"></i>
                    </button>
                @endguest
                <span class="count">{{ $listing->likes->count() }}</span>

                <!-- Comment Icon -->
                @auth
                    <button type="submit" class="btn btn-link comment-button">
                        <i class="far fa-comment"></i>
                    </button>
                @endauth

                <!-- Display the total number of comments -->
                @guest
                    <button class="btn btn-link comment-button">
                        <i class="far fa-comment"></i>
                    </button>
                @endguest
                <span class="count">{{ $listing->comments->count() }}</span>

                <!-- Favorite Icon -->
                @auth
                    @if ($listing->isFavoritedBy(auth()->user()))
                        <form method="POST" action="{{ route('favorites.remove', $listing->id) }}" class="show-icons">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link favorite-button text-warning">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('favorites.add', $listing->id) }}" class="show-icons">
                            @csrf
                            <button type="submit" class="btn btn-link favorite-button">
                                <i class="far fa-star"></i>
                            </button>
                        </form>
                    @endif
                @endauth

                <!-- Display the number of favorites -->
                @guest
                    <button class="btn btn-link favorite-button">
                        <i class="far fa-star"></i>
                    </button>
                @endguest
                <span class="count">{{ $listing->favoritesCount }}</span>
            </div>
        </div>

        <!-- Column 2: Listing Content -->
        <div class="col-md-10">
            <div class="card invi">
                <div class="card-body" id="card-body">
                    <!-- Listing User, Date/Time, and Description in the center -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <!-- Check if the user exists and has an avatar -->
                            @if($listing->user && $listing->user->avatar)
                                <img src="{{ $listing->user->avatar }}" alt="{{ $listing->user->name }}" class="rounded-circle listing-avatar" width="50">
                            @else
                                <!-- Handle the case when the user is not available or doesn't have an avatar -->
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="rounded-circle listing-avatar" width="50">
                            @endif
                            <div class="ms-3">
                                <!-- Check if the user exists -->
                                @if($listing->user)
                                    <h5 class="card-subtitle" id="listing-user-name">{{ $listing->user->name }}</h5>
                                @else
                                    <!-- Handle the case when the user is not available -->
                                    <p class="card-text" id="listing-user-name">Unknown User</p>
                                @endif
                                <p class="card-text" id="listing-datetime">Posted on: {{ $listing->created_at->format('F d, Y H:i:s') }}</p>
                            </div>
                        </div>
                        <!-- Add 'X' icon here on the right -->
                        <a href="{{ route('home.index') }}">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                    <!-- Listing Title -->
                    <div class="listing-title">
                        <h2 class="card-title" id="listing-title">{{ $listing->title }}</h2>
                    </div>

                    <!-- Tags -->
                    <div>
                        @foreach($listing->tags as $tag)
                            <a href="#" class="text-decoration-none me-2" id="listing-tags">#{{ $tag->name }}</a>
                        @endforeach
                    </div>

                    <p class="card-text mt-3" id="listing-desc">{{ $listing->description }}</p>

                    <!-- Comment Form -->
                    @auth
                        <div class="d-flex mt-4">
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle listing-avatar">
                            <form method="POST" action="{{ route('comments.store') }}" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                <textarea name="content" rows="3" class="form-control" id="comment-form" placeholder="Add to discussion"></textarea>
                                <button type="submit" class="btn btn-primary" id="submit-comment-button">Submit Comment</button>
                            </form>
                        </div>
                    @else
                        <p class="mt-3" id="notice">Login to leave a comment.</p>
                    @endauth

                    <!-- Comment Section -->
                    <div class="mt-2">
                        <h3 class="comment-text">Top Comments ({{ $listing->comments->count() }})</h3>
                        <!-- Display Comments -->
                        <ul class="list-unstyled" id="comment-list">
                            @foreach($listing->comments()->with('replies')->withCount('likes')->orderByDesc('likes_count')->orderBy('created_at')->get() as $comment)
                                <li class="comment-item mb-3">
                                    <div class="d-flex align-items-start comment-wrapper">
                                        @if(isset($comment->user))
                                            <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="rounded-circle comment-avatar" width="50">
                                            <div class="ms-3" id="comment-border">
                                                <p id="comment-user-name">{{ $comment->user->name }} •
                                                    <span class="comment-date">{{ $comment->created_at->format('M j') }}</span>
                                                </p>
                                                <p id="comment-content">{{ $comment->content }}</p>

                                                <!-- Check if the user has liked the comment -->
                                                @php
                                                    $userId = auth()->user()->id ?? null;
                                                    $liked = $comment->isLikedByUser($userId);
                                                @endphp

                                                <div class="d-flex align-items-center">
                                                    @auth
                                                        @if($liked)
                                                            <form method="POST" action="{{ route('comments.unlike', $comment->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-link comment-like-button">
                                                                    <i class="fas fa-thumbs-up"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('comments.like', $comment->id) }}">
                                                                @csrf
                                                                <button type="submit" class="btn btn-link comment-like-button">
                                                                    <i class="far fa-thumbs-up"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                    <!-- Display the total number of likes -->
                                                    <span class="count">{{ $comment->likes->count() }} {{ Str::plural('Like', $comment->likes->count()) }}</span>
                                                    <!-- Reply button -->
                                                    @auth
                                                        <button type="button" class="btn btn-link reply-button" data-comment-id="{{ $comment->id }}">
                                                            <i class="fa fa-reply" id="reply-icon"></i> Reply
                                                        </button>
                                                    @endauth
                                                </div>

                                                <!-- Reply form (hidden by default) -->
                                                <div class="reply-form" data-comment-id="{{ $comment->id }}" style="display: none;">
                                                    <form method="POST" action="{{ route('comments.storeReply', $comment->id) }}">
                                                        @csrf

                                                        <textarea name="content" id="reply-form" rows="3" class="form-control" placeholder="Add a reply"></textarea>

                                                        <button type="submit" class="btn btn-primary" id="submit-reply-button">Submit Reply</button>
                                                    </form>
                                                </div>

                                                <!-- Display replies for this comment -->
                                                @foreach($comment->replies as $reply)
                                                    <div class="d-flex align-items-start comment-wrapper reply-section">
                                                        @if(isset($reply->user))
                                                            <!-- Display user avatar -->
                                                            <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" class="rounded-circle comment-avatar" width="50">
                                                            <div class="ms-3" id="comment-border">
                                                                <!-- Display username and creation date -->
                                                                <strong id="comment-user-name">{{ $reply->user->name }} •
                                                                    <span class="comment-date">{{ $reply->created_at->format('M j') }}</span>
                                                                </strong>
                                                                <!-- Display reply content -->
                                                                <p id="comment-content">{{ $reply->content }}</p>
                                                                <!-- Like button -->
                                                                @auth
                                                                    <form method="POST" action="{{ route('reply.like', $reply->id) }}">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-link" id="reply-like-button">
                                                                            @if($reply->isLikedByUser(auth()->user()->id))
                                                                                <i class="fas fa-thumbs-up"></i>
                                                                            @else
                                                                                <i class="far fa-thumbs-up"></i>
                                                                            @endif
                                                                        </button>
                                                                        <!-- Display the total number of likes -->
                                                                        <span class="count">{{ $reply->likes->count() }} {{ Str::plural('Like', $reply->likes->count()) }}</span>
                                                                        <!-- Reply button -->
                                                                        <button type="button" class="btn btn-link btn-sm reply-button" data-comment-id="{{ $comment->id }}">
                                                                            <i class="fa fa-reply" id="reply-icon"></i> Reply
                                                                        </button>
                                                                    </form>
                                                                @endauth
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <!-- Handle the case where $comment->user is null or doesn't exist -->
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handle "Reply" button click
        $('.reply-button').on('click', function () {
            const commentId = $(this).data('comment-id');
            const replyForm = $('.reply-form[data-comment-id="' + commentId + '"]');

            // Toggle the reply form's visibility
            replyForm.toggle();
        });
    });
</script>

@section('js', 'listings_show.js')
@endsection
