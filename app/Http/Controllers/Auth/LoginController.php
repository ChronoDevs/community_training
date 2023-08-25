<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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

    public function showLoginForm()
    {
        return view('auth.login'); // Customize this view as needed
    }

    protected function guard()
    {
        return Auth::guard('admin'); // Use the 'admin' guard for administrators
        return Auth::guard('web');
    }
    
    protected function authenticated(Request $request, $user)
    {
        if ($user instanceof \App\Models\Admin) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('home');
        }
    }
    
    protected function username()
    {
        $input = request()->input('email');
    
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    
        request()->merge([$fieldType => $input]);
    
        return $fieldType;
    }
}