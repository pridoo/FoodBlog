<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <h2>Welcome to TasteBud Chronicles</h2>
            <p>Experience the best recipes and culinary adventures with us.</p>
            <div class="logo-container">
                <img src="css/uploads/logo1.png" alt="TasteBud Logo" class="logo">
                <img src="css/uploads/logo2.png" alt="University Logo" class="logo">
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="glass-container">
                <h1 class="text-center" style="font-family: Georgia; font-size: 30px;">Login</h1>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" required value="{{ old('email') }}" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-danger btn-block">Login</button>
                </form>

                <!-- Register Link -->
                <p class="mt-3 text-center">Don't have an account? <a href="{{ route('register') }}" class="register-link">Register here</a></p>

                <!-- Social Login Buttons -->
                <div class="social-login">
                    <a href="{{ route('google-auth') }}" class="btn-social google">
                        <i class="fab fa-google"></i> Login with Google
                    </a>
                    <a href="{{ route('facebook-auth') }}" class="btn-social facebook">
                        <i class="fab fa-facebook-f"></i> Login with Facebook
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
