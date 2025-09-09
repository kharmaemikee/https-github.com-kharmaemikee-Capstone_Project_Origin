<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        @include('tourist.partials.sidebar')

        {{-- Main Content Area for Fill-up Form --}}
        <main class="py-4 px-3 flex-grow-1">
            <div class="container">
                <h2 class="mb-4">Tourist Registration Form</h2>

                {{-- Room Availability Notification --}}
                @if(isset($conflictingBooking) && $conflictingBooking)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">
                            <i class="bi bi-exclamation-triangle-fill"></i> Room Unavailable
                        </h5>
                        <p class="mb-2">
                            <strong>Sorry!</strong> This room is no longer available for the selected date 
                            <strong>
                                @php
                                    try {
                                        echo \Carbon\Carbon::parse($requestData['reservation_date'])->format('M d, Y');
                                    } catch(\Exception $e) {
                                        echo $requestData['reservation_date'];
                                    }
                                @endphp
                            </strong>.
                        </p>
                        <p class="mb-2">
                            <strong>Conflicting Booking:</strong> 
                            Guest: {{ $conflictingBooking->guest_name }} | 
                            Date: 
                            @php
                                try {
                                    echo \Carbon\Carbon::parse($conflictingBooking->check_in_date)->format('M d, Y');
                                } catch(\Exception $e) {
                                    echo $conflictingBooking->check_in_date;
                                }
                            @endphp
                        </p>
                        <hr>
                        <div class="d-flex gap-2">
                            <a href="{{ route('explore.exploring') }}" class="btn btn-primary">
                                <i class="bi bi-house-fill"></i> Go Back to Home
                            </a>
                            <a href="{{ route('tourist.list') }}" class="btn btn-outline-primary">
                                <i class="bi bi-search"></i> Find Available Rooms
                            </a>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Display success or error messages --}}
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

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Enter Your Booking Details</h5>
                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            {{-- Hidden fields to carry over data from fillup.blade.php --}}
                            {{-- Use old() helper to retain values on validation failure --}}
                            <input type="hidden" name="room_id" value="{{ old('room_id', $requestData['room_id'] ?? '') }}">
                            {{-- Primary guest information (moved here from step 1) --}}
                            <div class="mb-3">
                                <label class="form-label">Primary Guest Name</label>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First name" value="{{ old('first_name') }}" required>
                                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" placeholder="Middle name (optional)" value="{{ old('middle_name') }}">
                                        @error('middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Last name" value="{{ old('last_name') }}" required>
                                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Age</label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror" name="age" min="1" value="{{ old('age', $user ? (function($birthday) { try { return \Carbon\Carbon::parse($birthday)->age; } catch(\Exception $e) { return ''; } })($user->birthday) : '') }}" required>
                                    @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                        <option value="">Select</option>
                                        <option value="male" {{ old('gender', $user->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $user->address ?? '') }}" required>
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <input type="hidden" name="nationality" value="{{ old('nationality', $requestData['nationality'] ?? ($user ? $user->nationality : '')) }}">
                            <input type="hidden" name="contact_number" value="{{ old('contact_number', $requestData['contact_number'] ?? ($user ? $user->phone : '')) }}">
                            <input type="hidden" name="reservation_date" value="{{ old('reservation_date', $requestData['reservation_date'] ?? '') }}">
                            <input type="hidden" name="num_nights" value="{{ old('num_nights', $requestData['num_nights'] ?? '') }}">
                            {{-- Number of Guests (visible here to drive dynamic guest inputs) --}}
                            <div class="mb-3 mt-3">
                                <label for="numGuests" class="form-label">Number of Guests</label>
                                <input type="number" class="form-control @error('num_guests') is-invalid @enderror" id="numGuests" name="num_guests" min="1" value="{{ old('num_guests', $requestData['num_guests'] ?? 1) }}" required>
                                @error('num_guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Dynamic guest names --}}
                            <div id="guestNamesContainer" class="mb-3" style="display: none;">
                                <label class="form-label">Guest Names</label>
                                <div id="guestInputs" class="d-flex flex-column gap-2"></div>
                                <small class="text-muted">Enter the names of all additional guests (excluding primary guest), one per input.</small>
                            </div>

                            {{-- Day Tour / Overnight Selection --}}
                            <div class="mb-3">
                                <label for="tour_type" class="form-label">Type of Tour:</label>
                                <select class="form-select @error('tour_type') is-invalid @enderror" id="tour_type" name="tour_type" required>
                                    <option value="">Select Tour Type</option>
                                    <option value="day_tour" {{ old('tour_type') == 'day_tour' ? 'selected' : '' }}>Day Tour</option>
                                    <option value="overnight" {{ old('tour_type') == 'overnight' ? 'selected' : '' }}>Overnight</option>
                                </select>
                                @error('tour_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Fields that show for Day Tour --}}
                            <div id="dayTourSpecificFields" style="display: none;">
                                <div class="mb-3">
                                    <label for="day_tour_time_of_pickup" class="form-label">Time of Pick-up (Day Tour):</label>
                                    <input type="time" class="form-control @error('day_tour_time_of_pickup') is-invalid @enderror" id="day_tour_time_of_pickup" name="day_tour_time_of_pickup" value="{{ old('day_tour_time_of_pickup') }}">
                                    @error('day_tour_time_of_pickup')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="day_tour_departure_time" class="form-label">Departure Time (Day Tour):</label>
                                    <input type="time" class="form-control @error('day_tour_departure_time') is-invalid @enderror" id="day_tour_departure_time" name="day_tour_departure_time" value="{{ old('day_tour_departure_time') }}">
                                    @error('day_tour_departure_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fields that show for Overnight --}}
                            <div id="overnightSpecificFields" style="display: none;">
                                <div class="mb-3">
                                    <label for="overnight_date_time_of_pickup" class="form-label">Date & Time of Pick-up (Overnight):</label>
                                    <input type="datetime-local" class="form-control @error('overnight_date_time_of_pickup') is-invalid @enderror" id="overnight_date_time_of_pickup" name="overnight_date_time_of_pickup" value="{{ old('overnight_date_time_of_pickup') }}">
                                    @error('overnight_date_time_of_pickup')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="num_senior_citizens" class="form-label">No. of Senior Citizen/s:</label>
                                    <input type="number" class="form-control @error('num_senior_citizens') is-invalid @enderror" id="num_senior_citizens" name="num_senior_citizens" min="0" value="{{ old('num_senior_citizens', 0) }}">
                                    @error('num_senior_citizens')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="num_pwds" class="form-label">No. of PWD/s:</label>
                                    <input type="number" class="form-control @error('num_pwds') is-invalid @enderror" id="num_pwds" name="num_pwds" min="0" value="{{ old('num_pwds', 0) }}">
                                    @error('num_pwds')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <hr> {{-- Separator --}}

                            {{-- IMPORTANT: These fields are NOT to be filled by the tourist.
                                They will be populated automatically by the system upon booking approval.
                                They are kept here as disabled inputs to avoid validation errors if they
                                were explicitly required by the backend, but their values will be ignored
                                and overwritten by the backend logic. --}}
                            <div id="commonFields" style="display: none;">
                                <div class="mb-3">
                                    <label for="assigned_boat" class="form-label">Assigned Boat:</label>
                                    <input type="text" class="form-control" id="assigned_boat" name="assigned_boat" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="boat_captain_crew" class="form-label">Boat Captain/Crew:</label>
                                    <input type="text" class="form-control" id="boat_captain_crew" name="boat_captain_crew" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="boat_contact_number" class="form-label">Boat Contact Number:</label>
                                    <input type="text" class="form-control" id="boat_contact_number" name="boat_contact_number" disabled>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-book-now" {{ isset($conflictingBooking) && $conflictingBooking ? 'disabled' : '' }}>
                                @if(isset($conflictingBooking) && $conflictingBooking)
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Room Unavailable
                                @else
                                    Proceed to Confirmation <i class="bi bi-check-circle"></i>
                                @endif
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

        /* Custom "BOOK NOW" BUTTON STYLE (reused from fillup.blade.php) */
        .btn-book-now {
            background-color: rgb(9, 135, 219); /* Blue color from your explore page's "View Rooms" button */
            border-color: rgb(9, 135, 219);
            color: #fff;
            border-radius: 6px; /* Added border-radius for rounded shape */
            padding: 7px 10px;   /* Adjusted padding for smaller button */
            font-weight: bold;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .btn-book-now:hover {
            background-color: rgb(5, 95, 155) !important;
            border-color: rgb(5, 95, 155) !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamic guest inputs
            const numGuestsInput = document.getElementById('numGuests');
            const guestContainer = document.getElementById('guestNamesContainer');
            const guestInputs = document.getElementById('guestInputs');

            function renderGuestInputs(count) {
                // count includes primary guest; we render additional guest names only
                const additional = Math.max((parseInt(count || '1', 10) - 1), 0);
                guestInputs.innerHTML = '';
                for (let i = 1; i <= additional; i++) {
                    const wrap = document.createElement('div');
                    wrap.className = 'input-group';
                    const span = document.createElement('span');
                    span.className = 'input-group-text';
                    span.textContent = `Guest ${i + 1}`; // guest numbering starts at 2
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = `guest_names[]`;
                    input.required = additional > 0; // require if there should be any
                    input.className = 'form-control';
                    input.placeholder = `Enter guest ${i + 1} full name`;
                    wrap.appendChild(span);
                    wrap.appendChild(input);
                    guestInputs.appendChild(wrap);
                }
            }

            function syncGuestInputs() {
                const v = parseInt(numGuestsInput.value || '1', 10);
                if (v > 1) {
                    guestContainer.style.display = '';
                    renderGuestInputs(v);
                } else {
                    guestContainer.style.display = 'none';
                    guestInputs.innerHTML = '';
                }
            }

            if (numGuestsInput) {
                numGuestsInput.addEventListener('input', syncGuestInputs);
                syncGuestInputs();
            }
            const tourTypeSelect = document.getElementById('tour_type');
            const dayTourSpecificFields = document.getElementById('dayTourSpecificFields');
            const overnightSpecificFields = document.getElementById('overnightSpecificFields');

            function resetInputs(container) {
                container.querySelectorAll('input').forEach(input => {
                    if (input.type === 'number') {
                        input.value = input.min || 0;
                    } else if (input.type === 'time' || input.type === 'datetime-local' || input.type === 'text') {
                        input.value = '';
                    }
                });
            }

            function toggleFormFields() {
                const selectedTourType = tourTypeSelect.value;

                // Hide all specific fields initially
                dayTourSpecificFields.style.display = 'none';
                overnightSpecificFields.style.display = 'none';

                // Reset all specific fields to clear previous values
                // Only reset if the form is NOT being reloaded due to validation errors
                // We check if there are old inputs for the tour type specific fields
                const hasOldDayTourInput = document.getElementById('day_tour_departure_time').value || document.getElementById('day_tour_time_of_pickup').value;
                const hasOldOvernightInput = document.getElementById('overnight_date_time_of_pickup').value || document.getElementById('num_senior_citizens').value || document.getElementById('num_pwds').value;

                if (!hasOldDayTourInput && !hasOldOvernightInput) {
                    resetInputs(dayTourSpecificFields);
                    resetInputs(overnightSpecificFields);
                }


                // Remove 'required' from all fields first to prevent issues when switching
                dayTourSpecificFields.querySelectorAll('input').forEach(input => input.removeAttribute('required'));
                overnightSpecificFields.querySelectorAll('input').forEach(input => input.removeAttribute('required'));

                if (selectedTourType === 'day_tour') {
                    dayTourSpecificFields.style.display = 'block';
                    // Make fields required for day tour
                    dayTourSpecificFields.querySelectorAll('input').forEach(input => input.setAttribute('required', 'required'));
                } else if (selectedTourType === 'overnight') {
                    overnightSpecificFields.style.display = 'block';
                    // Make fields required for overnight
                    overnightSpecificFields.querySelectorAll('input').forEach(input => input.setAttribute('required', 'required'));
                }
            }

            // Set initial state on page load
            // Use setTimeout to ensure old values are loaded before toggling
            setTimeout(() => {
                toggleFormFields();
            }, 0);


            // Add event listener for when the tour type changes
            tourTypeSelect.addEventListener('change', toggleFormFields);

            // Set minimum date for datetime-local input for overnight pick-up
            const overnightDateTimeInput = document.getElementById('overnight_date_time_of_pickup');
            if (overnightDateTimeInput) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                overnightDateTimeInput.min = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        });
    </script>
</x-app-layout>
