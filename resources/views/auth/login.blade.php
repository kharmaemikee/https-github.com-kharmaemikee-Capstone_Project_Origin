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
            position: relative;
            overflow-y: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }


        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.2) 100%);
            z-index: -1;
        }

        .container {
            position: relative;
            z-index: 1;
            display: flex;
            width: 90%;
            max-width: 1400px;
            align-items: center;
            justify-content: space-between;
            margin: 20px auto;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .welcome-section {
            flex: 1;
            text-align: center;
            min-width: 300px;
        }

        .welcome-text {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            line-height: 1.2;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #e3f2fd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-text h2 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #e3f2fd;
            margin: 0;
        }

        .explore-container {
            text-align: center;
            margin-top: 2rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 2rem;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 380px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .login-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #e3f2fd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }

        .input-group {
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 12px 0 0 12px;
            color: #007bff;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 0 12px 12px 0;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: #333;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.3);
            transform: translateY(-2px);
        }

        .toggle-password {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 0 12px 12px 0;
            color: #007bff;
            cursor: pointer;
            padding: 0.75rem 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
        }

        .login-btn {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: none;
            border-radius: 12px;
            width: 100%;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            position: relative;
            z-index: 1;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 123, 255, 0.6);
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .explore-btn {
            background: linear-gradient(135deg, #00bfff 0%, #0099cc 100%);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 191, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .explore-btn:hover {
            background: linear-gradient(135deg, #0099cc 0%, #007bb8 100%);
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 191, 255, 0.6);
            color: white;
        }

        .explore-btn:active {
            transform: translateY(-1px);
        }

        /* Mobile First Responsive Design */
        @media (max-width: 480px) {
            /* Extra small devices (phones, 480px and down) */


            .container {
                width: 95%;
                margin: 10px auto;
                gap: 1rem;
            }

            .welcome-text h1 {
                font-size: 1.8rem;
            }

            .welcome-text h2 {
                font-size: 1.2rem;
            }

            .login-card {
                max-width: 100%;
                padding: 1.25rem;
            }

            .login-card h3 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .form-control, .input-group-text {
                padding: 0.6rem 0.8rem;
                font-size: 0.9rem;
            }

            .login-btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .explore-btn {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }

        }

        @media (max-width: 768px) {
            /* Small devices (tablets, 768px and down) */
            .container {
                flex-direction: column;
                text-align: center;
                align-items: center;
                width: 90%;
            }

            .welcome-section {
                margin-right: 0;
                margin-bottom: 1.5rem;
                min-width: auto;
            }

            .welcome-text {
                font-size: 2.5rem;
                margin-bottom: 1.5rem;
            }

            .welcome-text h1 {
                font-size: 2rem;
            }

            .welcome-text h2 {
                font-size: 1.4rem;
            }

            .login-card {
                max-width: 100%;
                padding: 1.5rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-row .input-group {
                min-width: 100%;
                margin-bottom: 0.75rem;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            /* Medium devices (tablets, 769px to 1024px) */
            .container {
                justify-content: space-around;
                width: 85%;
            }

            .welcome-section {
                text-align: left;
                min-width: 280px;
            }

            .welcome-text h1 {
                font-size: 2.2rem;
            }

            .welcome-text h2 {
                font-size: 1.5rem;
            }

            .login-card {
                max-width: 400px;
            }
        }

        @media (min-width: 1025px) {
            /* Large devices (desktops, 1025px and up) */
            .container {
                justify-content: space-around;
                width: 90%;
                max-width: 1400px;
            }

            .welcome-section {
                text-align: left;
            }
        }

        /* Landscape orientation adjustments */
        @media (max-height: 600px) and (orientation: landscape) {


            .welcome-text {
                font-size: 2rem;
                margin-bottom: 1rem;
            }

            .welcome-text h1 {
                font-size: 1.8rem;
            }

            .welcome-text h2 {
                font-size: 1.2rem;
            }

            .login-card {
                padding: 1.25rem;
            }
        }


        .toggle-password {
            cursor: pointer;
        }

        

        /* Modern Link Styling */
        .forgot-password-link {
            color: #e3f2fd;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .forgot-password-link:hover {
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .register-link {
            color: #e3f2fd;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .register-link:hover {
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        /* Modern Error Messages */
        .text-danger {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            text-align: left;
            width: 100%;
            font-weight: 500;
            background: rgba(255, 107, 107, 0.1);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            border-left: 3px solid #ff6b6b;
        }

        .form-control.is-invalid {
            border: 2px solid #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
        }

        /* Animation for form elements */
        .login-card {
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-section {
            animation: slideInLeft 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
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
                    <a href="/forgot-password" class="forgot-password-link">Forgot Password?</a>
                </div>
                <button type="submit" class="btn login-btn">Login</button>
            </form>
            <p class="mt-3 text-white" style="position: relative; z-index: 1;">Don't have an account? <a href="/register" class="register-link">Register</a></p>
        </div>
    </div>

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