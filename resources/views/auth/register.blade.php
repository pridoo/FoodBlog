<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="main-container">
        <!-- Form Section -->
        <div class="left-section">
            <div class="glass-container">
                <h1>Register</h1>

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

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" placeholder="Enter username" required value="{{ old('username') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter email" required value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-danger">Register</button>
                </form>

                <p class="mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>
                <a href="/" class="mt-3 d-block">Back to Blog</a>
            </div>
        </div>

        <!-- Logo and Text Section -->
        <div class="right-section">
            <h2>Welcome to TasteBud Chronicles</h2>
            <p>Join our community by registering for an account.</p>
            <div class="logo-container">
                <img src="css/uploads/logo1.png" alt="Logo 1" class="logo">
                <img src="css/uploads/logo2.png" alt="Logo 2" class="logo">
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
