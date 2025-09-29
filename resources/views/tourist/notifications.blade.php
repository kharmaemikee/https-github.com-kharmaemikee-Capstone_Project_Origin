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

        <div class="main-content flex-grow-1">
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
                                                $title = 'Booking Completed';
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
                                            <div class="text-muted small">Your booking has been completed successfully.</div>
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

                                {{-- Booking Details with Pricing --}}
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
                                            <div class="info-item">
                                                <span class="info-label">Guest/s:</span>
                                                <span class="info-value">{{ $notification->booking->room->max_guests }} guests</span>
                                            </div>
                                        @endif
                                       
                                        @if($notification->booking->num_senior_citizens > 0)
                                            <div class="info-item">
                                                <span class="info-label">Senior Citizens:</span>
                                                <span class="info-value">{{ $notification->booking->num_senior_citizens }}</span>
                                            </div>
                                        @endif
                                        @if($notification->booking->num_pwds > 0)
                                            <div class="info-item">
                                                <span class="info-label">PWDs:</span>
                                                <span class="info-value">{{ $notification->booking->num_pwds }}</span>
                                            </div>
                                        @endif
                                        @php
                                            $ci = null; $co = null; $ciTime = null; $coTime = null; $ciDateStr = null; $coDateStr = null; $ciTimeStr = null; $coTimeStr = null;
                                            try { $ci = \Carbon\Carbon::parse((string)$notification->booking->check_in_date); } catch (\Exception $e) { $ci = null; }
                                            try { $co = $notification->booking->check_out_date ? \Carbon\Carbon::parse((string)$notification->booking->check_out_date) : null; } catch (\Exception $e) { $co = null; }
                                            // Determine times by tour type without changing backend
                                            if (($notification->booking->tour_type ?? '') === 'day_tour') {
                                                try { $ciTime = $notification->booking->day_tour_departure_time ? \Carbon\Carbon::parse((string)$notification->booking->check_in_date.' '.(string)$notification->booking->day_tour_departure_time) : null; } catch (\Exception $e) { $ciTime = null; }
                                                // For day tour, treat checkout as same day with pick-up time if present; fallback to check-out date
                                                try {
                                                    $coTime = ($notification->booking->day_tour_time_of_pickup ?? null) ? \Carbon\Carbon::parse((string)($co?->toDateString() ?: $ci?->toDateString()).' '.(string)$notification->booking->day_tour_time_of_pickup) : null;
                                                } catch (\Exception $e) { $coTime = null; }
                                            } else { // overnight
                                                try {
                                                    $ciTime = $notification->booking->overnight_date_time_of_departure
                                                        ? \Carbon\Carbon::parse((string)$notification->booking->overnight_date_time_of_departure)
                                                        : ($notification->booking->overnight_departure_time
                                                            ? \Carbon\Carbon::parse((string)$notification->booking->overnight_departure_time)
                                                            : null);
                                                } catch (\Exception $e) { $ciTime = null; }
                                                try { $coTime = $notification->booking->overnight_date_time_of_pickup ? \Carbon\Carbon::parse((string)$notification->booking->overnight_date_time_of_pickup) : null; } catch (\Exception $e) { $coTime = null; }
                                            }
                                            $ciDateStr = $ci ? $ci->format('M d, Y') : ($notification->booking->check_in_date ?? '');
                                            $coDateStr = ($co ?: $ci) ? ($co ?: $ci)->format('M d, Y') : ($notification->booking->check_out_date ?? $notification->booking->check_in_date ?? '');
                                            $ciTimeStr = $ciTime ? $ciTime->format('h:i A') : null;
                                            $coTimeStr = $coTime ? $coTime->format('h:i A') : null;
                                            // Fallbacks if parsing failed but raw times exist
                                            if (!$ciTimeStr) {
                                                if (($notification->booking->tour_type ?? '') === 'day_tour' && $notification->booking->day_tour_departure_time) {
                                                    try { $ciTimeStr = \Carbon\Carbon::parse((string)$notification->booking->day_tour_departure_time)->format('h:i A'); } catch (\Exception $e) { $ciTimeStr = (string)$notification->booking->day_tour_departure_time; }
                                                } elseif (($notification->booking->tour_type ?? '') === 'overnight' && $notification->booking->overnight_date_time_of_departure) {
                                                    try { $ciTimeStr = \Carbon\Carbon::parse((string)$notification->booking->overnight_date_time_of_departure)->format('h:i A'); } catch (\Exception $e) { $ciTimeStr = (string)$notification->booking->overnight_date_time_of_departure; }
                                                }
                                            }
                                            if (!$coTimeStr) {
                                                if (($notification->booking->tour_type ?? '') === 'day_tour' && ($notification->booking->day_tour_time_of_pickup ?? null)) {
                                                    try { $coTimeStr = \Carbon\Carbon::parse((string)$notification->booking->day_tour_time_of_pickup)->format('h:i A'); } catch (\Exception $e) { $coTimeStr = (string)$notification->booking->day_tour_time_of_pickup; }
                                                } elseif (($notification->booking->tour_type ?? '') === 'overnight' && $notification->booking->overnight_date_time_of_pickup) {
                                                    try { $coTimeStr = \Carbon\Carbon::parse((string)$notification->booking->overnight_date_time_of_pickup)->format('h:i A'); } catch (\Exception $e) { $coTimeStr = (string)$notification->booking->overnight_date_time_of_pickup; }
                                                }
                                            }
                                        @endphp

                                        <div class="info-item">
                                            <span class="info-label">Check-In:</span>
                                            <span class="info-value">{{ ($ciTimeStr ? ($ciTimeStr.' - ') : '') . $ciDateStr }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Check-Out:</span>
                                            <span class="info-value">{{ ($coTimeStr ? ($coTimeStr.' - ') : '') . $coDateStr }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Tour Type:</span>
                                            <span class="info-value">{{ ucwords(str_replace('_',' ', $notification->booking->tour_type ?? '')) }}</span>
                                        </div>
                                    </div>
                                    
                                    {{-- Pricing Breakdown --}}
                                    @php
                                        $roomPrice = $notification->booking->base_room_price ?? ($notification->booking->room ? $notification->booking->room->price_per_night : 0);
                                        $extraPersonCharge = $notification->booking->extra_person_charge ?? 0;
                                        $seniorDiscount = $notification->booking->senior_discount ?? 0;
                                        $pwdDiscount = $notification->booking->pwd_discount ?? 0;
                                        $finalRoomPrice = $notification->booking->final_total_price ?? $roomPrice;
                                        
                                        $boatPrice = 0;
                                        if ($notification->booking->assignedBoat) {
                                            $boatPrice = $notification->booking->assignedBoat->boat_prices ?? 0;
                                        } elseif ($notification->booking->boat_price) {
                                            $boatPrice = $notification->booking->boat_price;
                                        }
                                        $totalPrice = $finalRoomPrice + $boatPrice;
                                        
                                        // Calculate subtotal for discount calculation display
                                        $subtotal = $roomPrice + $extraPersonCharge;
                                        $pricePerPerson = $notification->booking->number_of_guests > 0 ? $subtotal / $notification->booking->number_of_guests : 0;
                                    @endphp
                                    
                                    <div class="pricing-breakdown">
                                        <div class="pricing-header">
                                            <i class="fas fa-calculator"></i>
                                            <h6>Pricing Breakdown</h6>
                                        </div>
                                        <div class="pricing-details">
                                            <div class="pricing-item">
                                                <span class="pricing-label">Room Base Price</span>
                                                <span class="pricing-value">₱{{ number_format($roomPrice, 2) }}</span>
                                            </div>
                                            @if($extraPersonCharge > 0)
                                                <div class="pricing-item extra-charge">
                                                    <span class="pricing-label">
                                                        Extra Person Charge 
                                                        @if($notification->booking->room)
                                                            ({{ $notification->booking->number_of_guests - $notification->booking->room->max_guests }} extra × ₱300)
                                                        @endif
                                                    </span>
                                                    <span class="pricing-value">₱{{ number_format($extraPersonCharge, 2) }}</span>
                                                </div>
                                            @endif
                                            @if($seniorDiscount > 0)
                                                <div class="pricing-item discount">
                                                    <span class="pricing-label">
                                                        Senior Discount (20%)
                                                        @if($notification->booking->num_senior_citizens > 0)
                                                            (₱{{ number_format($pricePerPerson, 2) }} × {{ $notification->booking->num_senior_citizens }} senior{{ $notification->booking->num_senior_citizens > 1 ? 's' : '' }})
                                                        @endif
                                                    </span>
                                                    <span class="pricing-value">-₱{{ number_format($seniorDiscount, 2) }}</span>
                                                </div>
                                            @endif
                                            @if($pwdDiscount > 0)
                                                <div class="pricing-item discount">
                                                    <span class="pricing-label">
                                                        PWD Discount (20%)
                                                        @if($notification->booking->num_pwds > 0)
                                                            (₱{{ number_format($pricePerPerson, 2) }} × {{ $notification->booking->num_pwds }} PWD{{ $notification->booking->num_pwds > 1 ? 's' : '' }})
                                                        @endif
                                                    </span>
                                                    <span class="pricing-value">-₱{{ number_format($pwdDiscount, 2) }}</span>
                                                </div>
                                            @endif
                                            @if($boatPrice > 0)
                                                <div class="pricing-item">
                                                    <span class="pricing-label">Boat Price</span>
                                                    <span class="pricing-value">₱{{ number_format($boatPrice, 2) }}</span>
                                                </div>
                                            @endif
                                            <div class="pricing-item total">
                                                <span class="pricing-label">Total Amount</span>
                                                <span class="pricing-value">₱{{ number_format($totalPrice, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

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
                                        <div class="mb-2 text-muted small">Thank you for visiting. You can request an extension below if needed.</div>
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
        </div>
    </div>


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

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
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

        .notification-card:last-child {
            margin-bottom: 0;
        }

        .notification-card.unread {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-left: 4px solid #007bff;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
        }

        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
        }

        .notification-card.unread:hover {
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.25);
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notification-time::before {
            content: "🕒";
            font-size: 0.8rem;
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
        /* Booking Details Section */
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

        /* Pricing Breakdown Section */
        .pricing-breakdown {
            margin: 1rem 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #fff8e1 0%, #ffffff 100%);
            border-radius: 12px;
            border-left: 4px solid #ff9800;
            box-shadow: 0 2px 10px rgba(255, 152, 0, 0.1);
        }

        .pricing-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            color: #ff9800;
        }

        .pricing-header h6 {
            margin: 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .pricing-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .pricing-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            border: 1px solid rgba(255, 152, 0, 0.1);
        }

        .pricing-item.extra-charge {
            background: rgba(255, 193, 7, 0.1);
            border-color: rgba(255, 193, 7, 0.3);
        }

        .pricing-item.discount {
            background: rgba(40, 167, 69, 0.1);
            border-color: rgba(40, 167, 69, 0.3);
        }

        .pricing-item.total {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: white;
            font-weight: 600;
            border: none;
        }

        .pricing-label {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .pricing-value {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .pricing-item.total .pricing-label,
        .pricing-item.total .pricing-value {
            color: white;
        }

        /* Boat Info Section */
        .boat-info-section {
            margin: 1rem 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border-left: 4px solid #28a745;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.1);
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
            padding: 0.5rem;
            background: rgba(40, 167, 69, 0.05);
            border-radius: 8px;
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
            min-height: 44px; /* Minimum touch target size */
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

        /* Responsive Design */
        
        /* Large Desktop (1200px and up) */
        @media (min-width: 1200px) {
            .notifications-section {
                max-width: 1200px;
                margin: 2rem auto;
            }
            
            .booking-details-grid,
            .boat-info-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Desktop (992px to 1199px) */
        @media (max-width: 1199px) and (min-width: 992px) {
            .booking-details-grid,
            .boat-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Tablet (768px to 991px) */
        @media (max-width: 991px) and (min-width: 768px) {
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

            .booking-details-grid,
            .boat-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .notification-actions {
                flex-direction: column;
            }

            .notification-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .notification-actions .btn:last-child {
                margin-bottom: 0;
            }
        }

        /* Mobile Landscape (576px to 767px) */
        @media (max-width: 767px) and (min-width: 576px) {
            .page-header {
                padding: 1.5rem 1rem;
                margin-bottom: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .page-title {
                font-size: 2.2rem;
            }

            .page-subtitle {
                font-size: 0.95rem;
            }

            .notifications-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1.5rem;
            }

            .unread-info {
                flex-direction: column;
                gap: 0.75rem;
            }

            .notifications-list {
                padding: 1rem;
            }

            .notification-card {
                margin-bottom: 1rem;
            }

            .notification-header {
                padding: 1rem;
                flex-direction: column;
                text-align: center;
            }

            .notification-icon {
                align-self: center;
            }

            .booking-details-section,
            .pricing-breakdown,
            .boat-info-section {
                margin: 0.75rem 1rem;
                padding: 1rem;
            }

            .booking-details-grid,
            .boat-info-grid {
                grid-template-columns: 1fr;
            }

            .pricing-details {
                gap: 0.25rem;
            }

            .pricing-item {
                padding: 0.5rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .pricing-label,
            .pricing-value {
                font-size: 0.85rem;
            }

            .notification-actions {
                flex-direction: column;
                padding: 1rem;
            }

            .notification-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .notification-actions .btn:last-child {
                margin-bottom: 0;
            }
        }

        /* Mobile Portrait (up to 575px) */
        @media (max-width: 575px) {
            .page-header {
                padding: 1rem 0.75rem;
                margin-bottom: 1rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .page-subtitle {
                font-size: 0.9rem;
            }

            .notifications-header {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
                padding: 1rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .section-subtitle {
                font-size: 0.9rem;
            }

            .unread-info {
                flex-direction: column;
                gap: 0.5rem;
            }

            .unread-badge {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }

            .notifications-list {
                padding: 0.75rem;
            }

            .notification-card {
                margin-bottom: 0.75rem;
            }

            .notification-header {
                padding: 0.75rem;
                flex-direction: column;
                text-align: center;
            }

            .notification-icon {
                align-self: center;
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .notification-title {
                font-size: 1rem;
            }

            .notification-time {
                font-size: 0.8rem;
            }

            .booking-details-section,
            .pricing-breakdown,
            .boat-info-section {
                margin: 0.5rem 0.75rem;
                padding: 0.75rem;
            }

            .booking-details-header h6,
            .pricing-header h6,
            .boat-info-header h6 {
                font-size: 0.9rem;
            }

            .booking-details-grid,
            .boat-info-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .booking-details-grid .info-item,
            .boat-info-grid .info-item {
                padding: 0.4rem;
            }

            .booking-details-grid .info-label,
            .boat-info-grid .info-label {
                font-size: 0.8rem;
            }

            .booking-details-grid .info-value,
            .boat-info-grid .info-value {
                font-size: 0.85rem;
            }

            .pricing-details {
                gap: 0.25rem;
            }

            .pricing-item {
                padding: 0.4rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .pricing-label,
            .pricing-value {
                font-size: 0.8rem;
            }

            .boat-info-note {
                font-size: 0.8rem;
                padding: 0.5rem;
            }

            .notification-actions {
                flex-direction: column;
                padding: 0.75rem;
            }

            .notification-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }

            .notification-actions .btn:last-child {
                margin-bottom: 0;
            }

            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .empty-title {
                font-size: 1.5rem;
            }

            .empty-description {
                font-size: 1rem;
            }
        }

        /* Extra Small Devices (up to 375px) */
        @media (max-width: 375px) {
            .page-header {
                padding: 0.75rem 0.5rem;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .notifications-header {
                padding: 0.75rem;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .notifications-list {
                padding: 0.5rem;
            }

            .notification-header {
                padding: 0.5rem;
            }

            .booking-details-section,
            .pricing-breakdown,
            .boat-info-section {
                margin: 0.4rem 0.5rem;
                padding: 0.5rem;
            }

            .notification-actions {
                padding: 0.5rem;
            }

            .empty-state {
                padding: 1.5rem 0.75rem;
            }

            .empty-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .empty-title {
                font-size: 1.3rem;
            }
        }

        /* Landscape Orientation Adjustments */
        @media (max-height: 500px) and (orientation: landscape) {
            .page-header {
                padding: 1rem 1.5rem;
                margin-bottom: 1rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .notifications-header {
                padding: 1rem;
            }

            .notification-header {
                padding: 0.75rem;
            }

            .booking-details-section,
            .pricing-breakdown,
            .boat-info-section {
                margin: 0.5rem 1rem;
                padding: 0.75rem;
            }
        }

        /* Responsive Utilities */
        .d-none-mobile {
            display: block;
        }

        .d-block-mobile {
            display: none;
        }

        @media (max-width: 767px) {
            .d-none-mobile {
                display: none;
            }

            .d-block-mobile {
                display: block;
            }
        }

        /* Touch-friendly improvements */
        .notification-card {
            -webkit-tap-highlight-color: transparent;
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Improved text selection */
        .notification-content,
        .booking-details-section,
        .pricing-breakdown,
        .boat-info-section {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }

        /* Better focus states for accessibility */
        .btn:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }

        .notification-card:focus-within {
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.25);
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

            /* Improve mobile scrolling */
            .notifications-section {
                overflow-x: hidden;
            }

            /* Better mobile text wrapping */
            .notification-title,
            .pricing-label,
            .booking-details-grid .info-value,
            .boat-info-grid .info-value {
                word-wrap: break-word;
                overflow-wrap: break-word;
            }

            /* Mobile-friendly form elements */
            .form-select,
            .form-control {
                min-height: 44px;
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .notification-icon,
            .empty-icon {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }
        }

        /* Print styles */
        @media print {
            .notification-actions,
            .btn {
                display: none !important;
            }

            .notification-card {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid #000;
            }

            .notifications-section {
                box-shadow: none;
                background: white;
            }
        }

        .swal2-confirm-responsive,
        .swal2-cancel-responsive {
            font-size: 12px !important;
            padding: 6px 12px !important;
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

        // Mobile sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</x-app-layout>
