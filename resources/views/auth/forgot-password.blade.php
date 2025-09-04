<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matnog Tourism - Forgot Password</title>
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
            justify-content: space-around; /* Changed to space-around to match login layout */
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

        .forgot-password-card {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 350px;
            color: white;
        }

        .input-group-text, .form-control {
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
            color: black;
        }
        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.7);
        }

        .reset-btn {
            background-color: black;
            color: white;
            border-radius: 20px;
            width: 100%;
            padding: 10px 20px;
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
        <div class="forgot-password-card text-center">
            <h3 class="text-white mb-4">Forgot Password</h3>

            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <p class="mb-4 text-sm">
                {{ __('Forgot your password? No problem. Just let us know your phone number and we will send you a password reset link that will allow you to choose a new one.') }}
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}" required autofocus>
                    @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-end mt-4">
                    <button type="submit" class="btn reset-btn">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="footer">&copy; 2025 Matnog Tourism</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
