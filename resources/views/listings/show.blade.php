@extends('layouts.app')

@section('title', $listing->title)
@section('css', 'listings_show.css')

@section('content')
<div class="container">
    <div class="row">
        <!-- Column 1: Icons and Likes/Dislikes -->
        <div class="col-md-2">
            <div class="d-flex flex-column align-items-center">
                <!-- Like or Unlike Icon and Likes Count -->
                @auth
                    @if(auth()->user()->hasLiked($listing))
                        <form method="POST" action="{{ route('listings.unlike', $listing->id) }}" class="show-icons">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-button">
                                <i class="fas fa-thumbs-up"></i>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('listings.like', $listing->id) }}" class="show-icons">
                            @csrf
                            <button type="submit" class="action-button">
                                <i class="far fa-thumbs-up"></i>
                            </button>
                        </form>
                    @endif
                @endauth

                <!-- Show likes count for non-authenticated users -->
                <span class="likes-count count">{{ $listing->likes->count() }} {{ Str::plural('Like', $listing->likes->count()) }}</span>

                <!-- Comment Icon -->
                <a href="#" class="action-button mt-3">
                    <i class="far fa-comment"></i>
                </a>

                <!-- Display the total number of comments -->
                <span class="count mt-3">{{ $listing->comments->count() }} {{ Str::plural('Comment', $listing->comments->count()) }}</span>

                <!-- Favorite Icon -->
                @if ($listing->isFavoritedBy(auth()->user()))
                    <form method="POST" action="{{ route('favorites.remove', $listing->id) }}" class="show-icons">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-link">
                            <i class="fas fa-star"></i>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('favorites.add', $listing->id) }}" class="show-icons">
                        @csrf
                        <button type="submit" class="action-link">
                            <i class="far fa-star"></i>
                        </button>
                    </form>
                @endif

                <!-- Display the number of favorites -->
                <span class="favorites-count count">{{ $listing->favoritesCount }} {{ Str::plural('Favorite', $listing->favoritesCount) }}</span>
            </div>
        </div>

        <!-- Column 2: Listing Content -->
        <div class="col-md-10">
            <div class="card invi">
                <div class="card-body" id="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Listing User, Date/Time, and Description in the center -->
                        <div class="d-flex align-items-center">
                            <img src="{{ $listing->user->avatar }}" alt="{{ $listing->user->name }}" class="rounded-circle listing-avatar" width="50">
                            <div class="ms-3">
                                <h5 class="card-subtitle" id="listing-user-name">{{ $listing->user->name }}</h5>
                                <p class="card-text" id="listing-datetime">Posted on: {{ $listing->created_at->format('F d, Y H:i:s') }}</p>
                            </div>
                        </div>
                        <!-- Add 'X' icon here on the right -->
                        <a href="javascript:void(0);" id="go-back">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>

                    <!-- Listing Title -->
                    <h2 class="card-title" id="listing-title">{{ $listing->title }}</h2>

                    <!-- Tags -->
                    <div class="mt-3">
                        @foreach($listing->tags as $tag)
                            <a href="#" class="text-decoration-none me-2" id="listing-tags">#{{ $tag->name }}</a>
                        @endforeach
                    </div>

                    <p class="card-text mt-3" id="listing-desc">{{ $listing->description }}</p>

                    <!-- Comment Form -->
                    @auth
                        <div class="d-flex mt-4">
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="rounded-circle listing-avatar" width="50">
                            <form method="POST" action="{{ route('comments.store') }}" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                <div class="form-group">
                                    <textarea name="content" rows="4" class="form-control" placeholder="Add a comment"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Comment</button>
                            </form>
                        </div>
                    @else
                        <p class="mt-3">Login to leave a comment.</p>
                    @endauth

                    <!-- Comment Section -->
                    <div class="mt-4">
                        <h3 class="comment-text">Top Comments</h3>
                        <!-- Display Comments -->
                        <ul class="list-unstyled" id="comment-list">
                            @foreach($listing->comments as $comment)
                                <li class="comment-item">
                                    <div class="d-flex align-items-start comment-wrapper">
                                        @if(isset($comment->user))
                                            <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="rounded-circle listing-avatar" width="50">
                                            <div class="ms-3" id="comment-border">
                                                <strong id="comment-user-name">{{ $comment->user->name }}</strong>
                                                <p id="comment-content">{{ $comment->content }}</p>

                                                <!-- Check if the user has liked the comment -->
                                                @php
                                                    $userId = auth()->user()->id ?? null;
                                                    $liked = $comment->isLikedByUser($userId);
                                                @endphp
                                                @if($liked)
                                                    <form method="POST" action="{{ route('comments.unlike', $comment->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Unlike</button>
                                                    </form>
                                                @else
                                                    <form method="POST" action="{{ route('comments.like', $comment->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm">Like</button>
                                                    </form>
                                                @endif

                                                <!-- Display the total number of likes -->
                                                <span id="comment-likes-count">{{ $comment->likes->count() }} {{ Str::plural('Like', $comment->likes->count()) }}</span>

                                                <!-- Reply button -->
                                                <label for="reply-toggle-{{ $comment->id }}" class="btn btn-link reply-button">Reply</label>
                                                <input type="checkbox" id="reply-toggle-{{ $comment->id }}" class="reply-toggle" />

                                                <!-- Reply form (hidden by default) -->
                                                <div class="reply-form">
                                                    <form method="POST" action="{{ route('comments.store') }}">
                                                        @csrf
                                                        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <div class="form-group">
                                                            <textarea name="content" rows="4" class="form-control" id="replyarea" placeholder="Add a reply"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" id="submit-btn">Submit Reply</button>
                                                    </form>
                                                </div>
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
</div>

@section('js', 'listings_show.js')
@endsection
