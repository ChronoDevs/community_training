<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * This middleware checks if the user is logged in as an admin. If the user is not logged in as an admin, the user will be redirected to the admin login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            // If the user is logged in as an admin, allow the request to proceed
            return $next($request);
        }

        // If the user is not logged in as an admin, perform redirection based on the intended URL
        $intendedUrl = url()->previous();

        // Define URLs that should not trigger a redirect (e.g., login, logout, etc.)
        $excludedUrls = [
            route('auth.login'), // Adjust this based on your login route
            route('auth.logout'), // Adjust this based on your logout route
        ];

        if (!in_array($intendedUrl, $excludedUrls)) {
            // Redirect the user to the admin login page
            return redirect()->route('auth.login'); // Adjust this based on your login route
        }

        // If the intended URL is an excluded URL, allow the request to proceed
        return $next($request);
    }
}
