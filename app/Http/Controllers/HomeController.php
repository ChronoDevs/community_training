<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Listing;
use App\Enums\ListingSort;

class HomeController extends Controller
{
    /**
     * Display the home page with listings and popular tags.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();

        // Sort the listings based on the 'sort' query parameter or use the default
        $sort = $request->query('sort', ListingSort::MOST_USED_TAG);
        $listings = Listing::sortBy($sort)->paginate(ListingSort::TOP_TAGS_LIMIT());

        // Retrieve the most used tags with the limit from the enum
        $popularTags = Listing::mostUsedTags(ListingSort::TOP_TAGS_LIMIT());

        return view('home.index', compact('listings', 'popularTags', 'categories'));
    }
}
