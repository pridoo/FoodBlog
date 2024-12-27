<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User; // Ensure User model exists
use Illuminate\Support\Facades\Auth;

use Exception;

class FacebookAuthController extends Controller
{
    
    public function callbackFacebook()
    {  
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookRedirect()
    {
        try {
            $facebook_user = Socialite::driver('facebook')->stateless()->user();

            // Find a user by Facebook ID
            $user = User::where('facebook_id', $facebook_user->getId())->first();

            if (!$user) {
                // Check if a user with the same email already exists
                $user = User::where('email', $facebook_user->getEmail())->first();

                if (!$user) {
                    // Create a new user if no user exists with the email
                    $user = User::firstOrCreate([
                        'name' => $facebook_user->getName(),
                        'email' => $facebook_user->getEmail(),
                        'facebook_id' => $facebook_user->getId(),
                    ]);
                } else {
                    // Update the existing user with the Facebook ID
                    $user->update([
                        'facebook_id' => $facebook_user->getId(),
                    ]);
                }
            }

            // Log in the user
            Auth::login($user);

            return redirect()->intended('http://localhost:8000');
        } catch (\Throwable $th) {
            // Handle exceptions
            return redirect()->route('login')->withErrors('Something went wrong: ' . $th->getMessage());
        }
    }

}


