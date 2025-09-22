<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        {{-- Font Awesome CDN for Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                {{-- Modern Header Section --}}
                <div class="booking-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="header-text">
                            <h1 class="page-title">Complete Your Booking</h1>
                            <p class="page-subtitle">Fill in your details to secure your reservation</p>
                        </div>
                    </div>
                    <div class="header-decoration">
                        <div class="decoration-circle"></div>
                        <div class="decoration-circle"></div>
                        <div class="decoration-circle"></div>
                    </div>
                </div>

                @isset($room)
                    <div class="booking-container">
                    <div class="row g-4">
                            {{-- Room Information Card - Enhanced Design --}}
                        <div class="col-12 col-lg-6 order-1 order-lg-2">
                                <div class="room-info-card">
                                    <div class="room-image-container">
                                    @if ($room->image_path)
                                            <img src="{{ asset($room->image_path) }}" class="room-image" alt="Room Image">
                                            <div class="room-overlay">
                                                <div class="overlay-content">
                                                    <i class="fas fa-bed overlay-icon"></i>
                                                    <span class="overlay-text">Room Preview</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="room-placeholder">
                                                <i class="fas fa-bed"></i>
                                                <span>Room Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="room-content">
                                        <div class="room-header">
                                            <h3 class="room-title">{{ $room->room_name }}</h3>
                                            <div class="room-price">
                                                <span class="price-amount">₱{{ number_format($room->price_per_night, 2) }}</span>
                                                <span class="price-period">per night</span>
                                            </div>
                                        </div>
                                        
                                        <div class="room-details">
                                            <div class="detail-item">
                                                <i class="fas fa-users"></i>
                                                <span>Max {{ $room->max_guests }} guests</span>
                                            </div>
                                        </div>
                                        
                                        @if ($room->description)
                                            <div class="amenities-section">
                                                <h6 class="amenities-title">
                                                    <i class="fas fa-star"></i>
                                                    Amenities
                                                </h6>
                                                <div class="amenities-list">
                                                    @php
                                                $amenities = explode('•', $room->description);
                                            @endphp
                                            @foreach ($amenities as $amenity)
                                                @php
                                                    $amenity = trim($amenity);
                                                @endphp
                                                        @if (!empty($amenity))
                                                            <div class="amenity-item">
                                                                <i class="fas fa-check"></i>
                                                                <span>{{ $amenity }}</span>
                                                            </div>
                                                @endif
                                            @endforeach
                                                </div>
                                            </div>
                                        @endif
                                </div>
                            </div>
                        </div>

                            {{-- Booking Form - Enhanced Design --}}
                        <div class="col-12 col-lg-6 order-2 order-lg-1">
                                <div class="booking-form-card">
                                    <div class="form-header">
                                        <h3 class="form-title">
                                            <i class="fas fa-edit"></i>
                                            Booking Details
                                        </h3>
                                        <p class="form-subtitle">Please provide your information to proceed</p>
                                    </div>
                            {{-- Step 1 (Schedule & Contact). Personal info moved to Step 2. --}}
                            <form id="fillupForm" action="{{ url('tourist/fillup/' . $room->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $roomId ?? '' }}">

                                {{-- Personal information fields moved to the next step (fillup2). --}}
                                        <div class="form-fields">
                                    {{-- Row 1: Nationality and Contact Number --}}
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="nationality" class="form-label">
                                                        <i class="fas fa-flag"></i>
                                                        Nationality
                                                    </label>
                                                    <select class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality" required>
                                                <option value="">Select Nationality</option>
                                                {{-- Options will be populated by JavaScript --}}
                                            </select>
                                            @error('nationality')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                                <div class="form-group">
                                                    <label for="contactNumber" class="form-label">
                                                        <i class="fas fa-phone"></i>
                                                        Contact Number
                                                    </label>
                                            <input type="text" 
                                                   class="form-control @error('contact_number') is-invalid @enderror" 
                                                   id="contactNumber" 
                                                   name="contact_number" 
                                                   placeholder="e.g., 09123456789" 
                                                   value="{{ Auth::user()->phone ?? old('contact_number') }}" 
                                                   pattern="[0-9]{11}" 
                                                   maxlength="11" 
                                                   minlength="11"
                                                   title="Please enter exactly 11 digits for the contact number." 
                                                   inputmode="numeric" 
                                                   oninput="validateContactNumber(this)"
                                                   required>
                                                    <div id="contact_number_error" class="error-message" style="display: none;">
                                                The number is not enough. Please enter exactly 11 digits.
                                            </div>
                                            @error('contact_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    {{-- Row 2: Reservation Date and Number of Nights --}}
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="reservationDate" class="form-label">
                                                        <i class="fas fa-calendar"></i>
                                                        Date of Reservation
                                                    </label>
                                            <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" id="reservationDate" name="reservation_date" value="{{ old('reservation_date') }}" required>
                                            @error('reservation_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                                <div class="form-group">
                                                    <label for="numNights" class="form-label">
                                                        <i class="fas fa-moon"></i>
                                                        Number of Nights
                                                    </label>
                                            <input type="number" class="form-control @error('num_nights') is-invalid @enderror" id="numNights" name="num_nights" min="1" value="{{ old('num_nights', 1) }}" required>
                                            @error('num_nights')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                            {{-- Row 3: Number of Guests --}}
                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="numGuests" class="form-label">
                                                        <i class="fas fa-users"></i>
                                                        Number of Guests
                                                    </label>
                                            <input type="number" class="form-control @error('num_guests') is-invalid @enderror" id="numGuests" name="num_guests" min="1" value="{{ old('num_guests', 1) }}" required>
                                            @error('num_guests')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Row 4: Payment & Identification (Step 1 uploads) --}}
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-receipt"></i>
                                                Downpayment Receipt
                                            </label>
                                            <input type="file" class="form-control @error('downpayment_receipt') is-invalid @enderror" name="downpayment_receipt" accept="image/*">
                                            @error('downpayment_receipt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"></label>
                                                <i class="fas fa-id-card"></i>
                                                Send Valid ID (Type)
                                            </label>
                                            <select class="form-control @error('valid_id_type') is-invalid @enderror" name="valid_id_type" id="validIdType">
                                                <option value="">Select ID Type</option>
                                                <option value="National I.D">National I.D</option>
                                                <option value="Passport">Passport</option>
                                                <option value="License">License</option>
                                                <option value="Other Valid I.D">Other Valid I.D</option>
                                            </select>
                                            @error('valid_id_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group" id="seniorPwdUploadRow" style="display:none;">
                                            <label class="form-label">
                                                <i class="fas fa-id-badge"></i>
                                                Upload Senior/PWD IDs (if applicable)
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-12 col-md-6">
                                                    <input type="file" class="form-control @error('senior_id_image') is-invalid @enderror" name="senior_id_image" id="senior_id_image" accept="image/*">
                                                    @error('senior_id_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    <small class="text-muted">Senior citizen ID image</small>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <input type="file" class="form-control @error('pwd_id_image') is-invalid @enderror" name="pwd_id_image" id="pwd_id_image" accept="image/*">
                                                    @error('pwd_id_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    <small class="text-muted">PWD ID image</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row" id="validIdNumberWrap" style="display:none;">
                                        <div class="form-group full-width">
                                            <label class="form-label" id="validIdNumberLabel">
                                                <i class="fas fa-hashtag"></i>
                                                ID Number
                                            </label>
                                            <input type="text" class="form-control @error('valid_id_number') is-invalid @enderror" name="valid_id_number" id="validIdNumber" value="{{ old('valid_id_number') }}" placeholder="Enter ID number">
                                            @error('valid_id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-row" id="validIdImageWrap" style="display:none;">
                                        <div class="form-group full-width">
                                            <label class="form-label">
                                                <i class="fas fa-image"></i>
                                                Upload Valid ID Image
                                            </label>
                                            <input type="file" class="form-control @error('valid_id_image') is-invalid @enderror" name="valid_id_image" id="validIdImage" accept="image/*">
                                            @error('valid_id_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-arrow-right"></i>
                                                Continue to Details
                                </button>
                                            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i>
                                                Back
                                            </a>
                                        </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="error-state">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="error-title">Room Not Found</h3>
                        <p class="error-description">Room details could not be loaded. Please go back and try again.</p>
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Go Back
                        </a>
                    </div>
                @endisset
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
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
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

        /* Adjust navbar width to match sidebar */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
        }

        /* Hide hamburger button by default on larger screens */
        .hamburger-btn {
            display: none !important;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                margin-left: 0;
            }
            
            .modern-sidebar {
                display: none !important;
            }
            
            /* Ensure hamburger button is visible */
            .hamburger-btn {
                display: block !important;
            }
            
            .modern-navbar {
                left: 0;
                width: 100%;
            }
        }

        /* Modern Booking Page Styling */
        .booking-header {
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

        /* Booking Container */
        .booking-container {
            margin-bottom: 2rem;
        }

        /* Room Info Card */
        .room-info-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .room-info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .room-image-container {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .room-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .room-info-card:hover .room-image {
            transform: scale(1.05);
        }

        .room-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .room-info-card:hover .room-overlay {
            opacity: 1;
        }

        .overlay-content {
            text-align: center;
            color: white;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .room-info-card:hover .overlay-content {
            transform: translateY(0);
        }

        .overlay-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .overlay-text {
            font-size: 1.3rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .room-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 1.2rem;
        }

        .room-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .room-content {
            padding: 2rem;
        }

        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .room-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            flex: 1;
        }

        .room-price {
            text-align: right;
        }

        .price-amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: #007bff;
            display: block;
        }

        .price-period {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .room-details {
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            color: #6c757d;
        }

        .detail-item i {
            color: #007bff;
            width: 20px;
        }

        .amenities-section {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 1.5rem;
        }

        .amenities-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .amenities-title i {
            color: #ffc107;
        }

        .amenities-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: #495057;
        }

        .amenity-item i {
            color: #28a745;
            width: 16px;
        }

        /* Booking Form Card */
        .booking-form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            height: 100%;
        }

        .form-header {
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
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

        .form-fields {
            padding: 2rem;
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

        .error-message {
            font-size: 0.875rem;
            color: #dc3545;
            margin-top: 0.5rem;
        }

        .form-actions {
            padding: 0 2rem 2rem 2rem;
            display: flex;
            gap: 1rem;
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
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
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
            margin: 0 0 2rem 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .booking-header {
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

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .room-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .room-price {
                text-align: left;
            }
        }

        @media (max-width: 576px) {
            .booking-header {
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .form-fields {
                padding: 1.5rem;
            }

            .form-actions {
                padding: 0 1.5rem 1.5rem 1.5rem;
            }

            .room-content {
                padding: 1.5rem;
            }
        }

        /* Animation for cards */
        .room-info-card,
        .booking-form-card {
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

        /* Staggered animation */
        .booking-form-card {
            animation-delay: 0.2s;
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
            
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>

    <script>
        // Function to validate contact number input
        function validateContactNumber(input) {
            const value = input.value;
            const errorDiv = document.getElementById('contact_number_error');
            
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

        document.addEventListener('DOMContentLoaded', function() {
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    // Bootstrap's 'md' breakpoint is 768px
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // Set minimum date for Date of Reservation to today
            const reservationDateInput = document.getElementById('reservationDate');
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const day = String(today.getDate()).padStart(2, '0');
            const minDate = `${year}-${month}-${day}`;
            reservationDateInput.setAttribute('min', minDate);

            // Dynamically populate Nationality dropdown with the same list as registration form
            const nationalities = [
                "Filipino", "Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Antiguans",
                "Argentinean", "Armenian", "Australian", "Austrian", "Azerbaijani", "Bahamian", "Bahraini",
                "Bangladeshi", "Barbadian", "Belarusian", "Belgian", "Belizean", "Beninese", "Bhutanese",
                "Bolivian", "Bosnian", "Botswanan", "Brazilian", "British", "Bruneian", "Bulgarian",
                "Burkinabé", "Burundian", "Cambodian", "Cameroonian", "Canadian", "Cape Verdean", "Central African",
                "Chadian", "Chilean", "Chinese", "Colombian", "Comoran", "Congolese", "Costa Rican",
                "Croatian", "Cuban", "Cypriot", "Czech", "Danish", "Djiboutian", "Dominican", "Dutch",
                "East Timorese", "Ecuadorean", "Egyptian", "Emirian", "Equatorial Guinean", "Eritrean",
                "Estonian", "Ethiopian", "Fijian", "Finnish", "French", "Gabonese", "Gambian", "Georgian",
                "German", "Ghanaian", "Greek", "Grenadian", "Guatemalan", "Guinean", "Guinea-Bissauan",
                "Guyanese", "Haitian", "Honduran", "Hungarian", "Icelander", "Indian", "Indonesian", "Iranian",
                "Iraqi", "Irish", "Israeli", "Italian", "Ivorian", "Jamaican", "Japanese", "Jordanian",
                "Kazakhstani", "Kenyan", "Kittian and Nevisian", "Kuwaiti", "Kyrgyz", "Laotian", "Latvian",
                "Lebanese", "Liberian", "Libyan", "Liechtensteiner", "Lithuanian", "Luxembourgish", "Malagasy",
                "Malawian", "Malaysian", "Maldivian", "Malian", "Maltese", "Marshallese", "Mauritanian",
                "Mauritian", "Mexican", "Micronesian", "Moldovan", "Monacan", "Mongolian", "Montenegrin",
                "Moroccan", "Mozambican", "Myanmar", "Namibian", "Nauruan", "Nepalese", "New Zealander",
                "Nicaraguan", "Nigerien", "Nigerian", "North Korean", "North Macedonian", "Norwegian",
                "Omani", "Pakistani", "Palauan", "Palestinian", "Panamanian", "Papua New Guinean", "Paraguayan",
                "Peruvian", "Polish", "Portuguese", "Qatari", "Romanian", "Russian", "Rwandan",
                "Saint Lucian", "Saint Vincentian and Grenadine", "Sammarinese", "Sao Tomean", "Saudi Arabian",
                "Senegalese", "Serbian", "Seychellois", "Sierra Leonean", "Singaporean", "Slovak", "Slovenian",
                "Solomon Islander", "Somali", "South African", "South Korean", "South Sudanese", "Spanish",
                "Sri Lankan", "Sudanese", "Surinamese", "Swedish", "Swiss", "Syrian", "Taiwanese", "Tajik",
                "Tanzanian", "Thai", "Togolese", "Tongan", "Trinidadian and Tobagonian", "Tunisian", "Turkish",
                "Turkmen", "Tuvaluan", "Ugandan", "Ukrainian", "Emirati", "Uruguayan", "Uzbek", "Vanuatuan",
                "Venezuelan", "Vietnamese", "Yemeni", "Zambian", "Zimbabwean"
            ];

            const nationalitySelect = document.getElementById('nationality');
            nationalities.sort().forEach(function(nationality) { // Sort alphabetically
                const option = document.createElement('option');
                option.value = nationality;
                option.textContent = nationality;
                nationalitySelect.appendChild(option);
            });

            // Set user's nationality as selected if present in the list
            // Use old('nationality') to re-select if there was a validation error
            const userNationality = "{{ Auth::user()->nationality ?? '' }}";
            const oldNationality = "{{ old('nationality') }}";
            const nationalityToSet = oldNationality || userNationality;
            
            console.log('User nationality:', userNationality);
            console.log('Old nationality:', oldNationality);
            console.log('Nationality to set:', nationalityToSet);
            
            if (nationalityToSet) {
                const selectedOption = nationalitySelect.querySelector(`option[value="${nationalityToSet}"]`);
                if (selectedOption) {
                    selectedOption.selected = true;
                    console.log('Set nationality to:', nationalityToSet);
                } else {
                    console.log('Nationality not found in dropdown:', nationalityToSet);
                }
            } else {
                // Default to Filipino if no old value and user's nationality is not set
                const filipinoOption = nationalitySelect.querySelector('option[value="Filipino"]');
                if (filipinoOption) {
                    filipinoOption.selected = true;
                    console.log('Set default nationality to: Filipino');
                }
            }

            // Function to toggle valid ID image input visibility and required attribute
            function toggleValidIdImage() {
                const validIdTypeSelect = document.getElementById('validIdType');
                const validIdImageInput = document.getElementById('validIdImage');
                const validIdImageWrap = document.getElementById('validIdImageWrap');
                const validIdNumberWrap = document.getElementById('validIdNumberWrap');
                const validIdNumberLabel = document.getElementById('validIdNumberLabel');
                const validIdNumberInput = document.getElementById('validIdNumber');

                if (validIdTypeSelect.value === '') {
                    validIdImageInput.setAttribute('required', 'required');
                    validIdImageWrap.style.display = 'none';
                    if (validIdNumberWrap) validIdNumberWrap.style.display = 'none';
                    if (validIdNumberInput) validIdNumberInput.value = '';
                } else {
                    validIdImageInput.removeAttribute('required');
                    validIdImageWrap.style.display = 'block';
                    if (validIdNumberWrap) validIdNumberWrap.style.display = 'block';
                    if (validIdNumberLabel) {
                        const type = validIdTypeSelect.value;
                        let labelText = 'ID Number';
                        if (type === 'National I.D') labelText = 'National I.D Number';
                        else if (type === 'Passport') labelText = 'Passport Number';
                        else if (type === 'License') labelText = 'License Number';
                        else if (type === 'Other Valid I.D') labelText = 'ID Number';
                        validIdNumberLabel.innerHTML = '<i class="fas fa-hashtag"></i> ' + labelText;
                    }
                }
            }

            // Initial call to set the state on page load
            toggleValidIdImage();

            // Add event listener for valid_id_type change
            document.getElementById('validIdType').addEventListener('change', toggleValidIdImage);

            // Valid ID image toggle based on type selection
            const idType = document.getElementById('validIdType');
            const idWrap = document.getElementById('validIdImageWrap');
            const idInput = document.getElementById('validIdImage');
            const idNumWrap = document.getElementById('validIdNumberWrap');
            const idNumInput = document.getElementById('validIdNumber');
            const idNumLabel = document.getElementById('validIdNumberLabel');
            const syncValidId = () => {
                const hasType = idType && idType.value && idType.value.trim() !== '';
                if (idWrap) idWrap.style.display = hasType ? 'block' : 'none';
                if (idInput) {
                    if (hasType) { idInput.setAttribute('required','required'); }
                    else { idInput.removeAttribute('required'); idInput.value = ''; }
                }
                if (idNumWrap) idNumWrap.style.display = hasType ? 'block' : 'none';
                if (idNumLabel) {
                    const type = idType.value;
                    let labelText = 'ID Number';
                    if (type === 'National I.D') labelText = 'National I.D Number';
                    else if (type === 'Passport') labelText = 'Passport Number';
                    else if (type === 'License') labelText = 'License Number';
                    else if (type === 'Other Valid I.D') labelText = 'ID Number';
                    idNumLabel.innerHTML = '<i class="fas fa-hashtag"></i> ' + labelText;
                }
            };
            if (idType) {
                idType.addEventListener('change', syncValidId);
                idType.addEventListener('input', syncValidId);
                syncValidId();
            }
        });
    </script>
</x-app-layout>
