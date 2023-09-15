<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\CommentPosted;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Listing;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('like');
    }

    /**
     * Store a new comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'content' => 'required|string',
            // Add any other validation rules as needed
        ]);

        // Create a new comment in the database
        $comment = new Comment([
            'content' => $request->input('content'),
            'listing_id' => $request->input('listing_id'),
            'user_id' => auth()->user()->id, // Associate the comment with the authenticated user
        ]);

        $comment->save();

        // Broadcast the new comment
        broadcast(new CommentPosted($comment))->toOthers();

        // Redirect back to the specific listing page
        return redirect()->route('listings.show', ['listing' => $request->input('listing_id')])
            ->with('success', 'Comment posted successfully');
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
        // return response()->json(['comments' => $comments]);
    }

    /**
     * Like a comment and reload the page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $commentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like(Request $request, $commentId)
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

            return redirect()->back()->with('success', 'Comment unliked successfully');
        } else {
            // User has not liked the comment, create a new like
            $commentLike = new CommentLike([
                'user_id' => $userId,
            ]);

            $comment->likes()->save($commentLike);

            return redirect()->back()->with('success', 'Comment liked successfully');
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
        }

        // Redirect back to the page (the comment's parent listing) after unliking
        return redirect()->route('listings.show', ['listing' => $comment->listing_id])
            ->with('success', 'Comment unliked successfully');
    }
}
