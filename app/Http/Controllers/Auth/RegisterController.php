<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\User\Auth\RegisterRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * User registration
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    protected function register(RegisterRequest $request)
    {
        $user = User::register($request->validated());
    
        if (!$user) {
            return redirect()->back()->withErrors($request->errors());
        }
    
        return redirect()->route('home')->with('success', 'Registration successful! Welcome to our platform.');
    }       
}
