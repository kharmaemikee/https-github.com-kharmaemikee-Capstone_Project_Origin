<x-app-layout>
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

        {{-- Mobile Offcanvas Toggle Button --}}
        <div class="mobile-toggle d-md-none">
            <button class="mobile-toggle-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                <i class="fas fa-bars"></i>
            </button>
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
        <div class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Resort: {{ $resort->resort_name }}</h2>
            </div>

            <div class="card p-4 shadow-sm">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Form for editing basic resort information --}}
                <form action="{{ route('resort.owner.update', $resort->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Use PUT or PATCH for updates --}}

                    {{-- Resort Name --}}
                    <div class="mb-3">
                        <label for="resort_name" class="form-label">Resort Name</label>
                        <input type="text" class="form-control form-control-sm" id="resort_name" name="resort_name" value="{{ old('resort_name', $resort->resort_name) }}" required>
                        @error('resort_name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control form-control-sm" id="location" name="location" value="{{ old('location', $resort->location) }}" required>
                        @error('location')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    {{-- Contact Number --}}
                    <div class="mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
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

                    {{-- Facebook Page Link (UPDATED FIELD NAME) --}}
                    <div class="mb-3">
                        <label for="facebook_page_link" class="form-label">Facebook Page Link</label>
                        <input type="url" class="form-control form-control-sm" id="facebook_page_link" name="facebook_page_link" value="{{ old('facebook_page_link', $resort->facebook_page_link) }}" placeholder="e.g., https://www.facebook.com/yourresortpage">
                        @error('facebook_page_link')<div class="text-danger">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Provide the full URL to your resort's Facebook page.</small>
                    </div>

                    {{-- Facebook Messenger Link (KEEP THIS IN MIND FOR CONTROLLER/MODEL) --}}
                    <div class="mb-3">
                        <label for="facebook_messenger_link" class="form-label">Facebook Messenger Link (Optional)</label>
                        <input type="url" class="form-control form-control-sm" id="facebook_messenger_link" name="facebook_messenger_link" value="{{ old('facebook_messenger_link', $resort->facebook_messenger_link) }}" placeholder="e.g., https://m.me/yourresortpage">
                        @error('facebook_messenger_link')<div class="text-danger">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">Provide the full URL for direct messages on Facebook Messenger.</small>
                    </div>

                    {{-- Image Upload --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Resort Image</label>
                        <input type="file" class="form-control form-control-sm" id="image" name="image">
                        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
                        @if($resort->image_path)
                            <small class="form-text text-muted mt-2">Current image:</small><br>
                            <img src="{{ asset($resort->image_path) }}" class="img-thumbnail mt-2" style="max-width: 150px;" onerror="this.onerror=null;this.src='{{ asset('images/default_resort.png') }}';">
                        @else
                            <small class="form-text text-muted mt-2">No image uploaded. Please upload a new image.</small>
                            <img src="{{ asset('images/default_resort.png') }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);">Update</button>
                </form>

                <hr class="my-4"> {{-- Separator for clarity --}}

                {{-- Section for Resort Status Management --}}
                <h4>Resort Status</h4>
                <p class="text-muted mb-3">Current Status:
                    @php
                        $statusClass = '';
                        switch ($resort->status) {
                            case 'open':
                                $statusClass = 'custom-badge-open'; // Custom class for open (now green)
                                break;
                            case 'closed':
                                $statusClass = 'custom-badge-closed'; // Custom class for closed
                                break;
                            case 'rehab':
                                $statusClass = 'custom-badge-rehab'; // Custom class for rehab
                                break;
                            default:
                                $statusClass = 'text-bg-secondary';
                                break;
                        }
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ ucfirst($resort->status ?? 'N/A') }}</span>
                </p>

                <div class="d-flex gap-2 mb-3">
                    {{-- Open Button --}}
                    <form id="status-open-form" action="{{ route('resort.owner.update_status', $resort->id) }}" method="POST" class="status-form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="open">
                        <button type="submit" class="btn custom-btn-open" {{ ($resort->status ?? '') === 'open' ? 'disabled' : '' }}>Open</button>
                    </form>

                    {{-- Close Button (now triggers modal) --}}
                    <button type="button" class="btn custom-btn-close" {{ ($resort->status ?? '') === 'closed' ? 'disabled' : '' }} data-bs-toggle="modal" data-bs-target="#closeConfirmationModal">Close</button>

                    {{-- Rehab Button (now triggers modal conditionally) --}}
                    <button type="button" class="btn custom-btn-rehab" id="rehab-button" {{ ($resort->status ?? '') === 'rehab' ? 'disabled' : '' }} data-current-status="{{ $resort->status ?? '' }}">Rehab</button>
                </div>

                {{-- NEW: Rehab Reason Input in its own form --}}
                <form id="status-rehab-form" action="{{ route('resort.owner.update_status', $resort->id) }}" method="POST" style="display: {{ ($resort->status ?? '') === 'rehab' ? 'block' : 'none' }};">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rehab">
                    <div class="mb-3">
                        <label for="rehab_reason" class="form-label">Reason for Rehab</label>
                        <textarea class="form-control form-control-sm" id="rehab_reason" name="rehab_reason" rows="3">{{ old('rehab_reason', $resort->rehab_reason) }}</textarea>
                        @error('rehab_reason')<div class="text-danger">{{ $message }}</div>@enderror
                        <small class="form-text text-muted">This reason will be displayed on the public page when the resort is under rehab.</small>
                        <button type="submit" class="btn btn-primary btn-sm mt-2" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);">Update Rehab Status & Reason</button>
                    </div>
                </form>

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

        /* Simple Sidebar Styling */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: #2c3e50;
            border-right: 1px solid #34495e;
            position: relative;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #34495e;
            background: #34495e;
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

        /* Mobile Toggle Button */
        .mobile-toggle {
            background: linear-gradient(135deg,rgb(35, 46, 26) 0%, #16213e 50%, #0f3460 100%);
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

        /* Responsive Design */
        @media (max-width: 576px) {
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }
    </style>
</x-app-layout>