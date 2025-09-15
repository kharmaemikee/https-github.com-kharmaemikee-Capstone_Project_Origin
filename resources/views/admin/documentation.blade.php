<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="modern-sidebar d-none d-md-block">
            {{-- Sidebar Header --}}
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" class="brand-icon-img">
                    </div>
                    <div class="brand-text">
                        <h4 class="brand-title">Admin Menu</h4>
                        <p class="brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
            </div>
            
            {{-- Sidebar Navigation --}}
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.resort') }}" class="nav-link {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Resort Management</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.boat') }}" class="nav-link {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Boat Management</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <button class="nav-link w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapse" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapse">
                            <div class="nav-icon">
                                <img src="{{ asset('images/users.png') }}" alt="Users Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Users</span>
                        <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                    </button>
                    <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapse">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.resorts') }}" class="nav-link {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                            </li>
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.boats') }}" class="nav-link {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                            </li>
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.tourists') }}" class="nav-link {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.documentation') }}" class="nav-link {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
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
                        <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" class="mobile-brand-icon-img">
                    </div>
                    <div class="mobile-brand-text">
                        <h5 class="mobile-brand-title" id="mobileSidebarLabel">Admin Menu</h5>
                        <p class="mobile-brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="mobile-sidebar-nav">
                <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.resort') }}" class="nav-link {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Resort Management</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.boat') }}" class="nav-link {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Boat Management</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <button class="nav-link w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapseMobile" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapseMobile">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/users.png') }}" alt="Users Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Users</span>
                            <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                        </button>
                        <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapseMobile">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                        <a href="{{ route('admin.users.resorts') }}" class="nav-link {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                                </li>
                                <li class="nav-item">
                                        <a href="{{ route('admin.users.boats') }}" class="nav-link {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                                </li>
                                <li class="nav-item">
                                        <a href="{{ route('admin.users.tourists') }}" class="nav-link {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.documentation') }}" class="nav-link {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
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

        {{-- Main Content Area: Tourist Bookings with search, filters, and export --}}
        <div class="main-content flex-grow-1">
                {{-- Enhanced Header Section --}}
                <div class="page-header mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="header-icon me-3">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div>
                            <h2 class="page-title mb-1">Documentation</h2>
                            <p class="page-subtitle mb-0">All Tourist Bookings Management</p>
                        </div>
                    </div>
                    <div class="header-stats">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h6 class="stat-label">Total Bookings</h6>
                                        <h4 class="stat-value">{{ is_countable($bookings) ? count($bookings) : ($bookings->total() ?? 0) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-ship"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h6 class="stat-label">Active Boats</h6>
                                        <h4 class="stat-value">{{ $bookings->where('assignedBoat', '!=', null)->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-hotel"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h6 class="stat-label">Resorts</h6>
                                        <h4 class="stat-value">{{ $bookings->pluck('room.resort.resort_name')->unique()->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-content">
                                        <h6 class="stat-label">Tourists</h6>
                                        <h4 class="stat-value">{{ $bookings->pluck('user')->unique()->count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Enhanced Search and Filter Card --}}
                <div class="card modern-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-search me-2"></i>Search & Filter
                        </h5>
                    </div>
                    <div class="card-body">

                        <form method="GET" action="{{ route('admin.documentation') }}" class="search-form">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="search" class="form-label">
                                            <i class="fas fa-search me-1"></i>Search
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" 
                                                   class="form-control modern-input" 
                                                   placeholder="Search by name, phone, address, resort, or boat">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_date" class="form-label">
                                            <i class="fas fa-calendar-alt me-1"></i>From Date
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                            <input type="date" id="start_date" name="start_date" 
                                                   value="{{ $filters['start_date'] ?? '' }}" 
                                                   class="form-control modern-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_date" class="form-label">
                                            <i class="fas fa-calendar-alt me-1"></i>To Date
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                            <input type="date" id="end_date" name="end_date" 
                                                   value="{{ $filters['end_date'] ?? '' }}" 
                                                   class="form-control modern-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="form-check modern-checkbox">
                                            <input class="form-check-input" type="checkbox" id="showAll" name="all" value="1" 
                                                   {{ !empty($showAll) && $showAll ? 'checked' : '' }}>
                                            <label class="form-check-label" for="showAll">
                                                <i class="fas fa-list me-1"></i>Show all results
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions mt-3">
                                <button type="submit" class="btn btn-primary btn-modern">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <a href="{{ route('admin.documentation') }}" class="btn btn-outline-secondary btn-modern">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </a>
                            </div>
                        </form>

                        <div class="results-section">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="results-info">
                                    <span class="badge badge-info me-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        @if(!empty($showAll) && $showAll)
                                            {{ is_countable($bookings) ? count($bookings) : 0 }} total results
                                        @else
                                            {{ $bookings->total() ?? 0 }} results
                                        @endif
                                    </span>
                                </div>
                                <div class="export-actions">
                                    <a href="{{ route('admin.documentation.export', request()->query()) }}" 
                                       class="btn btn-success btn-modern">
                                        <i class="fas fa-file-csv me-2"></i>Export CSV
                                    </a>
                                    <a href="{{ route('admin.documentation.export_pdf', request()->query()) }}" 
                                       class="btn btn-danger btn-modern">
                                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Enhanced Table Card --}}
                <div class="card modern-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table me-2"></i>Booking Records
                        </h5>
                    </div>
                    <div class="card-body p-0">

                        <div id="docCapture" class="table-responsive modern-table-container">
                            <table class="table modern-table">
                                <thead class="table-header">
                                    <tr>
                                        <th class="table-header-cell">
                                            <i class="fas fa-hotel me-1"></i>Resort
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-bed me-1"></i>Room
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-user me-1"></i>Tourist Account
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-map-marked-alt me-1"></i>Tour Type
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-clock me-1"></i>Departure Time
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-sun me-1"></i>Pick-up (Day)
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-moon me-1"></i>Pick-up (Overnight)
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-ship me-1"></i>Assigned Boat
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-hashtag me-1"></i>Boat Number
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-user-tie me-1"></i>Boat Captain
                                        </th>
                                        <th class="table-header-cell">
                                            <i class="fas fa-phone me-1"></i>Boat Contact
                                        </th>
                                        <th class="table-header-cell text-center">
                                            <i class="fas fa-cogs me-1"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @forelse($bookings as $booking)
                                        <tr class="table-row">
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    <span class="cell-text">{{ optional(optional($booking->room)->resort)->resort_name ?? ($booking->name_of_resort ?? '—') }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    <span class="cell-text">{{ optional($booking->room)->room_name ?? '—' }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    @php
                                                        $acctName = trim(((optional($booking->user)->first_name ?? '') . ' ' . (optional($booking->user)->last_name ?? '')));
                                                    @endphp
                                                    <span class="cell-text user-name">{{ $acctName !== '' ? $acctName : (optional($booking->user)->username ?? '—') }}</span>
                                                </div>
                                            </td>
                                            
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    <span class="badge badge-tour-type">{{ ucfirst($booking->tour_type ?? '—') }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    @if($booking->day_tour_departure_time)
                                                        @php
                                                            try {
                                                                echo \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('H:i');
                                                            } catch(\Exception $e) {
                                                                echo $booking->day_tour_departure_time;
                                                            }
                                                        @endphp
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    @if($booking->day_tour_time_of_pickup)
                                                        @php
                                                            try {
                                                                echo \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('H:i');
                                                            } catch(\Exception $e) {
                                                                echo $booking->day_tour_time_of_pickup;
                                                            }
                                                        @endphp
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    @if($booking->overnight_date_time_of_pickup)
                                                        @php
                                                            try {
                                                                echo \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('Y-m-d H:i');
                                                            } catch(\Exception $e) {
                                                                echo $booking->overnight_date_time_of_pickup;
                                                            }
                                                        @endphp
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    <span class="cell-text">{{ optional($booking->assignedBoat)->boat_name ?? $booking->assigned_boat ?? '—' }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    <span class="cell-text">{{ optional($booking->assignedBoat)->boat_number ?? '—' }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    <span class="cell-text">{{ optional($booking->assignedBoat)->captain_name ?? $booking->boat_captain_crew ?? '—' }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell">
                                                <div class="cell-content">
                                                    <span class="cell-text">{{ optional($booking->assignedBoat)->captain_contact ?? $booking->boat_contact_number ?? '—' }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell text-center">
                                                <div class="action-buttons">
                                                    <button type="button" class="btn btn-action btn-view viewDocBtn" 
                                                        title="View details" aria-label="View details"
                                                        data-bs-toggle="modal" data-bs-target="#docViewModal"
                                                        data-guest-name="{{ $booking->guest_name ?? '' }}"
                                                        data-guest-age="{{ $booking->guest_age ?? (optional($booking->user)->birthday ? \Carbon\Carbon::parse(optional($booking->user)->birthday)->age : '') }}"
                                                        data-guest-gender="{{ $booking->guest_gender ?? '' }}"
                                                        data-guest-address="{{ $booking->guest_address ?? '' }}"
                                                        data-guest-nationality="{{ $booking->guest_nationality ?? '' }}"
                                                        data-phone="{{ $booking->phone_number ?? '' }}"
                                                        data-checkin="{{ optional($booking->check_in_date)->format('Y-m-d') }}"
                                                        data-checkout="{{ optional($booking->check_out_date)->format('Y-m-d') }}"
                                                        data-seniors="{{ $booking->num_senior_citizens ?? '' }}"
                                                        data-pwds="{{ $booking->num_pwds ?? '' }}"
                                                        data-guest-count="{{ $booking->number_of_guests ?? '' }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="table-row">
                                            <td colspan="12" class="table-cell text-center">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No bookings found</h5>
                                                    <p class="text-muted">Try adjusting your search criteria or filters</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(empty($showAll) || !$showAll)
                            <div class="pagination-section">
                                @if ($bookings->hasPages())
                                    <nav class="pagination-nav">
                                        <div class="pagination-info">
                                            <p class="pagination-text">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Showing <strong>{{ $bookings->firstItem() }}</strong> to <strong>{{ $bookings->lastItem() }}</strong> 
                                                of <strong>{{ $bookings->total() }}</strong> results
                                            </p>
                                        </div>
                                        <div class="pagination-controls">
                                            <ul class="pagination modern-pagination">
                                                {{-- Previous Page Link --}}
                                                @if ($bookings->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link">
                                                            <i class="fas fa-chevron-left"></i>
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $bookings->previousPageUrl() }}" rel="prev">
                                                            <i class="fas fa-chevron-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Pagination Elements --}}
                                                @foreach ($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                                                    @if ($page == $bookings->currentPage())
                                                        <li class="page-item active">
                                                            <span class="page-link">{{ $page }}</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- Next Page Link --}}
                                                @if ($bookings->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $bookings->nextPageUrl() }}" rel="next">
                                                            <i class="fas fa-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled">
                                                        <span class="page-link">
                                                            <i class="fas fa-chevron-right"></i>
                                                        </span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </nav>
                                @endif
                            </div>
                        @endif

                        {{-- Signature section for resorts (prints at bottom) --}}
                        @php
                            $items = ($bookings instanceof \Illuminate\Pagination\AbstractPaginator)
                                ? $bookings->items()
                                : (is_iterable($bookings) ? $bookings : []);
                            $resortNames = collect($items)
                                ->map(function($b){
                                    if (!is_object($b)) { return null; }
                                    $resortName = null;
                                    try {
                                        $resortName = optional(optional($b->room)->resort)->resort_name;
                                    } catch (\Throwable $e) {
                                        // ignore and fallback
                                    }
                                    if (!$resortName && property_exists($b, 'name_of_resort')) {
                                        $resortName = $b->name_of_resort;
                                    }
                                    return $resortName ?: null;
                                })
                                ->filter()
                                ->unique()
                                ->values();
                        @endphp
                        <!-- @if($resortNames->isNotEmpty())
                            <div class="mt-5">
                                <div class="row g-4">
                                    @foreach($resortNames as $resortName)
                                        <div class="col-12 col-md-4 d-flex flex-column align-items-center">
                                            <div style="width: 100%; max-width: 320px; margin-top: 40px; border-top: 2px solid #000; height: 1px;"></div>
                                            <div class="text-center fw-bold mt-1" style="max-width: 320px;">{{ $resortName }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Documentation Row View Modal -->
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
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-user me-2"></i>Guest Information
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Name:</span>
                                        <span class="info-value" id="docGuestName">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Age:</span>
                                        <span class="info-value" id="docGuestAge">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Gender:</span>
                                        <span class="info-value" id="docGuestGender">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Nationality:</span>
                                        <span class="info-value" id="docGuestNationality">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Phone:</span>
                                        <span class="info-value" id="docPhone">N/A</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-calendar-alt me-2"></i>Booking Information
                                </h6>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Check-in:</span>
                                        <span class="info-value" id="docCheckin">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Check-out:</span>
                                        <span class="info-value" id="docCheckout">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Total Guests:</span>
                                        <span class="info-value" id="docGuestCount">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Seniors:</span>
                                        <span class="info-value" id="docSeniors">N/A</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">PWDs:</span>
                                        <span class="info-value" id="docPWDs">N/A</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-card">
                                <h6 class="info-card-title">
                                    <i class="fas fa-map-marker-alt me-2"></i>Address
                                </h6>
                                <div class="info-item">
                                    <span class="info-value" id="docGuestAddress">N/A</span>
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

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        /* Global Styles */
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

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

        .collapse-icon { 
            transition: transform 0.3s ease; 
        }
        .collapse-icon.rotated { 
            transform: rotate(180deg); 
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

        /* Main Content */
        .main-content {
            padding: 2rem;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Enhanced Page Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .header-icon i {
            font-size: 24px;
            color: white;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: #718096;
            font-size: 1.1rem;
            font-weight: 400;
        }

        /* Stats Cards */
        .header-stats {
            margin-top: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-icon i {
            font-size: 20px;
            color: white;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #718096;
            font-weight: 500;
            margin: 0 0 0.5rem 0;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        /* Modern Cards */
        .modern-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            background: white;
            overflow: hidden;
        }

        .modern-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem;
        }

        .modern-card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .modern-card .card-body {
            padding: 1.5rem;
        }

        /* Enhanced Form Styles */
        .search-form {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .modern-input {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .modern-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .input-group-text {
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            border-right: none;
            color: #718096;
        }

        .input-group .modern-input {
            border-left: none;
        }

        .input-group .modern-input:focus {
            border-left: 2px solid #667eea;
        }

        .modern-checkbox {
            margin-top: 1.5rem;
        }

        .modern-checkbox .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            border-radius: 4px;
            border: 2px solid #e2e8f0;
        }

        .modern-checkbox .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .modern-checkbox .form-check-label {
            font-weight: 500;
            color: #4a5568;
            margin-left: 0.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Modern Buttons */
        .btn-modern {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary.btn-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-success.btn-modern {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .btn-danger.btn-modern {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .btn-outline-secondary.btn-modern {
            border: 2px solid #e2e8f0;
            color: #718096;
            background: white;
        }

        .btn-outline-secondary.btn-modern:hover {
            background: #f8fafc;
            border-color: #cbd5e0;
        }

        /* Results Section */
        .results-section {
            background: #f8fafc;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-top: 1rem;
        }

        .badge-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .export-actions {
            display: flex;
            gap: 0.75rem;
        }

        /* Modern Table Styles */
        .modern-table-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .modern-table {
            margin-bottom: 0;
            font-size: 0.875rem;
        }

        .table-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .table-header-cell {
            background: transparent;
            font-weight: 600;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem 0.75rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-body {
            background: white;
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-row:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: scale(1.01);
        }

        .table-cell {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border: none;
        }

        .cell-content {
            display: flex;
            align-items: center;
        }

        .cell-text {
            color: #2d3748;
            font-weight: 500;
        }

        .user-name {
            font-weight: 600;
            color: #4a5568;
        }

        .badge-tour-type {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .btn-view:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        /* Empty State */
        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
        }

        .empty-state i {
            color: #cbd5e0;
        }

        .empty-state h5 {
            margin: 1rem 0 0.5rem 0;
        }

        /* Pagination Styles */
        .pagination-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .pagination-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-text {
            color: #718096;
            font-size: 0.875rem;
            margin: 0;
        }

        .modern-pagination {
            margin: 0;
        }

        .modern-pagination .page-link {
            border: 2px solid #e2e8f0;
            color: #4a5568;
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .modern-pagination .page-link:hover {
            background: #667eea;
            border-color: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .modern-pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }

        .modern-pagination .page-item.disabled .page-link {
            background: #f7fafc;
            border-color: #e2e8f0;
            color: #a0aec0;
        }

        /* Modal Styles */
        .modern-modal {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .modern-modal-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem;
        }

        .modal-title-section {
            flex: 1;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .modal-subtitle {
            color: #718096;
            font-size: 0.875rem;
            margin: 0.25rem 0 0 0;
        }

        .modern-close {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #f7fafc;
            border: 2px solid #e2e8f0;
            color: #718096;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .modern-close:hover {
            background: #e2e8f0;
            color: #4a5568;
        }

        .modern-modal-body {
            padding: 2rem;
        }

        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .info-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #4a5568;
            margin: 0 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .info-grid {
            display: grid;
            gap: 0.75rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .info-label {
            font-weight: 600;
            color: #718096;
            font-size: 0.875rem;
        }

        .info-value {
            font-weight: 500;
            color: #2d3748;
            text-align: right;
        }

        .modern-modal-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem;
        }

        /* Simple table responsive design */
        .table-responsive {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding: 0.75rem 0.5rem;
        }

        .table td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .page-title {
                font-size: 2rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-value {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .page-header {
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.75rem;
            }
            
            .header-stats .row {
                margin: 0 -0.5rem;
            }
            
            .header-stats .col-md-3 {
                padding: 0 0.5rem;
                margin-bottom: 1rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
            }
            
            .stat-icon i {
                font-size: 16px;
            }
            
            .stat-value {
                font-size: 1.25rem;
            }
            
            .search-form {
                padding: 1rem;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .btn-modern {
                width: 100%;
                justify-content: center;
            }
            
            .export-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .export-actions .btn-modern {
                width: 100%;
            }
            
            .pagination-nav {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .modern-table-container {
                font-size: 0.8rem;
            }
            
            .table-header-cell {
                padding: 0.75rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .table-cell {
                padding: 0.75rem 0.5rem;
            }
            
            .modal-dialog {
                margin: 1rem;
            }
            
            .modern-modal-body {
                padding: 1.5rem;
            }
            
            .info-card {
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
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .header-icon {
                width: 50px;
                height: 50px;
            }
            
            .header-icon i {
                font-size: 20px;
            }
            
            .stat-card {
                padding: 0.75rem;
            }
            
            .stat-value {
                font-size: 1.1rem;
            }
            
            .modern-card .card-header {
                padding: 1rem;
            }
            
            .modern-card .card-body {
                padding: 1rem;
            }
            
            .search-form {
                padding: 0.75rem;
            }
            
            .modern-input {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
            
            .table-header-cell {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }
            
            .table-cell {
                padding: 0.5rem 0.25rem;
            }
            
            .btn-action {
                width: 32px;
                height: 32px;
            }
            
            .modern-modal-body {
                padding: 1rem;
            }
            
            .info-card {
                padding: 0.75rem;
            }
            
            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .info-value {
                text-align: left;
            }
        }

        @media (max-width: 400px) {
            .page-title {
                font-size: 1.25rem;
            }
            
            .stat-card {
                padding: 0.5rem;
            }
            
            .stat-value {
                font-size: 1rem;
            }
            
            .modern-table-container {
                font-size: 0.75rem;
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
            
            .page-title {
                font-size: 1.1rem;
            }
            
            .page-subtitle {
                font-size: 0.75rem;
            }
            
            .stat-card {
                padding: 0.75rem;
            }
            
            .stat-icon {
                width: 35px;
                height: 35px;
            }
            
            .stat-icon-img {
                width: 16px;
                height: 16px;
            }
            
            .stat-number {
                font-size: 1.25rem;
            }
            
            .stat-label {
                font-size: 0.75rem;
            }
            
            .table {
                font-size: 0.7rem;
            }
            
            .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.65rem;
            }
            
            .btn i {
                font-size: 0.6rem;
            }
            
            .modal-dialog {
                margin: 0.25rem;
            }
            
            .modal-header {
                padding: 0.5rem;
            }
            
            .modal-body {
                padding: 0.5rem;
            }
            
            .modal-footer {
                padding: 0.5rem;
            }
            
            .form-control {
                font-size: 0.75rem;
                padding: 0.3rem 0.5rem;
            }
            
            .form-label {
                font-size: 0.7rem;
            }
            
            .btn-close {
                width: 1rem;
                height: 1rem;
            }
            
            .btn-close::before {
                font-size: 0.65rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 0.4rem;
            }
            
            .info-item {
                padding: 0.4rem;
            }
            
            .info-label {
                font-size: 0.65rem;
            }
            
            .info-value {
                font-size: 0.7rem;
            }
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

        /* Compact table styles used for single-page A4 capture */
        .compact-table table { font-size: 10px; }
        .compact-table table th,
        .compact-table table td { padding: 4px 6px !important; line-height: 1.2; }
        .compact-table table th { white-space: normal; }
        .compact-table .table { margin-bottom: 0; }
        .compact-table .badge { font-size: 9px; padding: 2px 6px; }

        /* Custom pagination styles matching vendor design */
        .pagination {
            margin-bottom: 0;
        }
        
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25;
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            margin: 0 0.125rem;
        }
        
        .pagination .page-link:hover {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .pagination .page-item.active .page-link {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
            opacity: 0.5;
        }
        
        .pagination .page-item:first-child .page-link {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }
        
        .pagination .page-item:last-child .page-link {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ['usersCollapse','usersCollapseMobile'].forEach(function(id){
                var container = document.getElementById(id);
                if(!container) return;
                var triggerBtn = document.querySelector('[data-bs-target="#'+id+'"]');
                var arrow = triggerBtn ? triggerBtn.querySelector('.collapse-icon') : null;
                if(!arrow) return;
                container.addEventListener('show.bs.collapse', function(){ arrow.classList.add('rotated'); });
                container.addEventListener('hide.bs.collapse', function(){ arrow.classList.remove('rotated'); });
            });
        });
    </script>

    {{-- html2canvas for PNG export (client-side only) --}}
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    
    {{-- Custom JavaScript to handle offcanvas hiding and PNG download --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- JavaScript for Offcanvas Hiding ---
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

            // --- JavaScript for PNG Download ---
            const btn = document.getElementById('downloadPngBtn');
            if (!btn) return;
            btn.addEventListener('click', async function () {
                const source = document.getElementById('docCapture');
                if (!source) return;

                // Stage a cloned, compact version sized to A4 LANDSCAPE and scale it so ALL rows fit on one page
                const stage = document.createElement('div');
                stage.id = 'exportStaging';
                stage.style.position = 'fixed';
                stage.style.left = '-99999px';
                stage.style.top = '0';
                stage.style.width = '1123px'; /* ~11.69in at 96dpi */
                stage.style.height = '794px'; /* ~8.27in at 96dpi */
                stage.style.overflow = 'hidden';
                stage.style.backgroundColor = '#ffffff';

                const cloneCard = document.createElement('div');
                cloneCard.style.backgroundColor = '#ffffff';
                cloneCard.style.padding = '8px';

                const cloned = source.cloneNode(true);
                // Apply compact styles
                cloned.classList.add('compact-table');
                // Ensure table width fits page
                cloned.style.maxWidth = '100%';
                cloned.style.overflow = 'visible';

                cloneCard.appendChild(cloned);
                stage.appendChild(cloneCard);
                document.body.appendChild(stage);

                // Compute scale to fit within A4 Landscape
                await new Promise(r => setTimeout(r, 0)); // allow layout
                const contentRect = cloneCard.getBoundingClientRect();
                const scaleX = 1123 / Math.max(contentRect.width, 1);
                const scaleY = 794 / Math.max(cloneCard.scrollHeight, 1);
                const scale = Math.min(scaleX, scaleY, 1);
                cloneCard.style.transformOrigin = 'top left';
                cloneCard.style.transform = `scale(${scale})`;
                cloneCard.style.width = contentRect.width + 'px';
                cloneCard.style.height = cloneCard.scrollHeight + 'px';

                const canvas = await html2canvas(stage, {
                    width: 1123,
                    height: 794,
                    backgroundColor: '#ffffff',
                    scale: 1,
                    useCORS: true
                });

                document.body.removeChild(stage);

                const dataUrl = canvas.toDataURL('image/png');
                const link = document.createElement('a');
                const ts = new Date().toISOString().replace(/[:.]/g, '-');
                link.download = `admin-tourist-bookings-A4-landscape-${ts}.png`;
                link.href = dataUrl;
                document.body.appendChild(link);
                link.click();
                link.remove();
            });
            // --- End JavaScript for PNG Download ---
        });
    </script>

    <script>
        // Wire up Documentation View modal population
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.viewDocBtn').forEach(function(btn){
                btn.addEventListener('click', function(){
                    const guestName = this.getAttribute('data-guest-name') || 'N/A';
                    const guestAge = this.getAttribute('data-guest-age') || 'N/A';
                    const guestGender = this.getAttribute('data-guest-gender') || 'N/A';
                    const guestAddress = this.getAttribute('data-guest-address') || 'N/A';
                    const guestNationality = this.getAttribute('data-guest-nationality') || 'N/A';
                    const phone = this.getAttribute('data-phone') || 'N/A';
                    const seniors = this.getAttribute('data-seniors') || 'N/A';
                    const pwds = this.getAttribute('data-pwds') || 'N/A';
                    const guestCount = this.getAttribute('data-guest-count') || 'N/A';
                    const checkin = this.getAttribute('data-checkin') || 'N/A';
                    const checkout = this.getAttribute('data-checkout') || 'N/A';

                    const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
                    setText('docGuestName', guestName);
                    setText('docGuestAge', guestAge);
                    setText('docGuestGender', guestGender);
                    setText('docGuestAddress', guestAddress);
                    setText('docGuestNationality', guestNationality);
                    setText('docPhone', phone);
                    setText('docCheckin', checkin);
                    setText('docCheckout', checkout);
                    setText('docGuestCount', guestCount);
                    setText('docSeniors', seniors);
                    setText('docPWDs', pwds);
                });
            });
        });
    </script>
</x-app-layout>