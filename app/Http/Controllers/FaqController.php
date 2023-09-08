<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display the FAQs page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Return the FAQs index view
        return view('faqs.index');
    }
}
