<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Boat Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Boat Menu
            </h4>
            <ul class="nav flex-column mt-3">
               
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    @if(auth()->user()->canAccessMainFeatures())
                        <a href="{{ route('boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Boat Management
                        </a>
                    @else
                        <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                              data-bs-toggle="tooltip" 
                              data-bs-placement="right" 
                              title="Upload your permits first to unlock this feature">
                            <img src="{{ asset('images/information.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                            Boat Management
                            <span class="badge bg-warning ms-2">Locked</span>
                        </span>
                    @endif
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Account Management
                    </a>
                </li>
                {{-- Notification (Desktop) --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                        <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Notifications
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger ms-2" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                        @endif
                    </a>
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
                {{-- Icon added here for Boat Owner in mobile sidebar using <img> --}}
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Boat Menu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                                <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Boat Management
                            </a>
                        @else
                            <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                <img src="{{ asset('images/information.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                                Boat Management
                                <span class="badge bg-warning ms-2">Locked</span>
                            </span>
                        @endif
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Account Management
                        </a>
                    </li>
                    {{-- Notification (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notifications
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <div class="container py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3>Boat Owner Notifications</h3>
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

                        @if ($boatOwnerNotifications->isEmpty())
                            <div class="alert alert-info">You have no notifications.</div>
                        @else
                            {{-- Mark All as Read Button --}}
                            @php
                                $unreadCount = $boatOwnerNotifications->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">{{ $unreadCount }} unread notification{{ $unreadCount > 1 ? 's' : '' }}</span>
                                    <form action="{{ route('boat.owner.notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-check-all me-1"></i>Mark All as Read
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <div class="list-group">
                                @foreach ($boatOwnerNotifications as $notification)
                                    <div class="list-group-item list-group-item-action {{ $notification->is_read ? 'text-muted' : 'border-primary' }}" id="notification-{{ $notification->id }}" data-notification-id="{{ $notification->id }}">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <h5 class="mb-1">{{ $notification->message }}</h5>
                                            <small class="text-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if ($notification->type === 'permit_resubmit')
                                            @php
                                                $docMap = [
                                                    'BIR Permit' => 'bir_permit',
                                                    'DTI Permit' => 'dti_permit',
                                                    'Business Permit' => 'business_permit',
                                                    'Owner Image' => 'owner_image',
                                                ];
                                                $docKey = null;
                                                $docLabel = null;
                                                foreach ($docMap as $label => $key) {
                                                    if (str_contains($notification->message, $label)) { $docKey = $key; $docLabel = $label; break; }
                                                }
                                                $hasWaiting = isset($boatOwnerNotifications) && $boatOwnerNotifications->contains(function($n) use ($docLabel) {
                                                    return $n->type === 'permit_resubmit_waiting' && ($docLabel ? str_contains($n->message, $docLabel) : true);
                                                });
                                                $hasApproved = isset($boatOwnerNotifications) && $boatOwnerNotifications->contains(function($n) use ($docLabel) {
                                                    return $n->type === 'permit_resubmit_approved' && ($docLabel ? str_contains($n->message, $docLabel) : true);
                                                });
                                            @endphp
                                            @if (!$hasWaiting && !$hasApproved)
                                                <form action="{{ route('boat.owner.upload-permits') }}" method="POST" enctype="multipart/form-data" class="mt-2 permit-resubmit-form">
                                                    @csrf
                                                    <div class="input-group input-group-sm align-items-center">
                                                        <input type="file" name="{{ $docKey ?? 'owner_image' }}" class="form-control" required>
                                                        <button type="submit" class="btn btn-primary ms-2 upload-again-btn">Upload again</button>
                                                        <span class="ms-3 small text-muted thanks-msg" style="display:none;">Thank you for your patience.</span>
                                                    </div>
                                                </form>
                                            @endif
                                        @endif

                                        @if ($notification->booking)
                                            <p class="mb-1">Booking ID: <strong>{{ $notification->booking->id }}</strong></p>
                                            @if ($notification->booking->resort)
                                                <p class="mb-1">Resort: <strong>{{ $notification->booking->resort->resort_name }}</strong></p>
                                            @endif
                                            @if ($notification->booking->user)
                                                <p class="mb-1">Tourist: <strong>
                                                    {{ trim($notification->booking->user->first_name . ' ' . $notification->booking->user->middle_name . ' ' . $notification->booking->user->last_name) }}
                                                </strong></p>
                                            @endif
                                            @if ($notification->booking->room)
                                                <p class="mb-1">Room: <strong>{{ $notification->booking->room->room_name }}</strong></p>
                                            @endif
                                            <p class="mb-1">Guests: <strong>{{ $notification->booking->number_of_guests }}</strong></p>
                                            <p class="mb-1">Check-in: <strong>
                                                @php
                                                    try {
                                                        echo \Carbon\Carbon::parse($notification->booking->check_in_date)->format('M d, Y');
                                                    } catch(\Exception $e) {
                                                        echo $notification->booking->check_in_date;
                                                    }
                                                @endphp
                                            </strong></p>
                                            <p class="mb-1">Tour Type: <strong>{{ ucfirst(str_replace('_', ' ', $notification->booking->tour_type)) }}</strong></p>
                                            @if ($notification->booking->tour_type === 'day_tour')
                                                <p class="mb-1">Departure Time: <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->day_tour_departure_time)->format('h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->day_tour_departure_time;
                                                        }
                                                    @endphp
                                                </strong></p>
                                                <p class="mb-1">Pick-up Time: <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->day_tour_time_of_pickup)->format('h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->day_tour_time_of_pickup;
                                                        }
                                                    @endphp
                                                </strong></p>
                                            @elseif ($notification->booking->tour_type === 'overnight')
                                                <p class="mb-1">Date & Time of Pick-up: <strong>
                                                    @php
                                                        try {
                                                            echo \Carbon\Carbon::parse($notification->booking->overnight_date_time_of_pickup)->format('M d, Y h:i A');
                                                        } catch(\Exception $e) {
                                                            echo $notification->booking->overnight_date_time_of_pickup;
                                                        }
                                                    @endphp
                                                </strong></p>
                                                @if ($notification->booking->check_out_date)
                                                    <p class="mb-1">Check-out Date: <strong>
                                                        @php
                                                            try {
                                                                echo \Carbon\Carbon::parse($notification->booking->check_out_date)->format('M d, Y');
                                                            } catch(\Exception $e) {
                                                                echo $notification->booking->check_out_date;
                                                            }
                                                        @endphp
                                                    </strong></p>
                                                @endif
                                                <p class="mb-1">Senior Citizens: <strong>{{ $notification->booking->num_senior_citizens }}</strong></p>
                                                <p class="mb-1">PWDs: <strong>{{ $notification->booking->num_pwds }}</strong></p>
                                            @endif
                                            <p class="mb-2 mt-2">Status:
                                                @if ($notification->booking->status === 'approved')
                                                    <span class="status-badge status-approved"><strong>Approved</strong></span>
                                                @elseif ($notification->booking->status === 'rejected')
                                                    <span class="status-badge status-rejected"><strong>Rejected</strong></span>
                                                @elseif ($notification->booking->status === 'cancelled')
                                                    <span class="status-badge status-rejected"><strong>Cancelled</strong></span>
                                                @elseif ($notification->booking->status === 'completed')
                                                    <span class="status-badge status-completed"><strong>Completed</strong></span>
                                                @else
                                                    <span class="status-badge status-pending"><strong>{{ ucfirst($notification->booking->status) }}</strong></span>
                                                @endif
                                            </p>

                                            {{-- Show assigned boat & captain if available --}}
                                            @if ($notification->booking->status === 'approved')
                                                @php
                                                    $assignedBoatName = $notification->booking->assigned_boat ?? ($notification->booking->assignedBoat->boat_name ?? null);
                                                    $captainName = $notification->booking->boat_captain_crew
                                                        ?? ($notification->booking->assignedBoat->captain_name ?? null);
                                                @endphp
                                                @if ($assignedBoatName || $captainName)
                                                    <div class="mt-2">
                                                        @if($assignedBoatName)
                                                            <p class="mb-1">Assigned Boat: <strong>{{ $assignedBoatName }}</strong></p>
                                                        @endif
                                                        <p class="mb-1">Boat Captain: <strong>{{ $captainName ?? 'N/A' }}</strong></p>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                        {{-- Action buttons for ALL notifications --}}
                                        <div class="mt-3 d-flex justify-content-end align-items-center">
                                            @unless ($notification->is_read)
                                                <form action="{{ route('boat.owner.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline me-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Mark as Read</button>
                                                </form>
                                            @endunless
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteNotificationModal" data-notification-id="{{ $notification->id }}">
                                                Delete
                                            </button>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $boatOwnerNotifications->links('vendor.pagination.boat-owner') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Notification Confirmation Modal --}}
    <div class="modal fade" id="deleteNotificationModal" tabindex="-1" aria-labelledby="deleteNotificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteNotificationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this notification? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteNotificationForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Permit Resubmit Upload Box if notification is type permit_resubmit --}}
    @if(isset($boatOwnerNotifications))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.list-group-item').forEach(function(item){
                    const heading = item.querySelector('h5.mb-1');
                    if (!heading) return;
                });

                // Delete notification modal handling
                var deleteNotificationModal = document.getElementById('deleteNotificationModal');
                if (deleteNotificationModal) {
                    deleteNotificationModal.addEventListener('show.bs.modal', function (event) {
                        var button = event.relatedTarget;
                        var notificationId = button.getAttribute('data-notification-id');
                        var form = document.getElementById('deleteNotificationForm');
                        form.action = '/boat-owner/notifications/' + notificationId;
                    });
                }
            });
        </script>
    @endif



    {{-- Custom CSS for sidebar nav-link hover and focus and icon rotation --}}
    <style>
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }
        .collapse-icon {
            transition: transform 0.3s ease-in-out;
            min-width: 1em;
        }
        .collapse-icon.rotated {
            transform: rotate(180deg);
        }
        .nav-link.active-parent {
            background-color:rgb(6, 58, 170) !important;
        }
        .status-badge {
            display: inline-block;
            padding: 0.3em 0.8em;
            font-size: 0.875em;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border-radius: 0.75rem;
            border: 1px solid transparent;
            text-transform: capitalize;
        }
        .status-approved {
            color: #28a745;
            background-color: #e6ffe9;
            border-color: #28a745;
        }
        .status-rejected,
        .status-cancelled {
            color: #dc3545;
            background-color: #ffe6e8;
            border-color: #dc3545;
        }
        .status-pending {
            color: #ffc107;
            background-color: #fffde6;
            border-color: #ffc107;
        }
        .status-completed {
            color: #007bff;
            background-color: #e0f0ff;
            border-color: #007bff;
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

    {{-- Custom JavaScript to handle arrow rotation, offcanvas hiding, and AJAX deletion --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);
                function hideOffcanvasOnDesktop() {
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }
                hideOffcanvasOnDesktop();
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // --- NEW: JavaScript for real-time notification count updates ---
            
            // Function to update notification count badges
            function updateNotificationCount() {
                var currentCount = parseInt(document.querySelector('#unreadBadgeDesktop')?.textContent || '0');
                if (currentCount > 0) {
                    currentCount--;
                    // Update both desktop and mobile badges
                    var desktopBadge = document.querySelector('#unreadBadgeDesktop');
                    var mobileBadge = document.querySelector('#unreadBadgeMobile');
                    
                    if (desktopBadge) {
                        if (currentCount > 0) {
                            desktopBadge.textContent = currentCount;
                        } else {
                            desktopBadge.remove();
                        }
                    }
                    
                    if (mobileBadge) {
                        if (currentCount > 0) {
                            mobileBadge.textContent = currentCount;
                        } else {
                            mobileBadge.remove();
                        }
                    }
                }
            }

            // Handle Mark as Read form submissions
            document.addEventListener('submit', function(e) {
                if (e.target.action && e.target.action.includes('markAsRead')) {
                    e.preventDefault();
                    
                    fetch(e.target.action, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the notification item to show as read
                            var notificationItem = e.target.closest('.list-group-item');
                            if (notificationItem) {
                                notificationItem.classList.remove('border-primary');
                                notificationItem.classList.add('text-muted');
                                
                                // Hide the Mark as Read button
                                var markAsReadBtn = e.target.querySelector('button');
                                if (markAsReadBtn) {
                                    markAsReadBtn.style.display = 'none';
                                }
                            }
                            
                            // Update notification count
                            updateNotificationCount();
                        }
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                        // Fallback to normal form submission
                        e.target.submit();
                    });
                }
            });

            // --- End NEW JavaScript for notification count updates ---


            
            // Disable upload button and show thank-you message after resubmit
            document.querySelectorAll('.permit-resubmit-form').forEach(function(form){
                form.addEventListener('submit', function(){
                    const btn = form.querySelector('.upload-again-btn');
                    const thanks = form.querySelector('.thanks-msg');
                    if (btn) {
                        btn.disabled = true;
                        btn.textContent = 'Uploading...';
                    }
                    if (thanks) {
                        thanks.style.display = 'inline';
                    }
                });
            });
        });
    </script>
</x-app-layout>
