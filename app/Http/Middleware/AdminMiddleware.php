<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    protected $adminRoutes = [
        'admin/login',
        'admin/logout',
    ];

    protected $socialLoginRoutes = [
        'login/facebook',
        'login/facebook/callback',
        'login/google',
        'login/google/callback',
        'login/line',
        'login/line/callback',
    ];

    public function handle(Request $request, Closure $next)
    {
        // Log the current route for debugging
        \Log::info('Current Route: ' . $request->route()->getName());
    
        if (Auth::guard('admin')->check()) {
            // If the user is logged in as an admin, allow the request to proceed
            return $next($request);
        }
    
        // If the request is for any of the excluded routes, allow access without authentication
        if ($this->inExceptArray($request)) {
            return $next($request);
        }
    
        // For all other routes, perform the regular redirection logic
        if (!$request->is($this->adminRoutes) && !$request->is($this->socialLoginRoutes)) {
            // Redirect the user to the regular login page if not already there
            return redirect()->route('login'); // Adjust this based on your regular login route
        }
    
        // If the intended URL is an excluded URL, allow the request to proceed
        return $next($request);
    }     

    protected function inExceptArray($request)
    {
        $currentRoute = $request->route()->getName();

        return in_array($currentRoute, array_merge($this->adminRoutes, $this->socialLoginRoutes));
    }
}
