<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="blog-container">
        <a href="{{ route('index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Blog List
        </a>
        <h1>{{ $blog->title }}</h1>
        <div class="blog-post">
            @if ($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="blog-image">
            @endif
            <div class="post-details">
                <!-- Render the content as raw HTML (preserving formatting like bold, H1, etc.) -->
                <p>{!! nl2br($blog->content) !!}</p>

                {{-- Like Button --}}
                @auth
                    <input type="hidden" name="blog_id" value="{{ $blog->id }}"> <!-- Added hidden blog_id input -->
                    <button type="button" id="likeButton" data-liked="{{ $hasLiked ? 'true' : 'false' }}">
                        <span class="heart-icon">❤️</span>
                        {{ $hasLiked ? 'Unlike' : 'Like' }}
                    </button>
                    <span id="likeCount">{{ $likeCount }} Likes</span>
                @else
                    <p>Please <a href="{{ route('login') }}">log in</a> to like this post.</p>
                @endauth

                {{-- Comments Section --}}
                <h2>Comments</h2>
                <div class="comments-section">
                    @forelse ($comments as $comment)
                        <div class="comment" id="comment_{{ $comment->id }}">
                            <strong>{{ $comment->user->email ?? 'Anonymous' }}</strong>
                            <p>{{ $comment->content }}</p>
                            <small>{{ $comment->created_at }}</small>
                        </div>
                    @empty
                        <p>No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>

                {{-- Add Comment Form --}}
                @auth
                    <h3>Add a Comment</h3>
                    <form id="commentForm" method="POST">
                        @csrf
                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                        <textarea name="content" id="commentContent" placeholder="Write your comment here..." required></textarea>
                        <button type="submit" name="submitComment">Submit Comment</button>
                    </form>
                @else
                    <p>Please <a href="{{ route('login') }}">log in</a> to leave a comment.</p>
                @endauth
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Like/Unlike functionality (AJAX)
            $('#likeButton').click(function () {
                const blogId = $('input[name="blog_id"]').val(); // Get the blog id
                const isLiked = $(this).data('liked'); // Check if already liked

                $.ajax({
                    url: '{{ route("like-unlike") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        blog_id: blogId,  // Send the blog id
                        action: isLiked ? 'unlike' : 'like',  // Send the action (like or unlike)
                    },
                    success: function (response) {
                        // Update the like count and button text based on response
                        $('#likeCount').text(response.likeCount + ' Likes');
                        $('#likeButton').text(response.hasLiked ? 'Unlike' : 'Like');
                        $('#likeButton').data('liked', response.hasLiked); // Update the liked data
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message); // Show error message if any
                    }
                });
            });

            // Comment submission functionality (AJAX)
            $('#commentForm').submit(function (e) {
                e.preventDefault();  // Prevent default form submission

                const blogId = $('input[name="blog_id"]').val();  // Get the blog id
                const content = $('#commentContent').val();  // Get the content of the comment

                $.ajax({
                    url: '{{ route("add-comment") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        blog_id: blogId,  // Send the blog id
                        content: content,  // Send the comment content
                    },
                    success: function (response) {
                        // Clear the comment field and prepend the new comment
                        $('#commentContent').val('');
                        $('.comments-section').prepend(`
                            <div class="comment" id="comment_${response.comment.id}">
                                <strong>${response.comment.email}</strong>
                                <p>${response.comment.content}</p>
                                <small>${response.comment.created_at}</small>
                            </div>
                        `);
                    },
                    error: function (xhr) {
                        alert('Error: ' + xhr.responseJSON.message); // Show error message if any
                    }
                });
            });
        });
    </script>
</body>

</html>
