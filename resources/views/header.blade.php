<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <title>Food Blog</title>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container">
        <!-- Food Blog title -->
        <a class="navbar-brand" href="{{ url('/') }}">TasteBud</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#latest-blogs">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#about-us">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#footer">Contact</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-danger" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('{{ asset('css/uploads/Dpfood.jpg') }}');">
    <div class="content">
        <h1>Taste Bud Chronicles</h1>
        <p>Express your culinary passion and share delicious recipes with the world.</p>
        <a href="#latest-blogs" class="btn btn-light btn-lg">Read More</a>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
