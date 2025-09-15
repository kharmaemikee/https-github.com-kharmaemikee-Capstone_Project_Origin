<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Verification - Matnog Tourism</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/js/app.js'])
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

        .verification-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 2rem;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .verification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .verification-card h3 {
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

        .verify-btn {
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

        .verify-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 123, 255, 0.6);
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        }

        .verify-btn:active {
            transform: translateY(-1px);
        }


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

        .text-success {
            color: #28a745;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            text-align: left;
            width: 100%;
            font-weight: 500;
            background: rgba(40, 167, 69, 0.1);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            border-left: 3px solid #28a745;
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

        .resend-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            position: relative;
            z-index: 1;
        }

        .resend-btn:hover {
            background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.6);
        }

        .resend-btn:active {
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

        /* Animation for form elements */
        .verification-card {
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

            .verification-card {
                max-width: 100%;
                padding: 1.25rem;
            }

            .verification-card h3 {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .form-control, .input-group-text {
                padding: 0.6rem 0.8rem;
                font-size: 0.9rem;
            }

            .verify-btn {
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

            .verification-card {
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

            .verification-card {
                max-width: 450px;
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

            .verification-card {
                padding: 1.25rem;
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
            <div class="text-center">
                <p class="mb-0">Please verify your phone number to continue</p>
            </div>
        </div>
        <div class="verification-card text-center">
            <h3>Phone Verification</h3>
            
            <div class="mb-3 text-white">
                <small>Thanks for signing up! Please verify your phone number by entering the OTP code. Check the database for the code in the phone_verified_at column.</small>
            </div>

            @if (session('status') == 'verification-code-sent')
                <div class="mb-3 text-primary">
                    <small><i class="fas fa-check-circle"></i> A new verification code has been generated. Check the database phone_verified_at column for the code.</small>
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

            <form method="POST" action="{{ route('verification.verify') }}">
                @csrf
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
                        autofocus
                    >
                    @error('code')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn verify-btn mb-3">
                    <i class="fas fa-check"></i> Verify Phone Number
                </button>
            </form>

            <div class="mb-3">
                <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-white p-0">
                        <small><i class="fas fa-redo"></i> Resend Code</small>
                    </button>
                </form>
            </div>

            <div class="mt-3">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-white p-0">
                        <small><i class="fas fa-sign-out-alt"></i> Log Out</small>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('verification.verify') }}"]');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show SweetAlert2 popup
                    Swal.fire({
                        title: 'Phone Verification Successful!',
                        text: 'You are now registered.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        // Submit the form after popup
                        form.submit();
                    });
                });
            }
        });
    </script>
</body>
</html>
