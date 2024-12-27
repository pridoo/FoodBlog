=<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Read Blogs</title>

    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="{{ asset('css/most_read.css') }}?v=1"> <!-- Custom CSS with versioning to prevent caching issues -->
</head>
<body>
    <!-- Removed the extra container here -->
    <h1 class="text-center mt-5">Most Read Blogs</h1> <!-- Only one container now -->

    
    <!-- Check if mostReadBlogs is set and not empty -->
    @if(isset($mostReadBlogs) && $mostReadBlogs->isNotEmpty())
        <div class="blogs row">
            @foreach($mostReadBlogs as $blog)
                <div class="col-md-4 mb-5 blog-post-wrapper">
                    <div class="card most-read-blog">
                        <!-- Blog Image -->
                        @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="card-img-top">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Default Image" class="card-img-top">
                        @endif

                        <!-- Blog Title and Content -->
                        <div class="card-body">
                            <h2 class="card-title">{{ $blog->title }}</h2>
                            <p class="card-text">
                                {!! Str::limit(strip_tags($blog->content), 150, '...') !!}
                            </p>

                            <!-- Comments Link -->
                            <p>
                                <a href="{{ route('blog.show', $blog->id) }}" class="my-custom-btn-primary">
                                    Comments: {{ $blog->comments_count }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">No popular posts found.</p>
    @endif

    <!-- Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for search functionality -->
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
            const mostReadBlogs = document.querySelectorAll('.most-read-blog'); // Most read blogs
            let hasVisiblePosts = false;  // Flag to track if there are visible posts

            // Handle Most Read Blogs Visibility
            mostReadBlogs.forEach(function(blog) {
                const text = blog.querySelector('.card-title').innerText.toLowerCase() + ' ' + blog.querySelector('.card-text').innerText.toLowerCase();
                if (matchesSearch(text, filter)) {
                    blog.closest('.blog-post-wrapper').style.display = 'block';  // Show matching blog
                    hasVisiblePosts = true;
                } else {
                    blog.closest('.blog-post-wrapper').style.display = 'none';  // Hide non-matching blog
                }
            });

            // Toggle "No results found" message visibility
            const noResultsMessage = document.getElementById('noResults');
            if (hasVisiblePosts) {
                noResultsMessage.style.display = 'none'; // Hide message if results exist
            } else {
                noResultsMessage.style.display = 'block'; // Show message if no results
            }

        }, 300)); // Delay of 300ms to debounce the input
    </script>
</body>
</html>
