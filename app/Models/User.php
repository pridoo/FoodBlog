<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username', // Added username
        'role',  
        'google_id',
        'facebook_id',   // Added role
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Register a new user.
     */
    public static function register($username, $email, $password)
    {
        // Check if username or email already exists
        if (self::where('email', $email)->exists() || self::where('username', $username)->exists()) {
            return false; // Registration failed
        }

        // Create the user with a default role 'user'
        self::create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password), // Hash password for security
            'role' => 'user', // Default role
        ]);

        return true; // Registration successful
    }

    /**
     * Login a user.
     */
    public static function login($email, $password)
    {
        $user = self::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            return true; // Login successful
        }

        return false; // Invalid credentials
    }

    /**
     * Find user by email.
     */
    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    /**
     * Register a social media user.
     */
    public static function registerSocialUser($email, $name, $role = 'user')
    {
        if (!self::where('email', $email)->exists()) {
            self::create([
                'email' => $email,
                'name' => $name,
                'role' => $role,
                'password' => Hash::make(\Str::random(16)), // Generate random password
            ]);
        }
    }

    /**
     * Relationships: A user can have many blogs, comments, and likes.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

     // Register a user with Google
    public static function registerGoogleUser($email, $name)
    {
        // Check if the user already exists
        $user = self::where('email', $email)->first();
        
        if (!$user) {
            // If user doesn't exist, create a new one
            $user = self::create([
                'email' => $email,
                'name' => $name,
                'role' => 'user',
            ]);
        }

        return $user;
    }

    // Register a user with Facebook
    public static function registerFacebookUser($email, $name)
    {
        // Check if the user already exists
        $user = self::where('email', $email)->first();

        if (!$user) {
            // If user doesn't exist, create a new one
            $user = self::create([
                'email' => $email,
                'name' => $name,
                'role' => 'user',
            ]);
        }

        return $user;
    }

}
