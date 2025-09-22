<x-app-layout>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="modern-sidebar d-none d-md-block">
            {{-- Sidebar Header --}}
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" class="brand-icon-img">
                    </div>
                    <div class="brand-text">
                        <h4 class="brand-title">Resorts Menu</h4>
                        <p class="brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
            </div>
            
            {{-- Sidebar Navigation --}}
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.information') }}" class="nav-link {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Resort Management</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Account Management</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.notification') }}" class="nav-link {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Notifications</span>
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="nav-badge notification-badge" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.documentation') }}" class="nav-link {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Documentation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start modern-mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <div class="mobile-sidebar-brand">
                    <div class="mobile-brand-icon">
                        <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" class="mobile-brand-icon-img">
                    </div>
                    <div class="mobile-brand-text">
                        <h5 class="mobile-brand-title" id="mobileSidebarLabel">Resorts Menu</h5>
                        <p class="mobile-brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="mobile-sidebar-nav">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.information') }}" class="nav-link {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Resort Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Account Management</span>
                        </a>
                    </li>
                    {{-- Notifications (Mobile) --}}
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.notification') }}" class="nav-link {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Notifications</span>
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="nav-badge" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- Documentation (Mobile) --}}
                    <li class="nav-item">
                        <a href="{{ route('resort.owner.documentation') }}" class="nav-link {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Documentation</span>
                        </a>
                    </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="main-content flex-grow-1">
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-title-section">
                    <h1 class="page-title">
                        <i class="fas fa-plus me-2"></i>
                        Add Room: {{ $resort->resort_name }}
                    </h1>
                    <p class="page-subtitle">Create a new room or cottage for your resort</p>
                </div>
            </div>

            {{-- Form Container --}}
            <div class="form-container">
                <div class="form-card">
                    <form action="{{ route('resort.owner.rooms.store', $resort->id) }}" method="POST" enctype="multipart/form-data" class="modern-form">
                        @csrf

                        {{-- Basic Information Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>
                                Basic Information
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="accommodation_type" class="form-label">
                                            <i class="fas fa-home me-1"></i>
                                            Accommodation Type
                                        </label>
                                        <select class="form-control @error('accommodation_type') is-invalid @enderror" id="accommodation_type" name="accommodation_type" required>
                                            <option value="room" {{ old('accommodation_type', request('type', 'room')) === 'room' ? 'selected' : '' }}>Room</option>
                                            <option value="cottage" {{ old('accommodation_type', request('type')) === 'cottage' ? 'selected' : '' }}>Cottage</option>
                                        </select>
                                        @error('accommodation_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="room_name" class="form-label">
                                            <i class="fas fa-tag me-1"></i>
                                            Room Name
                                        </label>
                                        <input type="text" class="form-control @error('room_name') is-invalid @enderror" id="room_name" name="room_name" value="{{ old('room_name') }}" required>
                                        @error('room_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>
                                    Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Describe the room features, amenities, and special characteristics...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pricing & Capacity Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-dollar-sign me-2"></i>
                                Pricing & Capacity
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price_per_night" class="form-label" id="priceLabel">
                                            <i class="fas fa-money-bill-wave me-1"></i>
                                            Price Per Night (₱)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" class="form-control @error('price_per_night') is-invalid @enderror" id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}" required min="0" placeholder="0.00">
                                        </div>
                                        @error('price_per_night')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="max_guests" class="form-label">
                                            <i class="fas fa-users me-1"></i>
                                            Maximum Guests
                                        </label>
                                        <input type="number" class="form-control @error('max_guests') is-invalid @enderror" id="max_guests" name="max_guests" value="{{ old('max_guests') }}" required min="1" placeholder="1">
                                        @error('max_guests')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Image Upload Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-image me-2"></i>
                                Room Images
                            </h3>
                            
                            <div class="form-group">
                                <label for="room_image" class="form-label">
                                    <i class="fas fa-upload me-1"></i>
                                    Upload Cover Image
                                </label>
                                <div class="file-upload-container">
                                    <input type="file" class="form-control @error('room_image') is-invalid @enderror" id="room_image" name="room_image" accept="image/*">
                                    <div class="file-upload-info">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Max 2MB. Accepted formats: JPG, PNG, GIF
                                        </small>
                                    </div>
                                </div>
                                @error('room_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="images" class="form-label">
                                    <i class="fas fa-images me-1"></i>
                                    Additional Photos (up to 4)
                                </label>
                                <div class="file-upload-container">
                                    <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple>
                                    <div class="file-upload-info">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            You can select multiple files; max 4 photos, 2MB each. Accepted formats: JPG, PNG, GIF
                                        </small>
                                    </div>
                                </div>
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Room Status Section --}}
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-cog me-2"></i>
                                Room Status
                            </h3>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Select Room Status
                                </label>
                                <div class="status-selection">
                                    <div class="status-option">
                                        <input class="form-check-input d-none" type="radio" name="status" id="statusOpen" value="open" {{ old('status', 'open') == 'open' ? 'checked' : '' }}>
                                        <label class="status-btn status-open" for="statusOpen">
                                            <div class="status-icon">
                                                <i class="fas fa-door-open"></i>
                                            </div>
                                            <div class="status-info">
                                                <div class="status-title">Open</div>
                                                <div class="status-desc">Available for booking</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="status-option">
                                        <input class="form-check-input d-none" type="radio" name="status" id="statusClosed" value="closed" {{ old('status') == 'closed' ? 'checked' : '' }}>
                                        <label class="status-btn status-closed" for="statusClosed">
                                            <div class="status-icon">
                                                <i class="fas fa-door-closed"></i>
                                            </div>
                                            <div class="status-info">
                                                <div class="status-title">Closed</div>
                                                <div class="status-desc">Temporarily unavailable</div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="status-option">
                                        <input class="form-check-input d-none" type="radio" name="status" id="statusRehab" value="maintenance" {{ old('status') == 'maintenance' ? 'checked' : '' }}>
                                        <label class="status-btn status-maintenance" for="statusRehab">
                                            <div class="status-icon">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                            <div class="status-info">
                                                <div class="status-title">Under Maintenance</div>
                                                <div class="status-desc">Being renovated</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Maintenance Reason (conditionally displayed) --}}
                            <div class="form-group" id="rehabReasonContainer" style="display: none;">
                                <label for="rehab_reason" class="form-label">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    Maintenance Reason
                                </label>
                                <textarea class="form-control @error('rehab_reason') is-invalid @enderror" id="rehab_reason" name="rehab_reason" rows="3" placeholder="Please provide details about the maintenance work...">{{ old('rehab_reason') }}</textarea>
                                @error('rehab_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Required if status is "Under Maintenance"
                                </div>
                            </div>
                        </div>

                        {{-- Legacy Availability Checkbox --}}
                        <div class="form-section">
                            <div class="form-group">
                                <div class="form-check legacy-checkbox">
                                    <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Available for Booking (Legacy - Status field preferred)
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="form-actions">
                            <div class="action-buttons">
                                <a href="{{ route('resort.owner.information') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Add Room
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 0;
            margin-left: 280px;
            overflow-y: auto;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
        }

        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border-left: 4px solid #007bff;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .page-title i {
            color: #007bff;
            font-size: 1.8rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
            font-weight: 400;
        }

        /* Form Container */
        .form-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .modern-form {
            padding: 2rem;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #f1f3f4;
        }

        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #495057;
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title i {
            color: #007bff;
            margin-right: 0.5rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            color: #6c757d;
            margin-right: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        /* Input Groups */
        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            color: #6c757d;
            font-weight: 600;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group .form-control:focus {
            border-left: 2px solid #007bff;
        }

        /* File Upload */
        .file-upload-container {
            position: relative;
        }

        .file-upload-info {
            margin-top: 0.5rem;
        }

        /* Status Selection */
        .status-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .status-option {
            position: relative;
        }

        .status-btn {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            width: 100%;
        }

        .status-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status-btn.active {
            border-color: #007bff;
            background: #f8f9ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }

        .status-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .status-open .status-icon {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-closed .status-icon {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .status-maintenance .status-icon {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .status-info {
            flex: 1;
        }

        .status-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.25rem;
        }

        .status-desc {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Legacy Checkbox */
        .legacy-checkbox {
            padding: 1rem;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
        }

        .legacy-checkbox .form-check-label {
            color: #856404;
            font-weight: 500;
        }

        /* Form Actions */
        .form-actions {
            background: #f8f9fa;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e9ecef;
            margin: 0 -2rem -2rem -2rem;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            color: white;
        }

        /* Responsive Design */
        /* Specific breakpoint for 768px */
        @media (max-width: 768px) and (min-width: 767px) {
            .hamburger-btn {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            .d-lg-none {
                display: block !important;
            }
            
            nav.navbar .d-lg-none .hamburger-btn {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                left: 0 !important;
            }
            
            .modern-sidebar {
                display: none !important;
            }
            
            /* Ensure hamburger button is visible */
            .hamburger-btn {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            /* Ensure the hamburger button container is visible */
            .d-lg-none {
                display: block !important;
            }
            
            /* Force hamburger button visibility with higher specificity */
            nav.navbar .d-lg-none .hamburger-btn {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                border: none !important;
                color: white !important;
                border-radius: 8px !important;
                padding: 8px 12px !important;
                font-size: 16px !important;
                transition: all 0.3s ease !important;
                box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3) !important;
            }
            
            nav.navbar .d-lg-none .hamburger-btn:hover {
                background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4) !important;
                color: white !important;
            }
            
            /* Additional debugging - make sure button is visible */
            .navbar .d-lg-none {
                display: block !important;
                visibility: visible !important;
            }
            
            .navbar .d-lg-none .btn.hamburger-btn {
                display: inline-block !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                z-index: 9999 !important;
            }
            
            .modern-navbar {
                left: 0 !important;
                width: 100% !important;
                margin-left: 0 !important;
            }
            
            /* Ensure no sidebar space is reserved */
            .d-flex.flex-column.flex-md-row {
                flex-direction: column !important;
            }
            
            /* Force main content to full width */
            .main-content {
                flex: 1 !important;
                margin-left: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .modern-form {
                padding: 1.5rem;
            }
            
            .form-section {
                margin-bottom: 2rem;
                padding-bottom: 1.5rem;
            }
            
            .status-selection {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .page-header {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.3rem;
            }
            
            .modern-form {
                padding: 1rem;
            }
            
            .form-actions {
                padding: 1rem;
                margin: 0 -1rem -1rem -1rem;
            }
        }

        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color:rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Added for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated {
            transform: rotate(180deg);
        }

        /* SweetAlert2 Responsive Styles */
        .swal2-popup-responsive {
            font-size: 14px !important;
            max-width: 90% !important;
            width: 400px !important;
        }

        .swal2-title-responsive {
            font-size: 18px !important;
            line-height: 1.4 !important;
        }

        .swal2-content-responsive {
            font-size: 14px !important;
            line-height: 1.5 !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .swal2-popup-responsive {
                font-size: 12px !important;
                max-width: 95% !important;
                width: 350px !important;
                margin: 10px !important;
            }

            .swal2-title-responsive {
                font-size: 16px !important;
            }

            .swal2-content-responsive {
                font-size: 12px !important;
            }
        }

        @media (max-width: 480px) {
            .swal2-popup-responsive {
                font-size: 11px !important;
                max-width: 98% !important;
                width: 320px !important;
                margin: 5px !important;
            }

            .swal2-title-responsive {
                font-size: 14px !important;
            }

            .swal2-content-responsive {
                font-size: 11px !important;
            }
        }
    </style>

    <script>
        // Function to show/hide rehab reason based on status selection
        function toggleRehabReason() {
            var statusRehab = document.getElementById('statusRehab');
            var rehabReasonContainer = document.getElementById('rehabReasonContainer');
            var rehabReasonInput = document.getElementById('rehab_reason');
            
            if (statusRehab && statusRehab.checked) {
                rehabReasonContainer.style.display = 'block';
                rehabReasonInput.setAttribute('required', 'required');
            } else {
                rehabReasonContainer.style.display = 'none';
                rehabReasonInput.removeAttribute('required');
                rehabReasonInput.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the state of the rehab reason field on page load
            toggleRehabReason();

            // Status button interactions and styling
            const statusButtons = document.querySelectorAll('.status-btn');
            const statusRadios = document.querySelectorAll('input[name="status"]');
            
            // Function to update active status button
            function updateActiveStatusButton() {
                statusButtons.forEach(btn => btn.classList.remove('active'));
                const checkedRadio = document.querySelector('input[name="status"]:checked');
                if (checkedRadio) {
                    const correspondingBtn = document.querySelector(`label[for="${checkedRadio.id}"]`);
                    if (correspondingBtn) {
                        correspondingBtn.classList.add('active');
                    }
                }
            }
            
            // Add click event to status buttons
            statusButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    statusButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Update active button when radio changes
            statusRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateActiveStatusButton();
                    toggleRehabReason();
                });
            });

            // Image upload validation
            const imagesInput = document.getElementById('images');
            if (imagesInput) {
                imagesInput.addEventListener('change', function() {
                    const files = this.files;
                    if (files.length > 4) {
                        alert('You can only select up to 4 images. Please select fewer images.');
                        this.value = '';
                        return;
                    }
                    
                    // Check file sizes
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > 2 * 1024 * 1024) { // 2MB
                            alert(`File "${files[i].name}" is too large. Please select files smaller than 2MB.`);
                            this.value = '';
                            return;
                        }
                    }
                });
            }
            
            // Initial setup
            updateActiveStatusButton();
            
            // Handle form submission with SweetAlert2 success popup
            const roomForm = document.querySelector('form[action*="rooms.store"]');
            if (roomForm) {
                roomForm.addEventListener('submit', function(e) {
                    // Let the form submit normally, we'll show the popup on success
                    // The success popup will be triggered by the server response
                });
            }
            
            // Check for success message in URL parameters and show SweetAlert2
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === '1' || window.location.href.includes('success')) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "You have successfully added rooms",
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'swal2-popup-responsive',
                        title: 'swal2-title-responsive',
                        content: 'swal2-content-responsive'
                    }
                });
            }

            // Update price label based on type (room vs cottage)
            var typeSelect = document.getElementById('accommodation_type');
            var priceLabel = document.getElementById('priceLabel');
            function updatePriceLabel() {
                if (!typeSelect || !priceLabel) return;
                priceLabel.textContent = typeSelect.value === 'cottage' ? 'Price Per Stay (₱)' : 'Price Per Night (₱)';
            }
            updatePriceLabel();
            if (typeSelect) {
                typeSelect.addEventListener('change', updatePriceLabel);
            }

            var collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

            collapseToggles.forEach(function(toggle) {
                var targetId = toggle.getAttribute('href');
                if (targetId) {
                    var targetCollapse = document.querySelector(targetId);
                    if (targetCollapse && targetCollapse.classList.contains('show')) {
                        var icon = toggle.querySelector('.collapse-icon');
                        if (icon) {
                            icon.classList.add('rotated');
                        }
                    }
                }

                toggle.addEventListener('click', function() {
                    var icon = this.querySelector('.collapse-icon');
                    if (icon) {
                        icon.classList.toggle('rotated');
                    }
                });
            });

            // --- New JavaScript for Offcanvas Hiding ---
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    if (window.innerWidth >= 768) { // Bootstrap's 'md' breakpoint is 768px
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }
            // --- End New JavaScript ---
        });
    </script>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');


        /* Adjust navbar width to match sidebar - desktop only */
        @media (min-width: 768px) {
            .modern-navbar {
                left: 280px;
                right: 0;
                width: calc(100% - 280px);
            }
        }

        /* Hide hamburger button by default on larger screens */
        .hamburger-btn {
            display: none !important;
        }
        
        /* Ensure sidebar is hidden at 768px and below */
        @media (max-width: 768px) {
            .modern-sidebar {
                display: none !important;
            }
        }
        
        /* Ensure hamburger button container is hidden on larger screens */
        .d-lg-none {
            display: none !important;
        }

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
            overflow-y: auto;
            z-index: 1000;
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

        .disabled-link {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .disabled-link .nav-icon-img.disabled {
            opacity: 0.5;
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
            position: relative;
            z-index: 1;
        }

        .mobile-sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

    </style>
</x-app-layout>