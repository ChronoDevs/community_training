<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Listing;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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

        // Fetch all listings from the database
        $listings = Listing::orderBy('created_at', 'desc')->paginate(5);

        return view('home.index', compact('listings', 'popularTags', 'categories'));
    }
}
