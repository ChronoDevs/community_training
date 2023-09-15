<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Notifications\PasswordResetNotification;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function sendResetResponse(Request $request, $response)
    {
        $user = $this->guard()->user();
    
        // Check if the user's password has already been reset
        if (!$user->created_at) {
            // Update the password reset timestamp
            $user->created_at = now();
            $user->save();
    
            $user->sendPasswordResetNotification($this->tokens->recent());
        }
    
        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }      
}
