<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ListingStoreRequest;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Tag;

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
        $listings = Listing::paginate(5);

        // Return the listings view with the data
        return view('listings.index', compact('listings'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listing = Listing::createListing($request);

        // Attach the selected category to the listing
        $listing->categories()->attach($request->input('category'));

        return redirect()->route('listings.index')->with('success', 'Listing created successfully!');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing)
    {
        // Check if the authenticated user is the creator of the listing
        if (Gate::denies('update-listing', $listing)) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'tags' => 'array', // Ensure 'tags' is an array in the request
        ]);

        $listing->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Sync tags for the listing
        $listing->tags()->sync($request->input('tags'));

        // Update the selected category for the listing
        $listing->categories()->sync($request->input('category'));

        return redirect()->route('listings.index')->with('success', 'Listing updated successfully!');
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

        // Update the 'deleted_by' column with the ID of the user who deleted the listing
        $listing->update([
            'deleted_by' => Auth::id(),
        ]);

        // Soft delete the listing
        $listing->delete();

        return redirect()->route('listings.index')->with('success', 'Listing deleted successfully!');
    }
}
