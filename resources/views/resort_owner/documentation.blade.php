<x-app-layout>
    <!-- Fixed background layer -->
    <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd); background-attachment: fixed; background-size: 100vw 100vh; background-position: 0 0; z-index: -1; margin: 0; padding: 0;"></div>
    
    <div class="d-flex flex-column flex-md-row" style="min-height: 100vh; width: 100%; position: relative; z-index: 1; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Resort Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Resorts Menu
            </h4>
            <ul class="nav flex-column mt-3">
                
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
                {{-- Notifications (Desktop) --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                        <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Notifications
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger ms-2" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                {{-- Documentation (Desktop) --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                        <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Documentation
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
                        <h3 class="mb-4">Documentation - Resort Bookings</h3>

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

                        <div id="docCapture" class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Resort</th>
                                        <th>Room</th>
                                        <th>Tourist</th>
                                        <th>Tour Type</th>
                                        <th>Departure Time</th>
                                        <th>Pick-up (Day)</th>
                                        <th>Pick-up (Overnight)</th>
                                        <th>Seniors</th>
                                        <th>PWDs</th>
                                        <th>Check-in Date</th>
                                        <th>Check-out Date</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>{{ optional(optional($booking->room)->resort)->resort_name ?? ($booking->name_of_resort ?? '—') }}</td>
                                            <td>{{ optional($booking->room)->room_name ?? '—' }}</td>
                                            <td>
                                                @php
                                                    $acctName = trim(((optional($booking->user)->first_name ?? '') . ' ' . (optional($booking->user)->last_name ?? '')));
                                                @endphp
                                                {{ $acctName !== '' ? $acctName : (optional($booking->user)->username ?? '—') }}
                                            </td>
                                            <td>{{ ucfirst($booking->tour_type ?? '—') }}</td>
                                            <td>
                                                @if($booking->day_tour_departure_time)
                                                    @php
                                                        try {
                                                            // Try to parse as time first
                                                            if (preg_match('/^\d{1,2}:\d{2}$/', $booking->day_tour_departure_time)) {
                                                                echo \Carbon\Carbon::createFromFormat('H:i', $booking->day_tour_departure_time)->format('H:i');
                                                            } else {
                                                                echo \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('H:i');
                                                            }
                                                        } catch (\Exception $e) {
                                                            echo $booking->day_tour_departure_time;
                                                        }
                                                    @endphp
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->day_tour_time_of_pickup)
                                                    @php
                                                        try {
                                                            // Try to parse as time first
                                                            if (preg_match('/^\d{1,2}:\d{2}$/', $booking->day_tour_time_of_pickup)) {
                                                                echo \Carbon\Carbon::createFromFormat('H:i', $booking->day_tour_time_of_pickup)->format('H:i');
                                                            } else {
                                                                echo \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('H:i');
                                                            }
                                                        } catch (\Exception $e) {
                                                            echo $booking->day_tour_time_of_pickup;
                                                        }
                                                    @endphp
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->overnight_date_time_of_pickup)
                                                    @php
                                                        try {
                                                            // Try to parse as datetime first
                                                            if (preg_match('/^\d{4}-\d{2}-\d{2} \d{1,2}:\d{2}$/', $booking->overnight_date_time_of_pickup)) {
                                                                echo \Carbon\Carbon::createFromFormat('Y-m-d H:i', $booking->overnight_date_time_of_pickup)->format('Y-m-d H:i');
                                                            } elseif (preg_match('/^\d{1,2}:\d{2}$/', $booking->overnight_date_time_of_pickup)) {
                                                                echo \Carbon\Carbon::createFromFormat('H:i', $booking->overnight_date_time_of_pickup)->format('H:i');
                                                            } else {
                                                                echo \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('Y-m-d H:i');
                                                            }
                                                        } catch (\Exception $e) {
                                                            echo $booking->overnight_date_time_of_pickup;
                                                        }
                                                    @endphp
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $booking->num_senior_citizens ?? '—' }}</td>
                                            <td>{{ $booking->num_pwds ?? '—' }}</td>
                                            <td>{{ optional($booking->check_in_date)->format('Y-m-d') }}</td>
                                            <td>{{ optional($booking->check_out_date)->format('Y-m-d') }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-info btn-sm viewDocBtn"
                                                        title="View details" aria-label="View details"
                                                        data-bs-toggle="modal" data-bs-target="#docViewModal"
                                                        data-guest-name="{{ $booking->guest_name ?? '' }}"
                                                        data-guest-age="{{ $booking->guest_age ?? '' }}"
                                                        data-guest-gender="{{ $booking->guest_gender ?? '' }}"
                                                        data-guest-address="{{ $booking->guest_address ?? '' }}"
                                                        data-guest-nationality="{{ $booking->guest_nationality ?? '' }}"
                                                        data-phone="{{ $booking->phone_number ?? '' }}"
                                                        data-guest-count="{{ $booking->number_of_guests ?? '' }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center text-muted">No bookings found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(empty($showAll) || !$showAll)
                            <div class="mt-3">
                                {{ $bookings->links() }}
                            </div>
                        @endif
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
                <div class="modal-header">
                    <h5 class="modal-title" id="docViewModalLabel">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><strong>Name of Guests:</strong> <span id="docGuestName">N/A</span></div>
                    <div class="mb-2"><strong>Age:</strong> <span id="docGuestAge">N/A</span></div>
                    <div class="mb-2"><strong>Gender:</strong> <span id="docGuestGender">N/A</span></div>
                    <div class="mb-2"><strong>Nationality:</strong> <span id="docGuestNationality">N/A</span></div>
                    <div class="mb-2"><strong>Phone:</strong> <span id="docPhone">N/A</span></div>
                    <div class="mb-2"><strong>Address:</strong> <span id="docGuestAddress">N/A</span></div>
                    <div class="mb-2"><strong>Guests (Count):</strong> <span id="docGuestCount">N/A</span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                });
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
    </style>
</x-app-layout>