<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display an individual blog post.
     *
     * @param int $id Blog ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        $comments = Comment::with('user')
            ->where('blog_id', $id)
            ->latest()
            ->get();

        $likeCount = Like::where('blog_id', $id)->count();

        $hasLiked = Auth::check() && Like::where('blog_id', $id)->where('user_id', Auth::id())->exists();

        return view('blog', [
            'blog' => $blog,
            'comments' => $comments,
            'likeCount' => $likeCount,
            'hasLiked' => $hasLiked,
        ]);
    }

    /**
     * Display all blog posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch the latest 10 blogs with pagination
        $blogs = Blog::latest()->paginate(10);
        
        // Fetch the 5 latest blogs (if needed for another section)
        $latestBlogs = Blog::latest()->take(10)->get();
        
        // Fetch the most-read blogs based on comments count
        $mostReadBlogs = Blog::withCount('comments')
            ->having('comments_count', '>', 0)
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();

        // Fetch the most-liked blogs based on the like count
        $mostLikedPosts = Blog::withCount('likes')
            ->having('likes_count', '>', 0)
            ->orderBy('likes_count', 'desc')
            ->take(3)
            ->get();

        return view('index', [
            'blogs' => $blogs,
            'latestBlogs' => $latestBlogs,
            'mostReadBlogs' => $mostReadBlogs, // Pass the most-read blogs to the view
            'mostLikedPosts' => $mostLikedPosts, // Pass the most-liked blogs to the view
        ]);
    }

    /**
     * Display the latest blogs.
     *
     * @return \Illuminate\View\View
     */
    public function latestBlogs()
    {
        $latestBlogs = Blog::latest()->get();

        return view('latest_blogs', [
            'latestBlogs' => $latestBlogs,
        ]);
    }
}
