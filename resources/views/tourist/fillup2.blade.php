<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        {{-- Font Awesome CDN for Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        @include('tourist.partials.sidebar')

        {{-- Main Content Area for Fill-up Form --}}
        <main class="main-content">
            <div class="container-fluid">
                {{-- Modern Header Section --}}
                <div class="registration-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="header-text">
                            <h1 class="page-title">Complete Your Registration</h1>
                            <p class="page-subtitle">Fill in your personal details to finalize your booking</p>
                        </div>
                    </div>
                    <div class="header-decoration">
                        <div class="decoration-circle"></div>
                        <div class="decoration-circle"></div>
                        <div class="decoration-circle"></div>
                    </div>
                </div>

                {{-- Room Availability Notification --}}
                @if(isset($conflictingBooking) && $conflictingBooking)
                    <div class="error-state">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="error-title">Room Unavailable</h3>
                        <p class="error-description">
                            Sorry! This room is no longer available for the selected date 
                            <strong>
                                @php
                                    try {
                                        echo \Carbon\Carbon::parse($requestData['reservation_date'])->format('M d, Y');
                                    } catch(\Exception $e) {
                                        echo $requestData['reservation_date'];
                                    }
                                @endphp
                            </strong>.
                        </p>
                        <div class="conflict-details">
                            <p><strong>Conflicting Booking:</strong></p>
                            <p>Guest: {{ $conflictingBooking->guest_name }} | 
                            Date: 
                            @php
                                try {
                                    echo \Carbon\Carbon::parse($conflictingBooking->check_in_date)->format('M d, Y');
                                } catch(\Exception $e) {
                                    echo $conflictingBooking->check_in_date;
                                }
                            @endphp</p>
                        </div>
                        <div class="error-actions">
                            <a href="{{ route('tourist.list') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Go Back to Rooms.
                            </a>
                            <a href="{{ route('tourist.list') }}" class="btn btn-secondary">
                                <i class="fas fa-search"></i> Find Available Rooms
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Display success or error messages --}}
                @if (session('success'))
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="success-content">
                            <h4>Success!</h4>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="error-content">
                            <h4>Error!</h4>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="registration-container">
                    <div class="registration-form-card">
                        <div class="form-header">
                            <h3 class="form-title">
                                <i class="fas fa-edit"></i>
                                Personal Information
                            </h3>
                            <p class="form-subtitle">Please provide your personal details to complete the booking</p>
                        </div>
                        
                        <form action="{{ route('bookings.store') }}" method="POST" class="registration-form">
                            @csrf
                            {{-- Hidden fields to carry over data from fillup.blade.php --}}
                            {{-- Use old() helper to retain values on validation failure --}}
                            <input type="hidden" name="room_id" value="{{ old('room_id', $requestData['room_id'] ?? '') }}">
                            
                            {{-- Tourist Account Information --}}
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-user-circle"></i>
                                    Tourist Account Information
                                </h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            First Name
                                        </label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Enter your first name" value="{{ old('first_name', $user->first_name ?? '') }}" required>
                                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Middle Name
                                        </label>
                                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" placeholder="Enter your middle name (optional)" value="{{ old('middle_name', $user->middle_name ?? '') }}">
                                        @error('middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Last Name
                                        </label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Enter your last name" value="{{ old('last_name', $user->last_name ?? '') }}" required>
                                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Address field - full width --}}
                            <div class="form-section">
                                <div class="form-group full-width">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Address
                                    </label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter your complete address" value="{{ old('address', $user->address ?? '') }}" required>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>


                            {{-- Primary Guest Information --}}
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-user-friends"></i>
                                    Primary Guest Information
                                </h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Primary Guest Name
                                        </label>
                                        <input type="text" class="form-control @error('guest_name') is-invalid @enderror" name="guest_name" placeholder="Enter primary guest name" value="{{ old('guest_name', $user->first_name . ' ' . $user->last_name ?? '') }}" required>
                                        @error('guest_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="help-text">This is the main guest for the booking (usually the tourist making the booking)</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="numGuests" class="form-label">
                                            <i class="fas fa-users"></i>
                                            Number of Guests
                                        </label>
                                        <input type="number" class="form-control @error('num_guests') is-invalid @enderror" id="numGuests" name="num_guests" min="1" value="{{ old('num_guests', $requestData['num_guests'] ?? 1) }}" required>
                                        @error('num_guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="nationality" value="{{ old('nationality', $requestData['nationality'] ?? ($user ? $user->nationality : '')) }}">
                            <input type="hidden" name="contact_number" value="{{ old('contact_number', $requestData['contact_number'] ?? ($user ? $user->phone : '')) }}">
                            <input type="hidden" name="reservation_date" value="{{ old('reservation_date', $requestData['reservation_date'] ?? '') }}">
                            <input type="hidden" name="num_nights" value="{{ old('num_nights', $requestData['num_nights'] ?? 1) }}">
                            <input type="hidden" name="age" value="{{ old('age', $user->age ?? 25) }}">
                            <input type="hidden" name="gender" value="{{ old('gender', $user->gender ?? 'male') }}">
                            <input type="hidden" name="special_requests" value="">

                            {{-- Dynamic guest names --}}
                            <div id="guestNamesContainer" class="form-section" style="display: none;">
                                <h4 class="section-title">
                                    <i class="fas fa-user-plus"></i>
                                    Additional Guest Names
                                </h4>
                                <div id="guestInputs" class="guest-inputs-container"></div>
                                <small class="help-text">Minimum age for guests is 7 years old.</small>
                                <small class="help-text">Enter the names of all additional guests (excluding primary guest), one per input.</small>
                            </div>

                            {{-- Tour Type - appears below guest names on all screen sizes --}}
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-route"></i>
                                    Tour Type Selection
                                </h4>
                                <div class="form-group full-width">
                                    <label for="tour_type" class="form-label">
                                        <i class="fas fa-map"></i>
                                        Type of Tour
                                    </label>
                                    <select class="form-control @error('tour_type') is-invalid @enderror" id="tour_type" name="tour_type" required>
                                    <option value="">Select Tour Type</option>
                                    <option value="day_tour" {{ old('tour_type') == 'day_tour' ? 'selected' : '' }}>Day Tour</option>
                                    <option value="overnight" {{ old('tour_type') == 'overnight' ? 'selected' : '' }}>Overnight</option>
                                </select>
                                @error('tour_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>


                            {{-- Tour type specific fields - positioned below tour type selection --}}
                            <div id="dayTourSpecificFields" class="form-section" style="display: none;">
                                <h4 class="section-title">
                                    <i class="fas fa-sun"></i>
                                    Day Tour Details
                                </h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="day_tour_departure_time" class="form-label">
                                            <i class="fas fa-clock"></i>
                                            Departure Time
                                        </label>
                                            <input type="time" class="form-control @error('day_tour_departure_time') is-invalid @enderror" id="day_tour_departure_time" name="day_tour_departure_time" value="{{ old('day_tour_departure_time') }}">
                                            @error('day_tour_departure_time')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    <div class="form-group">
                                        <label for="day_tour_time_of_pickup" class="form-label">
                                            <i class="fas fa-car"></i>
                                            Time of Pick-up
                                        </label>
                                            <input type="time" class="form-control @error('day_tour_time_of_pickup') is-invalid @enderror" id="day_tour_time_of_pickup" name="day_tour_time_of_pickup" value="{{ old('day_tour_time_of_pickup') }}">
                                            @error('day_tour_time_of_pickup')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Overnight specific fields - positioned below tour type selection --}}
                            <div id="overnightSpecificFields" class="form-section" style="display: none;">
                                <h4 class="section-title">
                                    <i class="fas fa-moon"></i>
                                    Overnight Tour Details
                                </h4>
                                <div class="form-group full-width">
                                    <label for="overnight_date_time_of_pickup" class="form-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        Date & Time of Pick-up
                                    </label>
                                    <input type="datetime-local" class="form-control @error('overnight_date_time_of_pickup') is-invalid @enderror" id="overnight_date_time_of_pickup" name="overnight_date_time_of_pickup" value="{{ old('overnight_date_time_of_pickup') }}">
                                    @error('overnight_date_time_of_pickup')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="num_senior_citizens" class="form-label">
                                            <i class="fas fa-user-clock"></i>
                                            No. of Senior Citizens
                                        </label>
                                            <input type="number" class="form-control @error('num_senior_citizens') is-invalid @enderror" id="num_senior_citizens" name="num_senior_citizens" min="0" value="{{ old('num_senior_citizens', 0) }}">
                                            @error('num_senior_citizens')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    <div class="form-group">
                                        <label for="num_pwds" class="form-label">
                                            <i class="fas fa-wheelchair"></i>
                                            No. of PWDs
                                        </label>
                                            <input type="number" class="form-control @error('num_pwds') is-invalid @enderror" id="num_pwds" name="num_pwds" min="0" value="{{ old('num_pwds', 0) }}">
                                            @error('num_pwds')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <hr> {{-- Separator --}}

                            {{-- IMPORTANT: These fields are NOT to be filled by the tourist.
                                They will be populated automatically by the system upon booking approval.
                                They are kept here as disabled inputs to avoid validation errors if they
                                were explicitly required by the backend, but their values will be ignored
                                and overwritten by the backend logic. --}}
                            <div id="commonFields" style="display: none;">
                                <div class="mb-3">
                                    <label for="assigned_boat" class="form-label">Assigned Boat:</label>
                                    <input type="text" class="form-control" id="assigned_boat" name="assigned_boat" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="boat_captain_crew" class="form-label">Boat Captain/Crew:</label>
                                    <input type="text" class="form-control" id="boat_captain_crew" name="boat_captain_crew" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="boat_contact_number" class="form-label">Boat Contact Number:</label>
                                    <input type="text" class="form-control" id="boat_contact_number" name="boat_contact_number" disabled>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" {{ isset($conflictingBooking) && $conflictingBooking ? 'disabled' : '' }}>
                                @if(isset($conflictingBooking) && $conflictingBooking)
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Room Unavailable
                                @else
                                        <i class="fas fa-check-circle"></i>
                                        Proceed to Confirmation
                                @endif
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Modern Sidebar Styling - Dark Theme */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .modern-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            pointer-events: none;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .brand-icon-img {
            width: 28px;
            height: 28px;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            flex: 1;
        }

        .brand-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin: 0;
            font-weight: 400;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav .nav {
            padding: 0 1rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .nav-link.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .nav-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }

        .notification-badge {
            background: linear-gradient(135deg, #ff6b6b, #ff4757);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

        /* Main Content Area */
        .main-content {
            padding: 2rem;
            background: transparent;
            min-height: 100vh;
            overflow-y: auto;
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 1rem;
            }
        }

        /* Modern Registration Page Styling */
        .registration-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            z-index: 2;
        }

        .header-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
        }

        .header-text {
            flex: 1;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 0.5rem 0;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
        }

        .header-decoration {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            opacity: 0.1;
        }

        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .decoration-circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20px;
            right: 20px;
        }

        .decoration-circle:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60px;
            right: 60px;
        }

        .decoration-circle:nth-child(3) {
            width: 40px;
            height: 40px;
            top: 100px;
            right: 100px;
        }

        /* Registration Container */
        .registration-container {
            margin-bottom: 2rem;
        }

        /* Registration Form Card */
        .registration-form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .registration-form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .form-header {
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-title i {
            color: #007bff;
        }

        .form-subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin: 0;
        }

        .registration-form {
            padding: 2rem;
        }

        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(248, 249, 250, 0.5);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title i {
            color: #007bff;
            width: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
            }
            
            .form-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #007bff;
            width: 16px;
        }

        .form-control {
            padding: 0.875rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            color: #dc3545;
            margin-top: 0.5rem;
        }

        .help-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.5rem;
            font-style: italic;
        }

        .guest-inputs-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-actions {
            padding: 2rem;
            display: flex;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            min-width: 200px;
            max-width: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-primary:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            }
            
            .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Error State */
        .error-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .error-icon {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 1.5rem;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1rem 0;
        }

        .error-description {
            font-size: 1rem;
            color: #6c757d;
            margin: 0 0 1.5rem 0;
        }

        .conflict-details {
            background: rgba(255, 193, 7, 0.1);
            padding: 1rem;
            border-radius: 10px;
            margin: 1.5rem 0;
            border-left: 4px solid #ffc107;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Success/Error Messages */
        .success-message,
        .error-message {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .success-message {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .error-message {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .success-icon,
        .error-icon {
            font-size: 1.5rem;
        }

        .success-icon {
            color: #007bff;
        }

        .error-icon {
            color: #dc3545;
        }

        .success-content h4,
        .error-content h4 {
            margin: 0 0 0.5rem 0;
            font-weight: 600;
        }

        .success-content p,
        .error-content p {
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .registration-header {
                padding: 2rem 1.5rem;
                margin-bottom: 2rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .btn-primary {
                width: 100%;
                max-width: 100%;
                min-width: auto;
            }

            .error-actions {
                flex-direction: column;
            }

            .error-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .registration-header {
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .registration-form {
                padding: 1.5rem;
            }

            .form-section {
                padding: 1rem;
            }

            .form-actions {
                padding: 1.5rem;
            }
        }

        /* Animation for cards */
        .registration-form-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Staggered animation for form sections */
        .form-section {
            animation: slideInLeft 0.6s ease-out;
        }

        .form-section:nth-child(2) { animation-delay: 0.1s; }
        .form-section:nth-child(3) { animation-delay: 0.2s; }
        .form-section:nth-child(4) { animation-delay: 0.3s; }
        .form-section:nth-child(5) { animation-delay: 0.4s; }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .mobile-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .mobile-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 85vw !important;
        }

        .mobile-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
        }

        .mobile-brand-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .mobile-brand-icon-img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        .mobile-brand-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mobile-brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin: 0;
            font-weight: 400;
        }

        .mobile-sidebar-nav {
            padding: 1rem 0;
        }

        .mobile-sidebar-nav .nav {
            padding: 0 1rem;
        }

        .mobile-sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .mobile-sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mobile-sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .mobile-sidebar-nav .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .mobile-sidebar-nav .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .mobile-sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
            }
            
            .modern-mobile-sidebar {
                width: 95vw !important;
            }
            
            .mobile-toggle {
                padding: 0.75rem;
            }
            
            .mobile-toggle-btn {
                padding: 0.5rem 0.75rem;
                font-size: 1rem;
            }
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamic guest inputs
            const numGuestsInput = document.getElementById('numGuests');
            const guestContainer = document.getElementById('guestNamesContainer');
            const guestInputs = document.getElementById('guestInputs');

            function renderGuestInputs(count) {
                // count includes primary guest; we render additional guest names only
                const additional = Math.max((parseInt(count || '1', 10) - 1), 0);
                guestInputs.innerHTML = '';
                for (let i = 1; i <= additional; i++) {
                    const wrap = document.createElement('div');
                    wrap.className = 'input-group';
                    const span = document.createElement('span');
                    span.className = 'input-group-text';
                    span.textContent = `Guest ${i + 1}`; // guest numbering starts at 2
                    const nameInput = document.createElement('input');
                    nameInput.type = 'text';
                    nameInput.name = `guest_names[]`;
                    nameInput.required = additional > 0; // require if there should be any
                    nameInput.className = 'form-control';
                    nameInput.placeholder = `Enter guest ${i + 1} full name`;
                    const ageInput = document.createElement('input');
                    ageInput.type = 'number';
                    ageInput.name = `guest_ages[]`;
                    ageInput.min = '7';
                    ageInput.placeholder = 'Age (7+)';
                    ageInput.className = 'form-control';
                    ageInput.style.maxWidth = '120px';
                    wrap.appendChild(span);
                    wrap.appendChild(nameInput);
                    wrap.appendChild(ageInput);
                    guestInputs.appendChild(wrap);
                }
            }

            function syncGuestInputs() {
                const v = parseInt(numGuestsInput.value || '1', 10);
                if (v > 1) {
                    guestContainer.style.display = 'block';
                    renderGuestInputs(v);
                } else {
                    guestContainer.style.display = 'none';
                    guestInputs.innerHTML = '';
                }
                // Always re-evaluate tour type specific fields after changing guest count
                toggleFormFields();
            }

            if (numGuestsInput) {
                numGuestsInput.addEventListener('input', syncGuestInputs);
                numGuestsInput.addEventListener('change', syncGuestInputs);
                // Initial render based on current value
                syncGuestInputs();
            }
            const tourTypeSelect = document.getElementById('tour_type');
            const dayTourSpecificFields = document.getElementById('dayTourSpecificFields');
            const overnightSpecificFields = document.getElementById('overnightSpecificFields');

            function resetInputs(container) {
                container.querySelectorAll('input').forEach(input => {
                    if (input.type === 'number') {
                        input.value = input.min || 0;
                    } else if (input.type === 'time' || input.type === 'datetime-local' || input.type === 'text') {
                        input.value = '';
                    }
                });
            }

            function toggleFormFields() {
                var tSel = document.getElementById('tour_type');
                var dayEl = document.getElementById('dayTourSpecificFields');
                var overEl = document.getElementById('overnightSpecificFields');
                if (!tSel || !dayEl || !overEl) { return; }

                var selectedTourType = tSel.value;

                // Hide both sections first (force hidden)
                dayEl.style.display = 'none';
                overEl.style.display = 'none';

                // Remove required attributes
                dayEl.querySelectorAll('input').forEach(function(input){ input.removeAttribute('required'); });
                overEl.querySelectorAll('input').forEach(function(input){ input.removeAttribute('required'); });

                if (selectedTourType === 'day_tour') {
                    dayEl.style.display = 'block';
                    dayEl.querySelectorAll('input').forEach(function(input){ input.setAttribute('required', 'required'); });
                } else if (selectedTourType === 'overnight') {
                    overEl.style.display = 'block';
                    overEl.querySelectorAll('input').forEach(function(input){ input.setAttribute('required', 'required'); });
                }
            }

            // Set initial state on page load
            // Use multiple small delays to ensure all old values are bound and DOM is ready
            setTimeout(function(){ toggleFormFields(); }, 0);
            setTimeout(function(){ toggleFormFields(); }, 200);
            setTimeout(function(){ toggleFormFields(); }, 800);


            // Add event listener for when the tour type changes
            if (tourTypeSelect) {
                var reToggle = function(){
                    toggleFormFields();
                };
                tourTypeSelect.addEventListener('change', reToggle);
                tourTypeSelect.addEventListener('input', reToggle);
                tourTypeSelect.addEventListener('blur', reToggle);
            }

            // Set minimum date for datetime-local input for overnight pick-up
            const overnightDateTimeInput = document.getElementById('overnight_date_time_of_pickup');
            if (overnightDateTimeInput) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                overnightDateTimeInput.min = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        });
    </script>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Modern Sidebar Styling - Dark Theme */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .modern-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            pointer-events: none;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .brand-icon-img {
            width: 28px;
            height: 28px;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            flex: 1;
        }

        .brand-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin: 0;
            font-weight: 400;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav .nav {
            padding: 0 1rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .nav-link.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .nav-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }

        .notification-badge {
            background: linear-gradient(135deg, #ff6b6b, #ff4757);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Main Content Area */
        .main-content {
            padding: 2rem;
            background: transparent;
            min-height: 100vh;
            overflow-y: auto;
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 1rem;
            }
        }
    </style>
</x-app-layout>