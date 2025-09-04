<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matnog Tourism</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/js/app.js'])
    <style>
        body {
            background: url("{{ asset('images/subiclogo.png') }}") no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            padding-top: 60px;
            padding-bottom: 60px;
            position: relative;
            overflow-y: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header {
            background: url("{{ asset('images/subiclogo1.png') }}") no-repeat center center/cover;
            height: 60px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: -1;
        }

        .container {
            position: relative;
            z-index: 1;
            display: flex;
            width: 80%;
            max-width: 1200px;
            align-items: center;
            justify-content: space-between;
            margin: 20px auto;
            flex-wrap: wrap;
        }

        .welcome-section {
            flex: 1;
            text-align: center;
            margin-right: 20px;
        }

        .welcome-text {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .explore-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 350px;
        }

        .input-group-text, .form-control {
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
        }

        .login-btn {
            background-color: black;
            color: white;
            border-radius: 20px;
            width: 100%;
        }

        .explore-btn {
            background-color: #00bfff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 1.1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .explore-btn:hover {
            background-color: #0099cc;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }

            .welcome-section {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }

        @media (min-width: 769px) {
            .container {
                justify-content: space-around;
            }

            .welcome-section {
                text-align: left;
            }
        }

        .footer {
            background: url("{{ asset('images/subiclogo2.png') }}") no-repeat center center/cover;
            height: 60px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
        }

        .toggle-password {
            cursor: pointer;
        }

        /* Added style for error messages */
        .text-danger {
            color: #dc3545; /* Bootstrap's red color for danger */
            font-size: 0.875em;
            margin-top: 0.25rem;
            text-align: left; /* Align error text to the left */
            width: 100%; /* Ensure it takes full width below the input */
        }
    </style>
</head>
<body>
    <div class="header"></div>
    <div class="overlay"></div>
    <div class="container">
        <div class="welcome-section">
            <div class="welcome-text text-center">
                <h1>Welcome to</h1>
                <h2>Matnog Tourism, Culture and Arts Office</h2>
            </div>
            <div class="explore-container text-center">
                <a href="{{ url('/explore/exploring') }}" class="explore-btn">Explore</a>
            </div>
        </div>
        <div class="login-card text-center">
            <h3 class="text-white">Login</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3 input-group flex-wrap"> {{-- Added flex-wrap for error message --}}
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" 
                           class="form-control" 
                           placeholder="Username or Number" 
                           name="login" 
                           value="{{ old('login') }}" 
                           id="loginInput" 
                           required 
                           autofocus
                           oninput="validateLoginInput(this)">
                    <div id="login_error" class="text-danger mt-1" style="display: none;">
                        The number is not enough. Please enter exactly 11 digits.
                    </div>
                    @error('login')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 input-group flex-wrap"> {{-- Added flex-wrap for error message --}}
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                    <span class="input-group-text toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </span>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <a href="/forgot-password" class="text-white">Forgot Password?</a>
                </div>
                <button type="submit" class="btn login-btn">Login</button>
            </form>
            <p class="mt-3 text-white">Don't have an account? <a href="/register" class="text-white fw-bold">Register</a></p>
        </div>
    </div>
    <div class="footer">&copy; 2025 Matnog Tourism</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        }

        // Function to validate login input (username or phone number)
        function validateLoginInput(input) {
            const value = input.value;
            const errorDiv = document.getElementById('login_error');
            
            // Check if input starts with a number (phone number)
            if (/^\d/.test(value)) {
                // Remove any non-digit characters
                const digitsOnly = value.replace(/\D/g, '');
                
                // Update the input value to only contain digits
                if (value !== digitsOnly) {
                    input.value = digitsOnly;
                }
                
                // Set maxlength to 11 for phone numbers
                input.maxLength = 11;
                input.setAttribute('maxlength', '11');
                
                // Check if the length is exactly 11 digits
                if (digitsOnly.length > 0 && digitsOnly.length !== 11) {
                    errorDiv.style.display = 'block';
                    input.classList.add('is-invalid');
                } else {
                    errorDiv.style.display = 'none';
                    input.classList.remove('is-invalid');
                }
            } else {
                // For usernames, remove maxlength and hide error
                input.removeAttribute('maxlength');
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

        // Dynamic character limit for login input
        document.addEventListener('DOMContentLoaded', function() {
            const loginInput = document.getElementById('loginInput');
            
            // Also check on page load if there's an old value
            if (loginInput.value) {
                validateLoginInput(loginInput);
            }
        });
    </script>
</body>
</html>