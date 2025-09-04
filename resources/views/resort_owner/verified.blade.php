<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Resort Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                {{ Auth::user()->username }}
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    @if(auth()->user()->canAccessMainFeatures())
                        <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                            <img src="{{ asset('images/information.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Management
                        </a>
                    @else
                        <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="right" 
                              title="Upload your permits first to unlock this feature">
                            <img src="{{ asset('images/information.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                            Resort Information
                            <span class="badge bg-warning ms-2">Locked</span>
                        </span>
                    @endif
                </li>
                <li class="nav-item mt-2">
                    {{-- Active link for Account Management --}}
                    <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Account Management
                    </a>
                </li>
                {{-- Notification with expandable Documentation (Desktop) --}}
                <li class="nav-item mt-2 position-relative">
                    <a class="nav-link text-white rounded p-2 d-flex justify-content-between align-items-center {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'active-parent' : '' }}"
                       data-bs-toggle="collapse" href="#notificationCollapseDesktop" role="button"
                       aria-expanded="{{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'true' : 'false' }}" aria-controls="notificationCollapseDesktop">
                        <span class="flex-grow-1 d-flex align-items-center justify-content-start">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notification
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-danger ms-2" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                            @endif
                        </span>
                        <span class="collapse-icon">
                            <img src="{{ asset('images/down-chevron.png') }}" alt="Toggle Icon" style="width: 16px; height: 16px;">
                        </span>
                    </a>
                    <div class="collapse {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'show' : '' }}" id="notificationCollapseDesktop">
                        <ul class="nav flex-column ps-3 mt-2">
                            <li class="nav-item">
                                <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                                    Notifications List
                                </a>
                            </li>
                            <li class="nav-item mt-1">
                                <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                                    Documentation
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        {{-- Mobile Offcanvas Toggle Button --}}
        <div class="d-md-none bg-light border-bottom p-2">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                &#9776;
            </button>
        </div>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
            <div class="offcanvas-header">
                {{-- Icon added here for Resort Owner in mobile sidebar using <img> --}}
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    {{ Auth::user()->username }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                <img src="{{ asset('images/information.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Resort Management
                            </a>
                        @else
                            <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                <img src="{{ asset('images/information.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                                Resort Information
                                <span class="badge bg-warning ms-2">Locked</span>
                            </span>
                        @endif
                    </li>
                    <li class="nav-item mt-2">
                        {{-- Active link for Account Management --}}
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                            <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Account Management
                        </a>
                    </li>
                    {{-- Notification with expandable Documentation (Mobile) --}}
                    <li class="nav-item mt-2 position-relative">
                        <a class="nav-link text-white rounded p-2 d-flex justify-content-between align-items-center {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'active-parent' : '' }}"
                           data-bs-toggle="collapse" href="#notificationCollapseMobile" role="button"
                           aria-expanded="{{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'true' : 'false' }}" aria-controls="notificationCollapseMobile">
                            <span class="flex-grow-1 d-flex align-items-center justify-content-start">
                                <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 16px;">
                                Notification
                                @if(isset($unreadCount) && $unreadCount > 0)
                                    <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                                @endif
                            </span>
                            <span class="collapse-icon">
                                <img src="{{ asset('images/down-chevron.png') }}" alt="Toggle Icon" style="width: 16px; height: 16px;">
                            </span>
                        </a>
                        <div class="collapse {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'show' : '' }}" id="notificationCollapseMobile">
                            <ul class="nav flex-column ps-3 mt-2">
                                <li class="nav-item">
                                    <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                                        Notifications List
                                    </a>
                                </li>
                                <li class="nav-item mt-1">
                                    <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                                        Documentation
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1 p-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">
                                    <i class="fas fa-user-check me-2"></i>
                                    Account Management - Permit Submission
                                </h4>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Current Status</h5>
                                        <div class="status-cards">
                                            <div class="card mb-3 {{ auth()->user()->bir_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">BIR Permit</span>
                                                        @if(auth()->user()->bir_approved)
                                                            <span class="badge bg-success">✓ Approved</span>
                                                        @elseif(auth()->user()->bir_permit_path)
                                                            <span class="badge bg-warning">Pending Review</span>
                                                        @else
                                                            <span class="badge bg-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->dti_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">DTI Permit</span>
                                                        @if(auth()->user()->dti_approved)
                                                            <span class="badge bg-success">✓ Approved</span>
                                                        @elseif(auth()->user()->dti_permit_path)
                                                            <span class="badge bg-warning">Pending Review</span>
                                                        @else
                                                            <span class="badge bg-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->business_permit_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Business Permit</span>
                                                        @if(auth()->user()->business_permit_approved)
                                                            <span class="badge bg-success">✓ Approved</span>
                                                        @elseif(auth()->user()->business_permit_path)
                                                            <span class="badge bg-warning">Pending Review</span>
                                                        @else
                                                            <span class="badge bg-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->owner_pic_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Owner Picture</span>
                                                        @if(auth()->user()->owner_pic_approved)
                                                            <span class="badge bg-success">✓ Approved</span>
                                                        @elseif(auth()->user()->owner_image_path)
                                                            <span class="badge bg-warning">Pending Review</span>
                                                        @else
                                                            <span class="badge bg-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->tourism_registration_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Tourism Registration</span>
                                                        @if(auth()->user()->tourism_registration_approved)
                                                            <span class="badge bg-success">✓ Approved</span>
                                                        @elseif(auth()->user()->tourism_registration_path)
                                                            <span class="badge bg-warning">Pending Review</span>
                                                        @else
                                                            <span class="badge bg-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                                                        @if(auth()->user()->is_approved)
                                    <div class="alert alert-success">
                                        <h6 class="mb-0">🎉 Congratulations! Your account has been fully approved.</h6>
                                    </div>
                                @elseif(!auth()->user()->bir_permit_path && !auth()->user()->dti_permit_path && !auth()->user()->business_permit_path && !auth()->user()->owner_image_path && !auth()->user()->tourism_registration_path)
                                    <div class="alert alert-info">
                                        <h6 class="mb-0">👋 Welcome! You can explore your dashboard and access basic features.</h6>
                                        <small class="mb-0">To unlock Resort Information, please upload your permits (BIR, DTI, Business Permit, Owner Picture, and Tourism Registration).</small>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <h6 class="mb-0">⏳ Your permits are under review.</h6>
                                        <small class="mb-0">Please wait for admin approval. You'll be able to access Resort Information once all permits are approved.</small>
                                    </div>
                                @endif
                                    </div>

                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Upload Permits</h5>
                                        <form action="{{ route('resort.owner.upload-permits') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="mb-3">
                                                <label for="bir_permit" class="form-label">BIR Permit <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control @error('bir_permit') is-invalid @enderror" 
                                                       id="bir_permit" name="bir_permit" accept="image/*,.pdf" 
                                                       {{ auth()->user()->bir_approved ? 'disabled' : '' }}>
                                                @error('bir_permit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload BIR permit (JPG, PNG, or PDF)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="dti_permit" class="form-label">DTI Permit <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control @error('dti_permit') is-invalid @enderror" 
                                                       id="dti_permit" name="dti_permit" accept="image/*,.pdf"
                                                       {{ auth()->user()->dti_approved ? 'disabled' : '' }}>
                                                @error('dti_permit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload DTI permit (JPG, PNG, or PDF)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="business_permit" class="form-label">Business Permit <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control @error('business_permit') is-invalid @enderror" 
                                                       id="business_permit" name="business_permit" accept="image/*,.pdf"
                                                       {{ auth()->user()->business_permit_approved ? 'disabled' : '' }}>
                                                @error('business_permit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload business permit (JPG, PNG, or PDF)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="owner_image" class="form-label">Owner Picture <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control @error('owner_image') is-invalid @enderror" 
                                                       id="owner_image" name="owner_image" accept="image/*"
                                                       {{ auth()->user()->owner_pic_approved ? 'disabled' : '' }}>
                                                @error('owner_image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload your picture (JPG or PNG)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tourism_registration" class="form-label">Tourism Registration <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control @error('tourism_registration') is-invalid @enderror" 
                                                       id="tourism_registration" name="tourism_registration" accept="image/*,.pdf"
                                                       {{ auth()->user()->tourism_registration_approved ? 'disabled' : '' }}>
                                                @error('tourism_registration')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload Tourism Registration (JPG, PNG, or PDF)</small>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100" 
                                                    {{ auth()->user()->is_approved ? 'disabled' : '' }}>
                                                <i class="fas fa-upload me-2"></i>
                                                {{ auth()->user()->is_approved ? 'All Permits Approved' : 'Upload Permits' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color:rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Style for the rotated icon */
        .collapse-icon img {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        .status-cards .card {
            transition: all 0.3s ease;
        }

        .status-cards .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 0.6;
        }

        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.5) !important;
        }
    </style>

    {{-- Custom JavaScript to handle arrow rotation and mobile sidebar behavior --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

            collapseToggles.forEach(function(toggle) {
                // Initialize arrow state based on collapse 'show' class
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

                // Add click listener for arrow rotation
                toggle.addEventListener('click', function() {
                    var icon = this.querySelector('.collapse-icon');
                    if (icon) {
                        icon.classList.toggle('rotated');
                    }
                });
            });

            // --- JavaScript for Offcanvas Hiding on Desktop ---
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
            // --- End JavaScript for Offcanvas Hiding ---
        });
    </script>
</x-app-layout>