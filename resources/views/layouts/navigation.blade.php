<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
    <div class="container-fluid d-flex align-items-center" style="padding: 0px 15px; height: 50px;">
        {{-- Back arrow --}}
        {{-- Welcome text --}}
        <div class="d-flex align-items-center">
            <a class="nav-link d-inline-block {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <h5 class="m-0 welcome-text" style="padding-left: 5px !important; font-size: 1.1rem;">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            Welcome Admin
                        @elseif(Auth::user()->role === 'resort_owner')
                        Welcome {{ Auth::user()->username }}
                        @elseif(Auth::user()->role === 'boat_owner')
                        Welcome {{ Auth::user()->username }}
                        @elseif(Auth::user()->role === 'tourist')
                        Welcome {{ Auth::user()->username }} to Subic Beach
                        @else
                            Welcome to our resorts
                        @endif
                    @else
                        Welcome to our resorts
                    @endauth
                </h4>
            </a>
        </div>

        {{-- User Menu for Mobile --}}
        <div class="d-md-none ms-auto mobile-nav-container"> 
            
            <div class="dropdown d-inline-block">
                @auth
                    @if(Auth::user()->owner_image_path)
                        {{-- Show image for owners (approved only) or tourist (no approval needed) --}}
                        <button class="btn btn-light border-0" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 5px;">
                            <img src="{{ asset(Auth::user()->owner_image_path) }}" 
                                 alt="Owner Image" 
                                 class="rounded-circle owner-image" 
                                 style="width: 32px; height: 32px; object-fit: cover; border: 2px solid #007bff;"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="rounded-circle owner-image-fallback" style="width: 32px; height: 32px; display: none;">
                                <i class="fas fa-user"></i>
                            </div>
                        </button>
                    @else
                        {{-- Show default icon for other users or unapproved images --}}
                        <button class="btn btn-light border-0" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 5px;">
                            <div class="rounded-circle owner-image-fallback" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 2px solid #007bff; color: #007bff;">
                                <i class="fas fa-user"></i>
                            </div>
                        </button>
                    @endif
                @else
                    <button class="btn btn-light border-0" type="button" id="mobileMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 5px;">
                        <div class="rounded-circle owner-image-fallback" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 2px solid #007bff; color: #007bff;">
                            <i class="fas fa-user"></i>
                        </div>
                    </button>
                @endauth
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileMenuButton">
                    <li></li>
                        <h6 class="dropdown-header">
                            @auth
                                {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}
                            @else
                                Guest
                            @endauth
                        </h6>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @auth
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Log Out</button>
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        {{-- User Menu for Desktop --}}
        <div class="d-none d-md-block ms-auto desktop-nav-container">
            <div class="dropdown d-inline-block">
                @auth
                @if(Auth::user()->owner_image_path)
                        {{-- Show image only for owners (approved only) or tourist (no approval needed) --}}
                        <a href="#" class="text-decoration-none d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 5px;">
                        <span class="me-2 text-primary">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                        <img src="{{ asset(Auth::user()->owner_image_path) }}" 
                             alt="Owner Image" 
                             class="rounded-circle owner-image" 
                             style="width: 28px; height: 28px; object-fit: cover; border: 1px solid #007bff;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="rounded-circle owner-image-fallback" style="width: 28px; height: 28px; display: none;">
                            <i class="fas fa-user"></i>
                        </div>
                    </a>
                @else
                        {{-- Show default icon for other users or unapproved images --}}
                        <a href="#" class="text-decoration-none d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 5px;">
                            <span class="me-2 text-primary">{{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}</span>
                            <div class="rounded-circle owner-image-fallback" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 1px solid #007bff; color: #007bff;">
                                <i class="fas fa-user"></i>
                            </div>
                    </a>
                @endif
            @else
                    <a href="#" class="text-decoration-none d-flex align-items-center" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 8px 5px;">
                        <span class="me-2 text-primary">Guest</span>
                        <div class="rounded-circle owner-image-fallback" style="width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 1px solid #007bff; color: #007bff;">
                            <i class="fas fa-user"></i>
                        </div>
                    </a>
            @endauth
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                @auth
                    @if(in_array(Auth::user()->role, ['resort_owner', 'boat_owner', 'tourist']))
                        <li>
                            <h6 class="dropdown-header text-primary">
                                Hi {{ trim(Auth::user()->first_name.' '.(Auth::user()->middle_name ? Auth::user()->middle_name.' ' : '').Auth::user()->last_name) }}!
                            </h6>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">Log Out</button>
                        </form>
                    </li>
                @else
                    <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    body {
        /* Add padding-top to the body to prevent content from being hidden behind the fixed navbar */
        padding-top: 50px; /* Mobile devices (phones, small tablets) - up to 767px */
    }

    /* Tablet devices (portrait/landscape) - 768px to 991.98px */
    @media (min-width: 768px) and (max-width: 991.98px) {
        body { padding-top: 50px; }
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 40px !important;
            margin-top: 10px !important;
        }
        #userDropdown { height: 50px; display: flex; align-items: center; margin-top: -30px !important; }
    }

    /* Medium desktops and larger tablets - 992px to 1199.98px */
    @media (min-width: 992px) and (max-width: 1199.98px) {
        body { padding-top: 50px; }
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 35px !important;
            margin-top: 30px !important;
        }
        #userDropdown { height: 50px; display: flex; align-items: center; }
    }

    /* Large desktops - 1200px to 1399.98px */
    @media (min-width: 1200px) and (max-width: 1399.98px) {
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 35px !important;
            margin-top: 30px !important;
        }
    }

   

    /* Extra large desktops - 1400px and above */
    @media (min-width: 1400px) {
        .navbar h5, .navbar .nav-link h5 {
            padding-bottom: 35px !important;
            margin-top: 30px !important;
        }
    }

    .fa-ellipsis-v {
        font-size: 20px;
        color: #6c757d;
    }

    .fa-arrow-left {
        font-size: 24px;
        color: #007bff;
    }

    /* Removed conflicting media query - now handled by unified system */

    /* UNIFIED VERTICAL ALIGNMENT SYSTEM - Consistent across all screen sizes */
    
    /* Base alignment for all elements */
    .welcome-text {
        padding-top: 0px !important;
        padding-bottom: 0px !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
        line-height: 1.2 !important;
    }
    
    .mobile-nav-container,
    .desktop-nav-container {
        padding-top: 0px !important;
        padding-bottom: 0px !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }

    @media (max-width: 320px) {
        /* Extra small phones - 320px and below */
        .welcome-text { font-size: 4.5vw !important; }
        
        /* Notification icon adjustments for 320px screens */
        .notification-dropdown button {
            padding: 6px 8px !important;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }
        
        .notification-dropdown .fas.fa-bell {
            font-size: 15px !important;
        }
        
        /* Adjust notification badge for smaller screens */
        .notification-dropdown .badge {
            font-size: 0.6rem !important;
            padding: 1px 4px !important;
            min-width: 14px !important;
            height: 14px !important;
            line-height: 11px !important;
        }
    }

    @media (min-width: 321px) and (max-width: 575px) {
        .welcome-text { font-size: 4vw !important; }
    }

    @media (min-width: 576px) and (max-width: 642px) {
        .welcome-text { font-size: 3.7vw !important; }
    }

    @media (min-width: 643px) and (max-width: 767px) {
        .welcome-text { font-size: 1.2rem !important; }
        .notification-dropdown button { padding: 5px 7px !important; }
    }

    @media (min-width: 768px) {
        .welcome-text { font-size: 1.1rem !important; }
        body { padding-top: 50px; }
    }


    /* Owner image styles */
    .owner-image {
        transition: transform 0.2s ease-in-out;
    }

    .owner-image:hover {
        transform: scale(1.05);
    }

    /* Fallback for broken images */
    .owner-image-fallback {
        background-color: #f8f9fa;
        border: 2px solid #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #007bff;
        font-weight: bold;
    }

    /* Force navbar to be 50px height with consistent padding - applies to ALL screen sizes */
    .navbar {
        min-height: 50px !important;
        height: 50px !important;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }

    .navbar .container-fluid {
        min-height: 50px !important;
        height: 50px !important;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }

    /* Removed universal rule - now handled by unified system */

    /* Notification dropdown styles */
    .notification-dropdown {
        border: 1px solid #dee2e6;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .notification-dropdown .dropdown-header {
        background-color:rgb(248, 250, 248);
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
        color: #495057;
    }

    .notification-dropdown .border-bottom:last-child {
        border-bottom: none !important;
    }

    .notification-dropdown .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .notification-dropdown .badge {
        font-size: 0.7rem;
    }

    /* Let Bootstrap handle all responsive behavior */

    /* Let Bootstrap handle vertical alignment */

    /* Let Bootstrap handle responsive display */

    /* Let Bootstrap handle spacing and positioning */

    /* Let Bootstrap handle navbar layout */

    /* Let Bootstrap handle responsive display - don't override */

    /* Let Bootstrap handle positioning */

    /* Let Bootstrap handle responsive behavior */

    /* Let Bootstrap handle margins */

    /* Let Bootstrap handle button sizing */

    /* Base notification icon styling - responsive across all screens */
    .notification-dropdown button {
        transition: all 0.2s ease;
        /* Default responsive padding that works on all screens */
        padding: 4px 6px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    
    .notification-dropdown button:hover {
        background-color: rgba(0, 0, 0, 0.05) !important;
        transform: scale(1.05);
    }
    
    .notification-dropdown button:focus {
        box-shadow: none !important;
    }
    
    /* Base notification badge styling - responsive across all screens */
    .notification-dropdown .badge {
        z-index: 10;
        border: 1px solid white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        /* Default responsive sizing */
        font-size: 0.65rem;
        padding: 2px 5px;
        min-width: 16px;
        height: 16px;
        line-height: 12px;
    }
    
    /* Base bell icon styling - responsive across all screens */
    .notification-dropdown .fas.fa-bell {
        font-size: 16px;
    }
    
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load notifications when dropdown is opened
    const mobileNotificationButton = document.getElementById('mobileNotificationButton');
    const desktopNotificationButton = document.getElementById('desktopNotificationButton');
    
    function loadNotifications(contentId) {
        const notificationContent = document.getElementById(contentId);
        if (!notificationContent) return;
        
        // Show loading state
        notificationContent.innerHTML = `
            <div class="text-center p-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0 text-muted">Loading notifications...</p>
            </div>
        `;
        
        // Fetch notifications via AJAX
        fetch('/tourist/notifications/ajax', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Notifications data:', data); // Debug log
            console.log('Data success:', data.success);
            console.log('Notifications array:', data.notifications);
            console.log('Notifications length:', data.notifications ? data.notifications.length : 'notifications is null/undefined');
            
            if (data.success && data.notifications && data.notifications.length > 0) {
                let html = '';
                data.notifications.forEach(notification => {
                    const timeAgo = new Date(notification.created_at).toLocaleDateString();
                    
                    html += `
                        <div class="p-3 border-bottom">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <h6 class="mb-1 fw-bold">${notification.message}</h6>
                                <small class="text-nowrap text-muted">${timeAgo}</small>
                            </div>
                            ${notification.booking ? `
                                <p class="mb-1 text-sm">Booking for: ${notification.booking.room_name || 'N/A Room'} at ${notification.booking.name_of_resort}</p>
                                <p class="mb-2">Status: <span class="badge ${getStatusClass(notification.booking.status)}">${getStatusText(notification.booking.status)}</span></p>
                            ` : ''}
                            <div class="d-flex justify-content-end align-items-center mt-2">
                                ${!notification.is_read ? `
                                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="markAsRead(${notification.id}, '${contentId}')">Mark as Read</button>
                                ` : ''}
                                <button class="btn btn-danger btn-sm" onclick="deleteNotification(${notification.id}, '${contentId}')">
                                    Delete <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                notificationContent.innerHTML = html;
            } else {
                notificationContent.innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-bell-slash text-muted" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0 text-muted">You have no new notifications.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            notificationContent.innerHTML = `
                <div class="text-center p-3">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <p class="mt-2 mb-0 text-muted">Error loading notifications.</p>
                    <small class="text-muted">Please try again later.</small>
                </div>
            `;
        });
    }
    
    function getStatusClass(status) {
        switch(status) {
            case 'approved': return 'bg-success';
            case 'rejected': return 'bg-danger';
            case 'cancelled': return 'bg-danger';
            case 'completed': return 'bg-primary';
            default: return 'bg-warning';
        }
    }
    
    function getStatusText(status) {
        switch(status) {
            case 'approved': return 'Approved!';
            case 'rejected': return 'Rejected';
            case 'cancelled': return 'Cancelled';
            case 'completed': return 'Completed';
            default: return status.charAt(0).toUpperCase() + status.slice(1);
        }
    }
    
    // Global functions for notification actions
    window.markAsRead = function(notificationId, contentId) {
        fetch(`/tourist/notifications/${notificationId}/mark-as-read`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications(contentId); // Reload notifications
                // Update notification count
                location.reload(); // Simple way to update the count badge
            }
        })
        .catch(error => console.error('Error marking as read:', error));
    };
    
    window.deleteNotification = function(notificationId, contentId) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`/tourist/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications(contentId); // Reload notifications
                    // Update notification count
                    location.reload(); // Simple way to update the count badge
                }
            })
            .catch(error => console.error('Error deleting notification:', error));
        }
    };
    
    // Add event listeners for dropdown show events
    if (mobileNotificationButton) {
        mobileNotificationButton.addEventListener('click', function() {
            loadNotifications('mobileNotificationContent');
        });
    }
    if (desktopNotificationButton) {
        desktopNotificationButton.addEventListener('click', function() {
            loadNotifications('desktopNotificationContent');
        });
    }
});
</script>