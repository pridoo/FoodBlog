<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the Registration Form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle Registration Logic
    public function register(Request $request)
    {
        // Validate the registration form fields
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // password confirmation will need an additional input `password_confirmation`
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create a new user in the database
        User::create([
            'name' => $request->username,  // Store the username in the 'name' field
            'username' => $request->username,  // Store the username in the 'username' column
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'role' => 'user', // Default role is 'user'
        ]);

        // Redirect to the login page after successful registration
        return redirect()->route('login');
    }

    // Show the Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle Login Logic
    public function login(Request $request)
    {
        // Validate login fields
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (auth()->attempt($credentials)) {
            // After successful login, check the user's role
            $user = auth()->user();

            // Redirect to admin dashboard if the user is an admin
            if ($user->role == 'admin') {
                return redirect()->route('admin.index'); 
            }

            // Redirect to the index page for regular users
            return redirect()->route('index');
        }

        // If authentication fails, redirect back with error
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Log the user out and redirect to login page
    public function logout()
    {
        auth()->logout(); // Logout the user
        return redirect()->route('login'); // Redirect to login page
    }
}
