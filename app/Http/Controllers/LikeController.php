<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Method to handle like/unlike functionality
    public function likeUnlikePost(Request $request)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return response()->json(['message' => 'Please log in to like or unlike this post.'], 401);
        }

        $blogId = $request->input('blog_id');
        $action = $request->input('action'); // 'like' or 'unlike'

        // Find the blog post
        $blog = Blog::findOrFail($blogId);

        $userId = Auth::id();

        // Check if the user has already liked the post
        $like = Like::where('blog_id', $blogId)->where('user_id', $userId)->first();

        if ($action === 'like') {
            if (!$like) {
                // Create a new like if it doesn't exist
                Like::create([
                    'blog_id' => $blogId,
                    'user_id' => $userId,
                ]);
                $hasLiked = true;
            } else {
                // If the user already liked the post, don't do anything
                $hasLiked = true;
            }
        } else if ($action === 'unlike') {
            if ($like) {
                // Delete the like if it exists
                $like->delete();
                $hasLiked = false;
            } else {
                // If the user hasn't liked the post, don't do anything
                $hasLiked = false;
            }
        } else {
            return response()->json(['message' => 'Invalid action.'], 400);
        }

        // Get the updated like count
        $likeCount = Like::where('blog_id', $blogId)->count();

        return response()->json([
            'likeCount' => $likeCount,
            'hasLiked' => $hasLiked,
        ]);
    }

    // Method to fetch likers for a specific blog post
    public function fetchLikers($id)
    {
        $blog = Blog::findOrFail($id);

        // Get all users who liked this post
        $likers = $blog->likes()->with('user:id,name')->get()->pluck('user');

        // Return a JSON response with the list of likers
        return response()->json($likers);
    }
}
