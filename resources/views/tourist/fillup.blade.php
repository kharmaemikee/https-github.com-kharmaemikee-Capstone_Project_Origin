<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                {{-- Tourist Icon --}}
                <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Tourist
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a href="{{ route('tourist.tourist') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start">
                        {{-- Home Icon --}}
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
                    <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 d-flex align-items-center justify-content-start">
                        {{-- Your Visit Icon --}}
                        <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Your Visit
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        {{-- Mobile Offcanvas Toggle Button --}}
        <div class="d-md-none bg-light border-bottom p-2">
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                &#9776;
            </button>
        </div>

        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="background-color: #2C3E50; color: white; width: 50vw;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/man.png') }}" alt="Tourist Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Tourist
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
                        <a href="{{ route('tourist.visit') }}" class="nav-link text-white rounded p-2 text-center d-flex align-items-center justify-content-start">
                            <img src="{{ asset('images/visit.png') }}" alt="Your Visit Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Your Visit
                            @if(($unreadCount ?? 0) > 0)
                                <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area for Fill-up Form --}}
        <main class="py-4 px-3 flex-grow-1">
            <div class="container">
                <h2 class="mb-4">Booking Details for Room ID: {{ $roomId ?? 'N/A' }}</h2>

                @isset($room)
                    <div class="card shadow-sm mb-4 " style="max-width: 600px;">
                        <div class="card-body">
                            <div class="row g-3"> {{-- Use row and g-3 for gutter --}}
                                @if ($room->image_path)
                                    <div class="col-12 col-md-4"> {{-- Image takes full width on small, 1/3 on medium+ --}}
                                        <img src="{{ asset('storage/' . $room->image_path) }}" class="img-fluid rounded" alt="Room Image" style="max-height: 150px; object-fit: cover; width: 100%;">
                                    </div>
                                @endif
                                <div class="col-12 @if ($room->image_path) col-md-8 @endif"> {{-- Text takes full width on small, 2/3 on medium+ if image exists --}}
                                    <h5 class="card-title">{{ $room->room_name }}</h5>
                                    <p class="card-text text-muted mb-1">Max Guests: {{ $room->max_guests }}</p>
                                    <p class="card-text text-muted mb-1">Price: ₱{{ number_format($room->price_per_night, 2) }} / Night</p>
                                    {{-- Displaying description with bullets, ensuring each bullet is on a new line --}}
                                    @if ($room->description)
                                        @php
                                            // Split the description by the bullet point character "•"
                                            // This assumes each amenity starts with a bullet point in the database.
                                            $amenities = explode('•', $room->description);
                                        @endphp
                                        @foreach ($amenities as $amenity)
                                            @php
                                                $amenity = trim($amenity);
                                            @endphp
                                            @if (!empty($amenity)) {{-- Only display if the amenity string is not empty --}}
                                                <p class="card-text mb-0">&bull; {{ $amenity }}</p>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        Room details could not be loaded. Please go back and try again.
                    </div>
                @endisset

                <h3 class="mb-3">Fill in Your Booking Details</h3>
                {{-- Step 1 (Schedule & Contact). Personal info moved to Step 2. --}}
                <form id="fillupForm" action="{{ route('tourist.fillup2') }}" method="GET">
                    {{-- @csrf is not needed for GET forms --}}
                    <input type="hidden" name="room_id" value="{{ $roomId ?? '' }}">

                    {{-- Personal information fields moved to the next step (fillup2). --}}
                    <div class="mb-3">
                        <label for="nationality" class="form-label">Nationality</label>
                        <select class="form-select @error('nationality') is-invalid @enderror" id="nationality" name="nationality" required>
                            <option value="">Select Nationality</option>
                            {{-- Options will be populated by JavaScript --}}
                        </select>
                        @error('nationality')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber" class="form-label">Contact Number</label>
                        <input type="text" 
                               class="form-control @error('contact_number') is-invalid @enderror" 
                               id="contactNumber" 
                               name="contact_number" 
                               placeholder="e.g., 09123456789" 
                               value="{{ Auth::user()->phone ?? old('contact_number') }}" 
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
                        <label for="reservationDate" class="form-label">Date of Reservation</label>
                        <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" id="reservationDate" name="reservation_date" value="{{ old('reservation_date') }}" required>
                        @error('reservation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="numNights" class="form-label">Number of Nights</label>
                        <input type="number" class="form-control @error('num_nights') is-invalid @enderror" id="numNights" name="num_nights" min="1" value="{{ old('num_nights', 1) }}" required>
                        @error('num_nights')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="numGuests" class="form-label">Number of Guests</label>
                        <input type="number" class="form-control @error('num_guests') is-invalid @enderror" id="numGuests" name="num_guests" min="1" value="{{ old('num_guests', 1) }}" required>
                        @error('num_guests')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-book-now">
                        Next <i class="bi bi-arrow-right"></i>
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Back</a>
                </form>
            </div>
        </main>
    </div>

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Custom "BOOK NOW" BUTTON STYLE (reused for next) */
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
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    // Bootstrap's 'md' breakpoint is 768px
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // Set minimum date for Date of Reservation to today
            const reservationDateInput = document.getElementById('reservationDate');
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const day = String(today.getDate()).padStart(2, '0');
            const minDate = `${year}-${month}-${day}`;
            reservationDateInput.setAttribute('min', minDate);

            // Dynamically populate Nationality dropdown with the same list as registration form
            const nationalities = [
                "Filipino", "Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Antiguans",
                "Argentinean", "Armenian", "Australian", "Austrian", "Azerbaijani", "Bahamian", "Bahraini",
                "Bangladeshi", "Barbadian", "Belarusian", "Belgian", "Belizean", "Beninese", "Bhutanese",
                "Bolivian", "Bosnian", "Botswanan", "Brazilian", "British", "Bruneian", "Bulgarian",
                "Burkinabé", "Burundian", "Cambodian", "Cameroonian", "Canadian", "Cape Verdean", "Central African",
                "Chadian", "Chilean", "Chinese", "Colombian", "Comoran", "Congolese", "Costa Rican",
                "Croatian", "Cuban", "Cypriot", "Czech", "Danish", "Djiboutian", "Dominican", "Dutch",
                "East Timorese", "Ecuadorean", "Egyptian", "Emirian", "Equatorial Guinean", "Eritrean",
                "Estonian", "Ethiopian", "Fijian", "Finnish", "French", "Gabonese", "Gambian", "Georgian",
                "German", "Ghanaian", "Greek", "Grenadian", "Guatemalan", "Guinean", "Guinea-Bissauan",
                "Guyanese", "Haitian", "Honduran", "Hungarian", "Icelander", "Indian", "Indonesian", "Iranian",
                "Iraqi", "Irish", "Israeli", "Italian", "Ivorian", "Jamaican", "Japanese", "Jordanian",
                "Kazakhstani", "Kenyan", "Kittian and Nevisian", "Kuwaiti", "Kyrgyz", "Laotian", "Latvian",
                "Lebanese", "Liberian", "Libyan", "Liechtensteiner", "Lithuanian", "Luxembourgish", "Malagasy",
                "Malawian", "Malaysian", "Maldivian", "Malian", "Maltese", "Marshallese", "Mauritanian",
                "Mauritian", "Mexican", "Micronesian", "Moldovan", "Monacan", "Mongolian", "Montenegrin",
                "Moroccan", "Mozambican", "Myanmar", "Namibian", "Nauruan", "Nepalese", "New Zealander",
                "Nicaraguan", "Nigerien", "Nigerian", "North Korean", "North Macedonian", "Norwegian",
                "Omani", "Pakistani", "Palauan", "Palestinian", "Panamanian", "Papua New Guinean", "Paraguayan",
                "Peruvian", "Polish", "Portuguese", "Qatari", "Romanian", "Russian", "Rwandan",
                "Saint Lucian", "Saint Vincentian and Grenadine", "Sammarinese", "Sao Tomean", "Saudi Arabian",
                "Senegalese", "Serbian", "Seychellois", "Sierra Leonean", "Singaporean", "Slovak", "Slovenian",
                "Solomon Islander", "Somali", "South African", "South Korean", "South Sudanese", "Spanish",
                "Sri Lankan", "Sudanese", "Surinamese", "Swedish", "Swiss", "Syrian", "Taiwanese", "Tajik",
                "Tanzanian", "Thai", "Togolese", "Tongan", "Trinidadian and Tobagonian", "Tunisian", "Turkish",
                "Turkmen", "Tuvaluan", "Ugandan", "Ukrainian", "Emirati", "Uruguayan", "Uzbek", "Vanuatuan",
                "Venezuelan", "Vietnamese", "Yemeni", "Zambian", "Zimbabwean"
            ];

            const nationalitySelect = document.getElementById('nationality');
            nationalities.sort().forEach(function(nationality) { // Sort alphabetically
                const option = document.createElement('option');
                option.value = nationality;
                option.textContent = nationality;
                nationalitySelect.appendChild(option);
            });

            // Set user's nationality as selected if present in the list
            // Use old('nationality') to re-select if there was a validation error
            const userNationality = "{{ Auth::user()->nationality ?? '' }}";
            const oldNationality = "{{ old('nationality') }}";
            const nationalityToSet = oldNationality || userNationality;
            
            console.log('User nationality:', userNationality);
            console.log('Old nationality:', oldNationality);
            console.log('Nationality to set:', nationalityToSet);
            
            if (nationalityToSet) {
                const selectedOption = nationalitySelect.querySelector(`option[value="${nationalityToSet}"]`);
                if (selectedOption) {
                    selectedOption.selected = true;
                    console.log('Set nationality to:', nationalityToSet);
                } else {
                    console.log('Nationality not found in dropdown:', nationalityToSet);
                }
            } else {
                // Default to Filipino if no old value and user's nationality is not set
                const filipinoOption = nationalitySelect.querySelector('option[value="Filipino"]');
                if (filipinoOption) {
                    filipinoOption.selected = true;
                    console.log('Set default nationality to: Filipino');
                }
            }
        });
    </script>
</x-app-layout>
