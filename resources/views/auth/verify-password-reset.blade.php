<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Matnog Tourism</title>
    <link rel="icon" type="image/png" href="{{ asset('image/tourism.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/tourism.png') }}">
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

        .verification-card {
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

        .verify-btn {
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

        .text-success {
            color: #28a745;
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
                <p class="mb-0">Please verify your phone number to reset password</p>
            </div>
        </div>
        <div class="verification-card text-center">
            <h3 class="text-white mb-4">Verify OTP Code</h3>
            
            <div class="mb-3 text-white">
                <small>Please enter the 6-digit OTP code sent to your phone number.</small>
            </div>

            @if (session('status') == 'verification-code-sent')
                <div class="mb-3 text-success">
                    <small><i class="fas fa-check-circle"></i> A verification code has been sent to your phone.</small>
                </div>
            @endif

            @if (session('status') == 'password-reset-sms-failed')
                <div class="mb-3 text-warning">
                    <small><i class="fas fa-exclamation-triangle"></i> Failed to send SMS. Please try again.</small>
                </div>
            @endif

            @if (session('status') == 'password-reset-sms-error')
                <div class="mb-3 text-danger">
                    <small><i class="fas fa-exclamation-circle"></i> SMS service error. Please try again later.</small>
                </div>
            @endif

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

            <form method="POST" action="{{ route('password.reset.verify.submit') }}">
                @csrf
                
                <div class="mb-3 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    <input 
                        type="text" 
                        class="form-control" 
                        placeholder="Phone Number" 
                        name="phone_number" 
                        value="{{ old('phone_number') }}"
                        maxlength="11"
                        required 
                        autofocus
                    >
                    @error('phone_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 input-group flex-wrap">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input 
                        id="code" 
                        name="code" 
                        type="text" 
                        maxlength="6"
                        class="form-control" 
                        placeholder="Enter 6-digit code"
                        value="{{ old('code') }}"
                        required 
                    >
                    @error('code')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn verify-btn mb-3">
                    <i class="fas fa-check"></i> Verify OTP
                </button>
            </form>

            <div class="mt-3">
                <a href="{{ route('password.request') }}" class="btn btn-link text-white p-0">
                    <small><i class="fas fa-arrow-left"></i> Back to Forgot Password</small>
                </a>
            </div>
        </div>
    </div>
    <div class="footer">&copy; 2025 Matnog Tourism</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
