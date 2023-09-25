<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Get the post login / dashboard URL to redirect to.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('admin.dashboard.index'); // Change this to the admin dashboard route
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'user_name'; // Use the 'username' field for admin authentication
    }

    /**
     * Show the application's login form for admin.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('auth.admin-login'); // Create a separate view for admin login
    }

    /**
     * Handle an authenticated admin user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user instanceof \App\Models\Admin) {
            return redirect()->route('admin.dashboard.index');
        } else {
            return redirect()->route('home');
        }
        // This method is called after a user is authenticated. It redirects the user to the appropriate dashboard.
    }
}
