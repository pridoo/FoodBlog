<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Add a new comment to a blog post.
     */
    public function addComment(Request $request)
    {
        // Validate the request
        $request->validate([
            'blog_id' => 'required|integer|exists:blogs,id',
            'content' => 'required|string|max:1000',
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'You must be logged in to comment.'], 403);
        }

        try {
            // Create a new comment
            $comment = Comment::create([
                'blog_id' => $request->input('blog_id'),
                'user_id' => Auth::id(),
                'content' => $request->input('content'),
            ]);

            // Return the newly created comment as a JSON response
            return response()->json([
                'message' => 'Comment added successfully.',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'email' => Auth::user()->email, // Ensure email is passed
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while adding the comment.'], 500);
        }
    }

    /**
     * Fetch comments for a blog post.
     */
    public function fetchComments(Request $request)
    {
        // Validate the request
        $request->validate([
            'blog_id' => 'required|integer|exists:blogs,id',
        ]);

        // Fetch comments for the specified blog post
        $comments = Comment::where('blog_id', $request->input('blog_id'))
            ->orderBy('created_at', 'desc')
            ->get(['id', 'content', 'created_at', 'user_id'])
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                    'email' => $comment->user->email, // Get the email from the user relationship
                ];
            });

        // Return the comments as a JSON response
        return response()->json($comments);
    }
}
