<x-app-layout>
    <!-- Fixed background layer -->
    <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd); background-attachment: fixed; background-size: 100vw 100vh; background-position: 0 0; z-index: -1; margin: 0; padding: 0;"></div>
    
    <div class="d-flex flex-column flex-md-row" style="min-height: 100vh; width: 100%; position: relative; z-index: 1; background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Admin --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Admin Menu
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.resort') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                        <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Resort Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                        <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Boat Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <button class="nav-link text-white rounded p-2 d-flex align-items-center w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapse" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapse">
                        <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Users
                        <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                    </button>
                    <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapse">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.resorts') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.boats') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.tourists') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
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
                {{-- Icon added here for Admin in mobile sidebar --}}
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Admin Menu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.resort') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                            <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Information
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Boat Information
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <button class="nav-link text-white rounded p-2 d-flex align-items-center w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapseMobile" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapseMobile">
                            <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Users
                            <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                        </button>
                        <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapseMobile">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.resorts') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.boats') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.tourists') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
                            <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Documentation
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area: Tourist Bookings with search, filters, and export --}}
        <div class="flex-grow-1 p-4">
            <div class="container py-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4">Documentation - All Tourist Bookings</h3>

                        <form method="GET" action="{{ route('admin.documentation') }}" class="row g-3 align-items-end mb-4">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" id="search" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control" placeholder="Search by name, phone, address, resort, or boat">
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">From Date</label>
                                <input type="date" id="start_date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">To Date</label>
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
                                <a href="{{ route('admin.documentation.export', request()->query()) }}" class="btn btn-success">Export CSV</a>
                                <a href="{{ route('admin.documentation.export_pdf', request()->query()) }}" class="btn btn-danger">Export PDF</a>
                            </div>
                        </div>

                        <div id="docCapture" class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Resort</th>
                                        <th>Room</th>
                                        <th>Tourist Account</th>
                                        <th>Tour Type</th>
                                        <th>Departure Time</th>
                                        <th>Pick-up (Day)</th>
                                        <th>Pick-up (Overnight)</th>
                                        <th>Assigned Boat</th>
                                        <th>Boat Number</th>
                                        <th>Boat Captain</th>
                                        <th>Boat Contact</th>
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
                                                            echo \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('H:i');
                                                        } catch(\Exception $e) {
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
                                                            echo \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('H:i');
                                                        } catch(\Exception $e) {
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
                                                            echo \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('Y-m-d H:i');
                                                        } catch(\Exception $e) {
                                                            echo $booking->overnight_date_time_of_pickup;
                                                        }
                                                    @endphp
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ optional($booking->assignedBoat)->boat_name ?? $booking->assigned_boat ?? '—' }}</td>
                                            <td>{{ optional($booking->assignedBoat)->boat_number ?? '—' }}</td>
                                            <td>{{ optional($booking->assignedBoat)->captain_name ?? $booking->boat_captain_crew ?? '—' }}</td>
                                            <td>{{ optional($booking->assignedBoat)->captain_contact ?? $booking->boat_contact_number ?? '—' }}</td>
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
                                                    data-checkin="{{ optional($booking->check_in_date)->format('Y-m-d') }}"
                                                    data-checkout="{{ optional($booking->check_out_date)->format('Y-m-d') }}"
                                                    data-seniors="{{ $booking->num_senior_citizens ?? '' }}"
                                                    data-pwds="{{ $booking->num_pwds ?? '' }}"
                                                    data-guest-count="{{ $booking->number_of_guests ?? '' }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center text-muted">No bookings found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(empty($showAll) || !$showAll)
                            <div class="mt-3">
                                @if ($bookings->hasPages())
                                    <nav class="d-flex justify-content-center">
                                        <div class="d-flex justify-content-center flex-fill d-sm-none">
                                            <ul class="pagination">
                                                {{-- Previous Page Link --}}
                                                @if ($bookings->onFirstPage())
                                                    <li class="page-item disabled" aria-disabled="true">
                                                        <span class="page-link">@lang('pagination.previous')</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $bookings->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                                                    </li>
                                                @endif

                                                {{-- Next Page Link --}}
                                                @if ($bookings->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $bookings->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                                                    </li>
                                                @else
                                                    <li class="page-item disabled" aria-disabled="true">
                                                        <span class="page-link">@lang('pagination.next')</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>

                                        <div class="d-none d-sm-flex flex-column align-items-center">
                                            <div class="mb-2">
                                                <p class="small text-muted mb-0">
                                                    {!! __('Showing') !!}
                                                    <span class="fw-semibold">{{ $bookings->firstItem() }}</span>
                                                    {!! __('to') !!}
                                                    <span class="fw-semibold">{{ $bookings->lastItem() }}</span>
                                                    {!! __('of') !!}
                                                    <span class="fw-semibold">{{ $bookings->total() }}</span>
                                                    {!! __('results') !!}
                                                </p>
                                            </div>

                                            <div>
                                                <ul class="pagination">
                                                    {{-- Previous Page Link --}}
                                                    @if ($bookings->onFirstPage())
                                                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                                            <span class="page-link" aria-hidden="true">
                                                                <i class="fas fa-chevron-left" style="font-size: 14px; width: 14px; height: 14px; display: inline-block; text-align: center;"></i>
                                                            </span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $bookings->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                                                                <i class="fas fa-chevron-left" style="font-size: 14px; width: 14px; height: 14px; display: inline-block; text-align: center;"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    {{-- Pagination Elements --}}
                                                    @foreach ($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                                                        @if ($page == $bookings->currentPage())
                                                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                                        @else
                                                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                                        @endif
                                                    @endforeach

                                                    {{-- Next Page Link --}}
                                                    @if ($bookings->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $bookings->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                                                                <i class="fas fa-chevron-right" style="font-size: 14px; width: 14px; height: 14px; display: inline-block; text-align: center;"></i>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                                            <span class="page-link" aria-hidden="true">
                                                                <i class="fas fa-chevron-right" style="font-size: 14px; width: 14px; height: 14px; display: inline-block; text-align: center;"></i>
                                                            </span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documentation Row View Modal -->
    <div class="modal fade" id="docViewModal" tabindex="-1" aria-labelledby="docViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="docViewModalLabel">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><strong>Guest Name:</strong> <span id="docGuestName">N/A</span></div>
                    <div class="mb-2"><strong>Age:</strong> <span id="docGuestAge">N/A</span></div>
                    <div class="mb-2"><strong>Gender:</strong> <span id="docGuestGender">N/A</span></div>
                    <div class="mb-2"><strong>Address:</strong> <span id="docGuestAddress">N/A</span></div>
                    <div class="mb-2"><strong>Nationality:</strong> <span id="docGuestNationality">N/A</span></div>
                    <div class="mb-2"><strong>Phone:</strong> <span id="docPhone">N/A</span></div>
                    <div class="mb-2"><strong>Check-in Date:</strong> <span id="docCheckin">N/A</span></div>
                    <div class="mb-2"><strong>Check-out Date:</strong> <span id="docCheckout">N/A</span></div>
                    <div class="mb-2"><strong>Guests (Count):</strong> <span id="docGuestCount">N/A</span></div>
                    <div class="mb-2"><strong>Seniors:</strong> <span id="docSeniors">N/A</span></div>
                    <div class="mb-2"><strong>PWDs:</strong> <span id="docPWDs">N/A</span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom CSS for sidebar nav-link hover and focus --}}
    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* This is the specific blue from your provided images */
        }
        .collapse-icon { transition: transform 0.3s ease; }
        .collapse-icon.rotated { transform: rotate(180deg); }

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