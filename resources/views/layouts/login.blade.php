<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('new-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new-assets/css/style.css') }}">
    <style>
        /* Background gradient */
        body.login-page {
            background: grey; 
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        /* Login container */
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

      

        /* Form input */
        .form-control {
            border-radius: 30px;
            padding: 15px;
            border: 1px solid #ddd;
        }

        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 5px rgba(37, 117, 252, 0.5);
        }

        /* Button styles */
        .btn-primary {
            background: #2575fc;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 16px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #1a5dbb;
        }

        /* Footer link */
        .card-footer {
            margin-top: 20px;
        }

        .card-footer a {
            color: #2575fc;
            text-decoration: none;
            font-weight: bold;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        /* Decorative line */
        hr {
            border-top: 2px solid #ddd;
            margin: 20px 0;
        }

        /* Remember Me checkbox */
        .remember-me {
            text-align: left;
        }

        .form-check-label {
            font-size: 14px;
        }

        /* Error message */
        .error-message {
            font-size: 12px;
            color: red;
        }
    </style>
</head>

<body class="login-page">
    <div class="login-container">
        <!-- Logo -->
        <div class="logo">
         
        </div>
        
        <!-- Title -->
        <h2 class="mb-3">Welcome Back</h2>
        <p class="text-muted mb-4">Please login to continue</p>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                <div class="error-message"></div> <!-- Error Message Placeholder -->
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                <div class="error-message"></div> <!-- Error Message Placeholder -->
            </div>
            <div class="mb-3 form-check remember-me">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Footer -->
        <div class="card-footer">
            <p class="text-muted">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
        </div>
    </div>

    <script src="{{ asset('new-assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('new-assets/js/script.js') }}"></script>
</body>

</html>
