<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Admin --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                ADMIN
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
                        <img src="{{ asset('images/information.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Resort Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                        <img src="{{ asset('images/information1.png') }}" alt="Boat Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Boat Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.users') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Users
                    </a>
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
                    ADMIN
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
                            <img src="{{ asset('images/information.png') }}" alt="Resort Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Information
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                            <img src="{{ asset('images/information1.png') }}" alt="Boat Information Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Boat Information
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.users') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Users
                        </a>
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
                                <button id="downloadPngBtn" type="button" class="btn btn-primary">Download PNG</button>
                            </div>
                        </div>

                        <div id="docCapture" class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Resort</th>
                                        <th>Room</th>
                                        <th>Tourist Account</th>
                                        <th>Guest Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th>Nationality</th>
                                        <th>Phone</th>
                                        <th>Tour Type</th>
                                        <th>Pick-up (Day)</th>
                                        <th>Departure Time</th>
                                        <th>Pick-up (Overnight)</th>
                                        <th>Seniors</th>
                                        <th>PWDs</th>
                                        <th>Check-in Date</th>
                                        <th>Check-out Date</th>
                                        <th>Guests (Count)</th>
                                        <th>Assigned Boat</th>
                                        <th>Boat Number</th>
                                        <th>Boat Captain</th>
                                        <th>Boat Contact</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->id }}</td>
                                            <td>{{ optional(optional($booking->room)->resort)->resort_name ?? ($booking->name_of_resort ?? '—') }}</td>
                                            <td>{{ optional($booking->room)->room_name ?? '—' }}</td>
                                            <td>
                                                @php
                                                    $acctName = trim(((optional($booking->user)->first_name ?? '') . ' ' . (optional($booking->user)->last_name ?? '')));
                                                @endphp
                                                {{ $acctName !== '' ? $acctName : (optional($booking->user)->username ?? '—') }}
                                            </td>
                                            <td>{{ $booking->guest_name ?? '—' }}</td>
                                            <td>{{ $booking->guest_age ?? '—' }}</td>
                                            <td>{{ ucfirst($booking->guest_gender ?? '—') }}</td>
                                            <td>{{ $booking->guest_address ?? '—' }}</td>
                                            <td>{{ $booking->guest_nationality ?? '—' }}</td>
                                            <td>{{ $booking->phone_number ?? '—' }}</td>
                                            <td>{{ ucfirst($booking->tour_type ?? '—') }}</td>
                                            <td>{{ $booking->day_tour_time_of_pickup ? (\Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('H:i')) : '—' }}</td>
                                            <td>{{ $booking->day_tour_departure_time ? (\Carbon\Carbon::parse($booking->day_tour_departure_time)->format('H:i')) : '—' }}</td>
                                            <td>{{ $booking->overnight_date_time_of_pickup ? (\Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('Y-m-d H:i')) : '—' }}</td>
                                            <td>{{ $booking->num_senior_citizens ?? '—' }}</td>
                                            <td>{{ $booking->num_pwds ?? '—' }}</td>
                                            <td>{{ optional($booking->check_in_date)->format('Y-m-d') }}</td>
                                            <td>{{ optional($booking->check_out_date)->format('Y-m-d') }}</td>
                                            <td>{{ $booking->number_of_guests ?? '—' }}</td>
                                            <td>{{ optional($booking->assignedBoat)->boat_name ?? $booking->assigned_boat ?? '—' }}</td>
                                            <td>{{ optional($booking->assignedBoat)->boat_number ?? '—' }}</td>
                                            <td>{{ optional($booking->assignedBoat)->captain_name ?? $booking->boat_captain_crew ?? '—' }}</td>
                                            <td>{{ optional($booking->assignedBoat)->captain_contact ?? $booking->boat_contact_number ?? '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="24" class="text-center text-muted">No bookings found.</td>
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

    {{-- Custom CSS for sidebar nav-link hover and focus --}}
    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* This is the specific blue from your provided images */
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
    </style>

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
</x-app-layout>