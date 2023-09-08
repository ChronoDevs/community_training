<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the post-logout redirect path.
     *
     * @return string
     */
    public function redirectTo()
    {
        return RouteServiceProvider::HOME;
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $this->registerOrLoginUser($user);

        // Returns to home after login
        return redirect()->route('home.index');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $this->registerOrLoginUser($user);

        // Returns to home after login
        return redirect()->route('home.index');
    }

    /**
     * Redirect the user to LINE for authentication.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToLine()
    {
        return Socialite::driver('line')->redirect();
    }

    /**
     * Handle the callback from LINE.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLineCallback()
    {
        try {
            $lineUser = Socialite::driver('line')->user();
        
            // Check if the LINE user is already registered in your database based on their LINE ID
            $user = User::where('line_id', $lineUser->getId())->first();
        
            if (!$user) {
                // If the user doesn't exist, create a new user
                $user = new User();
                $user->name = $lineUser->getName();
                $user->email = $lineUser->getEmail() ?? 'line_user@example.com'; // Use a default email if LINE user has no email
                $user->line_id = $lineUser->getId(); // Store LINE ID for future reference
                $user->password = bcrypt(Str::random(8)); // Temporary random password
                $user->save();
            }
        
            // Authenticate the user (you may use Laravel's Auth system)
            Auth::login($user);
        
            // Redirect to the home page or any other desired route
            return redirect()->route('home.index');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('LINE login error: ' . $e->getMessage());
        
            // Redirect to the error page with a user-friendly message
            return redirect('/error')->with('error', 'LINE login failed. Please try again later.');
        }
    }

    /**
     * Register or login the user based on provided data.
     *
     * @param  \Laravel\Socialite\AbstractUser  $data
     * @return void
     */
    protected function registerOrLoginUser($data)
    {
        $existingUser = User::where('email', $data->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->password = bcrypt('random_password'); // Set a temporary random password
            $user->save();

            Auth::login($user);
        }
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
