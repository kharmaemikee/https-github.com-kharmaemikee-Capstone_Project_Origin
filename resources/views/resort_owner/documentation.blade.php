<x-app-layout>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd); background-attachment: fixed; background-size: 100% 100%;">

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
            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-title-section">
                    <h1 class="page-title">
                        <i class="fas fa-file-alt me-2"></i>
                        Resort Documentation
                    </h1>
                    <p class="page-subtitle">View and manage booking documentation for your resort</p>
                </div>
            </div>

            {{-- Content Container --}}
            <div class="content-container">
                @php
                    $items = ($bookings instanceof \Illuminate\Pagination\AbstractPaginator)
                        ? $bookings->items()
                        : (is_iterable($bookings) ? $bookings : []);
                    $firstBooking = is_array($items) ? ($items[0] ?? null) : (collect($items)->first() ?? null);
                    $headerResortName = null;
                    try { $headerResortName = optional(optional(optional($firstBooking)->room)->resort)->resort_name; } catch (\Throwable $e) {}
                    if (!$headerResortName && $firstBooking && property_exists($firstBooking, 'name_of_resort')) {
                        $headerResortName = $firstBooking->name_of_resort;
                    }
                @endphp

                {{-- Search and Filter Section --}}
                <div class="search-filter-card">
                    <div class="search-filter-header">
                        <h3 class="search-filter-title">
                            <i class="fas fa-search me-2"></i>
                            Search & Filter
                        </h3>
                    </div>
                    <form method="GET" action="{{ route('resort.owner.documentation') }}" class="search-filter-form">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search" class="form-label">
                                        <i class="fas fa-user me-1"></i>
                                        Search Guest Name
                                    </label>
                                    <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control modern-input" placeholder="Enter guest name...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date" class="form-label">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        From Date
                                    </label>
                                    <input type="date" id="start_date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" class="form-control modern-input">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date" class="form-label">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        To Date
                                    </label>
                                    <input type="date" id="end_date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" class="form-control modern-input">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="form-check modern-checkbox">
                                        <input class="form-check-input" type="checkbox" id="showAll" name="all" value="1" {{ !empty($showAll) && $showAll ? 'checked' : '' }}>
                                        <label class="form-check-label" for="showAll">
                                            <i class="fas fa-list me-1"></i>
                                            Show all results
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="search-filter-actions">
                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="fas fa-search me-2"></i>
                                Apply Filters
                            </button>
                            <a href="{{ route('resort.owner.documentation') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Results Summary and Export Section --}}
                <div class="results-summary-card">
                    <div class="results-info">
                        <div class="results-count">
                            <i class="fas fa-list-alt me-2"></i>
                            <span class="results-text">
                                @if(!empty($showAll) && $showAll)
                                    Showing {{ is_countable($bookings) ? count($bookings) : 0 }} results (all)
                                @else
                                    Showing {{ $bookings->total() ?? 0 }} results
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="export-actions">
                        <a href="{{ route('resort.owner.documentation.export', request()->query()) }}" class="btn btn-success export-btn">
                            <i class="fas fa-file-csv me-2"></i>
                            Export CSV
                        </a>
                        <a href="{{ route('resort.owner.documentation.export_pdf', request()->query()) }}" class="btn btn-danger export-btn">
                            <i class="fas fa-file-pdf me-2"></i>
                            Export PDF
                        </a>
                    </div>
                </div>

                {{-- Documentation Table --}}
                <div class="table-card">
                    <div class="table-header">
                        <h3 class="table-title">
                            <i class="fas fa-table me-2"></i>
                            Booking Documentation
                        </h3>
                    </div>
                    <div id="docCapture" class="table-responsive modern-table-container">
                        <table class="table modern-table">
                            <thead class="table-header-row">
                                <tr>
                                    <th class="table-header-cell">
                                        <i class="fas fa-bed me-1"></i>
                                        Room
                                    </th>
                                    <th class="table-header-cell">
                                        <i class="fas fa-user me-1"></i>
                                        Tourist
                                    </th>
                                    <th class="table-header-cell">
                                        <i class="fas fa-route me-1"></i>
                                        Tour Type
                                    </th>
                                    <th class="table-header-cell">
                                        <i class="fas fa-sign-in-alt me-1"></i>
                                        Check-in
                                    </th>
                                    <th class="table-header-cell">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        Check-out
                                    </th>
                                    <th class="table-header-cell text-center">
                                        <i class="fas fa-cog me-1"></i>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @forelse($bookings as $booking)
                                    <tr class="table-row">
                                        <td class="table-cell">
                                            <div class="cell-content">
                                                <i class="fas fa-bed me-2 text-primary"></i>
                                                {{ optional($booking->room)->room_name ?? '—' }}
                                            </div>
                                        </td>
                                        <td class="table-cell">
                                            <div class="cell-content">
                                                <i class="fas fa-user me-2 text-info"></i>
                                                @php
                                                    $acctName = trim(((optional($booking->user)->first_name ?? '') . ' ' . (optional($booking->user)->last_name ?? '')));
                                                @endphp
                                                {{ $acctName !== '' ? $acctName : (optional($booking->user)->username ?? '—') }}
                                            </div>
                                        </td>
                                        <td class="table-cell">
                                            <div class="cell-content">
                                                <span class="tour-type-badge tour-type-{{ strtolower($booking->tour_type ?? 'unknown') }}">
                                                    {{ ucfirst($booking->tour_type ?? '—') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="table-cell" data-col="checkin">
                                            <div class="cell-content">
                                                <i class="fas fa-sign-in-alt me-2 text-primary"></i>
                                                @php
                                                    $ciText = '—';
                                                    try {
                                                        $ciBase = !empty($booking->check_in_date) ? \Carbon\Carbon::parse($booking->check_in_date) : null;
                                                        $reservationBase = !empty($booking->reservation_date) ? \Carbon\Carbon::parse($booking->reservation_date) : null;
                                                        // Always start from reservation date for Check-in display
                                                        $ci = $reservationBase ?: $ciBase;
                                                        // Check-in should display DEPARTURE time (going to resort)
                                                        if (($booking->tour_type ?? '') === 'day_tour' && !empty($booking->day_tour_departure_time)) {
                                                            // If full datetime provided in fill-up, use as-is; else merge time onto check-in date
                                                            if (strpos($booking->day_tour_departure_time, 'T') !== false || strpos($booking->day_tour_departure_time, ' ') !== false) {
                                                                $dep = \Carbon\Carbon::parse($booking->day_tour_departure_time);
                                                                $base = $reservationBase ?: $ciBase;
                                                                if ($base) { $ci = $base->copy()->setTime($dep->hour, $dep->minute, 0); }
                                                            } else {
                                                                // Use reservation date as base for day tours
                                                                $base = $reservationBase ?: $ciBase;
                                                                $ci = $base ? $base->copy()->setTimeFromTimeString($booking->day_tour_departure_time) : $ci;
                                                            }
                                                        } elseif (($booking->tour_type ?? '') === 'overnight' && !empty($booking->overnight_departure_time)) {
                                                            if (strpos($booking->overnight_departure_time, 'T') !== false) {
                                                                $dep = \Carbon\Carbon::parse($booking->overnight_departure_time);
                                                                $base = $reservationBase ?: $ciBase;
                                                                if ($base) { $ci = $base->copy()->setTime($dep->hour, $dep->minute, 0); }
                                                            } elseif ($reservationBase ?: $ciBase) {
                                                                $base = $reservationBase ?: $ciBase;
                                                                $ci = $base ? $base->copy()->setTimeFromTimeString($booking->overnight_departure_time) : $ci;
                                                            }
                                                        }
                                                        if ($ci) { $ciText = $ci->format('h:i A - M d, Y'); }
                                                    } catch (\Exception $e) { $ciText = '—'; }
                                                @endphp
                                                <span class="time-value">{{ $ciText }}</span>
                                            </div>
                                        </td>
                                        <td class="table-cell" data-col="checkout">
                                            <div class="cell-content">
                                                <i class="fas fa-sign-out-alt me-2 text-danger"></i>
                                                @php
                                                    $coText = '—';
                                                    try {
                                                        $ciBase = !empty($booking->check_in_date) ? \Carbon\Carbon::parse($booking->check_in_date) : null;
                                                        $coBase = !empty($booking->check_out_date) ? \Carbon\Carbon::parse($booking->check_out_date) : null;
                                                        $reservationBase = !empty($booking->reservation_date) ? \Carbon\Carbon::parse($booking->reservation_date) : null;
                                                        $co = $coBase;
                                                        // Check-out should display PICK-UP time (leaving resort)
                                                        if (($booking->tour_type ?? '') === 'day_tour' && !empty($booking->day_tour_time_of_pickup)) {
                                                            // If full datetime provided in fill-up, use as-is; else merge onto reservation date
                                                            if (strpos($booking->day_tour_time_of_pickup, 'T') !== false || strpos($booking->day_tour_time_of_pickup, ' ') !== false) {
                                                                $co = \Carbon\Carbon::parse($booking->day_tour_time_of_pickup);
                                                            } else {
                                                                // Use reservation date as base for day tours (ignore booking checkout)
                                                                $base = $reservationBase ?: $ciBase;
                                                                $co = $base ? $base->copy()->setTimeFromTimeString($booking->day_tour_time_of_pickup) : $co;
                                                            }
                                                        } elseif (($booking->tour_type ?? '') === 'overnight' && !empty($booking->overnight_date_time_of_pickup)) {
                                                            // Likely full datetime
                                                            $co = \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup);
                                                        }
                                                        if ($co) { $coText = $co->format('h:i A - M d, Y'); }
                                                    } catch (\Exception $e) { $coText = '—'; }
                                                @endphp
                                                <span class="time-value">{{ $coText }}</span>
                                            </div>
                                        </td>
                                        
                                        <td class="table-cell text-center">
                                            <div class="action-buttons">
                                                @php
                                                    $assignedBoat = optional($booking)->assignedBoat;
                                                @endphp
                                                <button type="button" class="btn btn-info btn-sm view-details-btn"
                                                        title="View details" aria-label="View details"
                                                        data-bs-toggle="modal" data-bs-target="#docViewModal"
                                                        data-guest-name="{{ $booking->guest_name ?? '' }}"
                                                        data-guest-age="{{ $booking->guest_age ?? '' }}"
                                                        data-guest-gender="{{ $booking->guest_gender ?? '' }}"
                                                        data-guest-address="{{ $booking->guest_address ?? '' }}"
                                                        data-guest-nationality="{{ $booking->guest_nationality ?? '' }}"
                                                        data-phone="{{ $booking->phone_number ?? '' }}"
                                                        data-downpayment="{{ $booking->downpayment_receipt_path ?? '' }}"
                                                        data-valid-id-type="{{ $booking->valid_id_type ?? '' }}"
                                                        data-valid-id="{{ $booking->valid_id_image_path ?? '' }}"
                                                        data-valid-id-number="{{ $booking->valid_id_number ?? '' }}"
                                                        data-senior-id="{{ $booking->senior_id_image_path ?? '' }}"
                                                        data-pwd-id="{{ $booking->pwd_id_image_path ?? '' }}"
                                                        data-extended="{{ ($booking->is_extended ?? false) ? 'Yes' : 'No' }}"
                                                        data-extension="{{ ($booking->is_extended ?? false) ? ('+' . ($booking->extension_value ?? '') . ' ' . ($booking->extension_type ?? '')) : '' }}"
                                                        data-check-in="{{ !empty($booking->check_in_date) ? (\Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d')) : '' }}"
                                                        data-check-out="{{ !empty($booking->check_out_date) ? (\Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d')) : '' }}"
                                                        data-tour-type="{{ $booking->tour_type ?? '' }}"
                                                        data-day-departure="{{ $booking->day_tour_departure_time ?? '' }}"
                                                        data-overnight-departure="{{ $booking->overnight_departure_time ?? '' }}"
                                                        data-day-pickup="{{ $booking->day_tour_time_of_pickup ?? '' }}"
                                                        data-overnight-pickup="{{ $booking->overnight_date_time_of_pickup ?? '' }}"
                                                        data-seniors="{{ $booking->num_senior_citizens ?? '' }}"
                                                        data-pwds="{{ $booking->num_pwds ?? '' }}"
                                                        data-boat-name="{{ $assignedBoat->boat_name ?? '' }}"
                                                        >
                                                    <i class="fas fa-eye me-1"></i>
                                                    View
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="table-row">
                                        <td colspan="6" class="table-cell text-center">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No bookings found</h5>
                                                <p class="text-muted">Try adjusting your search criteria or date range.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if(empty($showAll) || !$showAll)
                    <div class="pagination-container">
                        {{ $bookings->appends(request()->query())->links('vendor.pagination.resort-owner') }}
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

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
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
            margin-bottom: 2rem;
            border-left: 4px solid #007bff;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .page-title i {
            color: #007bff;
            font-size: 1.8rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
            font-weight: 400;
        }

        /* Content Container */
        .content-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Search and Filter Card */
        .search-filter-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .search-filter-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem 2rem;
            color: white;
        }

        .search-filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .search-filter-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            color: #6c757d;
            margin-right: 0.5rem;
        }

        .modern-input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .modern-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .modern-checkbox {
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .search-filter-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        .search-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        /* Results Summary Card */
        .results-summary-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .results-count {
            display: flex;
            align-items: center;
            color: #495057;
            font-weight: 500;
        }

        .results-count i {
            color: #007bff;
            margin-right: 0.5rem;
        }

        .export-actions {
            display: flex;
            gap: 1rem;
        }

        .export-btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .export-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 1.5rem 2rem;
            border-bottom: 2px solid #dee2e6;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: #495057;
            display: flex;
            align-items: center;
        }

        .table-title i {
            color: #007bff;
            margin-right: 0.5rem;
        }

        .modern-table-container {
            overflow-x: auto;
        }

        .modern-table {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-header-row {
            background: linear-gradient(135deg, #f8f9fa, #eef1f5);
        }

        .table-header-cell {
            background: transparent;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 700;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table-header-cell i {
            color: #6c757d;
            margin-right: 0.5rem;
        }

        .table-body {
            background: white;
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .table-row:hover {
            background: #f8f9ff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .table-cell {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border: none;
        }

        .cell-content {
            display: flex;
            align-items: center;
        }

        .cell-content i {
            font-size: 0.9rem;
        }

        .tour-type-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tour-type-overnight {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .tour-type-day_tour {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }

        .tour-type-unknown {
            background: #6c757d;
            color: white;
        }

        .time-value {
            font-weight: 500;
            color: #495057;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .view-details-btn {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .view-details-btn:hover {
            background: linear-gradient(135deg, #138496, #117a8b);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
        }

        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
        }

        .empty-state i {
            opacity: 0.5;
        }

        .pagination-container {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 55vw !important;
            z-index: 99999 !important;
        }

        /* Ensure offcanvas backdrop doesn't interfere */
        .offcanvas-backdrop {
            z-index: 99998 !important;
        }

        /* Override any app layout navigation z-index on mobile */
        @media (max-width: 767.98px) {
            nav.navbar {
                z-index: 1000 !important;
            }
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
            
            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .search-filter-form {
                padding: 1.5rem;
            }
            
            .search-filter-actions {
                flex-direction: column;
            }
            
            .results-summary-card {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .export-actions {
                justify-content: center;
            }
            
            .table-header-cell {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
            }
            
            .table-cell {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .page-header {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.3rem;
            }
            
            .search-filter-form {
                padding: 1rem;
            }
            
            .modern-table-container {
                font-size: 0.85rem;
            }
        }

        /* Style for the rotated icon */
        .collapse-icon img {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        /* Light badge variants for readability in table */
        .badge-light-success {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }

        .badge-light-warning {
            background-color: #fff3cd !important;
            color: #85640a !important;
            border: 1px solid #ffeeba !important;
        }

        .badge-light-danger {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border: 1px solid #f5c6cb !important;
        }

        .badge-light-info {
            background-color: #e0f7fa !important;
            color: #0c5460 !important;
            border: 1px solid #b8daff !important;
        }

        .badge-light-secondary {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
            border: 1px solid #d3d6da !important;
        }

        .badge-light-black {
            background-color: #f8f9fa !important;
            color: #212529 !important;
            border: 1px solid #dee2e6 !important;
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

    <!-- Modal for row details -->
    <div class="modal fade" id="docViewModal" tabindex="-1" aria-labelledby="docViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="modal-title-section">
                        <h5 class="modal-title" id="docViewModalLabel">
                            <i class="fas fa-user-circle me-2"></i>Booking Details
                        </h5>
                        <p class="modal-subtitle">Complete guest information and booking data</p>
                    </div>
                    <button type="button" class="btn-close modern-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modern-modal-body">
                    <div class="row g-3">
                        <!-- Guest Information Table -->
                        <div class="col-12">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-users me-2"></i>Guest Information
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Guest Name</th>
                                                <th>Age</th>
                                                <th>Nationality</th>
                                            </tr>
                                        </thead>
                                        <tbody id="docGuestTableBody">
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No guest information available</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-phone me-2"></i>Contact Information
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Phone:</span>
                                        <span class="info-value" id="docPhone">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Address:</span>
                                        <span class="info-value" id="docGuestAddress">N/A</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Information -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-calendar-alt me-2"></i>Booking Information
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Seniors:</span>
                                        <span class="info-value" id="docSeniors">—</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">PWDs:</span>
                                        <span class="info-value" id="docPwds">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Boat Information -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-ship me-2"></i>Boat Information
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Boat Name:</span>
                                        <span class="info-value" id="docBoatName">N/A</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <!-- Extension Information -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-clock me-2"></i>Extension Information
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Extended:</span>
                                        <span class="info-value" id="docExtended">No</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Extension Details:</span>
                                        <span class="info-value" id="docExtension">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Documents -->
                        <div class="col-12">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-file-alt me-2"></i>Documents
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Downpayment Receipt:</span>
                                        <span class="info-value">
                                            <button type="button" id="btnViewDownpaymentRO" class="btn btn-sm btn-outline-primary view-image-btn" style="display:none;">View</button>
                                        </span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Valid ID:</span>
                                        <span class="info-value">
                                            <span id="docValidIdTypeRO">—</span>
                                            <button type="button" id="btnViewValidIdRO" class="btn btn-sm btn-outline-primary ms-2 view-image-btn" style="display:none;">View</button>
                                        </span>
                                    </div>
                                    <div class="info-item" id="docValidIdNumberRowRO" style="display:none;">
                                        <span class="info-label">ID Number:</span>
                                        <span class="info-value" id="docValidIdNumberRO">—</span>
                                    </div>
                                    <div class="info-item" id="docSeniorIdRowRO" style="display:none;">
                                        <span class="info-label">Senior ID:</span>
                                        <span class="info-value">
                                            <button type="button" id="btnViewSeniorIdRO" class="btn btn-sm btn-outline-primary view-image-btn">View</button>
                                        </span>
                                    </div>
                                    <div class="info-item" id="docPwdIdRowRO" style="display:none;">
                                        <span class="info-label">PWD ID:</span>
                                        <span class="info-value">
                                            <button type="button" id="btnViewPwdIdRO" class="btn btn-sm btn-outline-primary view-image-btn">View</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Image Preview Modal --}}
    <div class="modal fade" id="imageViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageViewModalTitle">View Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="imageViewModalImg" src="" alt="Preview" class="img-fluid" style="max-height:70vh;">
                    <div id="imageViewIdNumberWrap" class="mt-3" style="display:none;">
                        <strong>ID Number:</strong> <span id="imageViewIdNumber"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="imageViewDownloadBtn" href="#" class="btn btn-primary" download>
                        <i class="fas fa-download me-1"></i>Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Wire up details modal
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.view-details-btn').forEach(function(btn){
                btn.addEventListener('click', function(){
                    const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val || 'N/A'; };
                    // Helpers to mirror admin modal formatting
                    const isBlankVal = (v) => {
                        if (v === null || v === undefined) return true;
                        const s = String(v).trim();
                        return s === '' || s === 'N/A' || s === '—' || s.toLowerCase() === 'na';
                    };
                    const firstNonBlank = (...vals) => { for (const v of vals) { if (!isBlankVal(v)) return v; } return 'N/A'; };
                    const formatTimeWithDate = (raw, baseDateRaw = null) => {
                        if (!raw) return raw;
                        const trimmed = String(raw).trim();
                        if (trimmed === 'N/A' || trimmed === '—' || trimmed.toLowerCase() === 'na') return trimmed;
                        const monthAbbr = ['Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'Jun.', 'Jul.', 'Aug.', 'Sept.', 'Oct.', 'Nov.', 'Dec.'];
                        let d = new Date(trimmed);
                        if (isNaN(d.getTime())) {
                            const normalized = trimmed.replace(' ', 'T');
                            d = new Date(normalized);
                        }
                        if (isNaN(d.getTime())) {
                            const timeMatch = trimmed.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
                            if (timeMatch && baseDateRaw) {
                                let base = new Date(String(baseDateRaw).replace(' ', 'T'));
                                if (!isNaN(base.getTime())) {
                                    let hours = parseInt(timeMatch[1], 10);
                                    const minutes = parseInt(timeMatch[2], 10);
                                    const ampm = timeMatch[3].toUpperCase();
                                    if (ampm === 'PM' && hours !== 12) hours += 12;
                                    if (ampm === 'AM' && hours === 12) hours = 0;
                                    base.setHours(hours, minutes, 0, 0);
                                    d = base;
                                }
                            }
                        }
                        if (isNaN(d.getTime())) return trimmed;
                        const hh = d.getHours();
                        const mm = d.getMinutes();
                        const ampm = hh >= 12 ? 'PM' : 'AM';
                        const hour12 = hh % 12 === 0 ? 12 : hh % 12;
                        const mmStr = String(mm).padStart(2, '0');
                        const timeStr = `${hour12}:${mmStr} ${ampm}`;
                        const m = d.getMonth();
                        const day = d.getDate();
                        const year = d.getFullYear();
                        const dateStr = `${monthAbbr[m]} ${day}, ${year}`;
                        return `${timeStr} - ${dateStr}`;
                    };
                    
                    // Parse guest information and populate table
                    const guestName = this.getAttribute('data-guest-name') || '';
                    const guestAge = this.getAttribute('data-guest-age') || '';
                    const guestGender = this.getAttribute('data-guest-gender') || '';
                    const guestNationality = this.getAttribute('data-guest-nationality') || '';
                    
                    // Parse guest names (format: "Name1 (Age1) - Nationality1; Name2 (Age2) - Nationality2")
                    const guestTableBody = document.getElementById('docGuestTableBody');
                    if (guestTableBody) {
                        guestTableBody.innerHTML = '';
                        
                        if (guestName && guestName.trim() !== '') {
                            const guestNames = guestName.split(';').map(name => name.trim()).filter(name => name !== '');
                            
                            if (guestNames.length > 0) {
                                guestNames.forEach((guestInfo, index) => {
                                    let name = guestInfo;
                                    let age = '';
                                    let nationality = '';
                                    
                                    // Extract age from parentheses
                                    const ageMatch = guestInfo.match(/\((\d+)\)/);
                                    if (ageMatch) {
                                        age = ageMatch[1];
                                        name = name.replace(/\(\d+\)/, '').trim();
                                    }
                                    
                                    // Extract nationality from after dash
                                    const nationalityMatch = guestInfo.match(/\s*-\s*(.+)$/);
                                    if (nationalityMatch) {
                                        nationality = nationalityMatch[1].trim();
                                        name = name.replace(/\s*-\s*.+$/, '').trim();
                                    }
                                    
                                    // If no age/nationality found in name, use the single values for first guest
                                    if (index === 0) {
                                        if (!age && guestAge) age = guestAge;
                                        if (!nationality && guestNationality) nationality = guestNationality;
                                    }
                                    
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="fw-bold">${index + 1}</td>
                            <td class="fw-semibold">${name || 'N/A'}</td>
                            <td><span class="badge bg-info">${age || 'N/A'}</span></td>
                            <td><span class="badge bg-warning text-dark">${nationality || 'N/A'}</span></td>
                        `;
                                    guestTableBody.appendChild(row);
                                });
                            } else {
                                // Fallback: show single guest info
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td class="fw-bold">1</td>
                                    <td class="fw-semibold">${guestName || 'N/A'}</td>
                                    <td><span class="badge bg-info">${guestAge || 'N/A'}</span></td>
                                    <td><span class="badge bg-warning text-dark">${guestNationality || 'N/A'}</span></td>
                                `;
                                guestTableBody.appendChild(row);
                            }
                        } else {
                            // No guest information
                            const row = document.createElement('tr');
                            row.innerHTML = '<td colspan="4" class="text-center text-muted">No guest information available</td>';
                            guestTableBody.appendChild(row);
                        }
                    }
                    
                    setText('docPhone', this.getAttribute('data-phone'));
                    setText('docGuestAddress', this.getAttribute('data-guest-address'));
                    const down = this.getAttribute('data-downpayment') || '';
                    // Boat details
                    setText('docBoatName', this.getAttribute('data-boat-name'));
                    setText('docBoatNumber', this.getAttribute('data-boat-number'));
                    
                    const idType = this.getAttribute('data-valid-id-type') || '';
                    const idPath = this.getAttribute('data-valid-id') || '';
                    const idNum = this.getAttribute('data-valid-id-number') || '';
                    const seniorId = this.getAttribute('data-senior-id') || '';
                    const pwdId = this.getAttribute('data-pwd-id') || '';
                    const downBtn = document.getElementById('btnViewDownpaymentRO');
                    const idBtn = document.getElementById('btnViewValidIdRO');
                    const idTypeSpan = document.getElementById('docValidIdTypeRO');
                    if (downBtn) { 
                        if (down) { 
                            downBtn.style.display='inline-block'; 
                            downBtn.setAttribute('data-img-url', '/' + down);
                            downBtn.setAttribute('data-dl-url', '/' + down);
                            downBtn.setAttribute('data-title', 'Downpayment Receipt');
                        } else { 
                            downBtn.style.display='none'; 
                        } 
                    }
                    if (idBtn) { 
                        idTypeSpan.textContent = idType || '—'; 
                        if (idPath) { 
                            idBtn.style.display='inline-block'; 
                            idBtn.setAttribute('data-img-url', '/' + idPath);
                            idBtn.setAttribute('data-dl-url', '/' + idPath);
                            idBtn.setAttribute('data-title', 'Valid ID' + (idType ? ' (' + idType + ')' : ''));
                            idBtn.setAttribute('data-id-number', idNum || '');
                        } else { 
                            idBtn.style.display='none'; 
                        } 
                    }
                    const idNumRow = document.getElementById('docValidIdNumberRowRO');
                    const idNumSpan = document.getElementById('docValidIdNumberRO');
                    if (idNumRow && idNumSpan) {
                        if (idNum && idNum.trim() !== '') { idNumRow.style.display = 'block'; idNumSpan.textContent = idNum; } else { idNumRow.style.display = 'none'; idNumSpan.textContent = '—'; }
                    }
                    // Senior/PWD
                    const seniorRow = document.getElementById('docSeniorIdRowRO');
                    const seniorBtn = document.getElementById('btnViewSeniorIdRO');
                    if (seniorRow && seniorBtn) {
                        if (seniorId) { 
                            seniorRow.style.display='block'; 
                            seniorBtn.setAttribute('data-img-url', '/' + seniorId);
                            seniorBtn.setAttribute('data-dl-url', '/' + seniorId);
                            seniorBtn.setAttribute('data-title', 'Senior ID');
                        } else { 
                            seniorRow.style.display='none'; 
                        }
                    }
                    const pwdRow = document.getElementById('docPwdIdRowRO');
                    const pwdBtn = document.getElementById('btnViewPwdIdRO');
                    if (pwdRow && pwdBtn) {
                        if (pwdId) { 
                            pwdRow.style.display='block'; 
                            pwdBtn.setAttribute('data-img-url', '/' + pwdId);
                            pwdBtn.setAttribute('data-dl-url', '/' + pwdId);
                            pwdBtn.setAttribute('data-title', 'PWD ID');
                        } else { 
                            pwdRow.style.display='none'; 
                        }
                    }
                    setText('docExtended', this.getAttribute('data-extended') || 'No');
                    setText('docExtension', this.getAttribute('data-extension') || '—');

                    // New fields passed via data attributes (mix departure/pickup into check-in/out like admin)
                    // Removed check-in/check-out display in modal per request
                    setText('docSeniors', this.getAttribute('data-seniors') || '—');
                    setText('docPwds', this.getAttribute('data-pwds') || '—');
                });
            });

            // Image view modal handlers
            const imageModalEl = document.getElementById('imageViewModal');
            const imageModal = new bootstrap.Modal(imageModalEl);
            document.addEventListener('click', function(e){
                const btn = e.target.closest('.view-image-btn');
                if (!btn) return;
                const url = btn.getAttribute('data-img-url');
                const title = btn.getAttribute('data-title') || 'View Image';
                const idNumber = btn.getAttribute('data-id-number') || '';
                const imgEl = document.getElementById('imageViewModalImg');
                const titleEl = document.getElementById('imageViewModalTitle');
                const downloadBtn = document.getElementById('imageViewDownloadBtn');
                const idNumEl = document.getElementById('imageViewIdNumber');
                const idWrapEl = document.getElementById('imageViewIdNumberWrap');
                
                if (imgEl && titleEl && downloadBtn) {
                    imgEl.src = url;
                    titleEl.textContent = title;
                    downloadBtn.href = url;
                    
                    if (idNumber && idNumber.trim() !== '') {
                        idNumEl.textContent = idNumber;
                        idWrapEl.style.display = 'block';
                    } else {
                        idNumEl.textContent = '';
                        idWrapEl.style.display = 'none';
                    }
                    imageModal.show();
                }
            });
        });
    </script>

    <style>
        /* Compact table styles used for single-page A4 capture */
        .compact-table table { font-size: 10px; }
        .compact-table table th,
        .compact-table table td { padding: 4px 6px !important; line-height: 1.2; }
        .compact-table table th { white-space: normal; }
        .compact-table .table { margin-bottom: 0; }
        .compact-table .badge { font-size: 9px; padding: 2px 6px; }

        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');



        /* Simple Sidebar Styling */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: #2c3e50;
            border-right: 1px solid #34495e;
            min-height: 100vh;
            overflow-y: auto;
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


        /* Compact, clean modal styles */
        .ro-doc-modal-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: #fff;
            border-bottom: none;
        }
        .ro-doc-modal-footer {
            background: #f8f9fa;
            border-top: none;
        }
        
        /* Guest information table styling */
        #docGuestTableBody .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.5rem;
        }
        
        #docGuestTableBody tr:hover {
            background-color: #f8f9fa !important;
        }
        
        #docGuestTableBody td {
            vertical-align: middle;
            padding: 0.75rem 0.5rem;
        }
        
        #docGuestTableBody .fw-semibold {
            color: #495057;
        }
        
        .modal-body h6 {
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 55vw !important;
            z-index: 1050;
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
            background: transparent;
        }

        .mobile-sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .mobile-sidebar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Table polish */
        .ro-doc-table-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            border: 1px solid #e9ecef;
        }
        .ro-doc-table thead th {
            background: linear-gradient(180deg, #f8f9fa, #eef1f5);
            border-bottom: 2px solid #dee2e6;
            font-weight: 700;
            color: #495057;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .ro-doc-table tbody tr:hover {
            background: #f8f9ff !important;
        }
        .ro-doc-table td, .ro-doc-table th {
            vertical-align: middle;
        }

        /* Main Content */
        .main-content {
            background: transparent;
            min-height: 100vh;
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
                width: 80vw !important;
            }
        }
    
    /* Modern Modal Styling */
    .modern-modal {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }
    
    .modern-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 1.5rem;
        border-bottom: none;
    }
    
    .modal-title-section {
        flex: 1;
    }
    
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .modal-subtitle {
        font-size: 0.875rem;
        opacity: 0.9;
        margin: 0.25rem 0 0 0;
    }
    
    .modern-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 1;
        transition: all 0.2s ease;
    }
    
    .modern-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }
    
    .modern-modal-body {
        padding: 1.5rem;
        background: #f8f9fa;
    }
    
    .info-card {
        background: white;
        border-radius: 8px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        height: 100%;
    }
    
    .info-card-title {
        color: #495057;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
    }
    
    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f3f4;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
        margin-right: 1rem;
    }
    
    .info-value {
        color: #6c757d;
        text-align: right;
        flex: 1;
        word-break: break-word;
    }
    
    .modern-modal-footer {
        background: white;
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 12px 12px;
        padding: 1rem 1.5rem;
    }
    
    .btn-modern {
        border-radius: 6px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Guest information table styling */
    #docGuestTableBody .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.5rem;
    }
    
    #docGuestTableBody tr:hover {
        background-color: #f8f9fa !important;
    }
    
    #docGuestTableBody td {
        vertical-align: middle;
        padding: 0.75rem 0.5rem;
    }
    
    #docGuestTableBody .fw-semibold {
        color: #495057;
    }
    </style>
</x-app-layout>