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

        .register-card {
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

        .register-btn {
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

        .text-danger {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
            text-align: left;
            width: 100%;
        }

        .toggle-password {
            cursor: pointer;
        }

        /* Tourist upload visibility */
        #touristImageGroup {
            display: none;
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
        <div class="register-card text-center">
            <h5 class="text-white">Create Account - Step 2</h5>
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                    <span class="input-group-text toggle-password" data-target="password">
                        <i class="fas fa-eye"></i>
                    </span>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
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

                <!-- Tourist Profile Image Upload (shown only if role is 'tourist') -->
                <div id="touristImageGroup" class="mb-2 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                    <input type="file" class="form-control" id="tourist_image" name="owner_image" accept="image/jpeg,image/png">
                    @error('owner_image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn register-btn">Register</button>
            </form>
            <p class="mt-2 text-white" style="font-size: 0.8rem;">Already have an account? <a href="{{ route('login') }}" class="text-white fw-bold">Login</a></p>
        </div>
    </div>
    <div class="footer">&copy; 2025 Matnog Tourism</div>

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

        // Toggle tourist image field based on role selection
        (function () {
            const roleSelect = document.getElementById('roleSelect');
            const touristImageGroup = document.getElementById('touristImageGroup');
            function toggleTouristImage() {
                touristImageGroup.style.display = roleSelect.value === 'tourist' ? 'flex' : 'none';
            }
            toggleTouristImage();
            roleSelect.addEventListener('change', toggleTouristImage);
        })();
    </script>
</body>
</html>

