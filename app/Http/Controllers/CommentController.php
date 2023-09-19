<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\CommentPosted;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Listing;
use App\Http\Requests\CommentStoreRequest;

class CommentController extends Controller
{
    /**
     * Create a new CommentController instance.
     *
     * @return void
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
        // Use the register method from the trait
        $comment = Comment::register(
            [
                'content' => $request->input('content'),
                'listing_id' => $request->input('listing_id'),
                'user_id' => auth()->user()->id,
            ],
            null, // Add any "before_function" if needed
            null, // Add any "after_function" if needed
            function ($comment) use ($request) {
                // Broadcast the new comment
                broadcast(new CommentPosted($comment))->toOthers();
                return $comment;
            },
            function ($rtn) {
                // Handle failure if needed
                // This function is called on failure
                // You can add your error handling logic here
            }
        );

        if ($comment) {
            // Redirect back to the specific listing page with a success message
            return redirect()->route('listings.show', ['listing' => $request->input('listing_id')])
                ->with('success', __('messages.success.comment'));
        } else {
            // Handle the case where comment registration fails with an error message
            return redirect()->back()->with('error', __('messages.error.comment'));
        }
    }

    /**
     * Retrieve all comments for a listing.
     *
     * @param  int  $listingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($listingId)
    {
        // Replace 'Comment' with your actual Comment model
        $comments = Comment::where('listing_id', $listingId)->latest()->get();

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
}
