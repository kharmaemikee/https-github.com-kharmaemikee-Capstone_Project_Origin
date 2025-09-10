<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Boat Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Boat Menu
            </h4>
            <ul class="nav flex-column mt-3">
                
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Boat Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Account Management
                    </a>
                </li>
                {{-- Notification (Desktop) --}}
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                        <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Notifications
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger ms-2" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                        @endif
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
                {{-- Icon added here for Boat Owner in mobile sidebar using <img> --}}
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Boat Menu
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                   
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Boat Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Account Management
                        </a>
                    </li>
                    {{-- Notification (Mobile) --}}
                    <li class="nav-item mt-2">
                        <a href="{{ route('boat.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notifications
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex-grow-1 p-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h2 class="mb-4">Add Boat</h2>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('boats.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="boat_name" class="form-label">Boat Name</label>
                                    <input type="text" class="form-control" id="boat_name" name="boat_name" placeholder="Enter boat name" value="{{ old('boat_name') }}">
                                    @error('boat_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="boat_number" class="form-label">Boat Number</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="boat_number" 
                                           name="boat_number" 
                                           placeholder="e.g., 09123456789" 
                                           value="{{ old('boat_number') }}" 
                                           pattern="[0-9]{11}" 
                                           maxlength="11" 
                                           minlength="11"
                                           title="Please enter exactly 11 digits for the boat number." 
                                           inputmode="numeric"
                                           oninput="validateBoatNumber(this)"
                                           required>
                                    <div id="boat_number_error" class="text-danger mt-1" style="display: none;">
                                        The boat number must be exactly 11 digits.
                                    </div>
                                    @error('boat_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="boat_prices" class="form-label">Boat Prices</label>
                                    <input type="number" class="form-control" id="boat_prices" name="boat_prices" placeholder="Enter boat prices" value="{{ old('boat_prices') }}" step="0.01">
                                    @error('boat_prices')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="boat_capacities" class="form-label">Boat Capacities</label>
                                    <input type="number" class="form-control" id="boat_capacities" name="boat_capacities" placeholder="Enter boat capacities" value="{{ old('boat_capacities') }}">
                                    @error('boat_capacities')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="captain_name" class="form-label">Boat Captain Name</label>
                                    <input type="text" class="form-control" id="captain_name" name="captain_name" placeholder="Enter captain full name" value="{{ old('captain_name') }}">
                                    @error('captain_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="captain_contact" class="form-label">Boat Captain Contact</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="captain_contact" 
                                           name="captain_contact" 
                                           placeholder="e.g., 09123456789" 
                                           value="{{ old('captain_contact') }}"
                                           pattern="[0-9]{11}" 
                                           maxlength="11" 
                                           minlength="11"
                                           title="Please enter exactly 11 digits for the captain contact number." 
                                           inputmode="numeric"
                                           oninput="validateCaptainContact(this)">
                                    <div id="captain_contact_error" class="text-danger mt-1" style="display: none;">
                                        The number is not enough. Please enter exactly 11 digits.
                                    </div>
                                    @error('captain_contact')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="image_path" class="form-label">Upload Boat Image</label>
                                    <input type="file" class="form-control" id="image_path" name="image_path" accept="image/*">
                                    <small class="form-text text-muted">Upload a single image for your boat.</small>
                                    @error('image_path')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </form>
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
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Styles for the collapse icon rotation */
        .collapse-icon img {
            transition: transform 0.3s ease-in-out;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        /* Set width for mobile offcanvas sidebar */
        #mobileSidebar {
            width: 50vw; /* This makes it half the viewport width */
        }
    </style>

    <script>
        // Function to validate boat number input
        function validateBoatNumber(input) {
            const value = input.value;
            const errorDiv = document.getElementById('boat_number_error');
            
            // Remove any non-digit characters
            const digitsOnly = value.replace(/\D/g, '');
            
            // Update the input value to only contain digits
            if (value !== digitsOnly) {
                input.value = digitsOnly;
            }
            
            // Check if the length is exactly 11 digits
            if (digitsOnly.length > 0 && digitsOnly.length !== 11) {
                errorDiv.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

        // Function to validate captain contact input
        function validateCaptainContact(input) {
            const value = input.value;
            const errorDiv = document.getElementById('captain_contact_error');
            
            // Remove any non-digit characters
            const digitsOnly = value.replace(/\D/g, '');
            
            // Update the input value to only contain digits
            if (value !== digitsOnly) {
                input.value = digitsOnly;
            }
            
            // Check if the length is exactly 11 digits
            if (digitsOnly.length > 0 && digitsOnly.length !== 11) {
                errorDiv.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

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

            // Function to handle image errors and display a default image
            window.handleImageError = function(imgElement, defaultImagePath) {
                imgElement.onerror = null; // Prevent infinite loop if default image also fails
                imgElement.src = defaultImagePath;
            };

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
            // --- End JavaScript ---
        });
    </script>
</x-app-layout>