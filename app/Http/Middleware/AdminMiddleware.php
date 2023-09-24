<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            // If the user is logged in as an admin, allow the request to proceed
            return $next($request);
        }

        // If the request is for the '/admin/login' route, allow access without authentication
        if ($request->is('admin/login')) {
            return $next($request);
        }

        // For all other routes, perform the regular redirection logic
        $intendedUrl = url()->previous();

        // Define URLs that should not trigger a redirect (e.g., admin login, admin logout, etc.)
        $excludedUrls = [
            route('admin.login'), // Adjust this based on your admin login route
            route('admin.logout'), // Adjust this based on your admin logout route
        ];

        if (!in_array($intendedUrl, $excludedUrls)) {
            // Redirect the user to the admin login page
            return redirect()->route('admin.login'); // Adjust this based on your admin login route
        }

        // If the intended URL is an excluded URL, allow the request to proceed
        return $next($request);
    }
}
