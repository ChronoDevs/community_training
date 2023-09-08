<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display the Tags page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Retrieve all tags along with their associated listings and paginate them
        $tags = Tag::with('listings')->paginate(10); // Adjust 10 to your desired number of tags per page

        // Pass the $tags variable to the tags index view
        return view('tags.index', compact('tags'));
    }
}
