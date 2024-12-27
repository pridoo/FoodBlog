<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Liked Blogs</title>
    <link rel="stylesheet" href="{{ asset('css/most_like.css') }}"> <!-- Link to your CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for like icon -->
</head>
<body>

<!-- Most Liked Blogs Section -->
<div class="container mt-5">
    <h1 class="text-center">Most Liked Blogs</h1>

    <!-- Blog posts container -->
    <div class="row most-liked-container">
        @foreach ($mostLikedPosts as $post)
            <div class="col-md-12 most-liked-post">
                <div class="post-content">
                    <h2>{{ $post->title }}</h2>

                    <!-- Render the content -->
                    <p>{!! $post->content !!}</p>

                    <div class="like-info">
                        <i class="fas fa-heart like-icon" data-id="{{ $post->id }}"></i> <!-- Like icon with post ID -->
                        <span class="like-count">{{ $post->like_count }} Likes</span>
                    </div>
                </div>
                <div class="post-image">
                    <!-- Correct image path, without showing the path in the HTML -->
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Blog Image" class="img-fluid">
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal for displaying likers -->
<div class="modal fade" id="likersModal" tabindex="-1" aria-labelledby="likersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="likersModalLabel">People who liked this post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="likers-list">
                    <!-- Likers will be dynamically loaded here -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    jQuery(document).ready(function($) {
        // When a like icon is clicked
        $('.like-icon').on('click', function() {
            var blogId = $(this).data('id'); // Get the blog ID from the data attribute
            var action = 'like'; // Assuming you want to like when clicked (or you can toggle)

            $.ajax({
                url: '{{ route("likeUnlikePost") }}', // Use named route for like/unlike
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', 
                    blog_id: blogId,
                    action: action
                },
                success: function(response) {
                    // Update the like count in the UI
                    $('[data-id="' + blogId + '"]').next('.like-count').text(response.likeCount + ' Likes');

                   
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
        });

        // When a like icon is clicked, show likers in a modal
        $('.like-info').on('click', function() {
            var blogId = $(this).find('.like-icon').data('id'); // Get the blog ID
            $.ajax({
                url: '{{ url("blog") }}/' + blogId + '/likers', // Include the blog ID in the URL
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    blog_id: blogId // Send the blog ID as part of the request
                },
                success: function(response) {
                    $('#likers-list').html(response); // Insert the likers list into the modal
                    $('#likersModal').modal('show'); // Show the modal
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                }
            });
        });
    });
</script>

</body>
</html>