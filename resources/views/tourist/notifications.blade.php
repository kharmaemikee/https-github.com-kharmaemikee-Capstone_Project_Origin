<x-app-layout>
    <head>
        {{-- Bootstrap Icons CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    @php
        $unreadCount = 0;
        try {
            if (Auth::check()) {
                $unreadCount = \App\Models\TouristNotification::where('user_id', Auth::id())->where('is_read', false)->count();
            }
        } catch (\Throwable $e) { $unreadCount = 0; }
    @endphp

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <h2 class="mb-4">Tourist Notifications</h2>

            {{-- Display Session Messages --}}
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

            {{-- Display Error Messages from Validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $notifications = \App\Models\TouristNotification::where('user_id', Auth::id())
                    ->with(['booking.room.resort'])
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            @if ($notifications->isEmpty())
                <div class="alert alert-info">You have no notifications.</div>
            @else
                {{-- Mark All as Read Button --}}
                @php
                    $unreadCount = $notifications->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">{{ $unreadCount }} unread notification{{ $unreadCount > 1 ? 's' : '' }}</span>
                        <form action="{{ route('tourist.notifications.markAllAsRead') }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-check-all me-1"></i>Mark All as Read
                            </button>
                        </form>
                    </div>
                @endif
                <div class="list-group">
                    @foreach ($notifications as $notification)
                        <div class="list-group-item list-group-item-action {{ $notification->is_read ? 'text-muted' : 'border-primary' }}" data-notification-id="{{ $notification->id }}">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h5 class="mb-1">{{ $notification->message }}</h5>
                                <small class="text-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>

                            {{-- Display only boat assignment information --}}
                            @if ($notification->booking && ($notification->booking->assignedBoat || $notification->booking->boat_captain_crew))
                                @php
                                    // Get boat information from assignedBoat relationship or direct fields
                                    $assignedBoatName = $notification->booking->assigned_boat ?? ($notification->booking->assignedBoat->boat_name ?? null);
                                    $captainName = $notification->booking->captain_name?? ($notification->booking->assignedBoat->captain_name ?? null);
                                    $captainContact = $notification->booking->captain_contact ?? ($notification->booking->assignedBoat->captain_contact ?? null);
                                    $boatContact = null;
                                    if ($notification->booking->assignedBoat && $notification->booking->assignedBoat->user) {
                                        $boatContact = $notification->booking->assignedBoat->user->phone ?? null;
                                    }
                                    $boatPrice = 0;
                                    if ($notification->booking->assignedBoat) {
                                        $boatPrice = $notification->booking->assignedBoat->boat_prices ?? 0;
                                    } elseif ($notification->booking->boat_price) {
                                        $boatPrice = $notification->booking->boat_price;
                                    }
                                @endphp
                                
                                <hr class="my-2">
                                <h6>🚤 Your Assigned Boat Information:</h6>
                                
                                @if($assignedBoatName)
                                    <p class="mb-1">Boat Name: <strong>{{ $assignedBoatName }}</strong></p>
                                @endif
                                
                                @if($captainName)
                                    <p class="mb-1">Boat Captain: <strong>{{ $captainName }}</strong></p>
                                @endif
                                
                                @if($captainContact)
                                    <p class="mb-1">Captain Contact: <strong>{{ $captainContact }}</strong></p>
                                @endif
                                
                                @if($boatContact)
                                    <p class="mb-1">Boat Contact: <strong>{{ $boatContact }}</strong></p>
                                @endif
                                
                                @if($boatPrice > 0)
                                    <p class="mb-1">Boat Price: <strong>₱{{ number_format($boatPrice, 2) }}</strong></p>
                                @endif
                                
                                <div class="alert alert-info mt-2 mb-0">
                                    <small><i class="fas fa-info-circle me-1"></i> Please contact your assigned boat captain for any questions about your trip.</small>
                                </div>
                            @endif
                            
                            {{-- Action buttons for ALL notifications --}}
                            <div class="mt-3 d-flex justify-content-end align-items-center">
                                @unless ($notification->is_read)
                                    <form action="{{ route('tourist.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline me-2">
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
            @endif
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

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

        /* Custom styles for status badges */
        .status-badge {
            display: inline-block;
            padding: .35em .65em;
            font-size: .75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }

        .status-badge-pending {
            background-color: #fff3cd;
            color: #664d03;
            border: 1px solid #ffecb5;
        }

        .status-badge-approved {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .status-badge-rejected {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }
    </style>

    {{-- Custom JavaScript for mobile sidebar behavior and modal handling --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar behavior
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

            // Delete notification modal handling
            var deleteNotificationModal = document.getElementById('deleteNotificationModal');
            if (deleteNotificationModal) {
                deleteNotificationModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var notificationId = button.getAttribute('data-notification-id');
                    var form = document.getElementById('deleteNotificationForm');
                    form.action = '/tourist/notifications/' + notificationId;
                });
            }

            // Function to update notification count badges
            function updateNotificationCount() {
                var currentCount = parseInt(document.querySelector('#unreadBadgeDesktop')?.textContent || '0');
                if (currentCount > 0) {
                    currentCount--;
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

            // Handle Mark as Read (AJAX + SweetAlert2)
            document.addEventListener('submit', function(e) {
                if (e.target.action && e.target.action.includes('mark-as-read')) {
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
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ title: 'Notification Mark as Read', icon: 'success', draggable: true });
                            }
                            var notificationItem = e.target.closest('.list-group-item');
                            if (notificationItem) {
                                notificationItem.classList.remove('border-primary');
                                notificationItem.classList.add('text-muted');
                                
                                var markAsReadBtn = e.target.querySelector('button');
                                if (markAsReadBtn) {
                                    markAsReadBtn.style.display = 'none';
                                }
                            }
                            
                            updateNotificationCount();
                        }
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                        e.target.submit();
                    });
                }
            });

            // Handle delete notification form submission
            document.getElementById('deleteNotificationForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                fetch(this.action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: "You deleted successfully!",
                                icon: "success",
                                draggable: true
                            });
                        }
                        
                        // Close the modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteNotificationModal'));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Reload the page to update the notifications list
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error deleting notification:', error);
                    // Fallback to normal form submission
                    this.submit();
                });
            });
        });
    </script>
</x-app-layout>
