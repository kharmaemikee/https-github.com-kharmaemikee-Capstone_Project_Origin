<x-app-layout>
    <head>
        {{-- Font Awesome CDN for Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        {{-- Bootstrap Icons CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        {{-- SweetAlert2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        <div class="main-content flex-grow-1">
            {{-- Main Content --}}
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
                {{-- Modern Header Section --}}
                <div class="page-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="header-text">
                        <h1 class="page-title">Your Visits</h1>
                        <p class="page-subtitle">Manage your bookings and travel plans</p>
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
            </div>

            {{-- Bookings Section --}}
            <div class="bookings-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-list-alt me-2"></i>
                        My Bookings
                    </h2>
                    <p class="section-subtitle">View and manage your current reservations</p>
                </div>
                @if ($bookings->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h3 class="empty-title">No Bookings Yet</h3>
                        <p class="empty-description">You don't have any current bookings. Start exploring our amazing resorts!</p>
                        <a href="{{ route('tourist.tourist') }}" class="empty-action-btn">
                            <i class="fas fa-search me-2"></i>
                            Explore Resorts
                        </a>
                    </div>
                @else
                    <div class="bookings-grid">
                        @foreach ($bookings as $booking)
                            <div class="booking-card">
                                <div class="booking-header">
                                    <div class="booking-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="booking-title-section">
                                        <h3 class="booking-title">{{ $booking->room->room_name ?? 'N/A' }}</h3>
                                        <p class="booking-resort">{{ $booking->name_of_resort }}</p>
                                    </div>
                                    <div class="booking-guests">
                                        <span class="guests-badge">
                                            <i class="fas fa-users"></i>
                                            {{ $booking->number_of_guests }}
                                        </span>
                                    </div>
                                </div>

                                <div class="booking-content">
                                    @php
                                        $ci = null; $co = null; $ciTime = null; $coTime = null;
                                        try { $ci = \Carbon\Carbon::parse((string)$booking->check_in_date); } catch (\Exception $e) { $ci = null; }
                                        try { $co = $booking->check_out_date ? \Carbon\Carbon::parse((string)$booking->check_out_date) : null; } catch (\Exception $e) { $co = null; }
                                        if (($booking->tour_type ?? '') === 'day_tour') {
                                            try { $ciTime = $booking->day_tour_departure_time ? \Carbon\Carbon::parse((string)$booking->check_in_date.' '.(string)$booking->day_tour_departure_time) : null; } catch (\Exception $e) { $ciTime = null; }
                                            try { $coTime = ($booking->day_tour_time_of_pickup ?? null) ? \Carbon\Carbon::parse((string)($co?->toDateString() ?: $ci?->toDateString()).' '.(string)$booking->day_tour_time_of_pickup) : null; } catch (\Exception $e) { $coTime = null; }
                                        } else {
                                            try { $ciTime = $booking->overnight_date_time_of_departure ? \Carbon\Carbon::parse((string)$booking->overnight_date_time_of_departure) : ($booking->overnight_departure_time ? \Carbon\Carbon::parse((string)$booking->overnight_departure_time) : null); } catch (\Exception $e) { $ciTime = null; }
                                            try { $coTime = $booking->overnight_date_time_of_pickup ? \Carbon\Carbon::parse((string)$booking->overnight_date_time_of_pickup) : null; } catch (\Exception $e) { $coTime = null; }
                                        }
                                        $ciDateStr = $ci ? $ci->format('M d, Y') : ($booking->check_in_date ?? '');
                                        $coDateStr = ($co ?: $ci) ? ($co ?: $ci)->format('M d, Y') : ($booking->check_out_date ?? $booking->check_in_date ?? '');
                                        $ciTimeStr = $ciTime ? $ciTime->format('h:i A') : null;
                                        $coTimeStr = $coTime ? $coTime->format('h:i A') : null;
                                        if (!$ciTimeStr) {
                                            if (($booking->tour_type ?? '') === 'day_tour' && $booking->day_tour_departure_time) {
                                                try { $ciTimeStr = \Carbon\Carbon::parse((string)$booking->day_tour_departure_time)->format('h:i A'); } catch (\Exception $e) { $ciTimeStr = (string)$booking->day_tour_departure_time; }
                                            } elseif (($booking->tour_type ?? '') === 'overnight' && ($booking->overnight_date_time_of_departure ?? $booking->overnight_departure_time)) {
                                                try { $ciTimeStr = \Carbon\Carbon::parse((string)($booking->overnight_date_time_of_departure ?? $booking->overnight_departure_time))->format('h:i A'); } catch (\Exception $e) { $ciTimeStr = (string)($booking->overnight_date_time_of_departure ?? $booking->overnight_departure_time); }
                                            }
                                        }
                                        if (!$coTimeStr) {
                                            if (($booking->tour_type ?? '') === 'day_tour' && ($booking->day_tour_time_of_pickup ?? null)) {
                                                try { $coTimeStr = \Carbon\Carbon::parse((string)$booking->day_tour_time_of_pickup)->format('h:i A'); } catch (\Exception $e) { $coTimeStr = (string)$booking->day_tour_time_of_pickup; }
                                            } elseif (($booking->tour_type ?? '') === 'overnight' && $booking->overnight_date_time_of_pickup) {
                                                try { $coTimeStr = \Carbon\Carbon::parse((string)$booking->overnight_date_time_of_pickup)->format('h:i A'); } catch (\Exception $e) { $coTimeStr = (string)$booking->overnight_date_time_of_pickup; }
                                            }
                                        }
                                    @endphp
                                    <div class="booking-dates">
                                        <div class="date-item">
                                            <i class="fas fa-calendar-plus"></i>
                                            <div class="date-info">
                                                <span class="date-label">Check-In</span>
                                                <span class="date-value">{{ ($ciTimeStr ? ($ciTimeStr.' - ') : '') . $ciDateStr }}</span>
                                            </div>
                                        </div>
                                        <div class="date-item">
                                            <i class="fas fa-calendar-minus"></i>
                                            <div class="date-info">
                                                <span class="date-label">Check-Out</span>
                                                <span class="date-value">{{ ($coTimeStr ? ($coTimeStr.' - ') : '') . $coDateStr }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($booking->room)
                                        <div class="booking-price">
                                            <div class="price-item">
                                                <i class="fas fa-bed"></i>
                                                <span class="price-label">Room Price</span>
                                                <span class="price-value">₱{{ number_format($booking->room->price_per_night, 2) }}/Per Stay</span>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Boat Information --}}
                                    <div class="booking-boat">
                                        <h6 class="boat-title">
                                            <i class="fas fa-ship me-2"></i>
                                            Boat Information
                                        </h6>
                                        <div class="boat-details">
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $showAssignment = false;
                                                $windowTime = null;
                                                if ($booking->tour_type === 'day_tour' && $booking->day_tour_departure_time) {
                                                    try {
                                                        $windowTime = \Carbon\Carbon::parse((string)$booking->check_in_date.' '.(string)$booking->day_tour_departure_time);
                                                    } catch (\Exception $e) { $windowTime = null; }
                                                } elseif ($booking->tour_type === 'overnight' && $booking->overnight_date_time_of_pickup) {
                                                    try {
                                                        $windowTime = \Carbon\Carbon::parse((string)$booking->overnight_date_time_of_pickup);
                                                    } catch (\Exception $e) { $windowTime = null; }
                                                }
                                                if ($windowTime) { $showAssignment = $now->gte($windowTime); }
                                            @endphp
                                            @if($showAssignment && $booking->assignedBoat && $booking->assignedBoat->user)
                                                <div class="boat-item">
                                                    <i class="fas fa-user"></i>
                                                    <span class="boat-label">Captain</span>
                                                    <span class="boat-value">{{ $booking->assignedBoat->user->name ?? 'N/A' }}</span>
                                                </div>
                                                <div class="boat-item">
                                                    <i class="fas fa-phone"></i>
                                                    <span class="boat-label">Contact</span>
                                                    <span class="boat-value">{{ $booking->assignedBoat->user->phone ?? 'N/A' }}</span>
                                                </div>
                                                <div class="boat-item">
                                                    <i class="fas fa-ship"></i>
                                                    <span class="boat-label">Boat</span>
                                                    <span class="boat-value">{{ $booking->assignedBoat->boat_name ?? 'N/A' }}</span>
                                                </div>
                                                <div class="boat-item">
                                                    <i class="fas fa-tag"></i>
                                                    <span class="boat-label">Price</span>
                                                    <span class="boat-value">₱{{ number_format($booking->assignedBoat->boat_prices ?? 0, 2) }}</span>
                                                </div>
                                            @elseif($showAssignment && $booking->boat_captain_crew && $booking->boat_captain_crew !== 'N/A')
                                                <div class="boat-item">
                                                    <i class="fas fa-user"></i>
                                                    <span class="boat-label">Captain</span>
                                                    <span class="boat-value">{{ $booking->boat_captain_crew }}</span>
                                                </div>
                                                <div class="boat-item">
                                                    <i class="fas fa-phone"></i>
                                                    <span class="boat-label">Contact</span>
                                                    <span class="boat-value">{{ $booking->boat_contact_number ?? 'N/A' }}</span>
                                                </div>
                                                <div class="boat-item">
                                                    <i class="fas fa-ship"></i>
                                                    <span class="boat-label">Boat</span>
                                                    <span class="boat-value">{{ $booking->assigned_boat ?? 'N/A' }}</span>
                                                </div>
                                                <div class="boat-item">
                                                    <i class="fas fa-tag"></i>
                                                    <span class="boat-label">Price</span>
                                                    <span class="boat-value">₱{{ number_format($booking->boat_price ?? 0, 2) }}</span>
                                                </div>
                                            @else
                                                <div class="boat-item">
                                                    <i class="fas fa-clock"></i>
                                                    <span class="boat-label">Status</span>
                                                    <span class="boat-value">Waiting to assign the boat on your booking date at the departure time</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Special Requirements --}}
                                    @if ($booking->num_senior_citizens > 0 || $booking->num_pwds > 0)
                                        <div class="booking-requirements">
                                            <h6 class="requirements-title">
                                                <i class="fas fa-heart me-2"></i>
                                                Special Requirements
                                            </h6>
                                            <div class="requirements-list">
                                                @if ($booking->num_senior_citizens > 0)
                                                    <span class="requirement-badge">
                                                        <i class="fas fa-user-clock"></i>
                                                        {{ $booking->num_senior_citizens }} Senior Citizens
                                                    </span>
                                                @endif
                                                @if ($booking->num_pwds > 0)
                                                    <span class="requirement-badge">
                                                        <i class="fas fa-wheelchair"></i>
                                                        {{ $booking->num_pwds }} PWDs
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- {{-- Tour Details --}}
                                    @if ($booking->tour_type === 'day_tour')
                                        <div class="booking-tour">
                                            <h6 class="tour-title">
                                                <i class="fas fa-sun me-2"></i>
                                                Day Tour Details
                                            </h6>
                                            <div class="tour-details">
                                                <div class="tour-item">
                                                    <i class="fas fa-plane-departure"></i>
                                                    <span class="tour-label">Departure</span>
                                                    <span class="tour-value">
                                                        @php
                                                            try { echo \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('h:i A'); }
                                                            catch(\Exception $e) { echo $booking->day_tour_departure_time; }
                                                        @endphp
                                                    </span>
                                                </div>
                                                <div class="tour-item">
                                                    <i class="fas fa-car"></i>
                                                    <span class="tour-label">Pickup</span>
                                                    <span class="tour-value">
                                                        @php
                                                            try { echo \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('h:i A'); }
                                                            catch(\Exception $e) { echo $booking->day_tour_time_of_pickup; }
                                                        @endphp
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif ($booking->tour_type === 'overnight')
                                        <div class="booking-tour">
                                            <h6 class="tour-title">
                                                <i class="fas fa-moon me-2"></i>
                                                Overnight Details
                                            </h6>
                                            <div class="tour-details">
                                                <div class="tour-item">
                                                    <i class="fas fa-plane-departure"></i>
                                                    <span class="tour-label">Departure</span>
                                                    <span class="tour-value">
                                                        @php
                                                            try { echo \Carbon\Carbon::parse($booking->overnight_departure_time)->format('h:i A'); }
                                                            catch(\Exception $e) { echo $booking->overnight_departure_time; }
                                                        @endphp
                                                    </span>
                                                </div>
                                                <div class="tour-item">
                                                    <i class="fas fa-car"></i>
                                                    <span class="tour-label">Pickup</span>
                                                    <span class="tour-value">
                                                        @php
                                                            try { echo \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('M d, Y h:i A'); }
                                                            catch(\Exception $e) { echo $booking->overnight_date_time_of_pickup; }
                                                        @endphp
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif -->

                                    {{-- Total Price --}}
                                    @php
                                        $roomPrice = $booking->base_room_price ?? ($booking->room ? $booking->room->price_per_night : 0);
                                        $extraPersonCharge = $booking->extra_person_charge ?? 0;
                                        $seniorDiscount = $booking->senior_discount ?? 0;
                                        $pwdDiscount = $booking->pwd_discount ?? 0;
                                        $finalRoomPrice = $booking->final_total_price ?? $roomPrice;
                                        
                                        $boatPrice = 0;
                                        if ($booking->assignedBoat) {
                                            $boatPrice = $booking->assignedBoat->boat_prices ?? 0;
                                        } elseif ($booking->boat_price) {
                                            $boatPrice = $booking->boat_price;
                                        }
                                        $totalPrice = $finalRoomPrice + $boatPrice;
                                        
                                        // Calculate subtotal for discount calculation display
                                        $subtotal = $roomPrice + $extraPersonCharge;
                                        $pricePerPerson = $booking->number_of_guests > 0 ? $subtotal / $booking->number_of_guests : 0;
                                    @endphp
                                    
                                    @if($totalPrice > 0)
                                        <div class="booking-total">
                                            <h6 class="total-title">
                                                <i class="fas fa-calculator me-2"></i>
                                                Total Cost Breakdown
                                            </h6>
                                            <div class="total-breakdown">
                                                @if($roomPrice > 0)
                                                    <div class="total-item">
                                                        <span class="total-label">Room Base Price</span>
                                                        <span class="total-value">₱{{ number_format($roomPrice, 2) }}</span>
                                                    </div>
                                                @endif
                                                @if($extraPersonCharge > 0)
                                                    <div class="total-item">
                                                        <span class="total-label">Extra Person Charge</span>
                                                        <span class="total-value">₱{{ number_format($extraPersonCharge, 2) }}</span>
                                                    </div>
                                                @endif
                                                @if($seniorDiscount > 0)
                                                    <div class="total-item discount">
                                                        <span class="total-label">
                                                            Senior Discount (20%)
                                                            @if($booking->num_senior_citizens > 0)
                                                                (₱{{ number_format($pricePerPerson, 2) }} × {{ $booking->num_senior_citizens }} senior{{ $booking->num_senior_citizens > 1 ? 's' : '' }})
                                                            @endif
                                                        </span>
                                                        <span class="total-value">-₱{{ number_format($seniorDiscount, 2) }}</span>
                                                    </div>
                                                @endif
                                                @if($pwdDiscount > 0)
                                                    <div class="total-item discount">
                                                        <span class="total-label">
                                                            PWD Discount (20%)
                                                            @if($booking->num_pwds > 0)
                                                                (₱{{ number_format($pricePerPerson, 2) }} × {{ $booking->num_pwds }} PWD{{ $booking->num_pwds > 1 ? 's' : '' }})
                                                            @endif
                                                        </span>
                                                        <span class="total-value">-₱{{ number_format($pwdDiscount, 2) }}</span>
                                                    </div>
                                                @endif
                                                @if($boatPrice > 0)
                                                    <div class="total-item">
                                                        <span class="total-label">Boat</span>
                                                        <span class="total-value">₱{{ number_format($boatPrice, 2) }}</span>
                                                    </div>
                                                @endif
                                                <div class="total-item total-final">
                                                    <span class="total-label">Total</span>
                                                    <span class="total-value">₱{{ number_format($totalPrice, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Status and Actions --}}
                                    <div class="booking-footer">
                                        <div class="booking-status">
                                            <span class="status-label">Status:</span>
                                            @if ($booking->display_status === 'pending')
                                                <span class="status-badge status-pending">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Awaiting Approval
                                                </span>
                                            @elseif ($booking->display_status === 'approved')
                                                <span class="status-badge status-approved">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Approved!
                                                </span>
                                            @elseif ($booking->display_status === 'rejected')
                                                <span class="status-badge status-rejected">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    Rejected
                                                </span>
                                            @elseif ($booking->display_status === 'cancelled')
                                                <span class="status-badge status-cancelled">
                                                    <i class="fas fa-ban me-1"></i>
                                                    Cancelled
                                                </span>
                                            @elseif ($booking->display_status === 'completed')
                                                <span class="status-badge status-completed">
                                                    <i class="fas fa-check-double me-1"></i>
                                                    Completed
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="booking-actions">
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="action-btn view-btn">
                                                <i class="fas fa-eye me-1"></i>
                                                View Details
                                            </a>
                                            @if ($booking->display_status === 'pending')
                                                <button type="button" class="action-btn cancel-btn cancel-booking-btn" data-booking-id="{{ $booking->id }}" data-cancel-url="{{ route('bookings.cancel', $booking->id) }}">
                                                    <i class="fas fa-times me-1"></i>
                                                    Cancel
                                                </button>
                                            @endif
                                            @if (in_array($booking->display_status, ['approved', 'rejected', 'cancelled', 'completed']))
                                                <button type="button" class="action-btn delete-btn delete-booking-btn" data-booking-id="{{ $booking->id }}">
                                                    <i class="fas fa-trash me-1"></i>
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Pagination for Bookings --}}
                    @if ($bookings->hasPages())
                        <div class="pagination-container">
                            {{ $bookings->links('vendor.pagination.tourist') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
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

        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Modern Visit Page Styling */


        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 85vw !important;
        }

        /* Ensure proper offcanvas behavior */
        .offcanvas-backdrop {
            z-index: 1040;
        }

        .offcanvas.show {
            z-index: 1045;
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

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
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

        /* Bookings Section */
        .bookings-section {
            margin-bottom: 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 1rem 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-title i {
            color: #007bff;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .empty-icon {
            font-size: 4rem;
            color: #007bff;
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1rem 0;
        }

        .empty-description {
            font-size: 1rem;
            color: #6c757d;
            margin: 0 0 2rem 0;
        }

        .empty-action-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .empty-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Bookings Grid */
        .bookings-grid {
            display: grid;
            gap: 2rem;
        }

        /* Booking Card */
        .booking-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .booking-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .booking-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .booking-title-section {
            flex: 1;
        }

        .booking-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
        }

        .booking-resort {
            font-size: 1rem;
            color: #6c757d;
            margin: 0;
        }

        .booking-guests {
            flex-shrink: 0;
        }

        .guests-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .booking-content {
            padding: 1.5rem;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
        }

        .status-approved {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .status-rejected {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .status-completed {
            background: linear-gradient(135deg, #cce5ff 0%, #b3d9ff 100%);
            color: #004085;
        }

        /* Booking Details Styles */
        .booking-dates {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .date-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border-left: 4px solid #007bff;
        }

        .date-item i {
            color: #007bff;
            font-size: 1.2rem;
        }

        .date-info {
            display: flex;
            flex-direction: column;
        }

        .date-label {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-value {
            font-size: 1rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .booking-price {
            margin-bottom: 1.5rem;
        }

        .price-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 12px;
            border-left: 4px solid #2196f3;
        }

        .price-item i {
            color: #2196f3;
            font-size: 1.2rem;
        }

        .price-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }

        .price-value {
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 700;
            margin-left: auto;
        }

        .booking-boat, .booking-requirements, .booking-tour {
            margin-bottom: 1.5rem;
        }

        .boat-title, .requirements-title, .tour-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
        }

        .boat-title i { color: #007bff; }
        .requirements-title i { color: #e91e63; }
        .tour-title i { color: #ff9800; }

        .boat-details, .tour-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
        }

        .boat-item, .tour-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
        }

        .boat-item i, .tour-item i {
            color: #6c757d;
            font-size: 0.9rem;
            width: 16px;
        }

        .boat-label, .tour-label {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
            min-width: 60px;
        }

        .boat-value, .tour-value {
            font-size: 0.9rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .requirements-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .requirement-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #e91e63 0%, #f06292 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .booking-total {
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            border-radius: 12px;
            border-left: 4px solid #4caf50;
        }

        .total-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
        }

        .total-title i {
            color: #4caf50;
        }

        .total-breakdown {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .total-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .total-item.total-final {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            padding-top: 1rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .total-label {
            color: #6c757d;
            font-weight: 500;
        }

        .total-value {
            color: #2c3e50;
            font-weight: 600;
        }

        .booking-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .booking-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }

        .booking-actions {
            display: flex;
            gap: 0.75rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .view-btn {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .cancel-btn {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            color: #212529;
        }

        .cancel-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }

        .delete-btn {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            .sidebar {
                display: none;
            }

            .main-content {
                padding: 1rem;
            }

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

            .section-title {
                font-size: 2rem;
            }

            .booking-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .booking-dates {
                grid-template-columns: 1fr;
            }

            .boat-details, .tour-details {
                grid-template-columns: 1fr;
            }

            .booking-footer {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .booking-actions {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .booking-card {
                margin: 0 -0.5rem;
            }

            .booking-content {
                padding: 1rem;
            }

            .booking-footer {
                padding: 1rem;
            }

            .action-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }

        /* SweetAlert2 Responsive Styles */
        @media (max-width: 768px) {
            .swal2-popup {
                width: 90% !important;
                max-width: 400px !important;
            }
            
            .swal2-title {
                font-size: 1.2rem !important;
            }
            
            .swal2-content {
                font-size: 0.9rem !important;
            }
            
            .swal2-actions {
                flex-direction: column !important;
                gap: 0.5rem !important;
            }
            
            .swal2-confirm,
            .swal2-cancel {
                width: 100% !important;
                margin: 0 !important;
            }
        }

        @media (max-width: 480px) {
            .swal2-popup {
                width: 95% !important;
                margin: 0.5rem !important;
            }
            
            .swal2-title {
                font-size: 1.1rem !important;
            }
            
            .swal2-content {
                font-size: 0.85rem !important;
            }
        }

        /* Animation for cards */
        .booking-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Staggered animation for booking cards */
        .booking-card:nth-child(1) { animation-delay: 0.1s; }
        .booking-card:nth-child(2) { animation-delay: 0.2s; }
        .booking-card:nth-child(3) { animation-delay: 0.3s; }
        .booking-card:nth-child(4) { animation-delay: 0.4s; }
        .booking-card:nth-child(5) { animation-delay: 0.5s; }


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
                margin-left: 0;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
                margin-left: 0;
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

    {{-- Custom JavaScript for mobile sidebar behavior and SweetAlert2 handling --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    // Bootstrap's 'md' breakpoint is 768px
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Delete Booking Confirmation with SweetAlert2
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-booking-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.delete-booking-btn');
                    const bookingId = button.getAttribute('data-booking-id');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this! This will permanently delete the booking record.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send AJAX request to delete booking
                            fetch(`/tourist/bookings/${bookingId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Remove the booking card from DOM
                                    const bookingCard = button.closest('.col-md-12');
                                    bookingCard.remove();
                                    
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The booking has been deleted successfully.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive'
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: data.message || "Failed to delete the booking. Please try again.",
                                        icon: "error",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive'
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while deleting the booking. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive'
                                    }
                                });
                            });
                        }
                    });
                }
            });

            // Cancel Booking Confirmation with SweetAlert2
            document.addEventListener('click', function(e) {
                if (e.target.closest('.cancel-booking-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.cancel-booking-btn');
                    const bookingId = button.getAttribute('data-booking-id');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You want to cancel this booking? This action cannot be undone.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#ffc107",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, cancel it!",
                        cancelButtonText: "Back",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send AJAX request to cancel booking
                            const url = button.getAttribute('data-cancel-url') || `/bookings/${bookingId}/cancel`;
                            const formData = new FormData();
                            formData.append('_method', 'PUT');
                            formData.append('_token', csrfToken);
                            fetch(url, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(async response => {
                                // Try to parse JSON; if not JSON, treat 2xx as success
                                const contentType = response.headers.get('content-type') || '';
                                if (!contentType.includes('application/json')) {
                                    return { success: response.ok };
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Reload the page to show updated status
                                    location.reload();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: data.message || "Failed to cancel the booking. Please try again.",
                                        icon: "error",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive'
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while canceling the booking. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive'
                                    }
                                });
                            });
                        }
                    });
                }
            });
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