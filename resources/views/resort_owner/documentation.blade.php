<x-app-layout>
    <!-- Fixed background layer -->
    <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd); background-attachment: fixed; background-size: 100vw 100vh; background-position: 0 0; z-index: -1; margin: 0; padding: 0;"></div>
    
    <div class="d-flex flex-column flex-md-row" style="min-height: 100vh; width: 100%; position: relative; z-index: 1; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

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
                        <a href="{{ route('resort.owner.documentation') }}" class="nav-link active" aria-current="page">
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
        <div class="d-md-none bg-light border-bottom p-2">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                &#9776;
            </button>
        </div>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
            <div class="offcanvas-header">
                {{-- Icon added here for Resort Owner in mobile sidebar using <img> --}}
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Resorts Menu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                   
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        @if(auth()->user()->canAccessMainFeatures())
                            <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Resort Management
                            </a>
                        @else
                            <span class="nav-link text-white-50 rounded p-2 d-flex align-items-center disabled-link" 
                                  data-bs-toggle="tooltip" 
                                  data-bs-placement="right" 
                                  title="Upload your permits first to unlock this feature">
                                <img src="{{ asset('images/information.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px; opacity: 0.5;">
                                Resort Information
                                <span class="badge bg-warning ms-2">Locked</span>
                            </span>
                        @endif
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
                            <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Account Management
                        </a>
                    </li>
                    {{-- Notifications (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notifications
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    {{-- Documentation (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                            <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Documentation
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area: Bookings with search, filters, and export --}}
        <div class="flex-grow-1 p-4">
            <div class="container py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
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
                        <h3 class="mb-4">{{ $headerResortName ?? 'Resort Documentation' }}</h3>

                        <form method="GET" action="{{ route('resort.owner.documentation') }}" class="row g-3 align-items-end mb-4">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search Name</label>
                                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control" placeholder="Enter Guest Name">
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">From</label>
                                <input type="date" id="start_date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">To</label>
                                <input type="date" id="end_date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="showAll" name="all" value="1" {{ !empty($showAll) && $showAll ? 'checked' : '' }}>
                                    <label class="form-check-label" for="showAll">Show all results</label>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex gap-2 align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Apply</button>
                            </div>
                        </form>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">
                                @if(!empty($showAll) && $showAll)
                                    Results: {{ is_countable($bookings) ? count($bookings) : 0 }} (all)
                                @else
                                    Results: {{ $bookings->total() ?? 0 }}
                                @endif
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('resort.owner.documentation.export', request()->query()) }}" class="btn btn-success">Export CSV</a>
                                <a href="{{ route('resort.owner.documentation.export_pdf', request()->query()) }}" class="btn btn-danger">Export PDF</a>
                            </div>
                        </div>

                        <div id="docCapture" class="table-responsive ro-doc-table-container">
                            <table class="table table-striped table-hover align-middle ro-doc-table">
                                <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Tourist</th>
                                        <th>Tour Type</th>
                                        <th>Departure Time — Overnight</th>
                                        <th>Departure Time — Day tour</th>
                                        <th>Pick-up (leaving)</th>
                                        
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>{{ optional($booking->room)->room_name ?? '—' }}</td>
                                            <td>
                                                @php
                                                    $acctName = trim(((optional($booking->user)->first_name ?? '') . ' ' . (optional($booking->user)->last_name ?? '')));
                                                @endphp
                                                {{ $acctName !== '' ? $acctName : (optional($booking->user)->username ?? '—') }}
                                            </td>
                                            <td>{{ ucfirst($booking->tour_type ?? '—') }}</td>
                                            <td data-col="overnight">
                                                @php
                                                    $overnightDep = null;
                                                    try {
                                                        if (!empty($booking->overnight_departure_time)) {
                                                            $overnightDep = \Carbon\Carbon::parse($booking->overnight_departure_time)->format('h:i A');
                                                        }
                                                    } catch (\Exception $e) { $overnightDep = $booking->overnight_departure_time ?? null; }
                                                    @endphp
                                                {{ $overnightDep ?? '—' }}
                                            </td>
                                            <td data-col="daytour">
                                                @php
                                                    $dayDep = null;
                                                    try {
                                                        if (!empty($booking->day_tour_departure_time)) {
                                                            $dayDep = \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('h:i A');
                                                        }
                                                    } catch (\Exception $e) { $dayDep = $booking->day_tour_departure_time ?? null; }
                                                    @endphp
                                                {{ $dayDep ?? '—' }}
                                            </td>
                                            <td data-col="pickup">
                                                @php
                                                    $pickupText = '—';
                                                    try {
                                                        if (($booking->tour_type ?? '') === 'overnight' && $booking->overnight_date_time_of_pickup) {
                                                            $pickupText = \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('Y-m-d h:i A');
                                                        } elseif (($booking->tour_type ?? '') === 'day_tour' && $booking->day_tour_time_of_pickup) {
                                                            $pickupText = \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('h:i A');
                                                            }
                                                        } catch (\Exception $e) {
                                                        $pickupText = ($booking->tour_type === 'overnight') ? ($booking->overnight_date_time_of_pickup ?? '—') : ($booking->day_tour_time_of_pickup ?? '—');
                                                        }
                                                    @endphp
                                                {{ $pickupText }}
                                            </td>
                                            
                                            <td class="text-center">
                                                @php
                                                    $assignedBoat = optional($booking)->assignedBoat;
                                                @endphp
                                                <button type="button" class="btn btn-info btn-sm viewDocBtn"
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
                                                        data-guest-count="{{ $booking->number_of_guests ?? '' }}"
                                                        data-overnight-departure="{{ !empty($booking->overnight_departure_time) ? (function() use($booking){ try { return \Carbon\Carbon::parse($booking->overnight_departure_time)->format('h:i A'); } catch (\Exception $e) { return $booking->overnight_departure_time; } })() : '—' }}"
                                                        data-daytour-departure="{{ !empty($booking->day_tour_departure_time) ? (function() use($booking){ try { return \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('h:i A'); } catch (\Exception $e) { return $booking->day_tour_departure_time; } })() : '—' }}"
                                                        data-pickup="{{ ($booking->tour_type === 'overnight') ? (!empty($booking->overnight_date_time_of_pickup) ? (function() use($booking){ try { return \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('M d, Y h:i A'); } catch (\Exception $e) { return $booking->overnight_date_time_of_pickup; } })() : '—') : (!empty($booking->day_tour_time_of_pickup) ? (function() use($booking){ try { return \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('h:i A'); } catch (\Exception $e) { return $booking->day_tour_time_of_pickup; } })() : '—') }}"
                                                        data-extended="{{ ($booking->is_extended ?? false) ? 'Yes' : 'No' }}"
                                                        data-extension="{{ ($booking->is_extended ?? false) ? ('+' . ($booking->extension_value ?? '') . ' ' . ($booking->extension_type ?? '')) : '' }}"
                                                        data-check-in="{{ !empty($booking->check_in_date) ? (\Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d')) : '' }}"
                                                        data-check-out="{{ !empty($booking->check_out_date) ? (\Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d')) : '' }}"
                                                        data-seniors="{{ $booking->num_senior_citizens ?? '' }}"
                                                        data-pwds="{{ $booking->num_pwds ?? '' }}"
                                                        data-boat-name="{{ $assignedBoat->boat_name ?? '' }}"
                                                        data-boat-number="{{ $assignedBoat->boat_number ?? '' }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center text-muted">No bookings found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(empty($showAll) || !$showAll)
                            <div class="mt-3">
                                {{ $bookings->appends(request()->query())->links('vendor.pagination.resort-owner') }}
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

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color:rgb(6, 58, 170) !important; /* Maroon Red */
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ro-doc-modal-header">
                    <div class="d-flex flex-column">
                        <h5 class="modal-title m-0 d-flex align-items-center gap-2" id="docViewModalLabel">
                            <i class="fas fa-file-alt"></i>
                            Booking Details
                        </h5>
                        <small class="text-white-75">Quick view of the selected record</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><strong>Name of Guests:</strong> <span id="docGuestName">N/A</span></div>
                    <div class="mb-2"><strong>Age:</strong> <span id="docGuestAge">N/A</span></div>
                    <div class="mb-2"><strong>Gender:</strong> <span id="docGuestGender">N/A</span></div>
                    <div class="mb-2"><strong>Nationality:</strong> <span id="docGuestNationality">N/A</span></div>
                    <div class="mb-2"><strong>Phone:</strong> <span id="docPhone">N/A</span></div>
                    <div class="mb-2"><strong>Address:</strong> <span id="docGuestAddress">N/A</span></div>
                    <div class="mb-2"><strong>Guests (Count):</strong> <span id="docGuestCount">N/A</span></div>
                    <hr>
                    <div class="row g-2">
                        <div class="col-6"><strong>Departure Time — Overnight:</strong> <span id="docOvernightDepartureRO">—</span></div>
                        <div class="col-6"><strong>Departure Time — Day tour:</strong> <span id="docDayTourDepartureRO">—</span></div>
                        <div class="col-6"><strong>Pick-up (leaving):</strong> <span id="docPickupRO">—</span></div>
                        <div class="col-6"><strong>Check-in Date:</strong> <span id="docCheckIn">—</span></div>
                        <div class="col-6"><strong>Check-out Date:</strong> <span id="docCheckOut">—</span></div>
                        <div class="col-6"><strong>Seniors:</strong> <span id="docSeniors">—</span></div>
                        <div class="col-6"><strong>PWDs:</strong> <span id="docPwds">—</span></div>
                    </div>
                    <hr>
                    <div class="mb-2"><strong>Assigned Boat:</strong> <span id="docBoatName">N/A</span></div>
                    <div class="mb-2"><strong>Boat Plate Number:</strong> <span id="docBoatNumber">N/A</span></div>
                    
                    <div class="mb-2"><strong>Downpayment Receipt:</strong> <button type="button" id="btnViewDownpaymentRO" class="btn btn-sm btn-outline-primary view-image-btn" style="display:none;">View</button></div>
                    <div class="mb-2"><strong>Valid ID:</strong> <span id="docValidIdTypeRO">—</span> <button type="button" id="btnViewValidIdRO" class="btn btn-sm btn-outline-primary ms-2 view-image-btn" style="display:none;">View</button></div>
                    <div class="mb-2" id="docValidIdNumberRowRO" style="display:none;"><strong>ID Number:</strong> <span id="docValidIdNumberRO">—</span></div>
                        <div class="mb-2" id="docSeniorIdRowRO" style="display:none;"><strong>Senior ID:</strong> <button type="button" id="btnViewSeniorIdRO" class="btn btn-sm btn-outline-primary ms-2 view-image-btn">View</button></div>
                        <div class="mb-2" id="docPwdIdRowRO" style="display:none;"><strong>PWD ID:</strong> <button type="button" id="btnViewPwdIdRO" class="btn btn-sm btn-outline-primary ms-2 view-image-btn">View</button></div>
                    <div class="mb-2"><strong>Extended:</strong> <span id="docExtended">No</span></div>
                    <div class="mb-2"><strong>Extension Details:</strong> <span id="docExtension">—</span></div>
                </div>
                <div class="modal-footer ro-doc-modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
            document.querySelectorAll('.viewDocBtn').forEach(function(btn){
                btn.addEventListener('click', function(){
                    const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val || 'N/A'; };
                    setText('docGuestName', this.getAttribute('data-guest-name'));
                    setText('docGuestAge', this.getAttribute('data-guest-age'));
                    setText('docGuestGender', this.getAttribute('data-guest-gender'));
                    setText('docGuestNationality', this.getAttribute('data-guest-nationality'));
                    setText('docPhone', this.getAttribute('data-phone'));
                    setText('docGuestAddress', this.getAttribute('data-guest-address'));
                    setText('docGuestCount', this.getAttribute('data-guest-count'));
                    const down = this.getAttribute('data-downpayment') || '';
                    // New timing fields
                    setText('docOvernightDepartureRO', this.getAttribute('data-overnight-departure') || '—');
                    setText('docDayTourDepartureRO', this.getAttribute('data-daytour-departure') || '—');
                    setText('docPickupRO', this.getAttribute('data-pickup') || '—');
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

                    // New fields passed via data attributes
                    setText('docCheckIn', this.getAttribute('data-check-in') || '—');
                    setText('docCheckOut', this.getAttribute('data-check-out') || '—');
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

        .disabled-link {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .disabled-link .nav-icon-img.disabled {
            opacity: 0.5;
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
            padding: 2rem;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
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
                width: 90vw !important;
            }
        }
    </style>
</x-app-layout>