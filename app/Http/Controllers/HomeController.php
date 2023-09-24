<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Listing;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();

        // Retrieve the most used tags in descending order of usage count
        $popularTags = DB::table('listing_tag')
            ->join('tags', 'listing_tag.tag_id', '=', 'tags.id')
            ->select('tags.name', DB::raw('COUNT(listing_tag.tag_id) as tag_count'))
            ->groupBy('tags.name')
            ->orderByDesc('tag_count')
            ->take(10) // Limit to the top 10 tags
            ->get();

        // Start with a base query for listings
        $listingsQuery = Listing::query();

        // Sort the listings based on the 'sort' query parameter
        $sort = $request->query('sort');
        if ($sort === 'latest') {
            $listingsQuery->orderBy('created_at', 'desc');
        } elseif ($sort === 'top') {
            $listingsQuery->withCount('likes')->orderByDesc('likes_count');
        } else {
            // Default to sorting by the most used tag
            $listingsQuery->orderByMostUsedTag();
        }

        // Fetch paginated listings
        $listings = $listingsQuery->paginate(10);

        return view('home.index', compact('listings', 'popularTags', 'categories'));
    }
}
