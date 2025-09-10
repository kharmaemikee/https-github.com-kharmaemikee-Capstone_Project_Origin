<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

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
                    {{-- Updated link to the new usersList method --}}
                    <a href="{{ route('admin.users') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Users
                    </a>
                </li>
                {{-- Documentation - now a direct link (Desktop) --}}
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
                        {{-- Updated link to the new usersList method --}}
                        <a href="{{ route('admin.users') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Users
                        </a>
                    </li>
                    {{-- Documentation - now a direct link (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.documentation') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
                            <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Documentation
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <h4 class="fw-bold">HOME</h4>
            <h5 class="text-muted">OVERVIEW</h5>

            <div class="container-fluid py-5">
                <div class="row g-4 justify-content-start"> {{-- Use justify-content-start to align left like the image --}}

                    {{-- Foreigners Box (similar to Total Partners/Tellers in your image) --}}
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3"> {{-- Responsive columns --}}
                        <a href="{{ route('admin.foreign') }}" class="text-decoration-none"> {{-- Updated route name --}}
                            <div class="card shadow rounded-3 border-0 h-100 p-3"> {{-- Added padding for inner content --}}
                                <div class="card-body p-0 d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        {{-- Foreign Flag Icon --}}
                                        <div class="p-2 rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e0f2f7; width: 48px; height: 48px;">
                                            <img src="{{ asset('images/flag1.png') }}" alt="Foreign Flag" style="width: 32px; height: 32px; object-fit: contain;">
                                        </div>
                                        <h6 class="ms-3 mb-0 text-muted">Other Nationalities</h6>
                                    </div>
                                    <div class="text-start">
                                        {{-- Display the actual count passed from the controller --}}
                                        <h3 class="fw-bold mb-0" id="foreignersCount">{{ $totalForeigners ?? 0 }}</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Filipino Box (similar to Total Customers/Deliveries in your image) --}}
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3"> {{-- Responsive columns --}}
                        <a href="{{ route('admin.total-filipino') }}" class="text-decoration-none"> {{-- Updated route name --}}
                            <div class="card shadow rounded-3 border-0 h-100 p-3"> {{-- Added padding for inner content --}}
                                <div class="card-body p-0 d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-center mb-3">
                                        {{-- Philippine Flag Icon --}}
                                        <div class="p-2 rounded-circle d-flex align-items-center justify-content-center" style="background-color: #e6ffe6; width: 48px; height: 48px;">
                                            <img src="{{ asset('images/flag.png') }}" alt="Philippine Flag" style="width: 32px; height: 32px; object-fit: contain;">
                                        </div>
                                        <h6 class="ms-3 mb-0 text-muted">Local Filipino</h6>
                                    </div>
                                    <div class="text-start">
                                        {{-- Display the actual count passed from the controller --}}
                                        <h3 class="fw-bold mb-0" id="filipinoCount">{{ $totalFilipinos ?? 0 }}</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- You can add more boxes here if needed, following the same structure --}}

                </div>


                {{-- Tour Type Statistics Bar Graph --}}
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card shadow rounded-3 border-0">
                            <div class="card-header bg-white border-0 pb-0">
                                <h5 class="card-title fw-bold text-dark mb-0">Tour Type Statistics</h5>
                                <p class="text-muted small mb-0">Distribution of day tours vs overnight stays</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <canvas id="tourTypeChart" width="400" height="200"></canvas>
                                    </div>
                                    <div class="col-md-4 d-flex flex-column justify-content-center">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3" style="width: 20px; height: 20px; background-color: #3498db; border-radius: 4px;"></div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Day Tours</h6>
                                                <span class="text-muted small">{{ $dayTourCount ?? 0 }} bookings</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="width: 20px; height: 20px; background-color: #e74c3c; border-radius: 4px;"></div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Overnight Stays</h6>
                                                <span class="text-muted small">{{ $overnightCount ?? 0 }} bookings</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }
    </style>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom JavaScript to handle offcanvas hiding and chart --}}
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
            // --- End JavaScript for Offcanvas ---

            // --- JavaScript for Tour Type Chart ---
            const ctx = document.getElementById('tourTypeChart').getContext('2d');
            const tourTypeChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Day Tours', 'Overnight Stays'],
                    datasets: [{
                        label: 'Number of Bookings',
                        data: [{{ $dayTourCount ?? 0 }}, {{ $overnightCount ?? 0 }}],
                        backgroundColor: [
                            '#3498db', // Blue for day tours
                            '#e74c3c'  // Red for overnight stays
                        ],
                        borderColor: [
                            '#2980b9', // Darker blue border
                            '#c0392b'  // Darker red border
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide legend since we have custom legend
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' bookings';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#666',
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: '#666',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
            // --- End JavaScript for Chart ---
        });
    </script>
</x-app-layout>