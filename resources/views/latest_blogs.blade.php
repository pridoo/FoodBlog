<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Blogs</title>

    {{-- Link to the CSS file --}}
    <link rel="stylesheet" href="{{ asset('css/latest_blogs.css') }}">
</head>

<body>
    <!-- Latest Blogs Section -->
    <section id="latest-blogs">
        <div class="container">
            <h2 class="latest-blogs-title">Latest Blogs</h2>

            @if(isset($latestBlogs) && $latestBlogs->isNotEmpty())
                <div class="blogs">
                    @foreach($latestBlogs as $blog)
                        <!-- Wrap each blog post in a wrapper with class 'blog-post-wrapper' -->
                        <div class="blog-post-wrapper" data-title="{{ $blog->title }}">
                            <div class="blog-image">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
                                @else
                                    <img src="{{ asset('images/default.jpg') }}" alt="Default Image">
                                @endif
                            </div>
                            <div class="blog-post">
                                <h5>{{ $blog->title }}</h5>
                                <!-- Render the content as raw HTML (preserving formatting like bold, H1, etc.) -->
                                <p>{!! Str::limit($blog->content, 150, '...') !!}</p>
                                <a href="{{ route('blog.show', $blog->id) }}" class="btn-link">Read More</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="no-blogs">No blogs available at the moment.</p>
            @endif
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Debouncing function for search input optimization
        function debounce(func, delay) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Normalize the search string for easier matching
        function normalizeString(str) {
            return str.replace(/\s+/g, '').toLowerCase();
        }

        // Function to check if the post matches the search
        function matchesSearch(postText, searchTerm) {
            const normalizedPostText = normalizeString(postText);
            const normalizedSearchTerm = normalizeString(searchTerm);
            const searchTokens = normalizedSearchTerm.split(/\s+/);
            return searchTokens.every(token => normalizedPostText.includes(token));
        }

        // Event listener for input field
        document.getElementById('searchInput').addEventListener('input', debounce(function() {
            const filter = this.value.trim();  // Get the input value and trim spaces
            const blogPosts = document.querySelectorAll('.blog-post-wrapper'); // All blog post wrappers
            
            let hasVisiblePosts = false;  // Flag to track if there are visible posts

            // Handle Blog Post Visibility
            blogPosts.forEach(function(post) {
                const text = post.querySelector('.blog-post').innerText.toLowerCase();
                if (matchesSearch(text, filter)) {
                    post.style.display = 'flex';  // Show matching posts (use flex if that's the layout)
                    hasVisiblePosts = true;
                } else {
                    post.style.display = 'none';  // Hide non-matching posts
                }
            });

            // Toggle "No results found" message visibility
            const noResultsMessage = document.querySelector('.no-blogs');
            if (hasVisiblePosts) {
                noResultsMessage.style.display = 'none'; // Hide message if results exist
            } else {
                noResultsMessage.style.display = 'block'; // Show message if no results
            }

        }, 300)); // Delay of 300ms to debounce the input
    </script>
</body>

</html>
