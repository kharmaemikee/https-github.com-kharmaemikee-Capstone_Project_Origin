<x-app-layout>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
                        @if(auth()->user()->canAccessMainFeatures())
                                <a href="{{ route('resort.owner.information') }}" class="nav-link {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                    <div class="nav-icon">
                                        <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                                    </div>
                                    <span class="nav-text">Resort Management</span>
                            </a>
                        @else
                                <span class="nav-link disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                    <div class="nav-icon">
                                        <img src="{{ asset('images/information.png') }}" alt="Resort Management Icon" class="nav-icon-img disabled">
                                    </div>
                                    <span class="nav-text">Resort Management</span>
                                    <span class="nav-badge">Locked</span>
                            </span>
                        @endif
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
                                    <span class="nav-badge notification-badge" id="unreadBadgeMobile">{{ $unreadCount }}</span>
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
        </div>

        {{-- Main Content Area --}}
        <div class="main-content flex-grow-1">
            <div class="container-fluid flex-grow-1 p-0">
            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-title-section">
                    <h1 class="page-title">
                        <i class="fas fa-edit me-2"></i>
                        Edit Resort: {{ $resort->resort_name }}
                    </h1>
                    <p class="page-subtitle">Update your resort information and settings</p>
                </div>
            </div>

            {{-- Form Container --}}
            <div class="form-container">
                <div class="form-card">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form for editing basic resort information --}}
                    <div class="modern-form">
                        <div class="form-section-header">
                            <h3 class="form-section-title">
                                <i class="fas fa-edit me-2"></i>
                                Resort Information
                            </h3>
                            <p class="form-section-subtitle">Update your resort's basic information and details</p>
                        </div>

                        <form action="{{ route('resort.owner.update', $resort->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Image Upload Section - Moved to Top --}}
                            <div class="mb-4">
                                <label for="image" class="form-label">
                                    <i class="fas fa-image me-1"></i>
                                    Resort Image
                                </label>
                                <input type="file" class="form-control form-control-sm" id="image" name="image" accept="image/*">
                                @error('image')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            {{-- Current Image Display --}}
                            <div class="mb-4">
                                <label class="form-label">Current Image</label>
                                <div class="current-image-container">
                                    @if($resort->image_path)
                                        <img src="{{ asset($resort->image_path) }}" class="current-image" data-fallback="{{ asset('images/default_resort.png') }}">
                                        <small class="form-text text-muted">Current resort image</small>
                                    @else
                                        <img src="{{ asset('images/default_resort.png') }}" class="current-image">
                                        <small class="form-text text-muted">No image uploaded. Please upload a new image.</small>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                {{-- Resort Name --}}
                                <div class="col-md-6 mb-4">
                                    <label for="resort_name" class="form-label">
                                        <i class="fas fa-building me-1"></i>
                                        Resort Name
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="resort_name" name="resort_name" value="{{ old('resort_name', $resort->resort_name) }}" required>
                                    @error('resort_name')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>

                                {{-- Location --}}
                                <div class="col-md-6 mb-4">
                                    <label for="location" class="form-label">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Location
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="location" name="location" value="{{ old('location', $resort->location) }}" required>
                                    @error('location')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                {{-- Contact Number --}}
                                <div class="col-md-6 mb-4">
                                    <label for="contact_number" class="form-label">
                                        <i class="fas fa-phone me-1"></i>
                                        Contact Number
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-sm" 
                                           id="contact_number" 
                                           name="contact_number" 
                                           value="{{ old('contact_number', $resort->contact_number) }}"
                                           placeholder="e.g., 09123456789"
                                           pattern="[0-9]{11}" 
                                           maxlength="11" 
                                           minlength="11"
                                           title="Please enter exactly 11 digits for the contact number." 
                                           inputmode="numeric"
                                           oninput="validateContactNumber(this)">
                                    <div id="contact_number_error" class="text-danger mt-1" style="display: none;">
                                        The number is not enough. Please enter exactly 11 digits.
                                    </div>
                                    @error('contact_number')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>

                                {{-- Empty column for spacing --}}
                                <div class="col-md-6 mb-4">
                                </div>
                            </div>

                            <div class="row">
                                {{-- Facebook Page Link --}}
                                <div class="col-md-6 mb-4">
                                    <label for="facebook_page_link" class="form-label">
                                        <i class="fab fa-facebook me-1"></i>
                                        Facebook Page Link
                                    </label>
                                    <input type="url" class="form-control form-control-sm" id="facebook_page_link" name="facebook_page_link" value="{{ old('facebook_page_link', $resort->facebook_page_link) }}" placeholder="e.g., https://www.facebook.com/yourresortpage">
                                    @error('facebook_page_link')<div class="text-danger">{{ $message }}</div>@enderror
                                    <small class="form-text text-muted">Provide the full URL to your resort's Facebook page.</small>
                                </div>

                                {{-- Facebook Messenger Link --}}
                                <div class="col-md-6 mb-4">
                                    <label for="facebook_messenger_link" class="form-label">
                                        <i class="fab fa-facebook-messenger me-1"></i>
                                        Facebook Messenger Link (Optional)
                                    </label>
                                    <input type="url" class="form-control form-control-sm" id="facebook_messenger_link" name="facebook_messenger_link" value="{{ old('facebook_messenger_link', $resort->facebook_messenger_link) }}" placeholder="e.g., https://m.me/yourresortpage">
                                    @error('facebook_messenger_link')<div class="text-danger">{{ $message }}</div>@enderror
                                    <small class="form-text text-muted">Provide the full URL for direct messages on Facebook Messenger.</small>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>
                                    Update Resort Information
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Visual Separator --}}
                    <div class="section-divider">
                        <div class="divider-line"></div>
                        <div class="divider-text">OR</div>
                        <div class="divider-line"></div>
                    </div>

                    {{-- Section for Resort Status Management --}}
                    <div class="status-management-section">
                        <div class="form-section-header">
                            <h3 class="form-section-title">
                                <i class="fas fa-toggle-on me-2"></i>
                                Resort Status Management
                            </h3>
                            <p class="form-section-subtitle">Control your resort's availability and status</p>
                        </div>

                        <div class="status-display">
                            <div class="current-status">
                                <span class="status-label">Current Status:</span>
                                @php
                                    $statusClass = '';
                                    $statusIcon = '';
                                    switch ($resort->status) {
                                        case 'open':
                                            $statusClass = 'custom-badge-open';
                                            $statusIcon = 'fas fa-check-circle';
                                            break;
                                        case 'closed':
                                            $statusClass = 'custom-badge-closed';
                                            $statusIcon = 'fas fa-times-circle';
                                            break;
                                        case 'rehab':
                                            $statusClass = 'custom-badge-rehab';
                                            $statusIcon = 'fas fa-tools';
                                            break;
                                        default:
                                            $statusClass = 'text-bg-secondary';
                                            $statusIcon = 'fas fa-question-circle';
                                            break;
                                    }
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    <i class="{{ $statusIcon }} me-1"></i>
                                    {{ ucfirst($resort->status ?? 'N/A') }}
                                </span>
                            </div>
                        </div>

                        <div class="status-actions">
                            {{-- Open Button --}}
                            <form id="status-open-form" action="{{ route('resort.owner.update_status', $resort->id) }}" method="POST" class="status-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="open">
                                <button type="submit" class="btn custom-btn-open" {{ ($resort->status ?? '') === 'open' ? 'disabled' : '' }}>
                                    <i class="fas fa-check-circle me-1"></i>
                                    Open Resort
                                </button>
                            </form>

                            {{-- Close Button --}}
                            <button type="button" class="btn custom-btn-close" {{ ($resort->status ?? '') === 'closed' ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#closeConfirmationModal">
                                <i class="fas fa-times-circle me-1"></i>
                                Close Resort
                            </button>

                            {{-- Rehab Button --}}
                            <button type="button" class="btn custom-btn-rehab" id="rehab-button" {{ ($resort->status ?? '') === 'rehab' ? 'disabled' : '' }} data-current-status="{{ $resort->status ?? '' }}">
                                <i class="fas fa-tools me-1"></i>
                                Under Renovation
                            </button>
                        </div>

                        {{-- Rehab Reason Input --}}
                        <form id="status-rehab-form" action="{{ route('resort.owner.update_status', $resort->id) }}" method="POST" class="rehab-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rehab">
                            <div class="rehab-reason-section">
                                <label for="rehab_reason" class="form-label">
                                    <i class="fas fa-comment-alt me-1"></i>
                                    Reason for Renovation
                                </label>
                                <textarea class="form-control form-control-sm" id="rehab_reason" name="rehab_reason" rows="3" placeholder="Please provide a detailed reason for the renovation...">{{ old('rehab_reason', $resort->rehab_reason) }}</textarea>
                                @error('rehab_reason')<div class="text-danger">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">This reason will be displayed on the public page when the resort is under renovation.</small>
                                <div class="rehab-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        Update Renovation Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    {{-- Close Confirmation Modal --}}
    <div class="modal fade" id="closeConfirmationModal" tabindex="-1" aria-labelledby="closeConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeConfirmationModalLabel">Confirm Close</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this resort as **Closed**? This will make it unavailable for bookings.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <form id="closeStatusForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="closed">
                        <button type="submit" class="btn custom-btn-close-modal btn-sm">Confirm Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Rehab Confirmation Modal --}}
    <div class="modal fade" id="rehabConfirmationModal" tabindex="-1" aria-labelledby="rehabConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rehabConfirmationModalLabel">Confirm Rehab Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this resort as **Under Renovation (Rehab)**? You will need to provide a reason for the rehab.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn custom-btn-rehab-modal btn-sm" id="confirmRehabAndShowReason">Confirm Rehab</button>
                </div>
            </div>
        </div>
    </div>

    <style>

        /* Added for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated {
            transform: rotate(180deg);
        }

        /* Custom Styles for Status Badges */
        .custom-badge-open {
            background-color: #d4edda !important; /* Light Green */
            color: #155724 !important; /* Dark Green text */
            border: 1px solid #c3e6cb !important; /* Green border */
        }

        .custom-badge-closed {
            background-color: #f8d7da !important; /* Light Red */
            color: #dc3545 !important; /* Dark Red text */
            border: 1px solid #dc3545 !important; /* Dark Red border */
        }

        .custom-badge-rehab {
            background-color: #f8d7da !important; /* Light Red */
            color: #dc3545 !important; /* Dark Red text */
            border: 1px solid #dc3545 !important; /* Dark Red border */
        }

        /* Custom button styles - Made them slightly smaller */
        .custom-btn-open {
            background-color:rgb(20, 139, 48); /* Green */
            color: white;
            border-color: #28a745;
            transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
            padding: .25rem .75rem; /* Smaller padding */
            font-size: .875rem; /* Smaller font size */
        }

        .custom-btn-open:hover:not(:disabled) {
            background-color:rgb(42, 161, 68); /* Slightly darker green on hover */
            border-color: #1e7e34;
        }

        .custom-btn-close {
            background-color: #dc3545; /* Red */
            color: white;
            border-color: #dc3545;
            transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out, color 0.2s ease-in-out;
            padding: .25rem .75rem; /* Smaller padding */
            font-size: .875rem; /* Smaller font size */
        }

        .custom-btn-close:hover:not(:disabled) {
            background-color: #c82333; /* Slightly darker red on hover */
            border-color: #bd2130;
            color: white; /* Text remains white on hover */
        }
        /* Style for the "Confirm Close" button inside the modal */
        .custom-btn-close-modal {
            background-color: #dc3545; /* Red */
            color: white; /* Text is white by default */
            border-color: #dc3545;
            transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
            padding: .25rem .75rem; /* Smaller padding */
            font-size: .875rem; /* Smaller font size */
        }

        .custom-btn-close-modal:hover:not(:disabled) {
            background-color: #c82333; /* Slightly darker red on hover */
            border-color: #bd2130;
            color: white; /* Ensure text remains white on hover */
        }


        .custom-btn-rehab {
            background-color: #dc3545; /* Red */
            color: white; /* Text color is white */
            border-color: #dc3545;
            transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
            padding: .25rem .75rem; /* Smaller padding */
            font-size: .875rem; /* Smaller font size */
        }

        .custom-btn-rehab:hover:not(:disabled) {
            background-color: #c82333; /* Slightly darker red on hover */
            border-color: #bd2130;
        }
        /* Style for the "Confirm Rehab" button inside the modal */
        .custom-btn-rehab-modal {
            background-color: #dc3545; /* Red */
            color: white; /* Text color is white */
            border-color: #dc3545;
            transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
            padding: .25rem .75rem; /* Smaller padding */
            font-size: .875rem; /* Smaller font size */
        }

        .custom-btn-rehab-modal:hover:not(:disabled) {
            background-color: #c82333; /* Slightly darker red on hover */
            border-color: #bd2130;
        }
    </style>

    {{-- Custom JavaScript to handle arrow rotation, image error, and rehab reason visibility --}}
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
            // Sidebar collapse logic
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

            // --- JavaScript for Status Modals ---
            // Ensure resortId is safely embedded as a JavaScript number.
            const resortId = parseInt('{{ $resort->id }}');

            const rehabButton = document.getElementById('rehab-button');
            const rehabReasonContainer = document.getElementById('status-rehab-form');
            const rehabReasonInput = document.getElementById('rehab_reason');
            const confirmRehabAndShowReasonButton = document.getElementById('confirmRehabAndShowReason');

            // Set the form action for the Close modal
            const closeStatusForm = document.getElementById('closeStatusForm');
            if (closeStatusForm) {
                closeStatusForm.action = `/resorts/${resortId}/status`;
            }

            // Function to show/hide rehab reason container
            function toggleRehabReasonVisibility(forceShow = false) {
                const currentStatusBadge = document.querySelector('p.text-muted .badge');
                const isCurrentlyRehab = currentStatusBadge && currentStatusBadge.textContent.trim().toLowerCase() === 'rehab';

                if (forceShow || isCurrentlyRehab) {
                    rehabReasonContainer.style.display = 'block';
                    rehabReasonInput.setAttribute('required', 'required');
                    if (forceShow && !rehabReasonInput.value) { // Focus if forced show and input is empty
                        rehabReasonInput.focus();
                    }
                } else {
                    rehabReasonContainer.style.display = 'none';
                    rehabReasonInput.removeAttribute('required');
                    // Only clear the reason if it's not currently being edited for rehab status
                    if (!isCurrentlyRehab) {
                        rehabReasonInput.value = '';
                    }
                }
            }

            // Event listener for the Rehab button click
            if (rehabButton) {
                rehabButton.addEventListener('click', function(event) {
                    const currentStatusBadge = document.querySelector('p.text-muted .badge');
                    const isCurrentlyRehab = currentStatusBadge && currentStatusBadge.textContent.trim().toLowerCase() === 'rehab';

                    if (isCurrentlyRehab) {
                        // If already in rehab, just toggle visibility of reason input directly
                        rehabReasonContainer.style.display = (rehabReasonContainer.style.display === 'none' || rehabReasonContainer.style.display === '') ? 'block' : 'none';
                        rehabReasonInput.setAttribute('required', 'required');
                        if (rehabReasonContainer.style.display === 'block') {
                            rehabReasonInput.focus();
                        } else {
                            rehabReasonInput.removeAttribute('required');
                        }
                    } else {
                        // If not in rehab, show the confirmation modal
                        var rehabModal = new bootstrap.Modal(document.getElementById('rehabConfirmationModal'));
                        rehabModal.show();
                    }
                });
            }

            // Event listener for "Confirm Rehab" button inside the Rehab modal
            if (confirmRehabAndShowReasonButton) {
                confirmRehabAndShowReasonButton.addEventListener('click', function() {
                    var rehabModal = bootstrap.Modal.getInstance(document.getElementById('rehabConfirmationModal'));
                    if (rehabModal) {
                        rehabModal.hide(); // Hide the modal
                    }
                    toggleRehabReasonVisibility(true); // Force show rehab reason input
                });
            }

            // Add click listener to 'Open' and 'Close' buttons to hide rehab reason container if visible
            const statusForms = document.querySelectorAll('.status-form'); // Get all status forms
            statusForms.forEach(form => {
                const statusInput = form.querySelector('input[name="status"]');
                const submitButton = form.querySelector('button[type="submit"]');

                if (submitButton && statusInput && statusInput.value !== 'rehab') {
                    submitButton.addEventListener('click', function() {
                        if (rehabReasonContainer.style.display === 'block') {
                            toggleRehabReasonVisibility(false); // Hide and clear
                        }
                    });
                }
            });

            // Initialize visibility on page load
            toggleRehabReasonVisibility();
            
            // Set initial display state for rehab form
            const rehabForm = document.getElementById('status-rehab-form');
            if (rehabForm) {
                const currentStatus = '{{ $resort->status ?? "" }}';
                if (currentStatus === 'rehab') {
                    rehabForm.style.display = 'block';
                } else {
                    rehabForm.style.display = 'none';
                }
            }

            // Handle image fallback
            const currentImage = document.querySelector('.current-image[data-fallback]');
            if (currentImage) {
                currentImage.addEventListener('error', function() {
                    this.src = this.getAttribute('data-fallback');
                });
            }

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
            gap: 0.75rem;
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
            background: transparent;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
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

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 1.5rem;
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
            margin-bottom: 1.5rem;
            border-left: 4px solid #007bff;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 0;
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

        /* Form Section Headers */
        .form-section-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .form-section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-section-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Form Actions */
        .form-actions {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid #f8f9fa;
            text-align: center;
        }

        .form-actions .btn {
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .form-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }

        /* Current Image Display */
        .current-image-container {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
        }

        .current-image {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        /* Section Divider */
        .section-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            padding: 0 2rem;
        }

        .divider-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(to right, transparent, #dee2e6, transparent);
        }

        .divider-text {
            padding: 0 1.5rem;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.9rem;
            background: white;
        }

        /* Status Management Section */
        .status-management-section {
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 12px;
            margin-top: 1rem;
        }

        .status-display {
            margin-bottom: 2rem;
            text-align: center;
        }

        .current-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .status-label {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
        }

        .status-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .status-actions .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            min-width: 150px;
        }

        .status-actions .btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .status-actions .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Rehab Reason Section */
        .rehab-reason-section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 2px solid #e9ecef;
        }

        .rehab-actions {
            margin-top: 1rem;
            text-align: center;
        }

        .rehab-actions .btn {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
        }

        /* Rehab Form */
        .rehab-form {
            transition: all 0.3s ease;
        }

        /* Form Input Styling */
        .form-control {
            padding: 1rem 1.25rem !important;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fff;
            min-height: 48px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background-color: #fff;
        }

        .form-control-sm {
            padding: 1rem 1.25rem !important;
            font-size: 1rem !important;
            border-radius: 8px !important;
            min-height: 48px !important;
        }

        /* Override Bootstrap's form-control-sm */
        .modern-form .form-control-sm {
            padding: 1rem 1.25rem !important;
            font-size: 1rem !important;
            min-height: 48px !important;
        }

        .modern-form input[type="text"],
        .modern-form input[type="url"],
        .modern-form input[type="file"],
        .modern-form textarea {
            padding: 1rem 1.25rem !important;
            min-height: 48px !important;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .text-danger {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 55vw !important;
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

        /* Responsive Design */
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
            }
            
            .modern-navbar {
                left: 0;
                width: 100%;
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
            
            .form-control {
                padding: 0.875rem 1rem !important;
                font-size: 0.95rem;
                min-height: 44px !important;
            }
            
            .form-control-sm {
                padding: 0.875rem 1rem !important;
                font-size: 0.95rem !important;
                min-height: 44px !important;
            }
            
            .modern-form input[type="text"],
            .modern-form input[type="url"],
            .modern-form input[type="file"],
            .modern-form textarea {
                padding: 0.875rem 1rem !important;
                min-height: 44px !important;
            }

            /* Mobile-specific form styling */
            .form-section-title {
                font-size: 1.3rem;
            }

            .status-actions {
                flex-direction: column;
                align-items: center;
            }

            .status-actions .btn {
                width: 100%;
                max-width: 300px;
            }

            .current-status {
                flex-direction: column;
                gap: 0.5rem;
            }

            .section-divider {
                margin: 1.5rem 0;
                padding: 0 1rem;
            }

            .status-management-section {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0;
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
            
            .form-control {
                padding: 0.75rem 0.875rem !important;
                font-size: 0.9rem;
                min-height: 40px !important;
            }
            
            .form-control-sm {
                padding: 0.75rem 0.875rem !important;
                font-size: 0.9rem !important;
                min-height: 40px !important;
            }
            
            .modern-form input[type="text"],
            .modern-form input[type="url"],
            .modern-form input[type="file"],
            .modern-form textarea {
                padding: 0.75rem 0.875rem !important;
                min-height: 40px !important;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }
    </style>
</x-app-layout>