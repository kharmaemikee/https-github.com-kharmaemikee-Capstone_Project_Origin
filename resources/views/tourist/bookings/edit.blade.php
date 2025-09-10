    <x-app-layout>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        </head>

        <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
            {{-- Desktop Sidebar (same as your visit.blade.php) --}}
            <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
                <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Menu
                </h4>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start">
                            <img src="{{ asset('images/house.png') }}" alt="Home Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Home
                        </a>
                    </li>
                    @php
                        $unreadCount = 0;
                        try {
                            if (Auth::check()) {
                                $unreadCount = \App\Models\TouristNotification::where('user_id', Auth::id())->where('is_read', false)->count();
                            }
                        } catch (\Throwable $e) { $unreadCount = 0; }
                    @endphp
                    <li class="nav-item mt-2">
                        <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 active d-flex align-items-center justify-content-start">
                            <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Your Visit
                            @if($unreadCount > 0)
                                <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Mobile Offcanvas Toggle Button (same as your visit.blade.php) --}}
            <div class="d-md-none bg-light border-bottom p-2">
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                    &#9776;
                </button>
            </div>

            {{-- Mobile Offcanvas Sidebar (same as your visit.blade.php) --}}
            <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                        <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                        Menu
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start">
                                <img src="{{ asset('images/house.png') }}" alt="Home Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Home
                            </a>
                        </li>
                        <li class="nav-item mt-2">
                            <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start active">
                                Your Visit
                                @if(($unreadCount ?? 0) > 0)
                                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Main Content Area --}}
            <main class="py-4 px-3 flex-grow-1">
                <div class="container">
                    <h2 class="fw-bold mb-4">Edit Your Booking</h2>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('tourist.bookings.update', $booking->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <h5 class="mb-3">Booking Details for {{ $booking->room->room_name ?? 'N/A' }} at {{ $booking->name_of_resort }}</h5>

                                <div class="mb-3">
                                    <label for="reservation_date" class="form-label">Reservation Date</label>
                                    <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" id="reservation_date" name="reservation_date" value="{{ old('reservation_date', \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d')) }}" required>
                                    @error('reservation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="num_guests" class="form-label">Number of Guests</label>
                                    <input type="number" class="form-control @error('num_guests') is-invalid @enderror" id="num_guests" name="num_guests" value="{{ old('num_guests', $booking->number_of_guests) }}" min="1" required>
                                    @error('num_guests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tour_type" class="form-label">Tour Type</label>
                                    <select class="form-select @error('tour_type') is-invalid @enderror" id="tour_type" name="tour_type" required>
                                        <option value="day_tour" {{ old('tour_type', $booking->tour_type) == 'day_tour' ? 'selected' : '' }}>Day Tour</option>
                                        <option value="overnight" {{ old('tour_type', $booking->tour_type) == 'overnight' ? 'selected' : '' }}>Overnight</option>
                                    </select>
                                    @error('tour_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Conditional fields for Day Tour --}}
                                <div id="day_tour_fields" style="display: {{ old('tour_type', $booking->tour_type) == 'day_tour' ? 'block' : 'none' }};">
                                    <div class="mb-3">
                                        <label for="day_tour_departure_time" class="form-label">Departure Time</label>
                                        <input type="time" class="form-control @error('day_tour_departure_time') is-invalid @enderror" id="day_tour_departure_time" name="day_tour_departure_time" value="{{ old('day_tour_departure_time', $booking->day_tour_departure_time ? (is_numeric($booking->day_tour_departure_time) ? date('H:i', strtotime($booking->day_tour_departure_time)) : \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('H:i')) : '') }}">
                                        @error('day_tour_departure_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="day_tour_time_of_pickup" class="form-label">Time of Pickup</label>
                                        <input type="time" class="form-control @error('day_tour_time_of_pickup') is-invalid @enderror" id="day_tour_time_of_pickup" name="day_tour_time_of_pickup" value="{{ old('day_tour_time_of_pickup', $booking->day_tour_time_of_pickup ? (is_numeric($booking->day_tour_time_of_pickup) ? date('H:i', strtotime($booking->day_tour_time_of_pickup)) : \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('H:i')) : '') }}">
                                        @error('day_tour_time_of_pickup')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Conditional fields for Overnight --}}
                                <div id="overnight_fields" style="display: {{ old('tour_type', $booking->tour_type) == 'overnight' ? 'block' : 'none' }};">
                                    <div class="mb-3">
                                        <label for="num_nights" class="form-label">Number of Nights</label>
                                        <input type="number" class="form-control @error('num_nights') is-invalid @enderror" id="num_nights" name="num_nights" value="{{ old('num_nights', $booking->number_of_nights) }}" min="0">
                                        @error('num_nights')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="overnight_date_time_of_pickup" class="form-label">Pickup Date/Time</label>
                                        <input type="datetime-local" class="form-control @error('overnight_date_time_of_pickup') is-invalid @enderror" id="overnight_date_time_of_pickup" name="overnight_date_time_of_pickup" value="{{ old('overnight_date_time_of_pickup', $booking->overnight_date_time_of_pickup ? (is_numeric($booking->overnight_date_time_of_pickup) ? date('Y-m-d\TH:i', strtotime($booking->overnight_date_time_of_pickup)) : \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('Y-m-d\TH:i')) : '') }}">
                                        @error('overnight_date_time_of_pickup')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h5 class="mt-4 mb-3">Tourist Information</h5>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $firstName) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="middle_name" class="form-label">Middle Name (Optional)</label>
                                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name', $middleName) }}">
                                    @error('middle_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $lastName) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age', $booking->guest_age) }}" min="1" required>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                        <option value="male" {{ old('gender', $booking->guest_gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $booking->guest_gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $booking->guest_gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $booking->guest_address) }}" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality" value="{{ old('nationality', $booking->guest_nationality) }}" required>
                                    @error('nationality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="contact_number" class="form-label">Contact Number</label>
                                    <input type="text" 
                                           class="form-control @error('contact_number') is-invalid @enderror" 
                                           id="contact_number" 
                                           name="contact_number" 
                                           value="{{ old('contact_number', $booking->phone_number) }}" 
                                           placeholder="e.g., 09123456789"
                                           pattern="[0-9]{11}" 
                                           maxlength="11" 
                                           minlength="11"
                                           title="Please enter exactly 11 digits for the contact number." 
                                           inputmode="numeric"
                                           oninput="validateContactNumber(this)"
                                           required>
                                    <div id="contact_number_error" class="text-danger mt-1" style="display: none;">
                                        The number is not enough. Please enter exactly 11 digits.
                                    </div>
                                    @error('contact_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="num_senior_citizens" class="form-label">Number of Senior Citizens</label>
                                    <input type="number" class="form-control @error('num_senior_citizens') is-invalid @enderror" id="num_senior_citizens" name="num_senior_citizens" value="{{ old('num_senior_citizens', $booking->num_senior_citizens) }}" min="0">
                                    @error('num_senior_citizens')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="num_pwds" class="form-label">Number of PWDs</label>
                                    <input type="number" class="form-control @error('num_pwds') is-invalid @enderror" id="num_pwds" name="num_pwds" value="{{ old('num_pwds', $booking->num_pwds) }}" min="0">
                                    @error('num_pwds')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="special_requests" class="form-label">Special Requests (Optional)</label>
                                    <textarea class="form-control @error('special_requests') is-invalid @enderror" id="special_requests" name="special_requests" rows="3">{{ old('special_requests', $booking->special_requests) }}</textarea>
                                    @error('special_requests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('tourist.visit') }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Booking</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <style>
            /* Add any specific styles for the edit page here if needed */
            .nav-link.text-white:hover,
            .nav-link.text-white:focus,
            .nav-link.text-white.active {
                background-color: rgb(6, 58, 170) !important;
            }
        </style>

        <script>
            // Function to validate contact number input
            function validateContactNumber(input) {
                const value = input.value;
                const errorDiv = document.getElementById('contact_number_error');
                
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
                // Logic for showing/hiding tour type specific fields
                const tourTypeSelect = document.getElementById('tour_type');
                const dayTourFields = document.getElementById('day_tour_fields');
                const overnightFields = document.getElementById('overnight_fields');

                function toggleTourTypeFields() {
                    if (tourTypeSelect.value === 'day_tour') {
                        dayTourFields.style.display = 'block';
                        overnightFields.style.display = 'none';
                    } else if (tourTypeSelect.value === 'overnight') {
                        dayTourFields.style.display = 'none';
                        overnightFields.style.display = 'block';
                    }
                }

                tourTypeSelect.addEventListener('change', toggleTourTypeFields);
                toggleTourTypeFields(); // Call on load to set initial state

                // Mobile sidebar behavior (from your original code)
                var mobileSidebar = document.getElementById('mobileSidebar');
                if (mobileSidebar) {
                    var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                    function hideOffcanvasOnDesktop() {
                        if (window.innerWidth >= 768) {
                            offcanvas.hide();
                        }
                    }
                    hideOffcanvasOnDesktop();
                    window.addEventListener('resize', hideOffcanvasOnDesktop);
                }
            });
        </script>
    </x-app-layout>
    