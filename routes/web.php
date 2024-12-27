<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Middleware\IsAdmin;

Route::get('/', [BlogController::class, 'index'])->name('index');


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

Route::get('auth/facebook', [FacebookAuthController::class, 'callbackFacebook']);
Route::get('auth/facebook/call-back', [FacebookAuthController::class, 'facebookRedirect']);

// Admin Routes (Protected by Middleware)
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');  // Admin dashboard
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store'); 
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

// Blog Routes
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.list');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/latest-blogs', [BlogController::class, 'latestBlogs'])->name('latest.blogs');

// Most-read (Most commented) Blog Route
Route::get('/most-read', [BlogController::class, 'getMostCommentedBlogs'])->name('most.read');

// Like and Comment Routes
Route::post('/like', [LikeController::class, 'like'])->name('like-unlike');  // Like route with name 'like-unlike'

// Like and Unlike Post Route
Route::post('/blog/like-unlike', [LikeController::class, 'likeUnlikePost'])->name('likeUnlikePost');  // Unique route name 'likeUnlikePost'

// Comment Route
Route::post('/comment', [CommentController::class, 'addComment'])->name('add-comment');

// Fetch Likers Route
Route::post('/blog/{id}/likers', [LikeController::class, 'fetchLikers'])->name('fetchLikers');
// web.php
Route::post('/like-unlike', [LikeController::class, 'likeUnlikePost'])->name('like-unlike');


Route::get('/most-liked', [BlogController::class, 'index']);

Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
