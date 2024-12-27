<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use Mews\Purifier\Facades\Purifier;

class AdminController extends Controller
{
    /**
     * Display all blog posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all blog posts from the database
        $blogs = Blog::all();

        return view('admin.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created blog post.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Optional image upload
        ]);

        // Sanitize the content using a stricter configuration for Purifier
        $content = Purifier::clean($request->input('content'), [
            'HTML.Allowed' => 'p,strong,em,u,ul,ol,li,br,img,embed', // Allow <embed> tag
            'HTML.AllowedAttributes' => 'img.src,img.alt,embed.src', // Allow 'src' attribute for <embed> tag
            'CSS.AllowedProperties' => [], // Removes all inline styles (CSS properties)
            'HTML.SafeIframe' => true, // Allow safe iframe tags if needed
            'HTML.SafeEmbed' => true, // Remove unsafe embeds
        ]);

        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images', 'public');
        }

        // Store the new blog post in the database
        Blog::create([
            'title' => $request->input('title'),
            'content' => $content,
            'image' => $imagePath, // Save the image path if uploaded
        ]);

        return redirect()->route('admin.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Show the form for editing a blog post.
     *
     * @param int $id Blog ID
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.edit', compact('blog'));
    }

    /**
     * Update an existing blog post.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Blog ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Optional image upload
        ]);

        // Fetch the blog post to update
        $blog = Blog::findOrFail($id);

        // Sanitize the content using a stricter configuration for Purifier
        $content = Purifier::clean($request->input('content'), [
            'HTML.Allowed' => 'p,strong,em,u,ul,ol,li,br,img,embed', // Allow <embed> tag
            'HTML.AllowedAttributes' => 'img.src,img.alt,embed.src', // Allow 'src' attribute for <embed> tag
            'CSS.AllowedProperties' => [], // Removes all inline styles (CSS properties)
            'HTML.SafeIframe' => true, // Allow safe iframe tags if needed
            'HTML.SafeEmbed' => true, // Remove unsafe embeds
        ]);

        // Handle image upload if present
        $imagePath = $blog->image;
        if ($request->hasFile('image')) {
            // Delete the old image if a new one is uploaded
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('blog_images', 'public');
        }

        // Update the blog post in the database
        $blog->update([
            'title' => $request->input('title'),
            'content' => $content,
            'image' => $imagePath, // Save the new image path if uploaded
        ]);

        return redirect()->route('admin.index')->with('success', 'Blog post updated successfully.');
    }

    /**
     * Delete a blog post.
     *
     * @param int $id Blog ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Delete the blog image if it exists
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        // Delete the blog post
        $blog->delete();

        return redirect()->route('admin.index')->with('success', 'Blog post deleted successfully.');
    }

    /**
     * Logout the authenticated user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout(); // Logs out the authenticated user
        return redirect()->route('login'); // Redirects to the login page
    }

    

    
}
