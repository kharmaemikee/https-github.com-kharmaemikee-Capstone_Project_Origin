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
                $unreadCount = \App\Models\TouristNotification::where('user_id', Auth::id())->where('is_read', false)->count();
            }
        } catch (\Throwable $e) { $unreadCount = 0; }
    @endphp

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        {{-- Main Content --}}
        <main class="main-content">
            {{-- Modern Header Section --}}
            <div class="page-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="header-text">
                        <h1 class="page-title">Notifications</h1>
                        <p class="page-subtitle">Stay updated with your booking notifications</p>
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
                $notifications = \App\Models\TouristNotification::where('user_id', Auth::id())
                    ->with(['booking.room.resort'])
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
                            <p class="section-subtitle">Stay updated with your booking information</p>
                        </div>
                @php
                    $unreadCount = $notifications->where('is_read', false)->count();
                @endphp
                            <div class="unread-info">
                                <span class="unread-badge">{{ $unreadCount }} unread</span>
                                <form action="{{ route('tourist.notifications.markAllAsRead') }}" method="POST" class="d-inline">
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
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="notification-content">
                                        @php
                                            $type = $notification->type ?? null;
                                            $title = $notification->message;
                                            if ($type === 'boat_assigned') {
                                                $title = 'Boat Assigned';
                                            } elseif ($type === 'booking_completed') {
                                                $title = 'Booking Completed';
                                            } elseif ($type === 'rating_request') {
                                                $title = 'Rate Your Stay';
                                            } elseif ($type === 'extension_requested') {
                                                $title = 'Extension Requested';
                                            } elseif ($type === 'extension_approved') {
                                                $title = 'Extension Approved';
                                            }
                                        @endphp
                                        <h5 class="notification-title">{{ $title }}</h5>
                                        @if($type === 'boat_assigned')
                                            <div class="text-muted small">Your boat has been assigned for your trip.</div>
                                        @elseif($type === 'booking_completed')
                                            <div class="text-muted small">Your booking has been marked as completed.</div>
                                        @elseif($type === 'rating_request')
                                            <div class="text-muted small">Please submit your 1–5 star rating for your stay.</div>
                                        @elseif($type === 'extension_requested')
                                            <div class="text-muted small">Your extension request has been sent to the resort owner for approval.</div>
                                        @elseif($type === 'extension_approved')
                                            <div class="text-muted small">Your room booking extension has been approved.</div>
                                        @endif
                                        <p class="notification-time">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    @unless ($notification->is_read)
                                        <div class="unread-indicator"></div>
                                    @endunless
                            </div>

                                {{-- Boat Assignment Information --}}
                            @if ($notification->booking)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $showAssignment = false;
                                    $windowTime = null;
                                    if ($notification->booking->tour_type === 'day_tour' && $notification->booking->day_tour_departure_time) {
                                        try {
                                            $windowTime = \Carbon\Carbon::parse((string)$notification->booking->check_in_date.' '.(string)$notification->booking->day_tour_departure_time);
                                        } catch (\Exception $e) { $windowTime = null; }
                                    } elseif ($notification->booking->tour_type === 'overnight' && $notification->booking->overnight_date_time_of_pickup) {
                                        try {
                                            $windowTime = \Carbon\Carbon::parse((string)$notification->booking->overnight_date_time_of_pickup);
                                        } catch (\Exception $e) { $windowTime = null; }
                                    }
                                    if ($windowTime) { $showAssignment = $now->gte($windowTime); }

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
                                @if($showAssignment)
                                    <div class="boat-info-section">
                                        <div class="boat-info-header">
                                            <i class="fas fa-ship"></i>
                                            <h6>Boat Assignment Details</h6>
                                        </div>
                                        <div class="boat-info-grid">
                                            @if($assignedBoatName)
                                                <div class="info-item">
                                                    <span class="info-label">Boat Name:</span>
                                                    <span class="info-value">{{ $assignedBoatName }}</span>
                                                </div>
                                            @endif
                                            @if($captainName)
                                                <div class="info-item">
                                                    <span class="info-label">Captain:</span>
                                                    <span class="info-value">{{ $captainName }}</span>
                                                </div>
                                            @endif
                                            @if($captainContact)
                                                <div class="info-item">
                                                    <span class="info-label">Captain Contact:</span>
                                                    <span class="info-value">{{ $captainContact }}</span>
                                                </div>
                                            @endif
                                            @if($boatContact)
                                                <div class="info-item">
                                                    <span class="info-label">Boat Contact:</span>
                                                    <span class="info-value">{{ $boatContact }}</span>
                                                </div>
                                            @endif
                                            @if($boatPrice > 0)
                                                <div class="info-item">
                                                    <span class="info-label">Boat Price:</span>
                                                    <span class="info-value">₱{{ number_format($boatPrice, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="boat-info-note">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Please contact your assigned boat captain for any questions about your trip.</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="boat-info-section">
                                        <div class="boat-info-header">
                                            <i class="fas fa-clock"></i>
                                            <h6>Boat Assignment</h6>
                                        </div>
                                        <div class="boat-info-grid">
                                            <div class="info-item">
                                                <span class="info-label">Status:</span>
                                                <span class="info-value">Waiting to assign the boat on your booking date at the departure time</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            
                                {{-- Extension Request (visible when booking is finished) --}}
                            @if ($notification->booking)
                                @php
                                    $booking = $notification->booking;
                                    $isFinished = ($booking->status === 'completed');
                                    if (!$isFinished && method_exists($booking, 'isCompleted')) {
                                        try { $isFinished = $booking->isCompleted(); } catch (\Throwable $e) { $isFinished = false; }
                                    }
                                @endphp
                                @if ($isFinished && !in_array($booking->status, ['pending_update_approval']))
                                    <div class="boat-info-section">
                                        <div class="boat-info-header">
                                            <i class="fas fa-clock-rotate-left"></i>
                                            <h6>Booking Completed</h6>
                                        </div>
                                        <div class="mb-2 text-muted small">Thank you for visiting. You can request an extension below or rate your stay from your bookings page.</div>
                                        <form action="{{ route('bookings.requestExtension', $booking->id) }}" method="POST" class="row g-2 align-items-end">
                                            @csrf
                                            <div class="col-12 col-md-4">
                                                <label class="form-label mb-1">Extend By</label>
                                                <select name="extension_type" class="form-select" required>
                                                    <option value="days">Days</option>
                                                    <option value="hours">Hours</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="form-label mb-1">Amount</label>
                                                <input type="number" min="1" name="extension_value" class="form-control" placeholder="Enter number" required>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-paper-plane me-1"></i>Send Request
                                                </button>
                                            </div>
                                        </form>
                                        <div class="boat-info-note mt-2">
                                            <i class="fas fa-info-circle"></i>
                                            <span>After you submit, the resort owner will review your request. No boat will be auto-assigned.</span>
                                        </div>
                                    </div>
                                @elseif($booking->status === 'pending_update_approval')
                                    <div class="boat-info-section">
                                        <div class="boat-info-header">
                                            <i class="fas fa-hourglass-half"></i>
                                            <h6>Extension Request Pending</h6>
                                        </div>
                                        <div class="boat-info-grid">
                                            <div class="info-item">
                                                <span class="info-label">Status:</span>
                                                <span class="info-value">Awaiting resort owner approval</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                                {{-- Rating Request (visible when booking is completed or notification asks for rating) --}}
                            @if ($notification->booking)
                                @php
                                    $booking = $notification->booking;
                                    $isCompleted = ($booking->status === 'completed');
                                    if (!$isCompleted && method_exists($booking, 'isCompleted')) {
                                        try { $isCompleted = $booking->isCompleted(); } catch (\Throwable $e) { $isCompleted = false; }
                                    }
                                    $shouldShowRating = ($type === 'rating_request') || $isCompleted;
                                    $alreadyRated = false;
                                    try { $alreadyRated = \App\Models\Rating::where('booking_id', $booking->id)->exists(); } catch (\Throwable $e) { $alreadyRated = false; }
                                @endphp
                                @if ($shouldShowRating && !$alreadyRated)
                                    <div class="boat-info-section">
                                        <div class="boat-info-header" style="color:#ffc107; border-color:#ffc107;">
                                            <i class="fas fa-star"></i>
                                            <h6>Rate Your Stay</h6>
                                        </div>
                                        <div class="mb-2 text-muted small">Please rate your experience (1–5 stars).</div>
                                        <form method="POST" action="{{ route('tourist.bookings.rating.store', $booking->id) }}" class="d-flex flex-column gap-2">
                                            @csrf
                                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <div>
                                                        <input type="radio" class="btn-check" name="stars" id="notif_rate_{{ $booking->id }}_{{ $i }}" value="{{ $i }}" autocomplete="off" {{ $i==5 ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-warning btn-sm" for="notif_rate_{{ $booking->id }}_{{ $i }}">
                                                            <i class="fas fa-star"></i> {{ $i }}
                                                        </label>
                                                    </div>
                                                @endfor
                                            </div>
                                            <div>
                                                <textarea name="comment" class="form-control" rows="2" placeholder="Optional comment"></textarea>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane me-1"></i>Submit Rating
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @elseif($shouldShowRating && $alreadyRated)
                                    <div class="boat-info-section">
                                        <div class="boat-info-header" style="color:#28a745;">
                                            <i class="fas fa-check"></i>
                                            <h6>Thanks for your rating</h6>
                                        </div>
                                        <div class="text-muted small">Your feedback has been recorded.</div>
                                    </div>
                                @endif
                            @endif

                                {{-- Action Buttons --}}
                                <div class="notification-actions">
                                @unless ($notification->is_read)
                                        <form action="{{ route('tourist.notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
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

        /* Page Header */
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

        /* Alerts */
        .alerts-container {
            margin-bottom: 2rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        /* Notifications Section */
        .notifications-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
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
        }

        /* Notifications Header */
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

        /* Notifications List */
        .notifications-list {
            padding: 0;
        }

        .notification-card {
            background: white;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
        }

        .notification-card:last-child {
            border-bottom: none;
        }

        .notification-card.unread {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-left: 4px solid #007bff;
        }

        .notification-card:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
        }

        .notification-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
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
            background: #007bff;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 0.5rem;
        }

        /* Boat Info Section */
        .boat-info-section {
            margin: 1rem 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border-left: 4px solid #28a745;
        }

        .boat-info-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: #28a745;
        }

        .boat-info-header h6 {
            margin: 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .boat-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .boat-info-grid .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .boat-info-grid .info-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 500;
        }

        .boat-info-grid .info-value {
            font-size: 0.95rem;
            color: #212529;
            font-weight: 600;
        }

        .boat-info-note {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #6c757d;
            background: rgba(40, 167, 69, 0.1);
            padding: 0.75rem;
            border-radius: 8px;
        }

        /* Notification Actions */
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
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header {
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

            .notifications-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .unread-info {
                flex-direction: column;
                gap: 0.75rem;
            }

            .boat-info-grid {
                grid-template-columns: 1fr;
            }

            .notification-actions {
                flex-direction: column;
            }

            .notification-actions .btn {
                width: 100%;
            }
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

        /* SweetAlert2 Responsive Styles */
        .swal2-popup-responsive {
            font-size: 14px !important;
            max-width: 90% !important;
        }

        .swal2-title-responsive {
            font-size: 18px !important;
            line-height: 1.4 !important;
        }

        .swal2-content-responsive {
            font-size: 14px !important;
            line-height: 1.4 !important;
        }

        .swal2-confirm-responsive {
            font-size: 14px !important;
            padding: 8px 16px !important;
        }

        .swal2-cancel-responsive {
            font-size: 14px !important;
            padding: 8px 16px !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .swal2-popup-responsive {
                font-size: 12px !important;
                max-width: 95% !important;
                margin: 10px !important;
            }

            .swal2-title-responsive {
                font-size: 16px !important;
            }

            .swal2-content-responsive {
                font-size: 12px !important;
            }

            .swal2-confirm-responsive,
            .swal2-cancel-responsive {
                font-size: 12px !important;
                padding: 6px 12px !important;
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

            // Handle Mark All as Read (AJAX)
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
                            // Mark all cards as read in the UI
                            document.querySelectorAll('.notification-card').forEach(card => {
                                card.classList.remove('unread');
                                card.classList.add('read');
                                const dot = card.querySelector('.unread-indicator');
                                if (dot) dot.remove();
                            });
                            // Update unread count display in header
                            const headerUnread = document.querySelector('.unread-badge');
                            if (headerUnread) headerUnread.textContent = '0 unread';
                            // Clear sidebar badges if present
                            const desktopBadge = document.querySelector('#unreadBadgeDesktop');
                            const mobileBadge = document.querySelector('#unreadBadgeMobile');
                            if (desktopBadge) desktopBadge.remove();
                            if (mobileBadge) mobileBadge.remove();
                            // Notify
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ title: 'All notifications marked as read', icon: 'success' });
                            }
                        }
                    })
                    .catch(() => {
                        // Fallback to normal submit if AJAX fails
                        e.target.submit();
                    });
                }
            });

            // Handle delete notification button clicks
            document.querySelectorAll('.delete-notification-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-notification-id');
                    const notificationItem = this.closest('.list-group-item');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this! This will delete the notification.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive',
                            confirmButton: 'swal2-confirm-responsive',
                            cancelButton: 'swal2-cancel-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Deleting...",
                                text: "Please wait while we delete the notification.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                customClass: {
                                    popup: 'swal2-popup-responsive',
                                    title: 'swal2-title-responsive',
                                    content: 'swal2-content-responsive'
                                }
                            });
                            
                            fetch(`/tourist/notifications/${notificationId}`, {
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
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive',
                                            confirmButton: 'swal2-confirm-responsive'
                                        }
                                    });
                                    
                                    // Update notification count
                                    updateNotificationCount();
                                } else {
                                    throw new Error('Delete failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting notification:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete notification. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive',
                                        confirmButton: 'swal2-confirm-responsive'
                                    }
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
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive',
                            confirmButton: 'swal2-confirm-responsive',
                            cancelButton: 'swal2-cancel-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Deleting...",
                                text: "Please wait while we delete all notifications.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => { Swal.showLoading(); },
                                customClass: { popup: 'swal2-popup-responsive', title: 'swal2-title-responsive', content: 'swal2-content-responsive' }
                            });

                            fetch(`{{ route('tourist.notifications.destroyAll') }}`, {
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
                                    // Remove all notification cards from the DOM
                                    document.querySelectorAll('.notification-card').forEach(card => card.remove());
                                    // Clear unread badges
                                    const desktopBadge = document.querySelector('#unreadBadgeDesktop');
                                    const mobileBadge = document.querySelector('#unreadBadgeMobile');
                                    if (desktopBadge) desktopBadge.remove();
                                    if (mobileBadge) mobileBadge.remove();
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
