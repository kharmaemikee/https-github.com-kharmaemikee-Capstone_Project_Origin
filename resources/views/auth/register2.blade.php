<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Step 2</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: url("{{ asset('images/subiclogo.png') }}") no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 100px;
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

        .register-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 1.5rem;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .register-card h3 {
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

        .register-btn {
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

        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 123, 255, 0.6);
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        }

        .register-btn:active {
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

            .register-card {
                max-width: 100%;
                padding: 1.25rem;
            }

            .register-card h3 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .form-control, .input-group-text, .toggle-password {
                padding: 0.6rem 0.8rem;
                font-size: 0.9rem;
            }

            .register-btn {
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

            .register-card {
                max-width: 100%;
                padding: 1.5rem;
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

            .register-card {
                max-width: 420px;
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

            .register-card {
                padding: 1.25rem;
            }
        }


        /* Modern Link Styling */
        .login-link {
            color: #e3f2fd;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .login-link:hover {
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

        /* Password strength indicator styles */
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }

        .strength-bar {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 0.25rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak .strength-fill {
            width: 25%;
            background: #ff4444;
        }

        .strength-fair .strength-fill {
            width: 50%;
            background: #ff8800;
        }

        .strength-good .strength-fill {
            width: 75%;
            background: #ffbb00;
        }

        .strength-strong .strength-fill {
            width: 100%;
            background: #00aa00;
        }

        .password-requirements {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #666;
        }

        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        .requirement.met {
            color: #00aa00;
        }

        .requirement.unmet {
            color: #ff4444;
        }

        .requirement i {
            margin-right: 0.5rem;
            font-size: 0.7rem;
        }

        /* Animation for form elements */
        .register-card {
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
        <div class="register-card text-center">
            <h3>Complete Registration</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-2 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password" oninput="checkPasswordStrength(this.value)">
                    <span class="input-group-text toggle-password" data-target="password">
                        <i class="fas fa-eye"></i>
                    </span>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Strength Indicator -->
                <div id="passwordStrength" class="password-strength" style="display: none;">
                    <div class="strength-bar">
                        <div class="strength-fill"></div>
                    </div>
                    <div class="password-requirements">
                        <div class="requirement" id="req-length">
                            <i class="fas fa-times"></i>
                            <span>At least 8 characters</span>
                        </div>
                        <div class="requirement" id="req-uppercase">
                            <i class="fas fa-times"></i>
                            <span>One uppercase letter</span>
                        </div>
                        <div class="requirement" id="req-lowercase">
                            <i class="fas fa-times"></i>
                            <span>One lowercase letter</span>
                        </div>
                        <div class="requirement" id="req-number">
                            <i class="fas fa-times"></i>
                            <span>One number</span>
                        </div>
                        <div class="requirement" id="req-special">
                            <i class="fas fa-times"></i>
                            <span>One special character</span>
                        </div>
                    </div>
                </div>

                <div class="mb-2 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                    <span class="input-group-text toggle-password" data-target="password_confirmation">
                        <i class="fas fa-eye"></i>
                    </span>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    <select name="role" id="roleSelect" class="form-control" required>
                        <option value="">Select Role</option>
                        <option value="tourist" {{ old('role') == 'tourist' ? 'selected' : '' }}>Tourist</option>
                        <option value="resort_owner" {{ old('role') == 'resort_owner' ? 'selected' : '' }}>Resort Owner</option>
                        <option value="boat_owner" {{ old('role') == 'boat_owner' ? 'selected' : '' }}>Boat Owner</option>
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                

                <button type="submit" class="btn register-btn">Register</button>
            </form>
            <p class="mt-3 text-white" style="position: relative; z-index: 1;">Already have an account? <a href="{{ route('login') }}" class="login-link">Login</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                if (input.type === "password") { input.type = "text"; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
                else { input.type = "password"; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
            });
        });

        function checkPasswordStrength(password) {
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthBar = strengthDiv.querySelector('.strength-fill');
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            // Show/hide strength indicator
            if (password.length > 0) {
                strengthDiv.style.display = 'block';
            } else {
                strengthDiv.style.display = 'none';
                return;
            }

            // Update requirement indicators
            Object.keys(requirements).forEach(req => {
                const reqElement = document.getElementById(`req-${req}`);
                const icon = reqElement.querySelector('i');
                if (requirements[req]) {
                    reqElement.classList.add('met');
                    reqElement.classList.remove('unmet');
                    icon.className = 'fas fa-check';
                } else {
                    reqElement.classList.add('unmet');
                    reqElement.classList.remove('met');
                    icon.className = 'fas fa-times';
                }
            });

            // Calculate strength score
            const score = Object.values(requirements).filter(Boolean).length;
            const strengthLevels = ['', 'strength-weak', 'strength-fair', 'strength-good', 'strength-strong'];
            
            // Reset classes
            strengthBar.parentElement.className = 'strength-bar';
            if (score > 0) {
                strengthBar.parentElement.classList.add(strengthLevels[score]);
            }

            // Validate password confirmation
            const confirmPassword = document.getElementById('password_confirmation');
            if (confirmPassword.value) {
                validatePasswordMatch();
            }
        }

        function validatePasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation');
            
            if (confirmPassword.value && password !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
                confirmPassword.classList.add('is-invalid');
            } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
            }
        }

        // Add event listener for password confirmation
        document.getElementById('password_confirmation').addEventListener('input', validatePasswordMatch);

        // Form validation before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            // Check if password meets all requirements
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };
            
            const allRequirementsMet = Object.values(requirements).every(Boolean);
            
            if (!allRequirementsMet) {
                e.preventDefault();
                alert('Password must meet all requirements: at least 8 characters, one uppercase letter, one lowercase letter, one number, and one special character.');
                return false;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match.');
                return false;
            }
        });
    </script>
</body>
</html>

