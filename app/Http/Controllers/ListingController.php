<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ListingStoreRequest;
use App\Http\Requests\ListingUpdateRequest;
use App\Models\Listing;
use App\Models\ListingLike;
use App\Models\Category;
use App\Models\Tag;
use App\Enums\ListingAction;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all listings from the database
        $listings = Listing::where('status', ListingAction::PUBLISH)->paginate(10);

        // Return the listings view with the data
        return view('listings.index', compact('listings'));
    }

    /**
     * Display the specified listing.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        return view('listings.show', compact('listing'));
    }

    /**
     * Show the form for creating a new listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retrieve the list of available tags and categories
        $tags = Tag::all();
        $categories = Category::all();

        return view('listings.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created listing in storage.
     *
     * @param  \App\Http\Requests\ListingStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListingStoreRequest $request)
    {
        // Attempt to create a new listing
        $listing = Listing::createListing($request);

        // Check if the listing was successfully created
        if ($listing) {
            // Attach the selected category to the listing
            $listing->categories()->attach($request->input('category'));

            return redirect()->route('listings.index')->with('success', 'Listing created successfully!');
        } else {
            // Handle the case where listing creation failed
            return redirect()->back()->with('error', 'Failed to create the listing. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified listing.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        // Check if the authenticated user is the creator of the listing
        if (Gate::denies('update-listing', $listing)) {
            abort(403, 'Unauthorized');
        }

        // Retrieve the list of available tags and categories
        $tags = Tag::all();
        $categories = Category::all();

        return view('listings.edit', compact('listing', 'tags', 'categories'));
    }

    /**
     * Update the specified listing in storage.
     *
     * @param  \App\Http\Requests\ListingUpdateRequest  $request
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(ListingUpdateRequest $request, Listing $listing)
    {
        // Check if the authenticated user is the creator of the listing
        if (Gate::denies('update-listing', $listing)) {
            abort(403, 'Unauthorized');
        }

        // Prepare data for the update (title, description, tags, category)
        $data = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'tags' => $request->input('tags'),
            'category' => $request->input('category'),
        ];

        // Use the custom update method in the Listing model
        if ($listing->updateListing($data)) {
            return redirect()->route('listings.index')->with('success', 'Listing updated successfully!');
        } else {
            // Handle the case where the update fails within the transaction
            return back()->with('error', 'Failed to update the listing.');
        }
    }

    /**
     * Remove the specified listing from storage.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        // Check if the authenticated user is the creator of the listing
        if (Gate::denies('delete-listing', $listing)) {
            abort(403, 'Unauthorized');
        }

        // Soft delete the listing (including 'deleted_by' and 'deleted_at' updates)
        $listing->softDelete();

        // Check if the listing was successfully deleted
        if ($listing->trashed()) {
            return redirect()->route('listings.index')->with('success', 'Listing deleted successfully!');
        } else {
            return redirect()->route('listings.index')->with('error', 'Failed to delete the listing.');
        }
    }

    /**
     * Like the listing.
     *
     * @param \App\Models\Listing $listing
     * @return \Illuminate\Http\Response
     */
    public function like(Listing $listing)
    {
        $user = auth()->user();

        if (!$listing->likes()->where('user_id', $user->id)->exists()) {
            $listing->likes()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }

    /**
     * Unlike the listing
     *
     * @param \App\Models\Listing $listing
     * @return \Illuminate\Http\Response
     */
    public function unlike(Listing $listing)
    {
        $listing->unlike(auth()->user());

        return redirect()->back();
    }
}
