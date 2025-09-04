<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Matnog Tourism</title>
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
            justify-content: center;
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

        .reset-card {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .input-group-text, .form-control {
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
        }

        .reset-btn {
            background-color: black;
            color: white;
            border-radius: 20px;
            width: 100%;
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

        .text-danger {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
            text-align: left;
            width: 100%;
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
            <div class="text-center">
                <p class="mb-0">Set your new password</p>
            </div>
        </div>
        <div class="reset-card text-center">
            <h3 class="text-white mb-4">Reset Password</h3>
            
            <div class="mb-3 text-white">
                <small>Please enter your new password below.</small>
            </div>

            @if ($errors->any())
                <div class="mb-3">
                    <div class="text-danger">
                        <small><i class="fas fa-exclamation-triangle"></i> Whoops! Something went wrong.</small>
                    </div>
                    <ul class="mt-2 list-unstyled text-danger">
                        @foreach ($errors->all() as $error)
                            <li><small>{{ $error }}</small></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                
                <div class="mb-3 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input 
                        type="password" 
                        class="form-control" 
                        placeholder="New Password" 
                        name="password" 
                        id="password"
                        required 
                        autofocus
                    >
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input 
                        type="password" 
                        class="form-control" 
                        placeholder="Confirm New Password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        required 
                    >
                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                        <i class="fas fa-eye" id="togglePasswordConfirmationIcon"></i>
                    </button>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn reset-btn mb-3">
                    <i class="fas fa-key"></i> Reset Password
                </button>
            </form>

            <div class="mt-3">
                <a href="{{ route('login') }}" class="btn btn-link text-white p-0">
                    <small><i class="fas fa-arrow-left"></i> Back to Login</small>
                </a>
            </div>
        </div>
    </div>
    <div class="footer">&copy; 2025 Matnog Tourism</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility for password field
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        // Toggle password visibility for password confirmation field
        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordField = document.getElementById('password_confirmation');
            const toggleIcon = document.getElementById('togglePasswordConfirmationIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
