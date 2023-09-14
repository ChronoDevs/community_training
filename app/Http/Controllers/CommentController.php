<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\CommentPosted; // Import the CommentPosted event
use App\Models\Comment; // Replace 'Comment' with your actual Comment model
use App\Models\Listing; // Replace 'Comment' with your actual Comment model

class CommentController extends Controller
{
    /**
     * Store a new comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'content' => 'required|string',
            // Add any other validation rules as needed
        ]);

        // Create a new comment in the database
        $comment = Comment::create([
            'content' => $validatedData['content'],
            // Add other fields if required
        ]);

        // Broadcast the new comment
        broadcast(new CommentPosted($comment))->toOthers();

        return response()->json(['message' => 'Comment posted successfully']);
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

        return response()->json(['comments' => $comments]);
    }
}
