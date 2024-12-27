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
    const mostLikedPosts = document.querySelectorAll('.most-liked-post'); // Most liked posts
    
    let hasVisiblePosts = false;  // Flag to track if there are visible posts
    console.log("Searching for: " + filter); // Log the search term

    // Handle Most Liked Posts Visibility
    mostLikedPosts.forEach(function(post) {
        const text = post.querySelector('.post-content p') ? post.querySelector('.post-content p').innerText.toLowerCase() : ''; // Ensure it exists
        console.log("Post text: " + text); // Log the post text
        if (matchesSearch(text, filter)) {
            post.style.display = 'flex';  // Show matching posts (assuming flex layout)
            hasVisiblePosts = true;
        } else {
            post.style.display = 'none';  // Hide non-matching posts
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
