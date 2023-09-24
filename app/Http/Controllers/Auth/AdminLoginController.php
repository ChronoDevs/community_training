<?php

namespace App\Http\Controllers\Auth;

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

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function redirectTo()
    {
        return route('admin.dashboard.index'); // Change this to the admin dashboard route
    }

    protected function username()
    {
        return 'user_name'; // Use the 'username' field for admin authentication
    }

    public function showLoginForm()
    {
        return view('auth.admin-login'); // Create a separate view for admin login
    }
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
