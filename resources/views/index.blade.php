<!-- resources/views/index.blade.php -->

@include('header')

<div class="container mt-5">
    <!-- Search Section -->
    <div class="search-container">
        <input type="text" id="searchInput" class="form-control" placeholder="Search blog posts...">
        <button class="btn" id="searchButton" type="button">
            <i class="bi bi-search"></i>
        </button>
        <div id="noResults" class="text-danger mt-2" style="display: none;">Searched item is not found</div> 
    </div>

    <!-- Include Latest Posts -->
    @include('latest_blogs')

    <!-- Most Read Section -->
    @include('most_read')  <!-- This will now have data passed to it from the controller -->

    <!-- Most Liked Section -->
    @include('most_like')

    <!-- About Section -->
    @include('about')
</div>

@include('footer')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
<!-- End Scripts -->
