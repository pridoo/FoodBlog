<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container mt-5">
    <h1 style="font-size: 30px; font-family: Georgia; text-align: center">Login</h1>

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
            <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-danger">Login</button>
    </form>

    <!-- Register Link -->
    <p class="mt-3">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>

    <!-- Social Login Buttons -->
    <div class="d-flex justify-content-center mt-3">
        <!-- Google Login Button -->
        <a href="#" class="btn btn-danger mr-3">
            <i class="fab fa-google"></i> Login with Google
        </a>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <!-- Facebook Login Button -->
        <a href="#" class="btn btn-danger mr-3">
            <i class="fab fa-facebook-f"></i> Login with Facebook
        </a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
