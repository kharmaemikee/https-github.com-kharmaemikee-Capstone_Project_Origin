<x-app-layout>
    <head>
        {{-- Font Awesome CDN for Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                $unreadCount = \App\Models\ResortOwnerNotification::where('user_id', Auth::id())->where('is_read', false)->count();
            }
        } catch (\Throwable $e) { $unreadCount = 0; }
    @endphp

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('resort_owner.partials.sidebar')

        <div class="main-content flex-grow-1">
            {{-- Modern Header Section --}}
            <div class="page-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="header-text">
                        <h1 class="page-title">Notifications</h1>
                        <p class="page-subtitle">Stay updated with your resort notifications</p>
                    </div>
                </div>
                <div class="header-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                </div>
            </div>

            {{-- Alerts Section --}}
            <div class="alerts-container">
            @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>

            @php
                $notifications = \App\Models\ResortOwnerNotification::where('user_id', Auth::id())
                    ->with(['booking.room.resort', 'booking.user'])
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            {{-- Notifications Section --}}
            <div class="notifications-section">
            @if ($notifications->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-bell-slash"></i>
                        </div>
                        <h3 class="empty-title">No Notifications</h3>
                        <p class="empty-description">You don't have any notifications yet. Check back later for updates!</p>
                    </div>
            @else
                    {{-- Notifications Header --}}
                    <div class="notifications-header">
                        <div class="header-info">
                            <h2 class="section-title">
                                <i class="fas fa-bell me-2"></i>
                                Your Notifications
                            </h2>
                            <p class="section-subtitle">Stay updated with your resort information</p>
                        </div>
                @php
                    $unreadCount = $notifications->where('is_read', false)->count();
                @endphp
                            <div class="unread-info">
                                <span class="unread-badge">{{ $unreadCount }} unread</span>
                                <form action="{{ route('resort_owner.notifications.markAllAsRead') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-double me-1"></i>Mark All as Read
                                    </button>
                                </form>
                                <button type="button" id="deleteAllNotificationsBtn" class="btn btn-outline-light">
                                    <i class="fas fa-trash me-1"></i>Delete All
                                </button>
                            </div>
                    </div>

                    {{-- Notifications List --}}
                    <div class="notifications-list">
                    @foreach ($notifications as $notification)
                            <div class="notification-card {{ $notification->is_read ? 'read' : 'unread' }}" data-notification-id="{{ $notification->id }}">
                                <div class="notification-header">
                                    <div class="notification-icon">
                                        @if($notification->type === 'new_booking')
                                            <i class="fas fa-calendar-plus"></i>
                                        @elseif($notification->type === 'booking_cancelled')
                                            <i class="fas fa-calendar-times"></i>
                                        @elseif($notification->type === 'room_rated')
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="fas fa-bell"></i>
                                        @endif
                                    </div>
                                    <div class="notification-content">
                                        @php
                                            $type = $notification->type ?? null;
                                            $title = $notification->message;
                                            if ($type === 'new_booking') {
                                                $title = 'New Booking';
                                            } elseif ($type === 'booking_cancelled') {
                                                $title = 'Booking Cancelled';
                                            } elseif ($type === 'room_rated') {
                                                $title = 'Room Rated';
                                            }
                                        @endphp
                                        <h5 class="notification-title">{{ $title }}</h5>
                                        @if($type === 'new_booking')
                                            <div class="text-muted small">You have received a new booking request.</div>
                                        @elseif($type === 'booking_cancelled')
                                            <div class="text-muted small">A booking has been cancelled.</div>
                                        @elseif($type === 'room_rated')
                                            <div class="text-muted small">One of your rooms has been rated by a guest.</div>
                                        @endif
                                        <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    @unless ($notification->is_read)
                                        <div class="unread-indicator"></div>
                                    @endunless
                            </div>

                                {{-- Booking Details --}}
                            @if ($notification->booking)
                                <div class="booking-details-section">
                                    <div class="booking-details-header">
                                        <i class="fas fa-info-circle"></i>
                                        <h6>Booking Details</h6>
                                    </div>
                                    <div class="booking-details-grid">
                                        @if($notification->booking->room)
                                            <div class="info-item">
                                                <span class="info-label">Room:</span>
                                                <span class="info-value">{{ $notification->booking->room->room_name }}</span>
                                            </div>
                                        @endif
                                        @if($notification->booking->user)
                                            <div class="info-item">
                                                <span class="info-label">Guest:</span>
                                                <span class="info-value">{{ $notification->booking->guest_name }}</span>
                                            </div>
                                        @endif
                                        <div class="info-item">
                                            <span class="info-label">Check-in:</span>
                                            <span class="info-value">{{ $notification->booking->check_in_date ? \Carbon\Carbon::parse($notification->booking->check_in_date)->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                        @if($notification->booking->check_out_date)
                                            <div class="info-item">
                                                <span class="info-label">Check-out:</span>
                                                <span class="info-value">{{ \Carbon\Carbon::parse($notification->booking->check_out_date)->format('M d, Y') }}</span>
                                            </div>
                                        @endif
                                        <div class="info-item">
                                            <span class="info-label">Status:</span>
                                            <span class="info-value">{{ ucfirst($notification->booking->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif


                                {{-- Action Buttons --}}
                                <div class="notification-actions">
                                @unless ($notification->is_read)
                                        <form action="{{ route('resort_owner.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-check me-1"></i>Mark as Read
                                            </button>
                                    </form>
                                @endunless
                                <button type="button" class="btn btn-outline-danger btn-sm delete-notification-btn" data-notification-id="{{ $notification->id }}">
                                        <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        </div>
    </div>

    <style>
        /* Include all the same styles as tourist notifications with some modifications */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');


        /* Include all other styles from tourist notifications */
        /* Hide hamburger button by default on larger screens */
        .hamburger-btn {
            display: none !important;
        }

        /* Hamburger Button Styles */
        .hamburger-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hamburger-btn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .hamburger-btn:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            color: white;
        }

        .hamburger-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

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

        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
        }

        .page-header {
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

        .notifications-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .notifications-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
        }

        .section-subtitle {
            font-size: 1rem;
            margin: 0;
            opacity: 0.9;
        }

        .unread-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .unread-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .notifications-list {
            padding: 1.5rem;
        }

        .notification-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .notification-card.unread {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-left: 4px solid #007bff;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
        }

        .notification-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
            border-bottom: 1px solid rgba(0, 123, 255, 0.1);
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
            margin: 0 0 0.5rem 0;
        }

        .notification-time {
            font-size: 0.9rem;
            color: #6c757d;
            margin: 0;
        }

        .unread-indicator {
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        .booking-details-section {
            margin: 1rem 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 12px;
            border-left: 4px solid #007bff;
            box-shadow: 0 2px 10px rgba(0, 123, 255, 0.1);
        }

        .booking-details-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: #007bff;
        }

        .booking-details-header h6 {
            margin: 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .booking-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .booking-details-grid .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            padding: 0.5rem;
            background: rgba(0, 123, 255, 0.05);
            border-radius: 8px;
        }

        .booking-details-grid .info-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
        }

        .booking-details-grid .info-value {
            font-size: 0.95rem;
            color: #212529;
            font-weight: 600;
        }

        .notification-actions {
            padding: 1rem 1.5rem;
            background: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            padding: 0.5rem 1rem;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: 1px solid #007bff;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            color: white;
        }

        .btn-outline-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: 1px solid #dc3545;
        }

        .btn-outline-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            margin: 2rem 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: #6c757d;
            font-size: 3rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .empty-title {
            font-size: 2rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 1rem;
        }

        .empty-description {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 0;
            line-height: 1.5;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .modern-sidebar {
                display: none;
            }
            
            /* Ensure hamburger button is visible */
            .hamburger-btn {
                display: block !important;
                width: 40px;
                height: 40px;
                padding: 8px 12px;
                font-size: 1.1rem;
            }
            
            .page-header {
                padding: 2rem 1rem;
                margin-bottom: 2rem;
            }
            
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .notifications-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .unread-info {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .booking-details-grid {
                grid-template-columns: 1fr;
            }
            
            .notification-actions {
                flex-direction: column;
            }
            
            .notification-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .hamburger-btn {
                width: 36px;
                height: 36px;
                padding: 6px 10px;
                font-size: 1rem;
            }
        }

        @media (max-width: 320px) {
            .hamburger-btn {
                width: 32px;
                height: 32px;
                padding: 4px 8px;
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission
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
                                Swal.fire({ title: 'Notification Mark as Read', icon: 'success' });
                            }
                            var notificationItem = e.target.closest('.notification-card');
                            if (notificationItem) {
                                notificationItem.classList.remove('unread');
                                notificationItem.classList.add('read');
                                
                                var markAsReadBtn = e.target.querySelector('button');
                                if (markAsReadBtn) {
                                    markAsReadBtn.style.display = 'none';
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                        e.target.submit();
                    });
                }
            });

            // Handle Mark All as Read
            document.addEventListener('submit', function(e) {
                if (e.target.action && e.target.action.includes('mark-all-as-read')) {
                    e.preventDefault();
                    fetch(e.target.action, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data && data.success) {
                            document.querySelectorAll('.notification-card').forEach(card => {
                                card.classList.remove('unread');
                                card.classList.add('read');
                                const dot = card.querySelector('.unread-indicator');
                                if (dot) dot.remove();
                            });
                            const headerUnread = document.querySelector('.unread-badge');
                            if (headerUnread) headerUnread.textContent = '0 unread';
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ title: 'All notifications marked as read', icon: 'success' });
                            }
                        }
                    })
                    .catch(() => {
                        e.target.submit();
                    });
                }
            });

            // Handle delete notification
            document.querySelectorAll('.delete-notification-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-notification-id');
                    const notificationItem = this.closest('.notification-card');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this! This will delete the notification.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/resort_owner/notifications/${notificationId}`, {
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
                                    if (notificationItem) notificationItem.remove();
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The notification has been deleted successfully.",
                                        icon: "success"
                                    });
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting notification:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete notification. Please try again.",
                                    icon: "error"
                                });
                            });
                        }
                    });
                });
            });

            // Handle Delete All Notifications
            const deleteAllBtn = document.getElementById('deleteAllNotificationsBtn');
            if (deleteAllBtn) {
                deleteAllBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: "Delete all notifications?",
                        text: "This will permanently delete all your notifications.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete all",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/resort_owner/notifications`, {
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
                                    document.querySelectorAll('.notification-card').forEach(card => card.remove());
                                    Swal.fire({ title: "Deleted!", text: "All notifications deleted.", icon: "success" });
                                } else {
                                    throw new Error('Delete all failed');
                                }
                            })
                            .catch(() => {
                                Swal.fire({ title: "Error!", text: "Failed to delete all notifications. Please try again.", icon: "error" });
                            });
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>
