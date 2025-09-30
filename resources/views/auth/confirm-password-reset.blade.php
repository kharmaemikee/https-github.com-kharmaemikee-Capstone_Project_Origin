<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password Reset - Matnog Tourism</title>
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

        /* removed header */

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

        .confirmation-card {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .btn-yes {
            background-color: #28a745;
            color: white;
            border-radius: 20px;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-no {
            background-color: #6c757d;
            color: white;
            border-radius: 20px;
            width: 100%;
        }

        /* removed footer */

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
    
    <div class="overlay"></div>
    <div class="container">
        <div class="welcome-section">
            <div class="welcome-text text-center">
                <h1>Welcome to</h1>
                <h2>Matnog Tourism, Culture and Arts Office</h2>
            </div>
            <div class="text-center">
                <p class="mb-0">OTP verification successful!</p>
            </div>
        </div>
        <div class="confirmation-card text-center">
            <h3 class="text-white mb-4">Password Reset Confirmation</h3>
            
            <div class="mb-4 text-white">
                <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                <p class="mb-0">Your phone number has been verified successfully!</p>
            </div>

            <div class="mb-4">
                <h5 class="text-white">Do you want to change your password?</h5>
            </div>

            <form method="POST" action="{{ route('password.reset.confirm.submit') }}">
                @csrf
                
                <button type="submit" name="action" value="yes" class="btn btn-yes">
                    <i class="fas fa-key"></i> Yes, Change Password
                </button>
            </form>

            <form method="POST" action="{{ route('password.reset.confirm.submit') }}">
                @csrf
                
                <button type="submit" name="action" value="no" class="btn btn-no">
                    <i class="fas fa-times"></i> Not Now
                </button>
            </form>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
