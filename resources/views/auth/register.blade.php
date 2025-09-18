<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Matnog Tourism</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
            margin-bottom: 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 1.5rem;
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
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

        .form-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .form-row .input-group {
            flex: 1;
            min-width: 150px;
            position: relative;
            z-index: 1;
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

            .form-control, .input-group-text {
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


            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-row .input-group {
                min-width: 100%;
                margin-bottom: 0.75rem;
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

            .register-card {
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

        .toggle-password {
            cursor: pointer;
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

        /* Style for hidden file inputs */
        .file-upload-group {
            display: none; /* Hidden by default */
        }

        /* --- NEW STYLES FOR FILE INPUT LABELS --- */
        .file-upload-group .form-control[type="file"] + label {
            /* This targets the label directly after a file input */
            display: inline-block; /* Allows width/padding adjustments */
            width: auto; /* Shrink to content */
            max-width: 100%; /* Ensure it doesn't overflow */
            padding: 0.375rem 0.75rem; /* Adjust padding (Bootstrap's default for form-control is 0.375rem 0.75rem) */
            font-size: 0.875rem; /* Slightly smaller font size */
            line-height: 1.5;
            border-radius: 0.25rem; /* Match Bootstrap's default input border-radius */
            text-align: center; /* Center the text */
            white-space: nowrap; /* Prevent text wrapping */
            overflow: hidden; /* Hide overflow if text is too long */
            text-overflow: ellipsis; /* Add ellipsis for long file names */
            background-color: rgba(255, 255, 255, 0.7); /* Keep background consistent */
            color: #495057; /* Default input text color for better readability */
            border: 1px solid #ced4da; /* Add a subtle border */
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075); /* Subtle inner shadow */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            border-top-left-radius: 0; /* Adjust border radius for label next to icon */
            border-bottom-left-radius: 0; /* Adjust border radius for label next to icon */
            flex-grow: 1; /* Allow the label to grow and take available space */
        }

        /* Adjust icon and input positioning within the file input group */
        .file-upload-group .input-group .input-group-text {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* Make sure the input itself is hidden, but the label is clickable */
        .file-upload-group .form-control[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }

        /* Adjust appearance on focus/hover */
        .file-upload-group .form-control[type="file"]:focus + label,
        .file-upload-group .form-control[type="file"] + label:hover {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        /* Mobile specific adjustments for file upload labels */
        @media (max-width: 768px) {
            .file-upload-group .form-control[type="file"] + label {
                padding: 0.5rem 0.75rem; /* Slightly more padding for mobile tap targets */
                font-size: 0.9rem; /* Restore slightly larger font size for readability on mobile */
                width: 100%; /* Make them full width again on small screens if they are in a column */
            }
            .file-upload-group .input-group {
                flex-direction: row; /* Keep icon and label side-by-side even in column layout */
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
            <h3>Create Account</h3>
            <form method="POST" action="{{ route('register.step1') }}">
                @csrf
                <div class="form-row">
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                        @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Middle Name (optional)" name="middle_name" value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" 
                               class="form-control" 
                               placeholder="Phone Number (e.g., 09123456789)" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               required 
                               maxlength="11" 
                               minlength="11" 
                               pattern="[0-9]{11}" 
                               title="Please enter exactly 11 digits for the phone number (e.g., 09123456789)"
                               inputmode="numeric"
                               oninput="validatePhoneNumber(this)">
                        <div id="phone_error" class="text-danger mt-1" style="display: none;">
                            The number is not enough. Please enter exactly 11 digits.
                        </div>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        <input type="date" class="form-control" name="birthday" id="birthday" value="{{ old('birthday') }}" max="{{ date('Y-m-d', strtotime('-18 years')) }}" required onchange="validateAge(this)">
                        @error('birthday')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="age-error" class="text-danger" style="display: none;"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                        <select name="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" class="form-control" placeholder="Address" name="address" value="{{ old('address') }}" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2 input-group flex-wrap">
                        <span class="input-group-text"><i class="fas fa-flag"></i></span>
                        <select name="nationality" class="form-control" required>
                            <option value="">Select Nationality</option>
                            <option value="Filipino" {{ old('nationality') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                            <option value="Afghan" {{ old('nationality') == 'Afghan' ? 'selected' : '' }}>Afghan</option>
                            <option value="Albanian" {{ old('nationality') == 'Albanian' ? 'selected' : '' }}>Albanian</option>
                            <option value="Algerian" {{ old('nationality') == 'Algerian' ? 'selected' : '' }}>Algerian</option>
                            <option value="American" {{ old('nationality') == 'American' ? 'selected' : '' }}>American</option>
                            <option value="Andorran" {{ old('nationality') == 'Andorran' ? 'selected' : '' }}>Andorran</option>
                            <option value="Angolan" {{ old('nationality') == 'Angolan' ? 'selected' : '' }}>Angolan</option>
                            <option value="Antiguans" {{ old('nationality') == 'Antiguans' ? 'selected' : '' }}>Antiguans</option>
                            <option value="Argentinean" {{ old('nationality') == 'Argentinean' ? 'selected' : '' }}>Argentinean</option>
                            <option value="Armenian" {{ old('nationality') == 'Armenian' ? 'selected' : '' }}>Armenian</option>
                            <option value="Australian" {{ old('nationality') == 'Australian' ? 'selected' : '' }}>Australian</option>
                            <option value="Austrian" {{ old('nationality') == 'Austrian' ? 'selected' : '' }}>Austrian</option>
                            <option value="Azerbaijani" {{ old('nationality') == 'Azerbaijani' ? 'selected' : '' }}>Azerbaijani</option>
                            <option value="Bahamian" {{ old('nationality') == 'Bahamian' ? 'selected' : '' }}>Bahamian</option>
                            <option value="Bahraini" {{ old('nationality') == 'Bahraini' ? 'selected' : '' }}>Bahraini</option>
                            <option value="Bangladeshi" {{ old('nationality') == 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi</option>
                            <option value="Barbadian" {{ old('nationality') == 'Barbadian' ? 'selected' : '' }}>Barbadian</option>
                            <option value="Belarusian" {{ old('nationality') == 'Belarusian' ? 'selected' : '' }}>Belarusian</option>
                            <option value="Belgian" {{ old('nationality') == 'Belgian' ? 'selected' : '' }}>Belgian</option>
                            <option value="Belizean" {{ old('nationality') == 'Belizean' ? 'selected' : '' }}>Belizean</option>
                            <option value="Beninese" {{ old('nationality') == 'Beninese' ? 'selected' : '' }}>Beninese</option>
                            <option value="Bhutanese" {{ old('nationality') == 'Bhutanese' ? 'selected' : '' }}>Bhutanese</option>
                            <option value="Bolivian" {{ old('nationality') == 'Bolivian' ? 'selected' : '' }}>Bolivian</option>
                            <option value="Bosnian" {{ old('nationality') == 'Bosnian' ? 'selected' : '' }}>Bosnian</option>
                            <option value="Botswanan" {{ old('nationality') == 'Botswanan' ? 'selected' : '' }}>Botswanan</option>
                            <option value="Brazilian" {{ old('nationality') == 'Brazilian' ? 'selected' : '' }}>Brazilian</option>
                            <option value="British" {{ old('nationality') == 'British' ? 'selected' : '' }}>British</option>
                            <option value="Bruneian" {{ old('nationality') == 'Bruneian' ? 'selected' : '' }}>Bruneian</option>
                            <option value="Bulgarian" {{ old('nationality') == 'Bulgarian' ? 'selected' : '' }}>Bulgarian</option>
                            <option value="Burkinabé" {{ old('nationality') == 'Burkinabé' ? 'selected' : '' }}>Burkinabé</option>
                            <option value="Burundian" {{ old('nationality') == 'Burundian' ? 'selected' : '' }}>Burundian</option>
                            <option value="Cambodian" {{ old('nationality') == 'Cambodian' ? 'selected' : '' }}>Cambodian</option>
                            <option value="Cameroonian" {{ old('nationality') == 'Cameroonian' ? 'selected' : '' }}>Cameroonian</option>
                            <option value="Canadian" {{ old('nationality') == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                            <option value="Cape Verdean" {{ old('nationality') == 'Cape Verdean' ? 'selected' : '' }}>Cape Verdean</option>
                            <option value="Central African" {{ old('nationality') == 'Central African' ? 'selected' : '' }}>Central African</option>
                            <option value="Chadian" {{ old('nationality') == 'Chadian' ? 'selected' : '' }}>Chadian</option>
                            <option value="Chilean" {{ old('nationality') == 'Chilean' ? 'selected' : '' }}>Chilean</option>
                            <option value="Chinese" {{ old('nationality') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                            <option value="Colombian" {{ old('nationality') == 'Colombian' ? 'selected' : '' }}>Colombian</option>
                            <option value="Comoran" {{ old('nationality') == 'Comoran' ? 'selected' : '' }}>Comoran</option>
                            <option value="Congolese" {{ old('nationality') == 'Congolese' ? 'selected' : '' }}>Congolese</option>
                            <option value="Costa Rican" {{ old('nationality') == 'Costa Rican' ? 'selected' : '' }}>Costa Rican</option>
                            <option value="Croatian" {{ old('nationality') == 'Croatian' ? 'selected' : '' }}>Croatian</option>
                            <option value="Cuban" {{ old('nationality') == 'Cuban' ? 'selected' : '' }}>Cuban</option>
                            <option value="Cypriot" {{ old('nationality') == 'Cypriot' ? 'selected' : '' }}>Cypriot</option>
                            <option value="Czech" {{ old('nationality') == 'Czech' ? 'selected' : '' }}>Czech</option>
                            <option value="Danish" {{ old('nationality') == 'Danish' ? 'selected' : '' }}>Danish</option>
                            <option value="Djiboutian" {{ old('nationality') == 'Djiboutian' ? 'selected' : '' }}>Djiboutian</option>
                            <option value="Dominican" {{ old('nationality') == 'Dominican' ? 'selected' : '' }}>Dominican</option>
                            <option value="Dutch" {{ old('nationality') == 'Dutch' ? 'selected' : '' }}>Dutch</option>
                            <option value="East Timorese" {{ old('nationality') == 'East Timorese' ? 'selected' : '' }}>East Timorese</option>
                            <option value="Ecuadorean" {{ old('nationality') == 'Ecuadorean' ? 'selected' : '' }}>Ecuadorean</option>
                            <option value="Egyptian" {{ old('nationality') == 'Egyptian' ? 'selected' : '' }}>Egyptian</option>
                            <option value="Emirian" {{ old('nationality') == 'Emirian' ? 'selected' : '' }}>Emirian</option>
                            <option value="Equatorial Guinean" {{ old('nationality') == 'Equatorial Guinean' ? 'selected' : '' }}>Equatorial Guinean</option>
                            <option value="Eritrean" {{ old('nationality') == 'Eritrean' ? 'selected' : '' }}>Eritrean</option>
                            <option value="Estonian" {{ old('nationality') == 'Estonian' ? 'selected' : '' }}>Estonian</option>
                            <option value="Ethiopian" {{ old('nationality') == 'Ethiopian' ? 'selected' : '' }}>Ethiopian</option>
                            <option value="Filipino" {{ old('nationality') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                            <option value="Fijian" {{ old('nationality') == 'Fijian' ? 'selected' : '' }}>Fijian</option>
                            <option value="Finnish" {{ old('nationality') == 'Finnish' ? 'selected' : '' }}>Finnish</option>
                            <option value="French" {{ old('nationality') == 'French' ? 'selected' : '' }}>French</option>
                            <option value="Gabonese" {{ old('nationality') == 'Gabonese' ? 'selected' : '' }}>Gabonese</option>
                            <option value="Gambian" {{ old('nationality') == 'Gambian' ? 'selected' : '' }}>Gambian</option>
                            <option value="Georgian" {{ old('nationality') == 'Georgian' ? 'selected' : '' }}>Georgian</option>
                            <option value="German" {{ old('nationality') == 'German' ? 'selected' : '' }}>German</option>
                            <option value="Ghanaian" {{ old('nationality') == 'Ghanaian' ? 'selected' : '' }}>Ghanaian</option>
                            <option value="Greek" {{ old('nationality') == 'Greek' ? 'selected' : '' }}>Greek</option>
                            <option value="Grenadian" {{ old('nationality') == 'Grenadian' ? 'selected' : '' }}>Grenadian</option>
                            <option value="Guatemalan" {{ old('nationality') == 'Guatemalan' ? 'selected' : '' }}>Guatemalan</option>
                            <option value="Guinean" {{ old('nationality') == 'Guinean' ? 'selected' : '' }}>Guinean</option>
                            <option value="Guinea-Bissauan" {{ old('nationality') == 'Guinea-Bissauan' ? 'selected' : '' }}>Guinea-Bissauan</option>
                            <option value="Guyanese" {{ old('nationality') == 'Guyanese' ? 'selected' : '' }}>Guyanese</option>
                            <option value="Haitian" {{ old('nationality') == 'Haitian' ? 'selected' : '' }}>Haitian</option>
                            <option value="Honduran" {{ old('nationality') == 'Honduran' ? 'selected' : '' }}>Honduran</option>
                            <option value="Hungarian" {{ old('nationality') == 'Hungarian' ? 'selected' : '' }}>Hungarian</option>
                            <option value="Icelander" {{ old('nationality') == 'Icelander' ? 'selected' : '' }}>Icelander</option>
                            <option value="Indian" {{ old('nationality') == 'Indian' ? 'selected' : '' }}>Indian</option>
                            <option value="Indonesian" {{ old('nationality') == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                            <option value="Iranian" {{ old('nationality') == 'Iranian' ? 'selected' : '' }}>Iranian</option>
                            <option value="Iraqi" {{ old('nationality') == 'Iraqi' ? 'selected' : '' }}>Iraqi</option>
                            <option value="Irish" {{ old('nationality') == 'Irish' ? 'selected' : '' }}>Irish</option>
                            <option value="Israeli" {{ old('nationality') == 'Israeli' ? 'selected' : '' }}>Israeli</option>
                            <option value="Italian" {{ old('nationality') == 'Italian' ? 'selected' : '' }}>Italian</option>
                            <option value="Ivorian" {{ old('nationality') == 'Ivorian' ? 'selected' : '' }}>Ivorian</option>
                            <option value="Jamaican" {{ old('nationality') == 'Jamaican' ? 'selected' : '' }}>Jamaican</option>
                            <option value="Japanese" {{ old('nationality') == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                            <option value="Jordanian" {{ old('nationality') == 'Jordanian' ? 'selected' : '' }}>Jordanian</option>
                            <option value="Kazakhstani" {{ old('nationality') == 'Kazakhstani' ? 'selected' : '' }}>Kazakhstani</option>
                            <option value="Kenyan" {{ old('nationality') == 'Kenyan' ? 'selected' : '' }}>Kenyan</option>
                            <option value="Kittian and Nevisian" {{ old('nationality') == 'Kittian and Nevisian' ? 'selected' : '' }}>Kittian and Nevisian</option>
                            <option value="Kuwaiti" {{ old('nationality') == 'Kuwaiti' ? 'selected' : '' }}>Kuwaiti</option>
                            <option value="Kyrgyz" {{ old('nationality') == 'Kyrgyz' ? 'selected' : '' }}>Kyrgyz</option>
                            <option value="Laotian" {{ old('nationality') == 'Laotian' ? 'selected' : '' }}>Laotian</option>
                            <option value="Latvian" {{ old('nationality') == 'Latvian' ? 'selected' : '' }}>Latvian</option>
                            <option value="Lebanese" {{ old('nationality') == 'Lebanese' ? 'selected' : '' }}>Lebanese</option>
                            <option value="Liberian" {{ old('nationality') == 'Liberian' ? 'selected' : '' }}>Liberian</option>
                            <option value="Libyan" {{ old('nationality') == 'Libyan' ? 'selected' : '' }}>Libyan</option>
                            <option value="Liechtensteiner" {{ old('nationality') == 'Liechtensteiner' ? 'selected' : '' }}>Liechtensteiner</option>
                            <option value="Lithuanian" {{ old('nationality') == 'Lithuanian' ? 'selected' : '' }}>Lithuanian</option>
                            <option value="Luxembourger" {{ old('nationality') == 'Luxembourger' ? 'selected' : '' }}>Luxembourger</option>
                            <option value="Macedonian" {{ old('nationality') == 'Macedonian' ? 'selected' : '' }}>Macedonian</option>
                            <option value="Malagasy" {{ old('nationality') == 'Malagasy' ? 'selected' : '' }}>Malagasy</option>
                            <option value="Malawian" {{ old('nationality') == 'Malawian' ? 'selected' : '' }}>Malawian</option>
                            <option value="Malaysian" {{ old('nationality') == 'Malaysian' ? 'selected' : '' }}>Malaysian</option>
                            <option value="Maldivan" {{ old('nationality') == 'Maldivan' ? 'selected' : '' }}>Maldivan</option>
                            <option value="Malian" {{ old('nationality') == 'Malian' ? 'selected' : '' }}>Malian</option>
                            <option value="Maltese" {{ old('nationality') == 'Maltese' ? 'selected' : '' }}>Maltese</option>
                            <option value="Mauritanian" {{ old('nationality') == 'Mauritanian' ? 'selected' : '' }}>Mauritanian</option>
                            <option value="Mauritian" {{ old('nationality') == 'Mauritian' ? 'selected' : '' }}>Mauritian</option>
                            <option value="Mexican" {{ old('nationality') == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                            <option value="Moldovan" {{ old('nationality') == 'Moldovan' ? 'selected' : '' }}>Moldovan</option>
                            <option value="Monacan" {{ old('nationality') == 'Monacan' ? 'selected' : '' }}>Monacan</option>
                            <option value="Mongolian" {{ old('nationality') == 'Mongolian' ? 'selected' : '' }}>Mongolian</option>
                            <option value="Moroccan" {{ old('nationality') == 'Moroccan' ? 'selected' : '' }}>Moroccan</option>
                            <option value="Mosotho" {{ old('nationality') == 'Mosotho' ? 'selected' : '' }}>Mosotho</option>
                            <option value="Motswana" {{ old('nationality') == 'Motswana' ? 'selected' : '' }}>Motswana</option>
                            <option value="Mozambican" {{ old('nationality') == 'Mozambican' ? 'selected' : '' }}>Mozambican</option>
                            <option value="Namibian" {{ old('nationality') == 'Namibian' ? 'selected' : '' }}>Namibian</option>
                            <option value="Nepalese" {{ old('nationality') == 'Nepalese' ? 'selected' : '' }}>Nepalese</option>
                            <option value="New Zealander" {{ old('nationality') == 'New Zealander' ? 'selected' : '' }}>New Zealander</option>
                            <option value="Nicaraguan" {{ old('nationality') == 'Nicaraguan' ? 'selected' : '' }}>Nicaraguan</option>
                            <option value="Nigerien" {{ old('nationality') == 'Nigerien' ? 'selected' : '' }}>Nigerien</option>
                            <option value="North Korean" {{ old('nationality') == 'North Korean' ? 'selected' : '' }}>North Korean</option>
                            <option value="Northern Irish" {{ old('nationality') == 'Northern Irish' ? 'selected' : '' }}>Northern Irish</option>
                            <option value="Norwegian" {{ old('nationality') == 'Norwegian' ? 'selected' : '' }}>Norwegian</option>
                            <option value="Omani" {{ old('nationality') == 'Omani' ? 'selected' : '' }}>Omani</option>
                            <option value="Pakistani" {{ old('nationality') == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                            <option value="Palauan" {{ old('nationality') == 'Palauan' ? 'selected' : '' }}>Palauan</option>
                            <option value="Panamanian" {{ old('nationality') == 'Panamanian' ? 'selected' : '' }}>Panamanian</option>
                            <option value="Papua New Guinean" {{ old('nationality') == 'Papua New Guinean' ? 'selected' : '' }}>Papua New Guinean</option>
                            <option value="Paraguayan" {{ old('nationality') == 'Paraguayan' ? 'selected' : '' }}>Paraguayan</option>
                            <option value="Peruvian" {{ old('nationality') == 'Peruvian' ? 'selected' : '' }}>Peruvian</option>
                            <option value="Polish" {{ old('nationality') == 'Polish' ? 'selected' : '' }}>Polish</option>
                            <option value="Portuguese" {{ old('nationality') == 'Portuguese' ? 'selected' : '' }}>Portuguese</option>
                            <option value="Qatari" {{ old('nationality') == 'Qatari' ? 'selected' : '' }}>Qatari</option>
                            <option value="Romanian" {{ old('nationality') == 'Romanian' ? 'selected' : '' }}>Romanian</option>
                            <option value="Russian" {{ old('nationality') == 'Russian' ? 'selected' : '' }}>Russian</option>
                            <option value="Rwandan" {{ old('nationality') == 'Rwandan' ? 'selected' : '' }}>Rwandan</option>
                            <option value="Saint Lucian" {{ old('nationality') == 'Saint Lucian' ? 'selected' : '' }}>Saint Lucian</option>
                            <option value="Salvadoran" {{ old('nationality') == 'Salvadoran' ? 'selected' : '' }}>Salvadoran</option>
                            <option value="Samoan" {{ old('nationality') == 'Samoan' ? 'selected' : '' }}>Samoan</option>
                            <option value="San Marinese" {{ old('nationality') == 'San Marinese' ? 'selected' : '' }}>San Marinese</option>
                            <option value="Sao Tomean" {{ old('nationality') == 'Sao Tomean' ? 'selected' : '' }}>Sao Tomean</option>
                            <option value="Saudi" {{ old('nationality') == 'Saudi' ? 'selected' : '' }}>Saudi</option>
                            <option value="Senegalese" {{ old('nationality') == 'Senegalese' ? 'selected' : '' }}>Senegalese</option>
                            <option value="Serbian" {{ old('nationality') == 'Serbian' ? 'selected' : '' }}>Serbian</option>
                            <option value="Seychellois" {{ old('nationality') == 'Seychellois' ? 'selected' : '' }}>Seychellois</option>
                            <option value="Sierra Leonean" {{ old('nationality') == 'Sierra Leonean' ? 'selected' : '' }}>Sierra Leonean</option>
                            <option value="Singaporean" {{ old('nationality') == 'Singaporean' ? 'selected' : '' }}>Singaporean</option>
                            <option value="Slovakian" {{ old('nationality') == 'Slovakian' ? 'selected' : '' }}>Slovakian</option>
                            <option value="Slovenian" {{ old('nationality') == 'Slovenian' ? 'selected' : '' }}>Slovenian</option>
                            <option value="Solomon Islander" {{ old('nationality') == 'Solomon Islander' ? 'selected' : '' }}>Solomon Islander</option>
                            <option value="Somali" {{ old('nationality') == 'Somali' ? 'selected' : '' }}>Somali</option>
                            <option value="South African" {{ old('nationality') == 'South African' ? 'selected' : '' }}>South African</option>
                            <option value="South Korean" {{ old('nationality') == 'South Korean' ? 'selected' : '' }}>South Korean</option>
                            <option value="Spanish" {{ old('nationality') == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                            <option value="Sri Lankan" {{ old('nationality') == 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                            <option value="Sudanese" {{ old('nationality') == 'Sudanese' ? 'selected' : '' }}>Sudanese</option>
                            <option value="Surinamer" {{ old('nationality') == 'Surinamer' ? 'selected' : '' }}>Surinamer</option>
                            <option value="Swazi" {{ old('nationality') == 'Swazi' ? 'selected' : '' }}>Swazi</option>
                            <option value="Swedish" {{ old('nationality') == 'Swedish' ? 'selected' : '' }}>Swedish</option>
                            <option value="Swiss" {{ old('nationality') == 'Swiss' ? 'selected' : '' }}>Swiss</option>
                            <option value="Syrian" {{ old('nationality') == 'Syrian' ? 'selected' : '' }}>Syrian</option>
                            <option value="Taiwanese" {{ old('nationality') == 'Taiwanese' ? 'selected' : '' }}>Taiwanese</option>
                            <option value="Tajik" {{ old('nationality') == 'Tajik' ? 'selected' : '' }}>Tajik</option>
                            <option value="Tanzanian" {{ old('nationality') == 'Tanzanian' ? 'selected' : '' }}>Tanzanian</option>
                            <option value="Thai" {{ old('nationality') == 'Thai' ? 'selected' : '' }}>Thai</option>
                            <option value="Togolese" {{ old('nationality') == 'Togolese' ? 'selected' : '' }}>Togolese</option>
                            <option value="Tongan" {{ old('nationality') == 'Tongan' ? 'selected' : '' }}>Tongan</option>
                            <option value="Trinidadian or Tobagonian" {{ old('nationality') == 'Trinidadian or Tobagonian' ? 'selected' : '' }}>Trinidadian or Tobagonian</option>
                            <option value="Tunisian" {{ old('nationality') == 'Tunisian' ? 'selected' : '' }}>Tunisian</option>
                            <option value="Turkish" {{ old('nationality') == 'Turkish' ? 'selected' : '' }}>Turkish</option>
                            <option value="Tuvaluan" {{ old('nationality') == 'Tuvaluan' ? 'selected' : '' }}>Tuvaluan</option>
                            <option value="Ugandan" {{ old('nationality') == 'Ugandan' ? 'selected' : '' }}>Ugandan</option>
                            <option value="Ukrainian" {{ old('nationality') == 'Ukrainian' ? 'selected' : '' }}>Ukrainian</option>
                            <option value="Uruguayan" {{ old('nationality') == 'Uruguayan' ? 'selected' : '' }}>Uruguayan</option>
                            <option value="Uzbekistani" {{ old('nationality') == 'Uzbekistani' ? 'selected' : '' }}>Uzbekistani</option>
                            <option value="Venezuelan" {{ old('nationality') == 'Venezuelan' ? 'selected' : '' }}>Venezuelan</option>
                            <option value="Vietnamese" {{ old('nationality') == 'Vietnamese' ? 'selected' : '' }}>Vietnamese</option>
                            <option value="Yemenite" {{ old('nationality') == 'Yemenite' ? 'selected' : '' }}>Yemenite</option>
                            <option value="Zambian" {{ old('nationality') == 'Zambian' ? 'selected' : '' }}>Zambian</option>
                            <option value="Zimbabwean" {{ old('nationality') == 'Zimbabwean' ? 'selected' : '' }}>Zimbabwean</option>
                        </select>
                        @error('nationality')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn register-btn">Next</button>
            </form>
            <p class="mt-3 text-white" style="position: relative; z-index: 1;">Already have an account? <a href="{{ route('login') }}" class="login-link">Login</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to validate phone number input
        function validatePhoneNumber(input) {
            const value = input.value;
            const errorDiv = document.getElementById('phone_error');
            
            // Remove any non-digit characters
            const digitsOnly = value.replace(/\D/g, '');
            
            // Update the input value to only contain digits
            if (value !== digitsOnly) {
                input.value = digitsOnly;
            }
            
            // Check if the length is exactly 11 digits
            if (digitsOnly.length > 0 && digitsOnly.length !== 11) {
                errorDiv.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = "password";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Script to show/hide file upload fields based on role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('roleSelect');
            const ownerDocumentsDiv = document.getElementById('ownerDocuments');
            const fileInputs = ownerDocumentsDiv.querySelectorAll('input[type="file"]');
            const fileLabels = ownerDocumentsDiv.querySelectorAll('label[for]');

            function toggleOwnerDocuments() {
                const isOwnerRole = roleSelect.value === 'resort_owner' || roleSelect.value === 'boat_owner';
                if (isOwnerRole) {
                    ownerDocumentsDiv.style.display = 'flex'; // Use flex to maintain form-row layout
                    fileInputs.forEach(input => input.setAttribute('required', 'required'));
                } else {
                    ownerDocumentsDiv.style.display = 'none';
                    fileInputs.forEach(input => {
                        input.removeAttribute('required');
                        input.value = ''; // Clear selected files when hidden
                    });
                    fileLabels.forEach(label => {
                        const originalText = label.getAttribute('data-original-text');
                        if (originalText) {
                            label.textContent = originalText;
                        }
                    });
                }
            }

            // Update label text when a file is selected
            fileInputs.forEach(input => {
                const label = document.querySelector(`label[for="${input.id}"]`);
                if (label) {
                    label.setAttribute('data-original-text', label.textContent); // Store original text
                    input.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            label.textContent = this.files[0].name;
                        } else {
                            label.textContent = label.getAttribute('data-original-text');
                        }
                    });
                }
            });

            // Call on page load to set initial state based on old input
            toggleOwnerDocuments();

            // Add event listener for when the role changes
            roleSelect.addEventListener('change', toggleOwnerDocuments);
        });

        // Age validation function
        function validateAge(input) {
            const birthday = new Date(input.value);
            const today = new Date();
            const ageError = document.getElementById('age-error');
            
            // Check if date is in the future
            if (birthday > today) {
                ageError.textContent = 'Birthday cannot be in the future.';
                ageError.style.display = 'block';
                input.setCustomValidity('Birthday cannot be in the future.');
                return;
            }
            
            const age = today.getFullYear() - birthday.getFullYear();
            const monthDiff = today.getMonth() - birthday.getMonth();
            
            // Check if birthday has occurred this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
                age--;
            }
            
            if (age < 18) {
                ageError.textContent = 'You must be at least 18 years old to register.';
                ageError.style.display = 'block';
                input.setCustomValidity('You must be at least 18 years old to register.');
            } else {
                ageError.style.display = 'none';
                input.setCustomValidity('');
            }
        }

        // Form validation before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const birthday = document.getElementById('birthday').value;
            if (birthday) {
                const birthdayDate = new Date(birthday);
                const today = new Date();
                const age = today.getFullYear() - birthdayDate.getFullYear();
                const monthDiff = today.getMonth() - birthdayDate.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdayDate.getDate())) {
                    age--;
                }
                
                if (age < 18) {
                    e.preventDefault();
                    document.getElementById('age-error').textContent = 'You must be at least 18 years old to register.';
                    document.getElementById('age-error').style.display = 'block';
                    return false;
                }
            }
        });
    </script>
</body>
</html>