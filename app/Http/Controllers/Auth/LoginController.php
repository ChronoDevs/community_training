<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Customize this view as needed
        // This method displays the login form.
    }

    /**
     * Get the guard to use for authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return Auth::guard('admin'); // Use the 'admin' guard for administrators
        // This method returns the guard to use for authentication.
    }

    /**
     * Handle an authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user instanceof \App\Models\Admin) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('home');
        }
        // This method is called after a user is authenticated. It redirects the user to the appropriate dashboard.
    }

    /**
     * Determine the username to use for authentication.
     *
     * @return string
     */
    protected function username()
    {
        $input = request()->input('email');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        request()->merge([$fieldType => $input]);

        return $fieldType;
        // This method determines the username to use for authentication. By default, it uses the email address, but it can be customized to use another field.
    }

    /**
     * Log the user out and perform necessary actions
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
