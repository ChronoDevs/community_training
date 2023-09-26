<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreateTagRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Listing;
use App\Models\Favorite;
use App\Models\ListingLike;

class DashboardController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        $postCount = Listing::count(); // Get the total number of posts/listings
        $likeCount = ListingLike::count(); // Get the total number of likes
        $favoriteCount = Favorite::count(); // Get the total number of favorites
        
        return view('admin.dashboard.index', compact('postCount', 'likeCount', 'favoriteCount'));
    }
}
