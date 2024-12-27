<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    // Redirect to Google for authentication
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback function after Google authentication
    public function callbackGoogle()
    {
        try {
            // Get the authenticated Google user
            $google_user = Socialite::driver('google')->stateless()->user(); // Using stateless for better session handling

            // Log the Google user data for debugging (manually extracting values)
            Log::info('Google User Data:', [
                'id' => $google_user->getId(),
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'avatar' => $google_user->getAvatar()
            ]);

            // Find the user by Google ID
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                // If no user is found with Google ID, check by email
                $user = User::where('email', $google_user->getEmail())->first();

                if (!$user) {
                    // Create a new user if not found by email
                    $user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'google_id' => $google_user->getId(),
                    ]);
                } else {
                    // If user with the same email exists, update the Google ID
                    $user->google_id = $google_user->getId();
                    $user->save();
                }
            }

            // Log the user in
            Auth::login($user);

            // Log the user login data for debugging (manually extracting values)
            Log::info('User logged in:', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            // Redirect to intended route or homepage
            return redirect()->intended('/');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Handle invalid state error (common with OAuth)
            Log::error('Google authentication error: Invalid State', ['error' => $e->getMessage()]);
            return redirect()->route('login')->withErrors('Google authentication failed. Please try again.');

        } catch (\Exception $e) {
            // Log and handle general exceptions
            Log::error('Google authentication error:', ['error' => $e->getMessage()]);
            return redirect()->route('login')->withErrors('Something went wrong: ' . $e->getMessage());
        }
    }
}
