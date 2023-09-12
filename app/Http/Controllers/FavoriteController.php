<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Listing;

class FavoriteController extends Controller
{
    /**
     * Display the user's favorite listings.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $favorites = $user->favorites; // Assuming you have defined a "favorites" relationship in your User model.

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Add a listing to the user's favorites.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Listing $listing)
    {
        // Create a new favorite record for the current user and listing
        $favorite = Favorite::create([
            'user_id' => auth()->id(),
            'listing_id' => $listing->id,
        ]);

        if ($favorite) {
            return back()->with('success', __('validation.custom.favorites.add.success'));
        } else {
            return back()->with('error', __('validation.custom.favorites.add.error'));
        }
    }

    /**
     * Remove a listing from the user's favorites.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Listing $listing)
    {
        // Find and delete the favorite record for the current user and listing
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('listing_id', $listing->id)
            ->first();

        if ($favorite) {
            if ($favorite->delete()) {
                return back()->with('success', __('validation.custom.favorites.remove.success'));
            } else {
                return back()->with('error', __('validation.custom.favorites.remove.error'));
            }
        } else {
            return back()->with('error', __('validation.custom.favorites.remove.not_found'));
        }
    }

    /**
     * Add a listing to the user's favorites using Eloquent relationships.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToFavorites(Listing $listing)
    {
        $user = auth()->user();

        if (!$user->favorites()->where('listing_id', $listing->id)->exists()) {
            $user->favorites()->create(['listing_id' => $listing->id]);
            return back()->with('success', __('validation.custom.favorites.addToFavorites.success'));
        }

        return back()->with('error', __('validation.custom.favorites.addToFavorites.error'));
    }
}
