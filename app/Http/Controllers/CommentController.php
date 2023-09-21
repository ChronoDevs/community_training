<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\CommentPosted;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Listing;
use App\Models\Reply;
use App\Models\ReplyLike;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\ReplyToCommentRequest;
use App\Http\Requests\StoreReplyRequest;

class CommentController extends Controller
{
    /**
     * Create a new CommentController instance.
     */
    public function __construct()
    {
        // Apply the 'auth' middleware to the 'like' method
        $this->middleware('auth')->only('like');
    }

    /**
     * Store a new comment.
     *
     * @param  CommentStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentStoreRequest $request)
    {
        // Data to pass to the static method
        $data = [
            'content' => $request->input('content'),
            'listing_id' => $request->input('listing_id'),
            'parent_id' => $request->input('parent_id'),
        ];

        // Use the static method to store the comment
        $comment = Comment::storeComment($data);

        if ($comment) {
            // Redirect back to the specific listing page with a success message
            return redirect()->route('listings.show', ['listing' => $request->input('listing_id')])
                ->with('success', __('messages.success.comment'));
        } else {
            // Handle the case where comment creation or registration fails with an error message
            return redirect()->back()->with('error', __('messages.error.comment'));
        }
    }

    /**
     * Retrieve all comments for a listing ordered by likes and created_at.
     *
     * @param  int  $listingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($listingId)
    {
        // Replace 'Comment' with your actual Comment model
        $comments = Comment::where('listing_id', $listingId)
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->orderBy('created_at')
            ->get();

        // Return a JSON response with the comments data
        return response()->json(['comments' => $comments]);
    }

    /**
     * Like a comment.
     *
     * @param  int  $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like($commentId)
    {
        // Find the comment by ID
        $comment = Comment::findOrFail($commentId);

        // Check if the user has already liked this comment
        $userId = Auth::id();

        if ($comment->isLikedByUser($userId)) {
            // User has already liked the comment, remove the like
            $commentLike = CommentLike::where('comment_id', $comment->id)
                ->where('user_id', $userId)
                ->first();

            if ($commentLike) {
                $commentLike->delete();
            }

            return redirect()->back()->with('success', __('messages.success.unlike'));
        } else {
            // User has not liked the comment, create a new like
            $commentLike = new CommentLike([
                'user_id' => $userId,
            ]);

            $comment->likes()->save($commentLike);

            return redirect()->back()->with('success', __('messages.success.like'));
        }
    }

    /**
     * Unlike a comment.
     *
     * @param  int  $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlike($commentId)
    {
        // Find the comment by ID
        $comment = Comment::findOrFail($commentId);

        // Check if the user has already liked this comment
        $userId = Auth::id();

        if ($comment->isLikedByUser($userId)) {
            // User has already liked the comment, remove the like
            $commentLike = CommentLike::where('comment_id', $comment->id)
                ->where('user_id', $userId)
                ->first();

            if ($commentLike) {
                $commentLike->delete();
            }

            return redirect()->back()->with('success', __('messages.success.unlike'));
        } else {
            // Handle the case where the user is trying to unlike a comment they haven't previously liked
            return redirect()->back()->with('error', __('messages.error.like'));
        }
    }

    /**
     * Reply to a comment.
     *
     * @param  ReplyToCommentRequest  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply(ReplyToCommentRequest $request, $commentId)
    {
        // Find the parent comment
        $parentComment = Comment::findOrFail($commentId);

        // Use the new method to reply to the comment
        $comment = $parentComment->replyToComment([
            'content' => $request->input('content'),
        ]);

        if ($comment) {
            return redirect()->route('listings.show', ['listing' => $request->input('listing_id')])
                ->with('success', __('messages.success.comment_reply'));
        } else {
            // Handle the case where the reply creation failed
            return redirect()->back()->with('error', __('messages.error.comment_reply'));
        }
    }

    /**
     * Store a reply to a comment.
     *
     * @param  StoreReplyToCommentRequest  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReply(StoreReplyRequest $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $reply = $comment->storeReply([
            'content' => $request->input('content'),
        ]);

        if ($reply) {
            return redirect()->back()->with('success', __('messages.success.create_reply'));
        } else {
            // Handle the case where the reply creation failed
            return redirect()->back()->with('error', __('messages.error.create_reply'));
        }
    }

    /**
     * Show replies to a comment.
     *
     * @param  int  $commentId
     * @return \Illuminate\View\View
     */
    public function showReplies($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $replies = $comment->replies;

        return view('comments.replies', compact('comment', 'replies'));
    }

    /**
     * Like a reply.
     *
     * @param int $replyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function likeReply($replyId)
    {
        $reply = Reply::findOrFail($replyId);
        $reply->like(auth()->user()->id);

        return redirect()->back();
    }

    /**
     * Unlike a reply.
     *
     * @param int $replyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlikeReply($replyId)
    {
        $reply = Reply::findOrFail($replyId);
        $reply->unlike(auth()->user()->id);

        return redirect()->back();
    }
}
