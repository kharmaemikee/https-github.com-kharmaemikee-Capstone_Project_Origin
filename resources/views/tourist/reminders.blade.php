<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        @include('tourist.partials.sidebar')

        {{-- Main Content Area --}}
        <div class="container-fluid flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 style="color: #2C3E50;">Reminders</h1>
                {{-- View All Resorts Button - moved to top right --}}
                <a href="{{ route('tourist.list') }}" class="btn btn-primary btn-sm shadow-sm rounded-pill px-4 py-2" style="background-color: #3498DB; border-color: #3498DB;">
                    <i class="bi bi-house-fill me-2"></i>View All Resorts
                </a>
            </div>

            <div class="row g-4">
                {{-- Registration Step Box --}}
                <div class="col-md-6">
                    <div class="step-box">
                        <div class="step-icon"><img src="{{ asset('images/registration.png') }}" alt="Registration Icon" style="width: 32px; height: 32px;"></div>
                        <div class="step-content">
                            <h3>01 REGISTRATION</h3>
                            <p>Fill out the required information: name, address, age, nationality, and contact number.</p>
                        </div>
                    </div>
                </div>

                {{-- Payment Step Box --}}
                <div class="col-md-6">
                    <div class="step-box">
                        <div class="step-icon"><img src="{{ asset('images/payment.png') }}" alt="Payment Icon" style="width: 32px; height: 32px;"></div>
                        <div class="step-content">
                            <h3>02 PAYMENT</h3>
                            <p>
                                <strong>BOAT RENTAL</strong>
                                <br>
                                <span style="display:inline-block; background-color:#28a745; color:white; padding: 5px 10px; border-radius: 5px; margin-top: 5px;">P 3,000 Day Tour</span>
                                <span style="display:inline-block; background-color:#ffc107; color:#333; padding: 5px 10px; border-radius: 5px; margin-top: 5px; margin-left: 10px;">P 3,500 Overnight</span>
                                <br>
                                <strong>REGISTRATION FEE</strong>
                                <span style="display:inline-block; background-color:#17a2b8; color:white; padding: 5px 10px; border-radius: 5px; margin-top: 5px;">P 150 Local</span>
                                <span style="display:inline-block; background-color:#dc3545; color:white; padding: 5px 10px; border-radius: 5px; margin-top: 5px; margin-left: 10px;">P 300 Foreign</span>
                                <br>
                                <small>7 years old and below - No Registration Fee</small>
                                <br>
                                <small>20% discount for Senior Citizen & PWDs</small>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Juag Lagoon Fish Sanctuary Card --}}
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold text-uppercase mb-3">Juag Lagoon Fish Sanctuary</h5>
                            <div class="row g-2">
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/juag.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon">
                                </div>
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/juag2.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon">
                                </div>
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/juag3.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon">
                                </div>
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/juag4.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Calintaan Cave Card --}}
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold text-uppercase mb-3">Calintaan Cave</h5>
                            <div class="row g-2">
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/cave.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave">
                                </div>
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/cave2.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave">
                                </div>
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/cave3.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave">
                                </div>
                                <div class="col-6 col-md-3">
                                    <img src="{{ asset('images/cave4.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Subic Beach Card --}}
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold text-uppercase mb-3">Subic Beach</h5>
                            <div class="row g-2">
                               
                                <div class="col-6 col-md-4">
                                    <img src="{{ asset('images/subic2.png') }}" class="img-fluid rounded-3" alt="Subic Beach">
                                </div>
                                <div class="col-6 col-md-4">
                                    <img src="{{ asset('images/subic3.png') }}" class="img-fluid rounded-3" alt="Subic Beach">
                                </div>
                                <div class="col-6 col-md-4">
                                    <img src="{{ asset('images/subic4.png') }}" class="img-fluid rounded-3" alt="Subic Beach">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 10 Persons per Boat Trip Reminder --}}
                <div class="col-md-6">
                    <div class="step-box" style="justify-content: center; text-align: center; border-left: 8px solid #ff9800; background-color: #fff8e1;">
                        <div class="step-content">
                            <h3 style="color: #e65100;">10 PERSONS PER BOAT TRIP</h3>
                            <p>Enjoy your trip with up to 10 individuals per boat.</p>
                        </div>
                    </div>
                </div>

                {{-- Contact Us Box --}}
                <div class="col-md-6">
                    <div class="step-box" style="justify-content: center; text-align: center; border-left: 8px solid #6c757d; background-color: #e2e6ea;">
                        <div class="step-content">
                            <h3 style="color: #343a40;">CONTACT US!</h3>
                            <p>
                                <img src="{{ asset('images/phone.png') }}" alt="Phone Icon" style="width: 20px; height: 20px; margin-right: 5px; vertical-align: middle;"> 0909-515-9274<br>
                                <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 20px; height: 20px; margin-right: 5px; vertical-align: middle;"> Matnog Tourism Culture and Arts Office<br>
                                <img src="{{ asset('images/home.png') }}" alt="Location Icon" style="width: 20px; height: 20px; margin-right: 5px; vertical-align: middle;"> Camcaman, Matnog, Sorsogon
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Icons CSS (Optional, but good for icons like person-lines-fill) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color:rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Custom CSS for light background badges - retained for potential future use or consistency */
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
            background-color: #f8f9fa !important; /* Very light gray, almost white */
            color: #212529 !important; /* Dark text for contrast */
            border: 1px solid #dee2e6 !important;
        }

        /* Custom styles for cards - retained for potential future use or consistency */
        .card-title {
            font-weight: bold;
            color: #333;
            font-size: 1.15rem;
        }
        .card-text {
            font-size: 0.95rem;
            color: #6c757d;
        }
        .resort-view-rooms-btn {
            background-color: rgb(9, 135, 219);
            border-color: rgb(9, 135, 219);
            color: #fff;
            border-radius: 6px; /* Added border-radius for rounded shape */
            padding: 7px 10px;    /* Adjusted padding for smaller button */
            transition: background-color 0.2s, border-color 0.2s;
        }
        .resort-view-rooms-btn:hover {
            background-color: rgb(5, 95, 155) !important;
            border-color: rgb(5, 95, 155) !important;
        }
        .card-body > *:first-child {
            margin-top: 0;
        }
        .flex-grow-1 {
            flex-grow: 1;
        }
        .h-100.d-flex.flex-column {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }

        /* Card Hover Effect - retained for consistency */
        .hover-effect-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            cursor: pointer;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
        }

        .hover-effect-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }

        /* Styles for the new "step-box" content */
        .step-box {
            display: flex;
            align-items: flex-start;
            background-color: #f2faff;
            border: 2px solid #b3e5fc;
            border-left: 8px solid #00aaff; /* Default blue border */
            padding: 15px;
            margin-bottom: 16px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08); /* Lighter shadow for step-boxes */
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            height: 100%; /* Ensure all step-boxes in a row have equal height */
        }

        .step-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12); /* Stronger shadow on hover */
        }

        .step-icon {
            font-size: 32px;
            margin-right: 15px;
            flex-shrink: 0;
            margin-top: 2px;
            color: #00aaff;
        }
        .step-icon img {
            display: block;
        }

        .step-content h3 {
            margin: 0;
            font-size: 18px;
            color: #0077b6;
            font-weight: 600;
        }

        .step-content p {
            margin: 4px 0 0;
            font-size: 15px;
            color: #333;
            line-height: 1.5;
        }

        /* Specific styles for step-boxes with custom colors */
        .step-box[style*="border-left: 8px solid #ff9800"] { /* 10 Persons box */
            border-color: #ff9800 !important;
            background-color: #fff8e1 !important;
        }
        .step-box[style*="border-left: 8px solid #6c757d"] { /* Contact Us box */
            border-color: #6c757d !important;
            background-color: #e2e6ea !important;
        }
        .step-box h3[style*="color: #e65100"] { /* 10 Persons title */
            color: #e65100 !important;
        }
        .step-box h3[style*="color: #343a40"] { /* Contact Us title */
            color: #343a40 !important;
        }

        /* Adjustments for the View All Resorts button when at the top-right */
        .btn-primary.btn-sm {
            padding: 0.5rem 1.25rem; /* Slightly larger padding for readability */
            font-size: 0.875rem; /* Standard small button font size */
        }
    </style>

    {{-- Custom JavaScript for image error handling and mobile sidebar behavior --}}
    <script>
        function handleImageError(imgElement, defaultImagePath) {
            imgElement.onerror = null;
            imgElement.src = defaultImagePath;
        }

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