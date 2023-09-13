<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Support\Facades\Config;
use League\Csv\Writer;

class ListingController extends Controller
{
       /**
     * Retrieve and display a list of listings with associated users and tags.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function posts()
    {
        // Fetch listings with their associated users and tags
        $listings = Listing::with('user', 'tags')->paginate(config('const.page_pagination'));

        return view('admin.posts', ['listings' => $listings]);
    }

    /**
     * Display the inspection view for a specific listing.
     *
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Contracts\View\View
     */
    public function inspectListing(Listing $listing)
    {
        return view('admin.inspect_listing', ['listing' => $listing]);
    }

    /**
     * Update the status of a listing based on the provided status and action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Listing  $listing
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateListingStatus(Request $request, Listing $listing)
    {
        $status = $request->input('status');
        $action = $request->input('action');

        // Call the custom method on the Listing instance
        $message = $listing->updateListingStatus($status, $action);

        if ($message === false) {
            return redirect()->back()->with('error',  __('messages.error.create'));
        }

        // Redirect back with the success message
        return redirect()->back()->with('success',  __('messages.success.update'));
    }

    public function filterListings(Request $request)
    {
        $status = $request->input('status');
        
        // Fetch filtered listings based on the selected status
        $listings = Listing::where('status', $status)->get();
        
        return response()->json(['listings' => $listings]);
    }
}
