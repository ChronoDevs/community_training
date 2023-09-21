<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreateTagRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('admin.dashboard.index');
    }
}
