<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Resort Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                {{ Auth::user()->username }}
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/information.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Resort Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Account Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a class="nav-link text-white rounded p-2 d-flex justify-content-between align-items-center {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'active-parent' : '' }}"
                       data-bs-toggle="collapse" href="#notificationCollapseDesktop" role="button"
                       aria-expanded="{{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'true' : 'false' }}" aria-controls="notificationCollapseDesktop">
                        {{-- Adjusted justify-content-start here --}}
                        <span class="flex-grow-1 d-flex align-items-center justify-content-start">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notification
                        </span>
                        {{-- Replaced triangle with down.png icon --}}
                        <span class="collapse-icon">
                            <img src="{{ asset('images/down-chevron.png') }}" alt="Toggle Icon" style="width: 16px; height: 16px;">
                        </span>
                    </a>
                    <div class="collapse {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'show' : '' }}" id="notificationCollapseDesktop">
                        <ul class="nav flex-column ps-3 mt-2">
                            <li class="nav-item">
                                <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                                    Notifications List
                                </a>
                            </li>
                            <li class="nav-item mt-1">
                                <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                                    Documentation
                                </a>
                            </li>
                        </ul>
                    </div>
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
                    {{ Auth::user()->username }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/information.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Account Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-white rounded p-2 d-flex justify-content-between align-items-center {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'active-parent' : '' }}"
                           data-bs-toggle="collapse" href="#notificationCollapseMobile" role="button"
                           aria-expanded="{{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'true' : 'false' }}" aria-controls="notificationCollapseMobile">
                            {{-- Adjusted justify-content-start here --}}
                            <span class="flex-grow-1 d-flex align-items-center justify-content-start">
                                <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                                Notification
                            </span>
                            {{-- Replaced triangle with down.png icon --}}
                            <span class="collapse-icon">
                                <img src="{{ asset('images/down-chevron.png') }}" alt="Toggle Icon" style="width: 16px; height: 16px;">
                            </span>
                        </a>
                        <div class="collapse {{ (request()->routeIs('resort.owner.notification') || request()->routeIs('resort.owner.documentation')) ? 'show' : '' }}" id="notificationCollapseMobile">
                            <ul class="nav flex-column ps-3 mt-2">
                                <li class="nav-item">
                                    <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                                        Notifications List
                                    </a>
                                </li>
                                <li class="nav-item mt-1">
                                    <a href="{{ route('resort.owner.documentation') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('resort.owner.documentation') ? 'active' : '' }}">
                                        Documentation
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Add Room for {{ $resort->resort_name }}</h2>
            </div>

            <div class="card shadow-sm p-4">
                <form action="{{ route('resort.owner.rooms.store', $resort->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="room_name" class="form-label">Room Name</label>
                        <input type="text" class="form-control @error('room_name') is-invalid @enderror" id="room_name" name="room_name" value="{{ old('room_name') }}" required>
                        @error('room_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price_per_night" class="form-label">Price Per Night (₱)</label>
                        <input type="number" step="0.01" class="form-control @error('price_per_night') is-invalid @enderror" id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}" required min="0">
                        @error('price_per_night')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="max_guests" class="form-label">Maximum Guests</label>
                        <input type="number" class="form-control @error('max_guests') is-invalid @enderror" id="max_guests" name="max_guests" value="{{ old('max_guests') }}" required min="1">
                        @error('max_guests')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_image" class="form-label">Room Image</label>
                        <input type="file" class="form-control @error('room_image') is-invalid @enderror" id="room_image" name="room_image" accept="image/*">
                        @error('room_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Max 2MB. Accepted formats: JPG, PNG, GIF.</div>
                    </div>

                    {{-- NEW: Room Status Field --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Room Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required onchange="toggleRehabReason()">
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="rehab" {{ old('status') == 'rehab' ? 'selected' : '' }}>Under Rehabilitation</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NEW: Rehabilitation Reason Field (conditionally displayed) --}}
                    <div class="mb-3" id="rehabReasonGroup" style="display: {{ old('status') == 'rehab' ? 'block' : 'none' }};">
                        <label for="rehab_reason" class="form-label">Rehabilitation Reason</label>
                        <textarea class="form-control @error('rehab_reason') is-invalid @enderror" id="rehab_reason" name="rehab_reason" rows="3">{{ old('rehab_reason') }}</textarea>
                        @error('rehab_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Required if status is "Under Rehabilitation".</div>
                    </div>

                    {{-- Original 'is_available' checkbox - keeping it for compatibility as it's in your fillable --}}
                    {{-- Note: 'status' is now the primary field for availability states --}}
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_available">Available for Booking (Legacy Checkbox)</label>
                        <div class="form-text">This checkbox is for older compatibility; the "Room Status" field is now primary.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('resort.owner.rooms.index', $resort->id) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);">Add Room</button>
                    </div>
                </form>
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

        /* Added for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated {
            transform: rotate(180deg);
        }
    </style>

    <script>
        // Function to show/hide rehab reason based on status selection
        function toggleRehabReason() {
            var statusSelect = document.getElementById('status');
            var rehabReasonGroup = document.getElementById('rehabReasonGroup');
            if (statusSelect.value === 'rehab') {
                rehabReasonGroup.style.display = 'block';
            } else {
                rehabReasonGroup.style.display = 'none';
                // Optionally clear the value if not rehab to prevent unwanted data
                var rehabReasonInput = document.getElementById('rehab_reason');
                if (rehabReasonInput) {
                    rehabReasonInput.value = '';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the state of the rehab reason field on page load
            toggleRehabReason();

            var collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

            collapseToggles.forEach(function(toggle) {
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

                toggle.addEventListener('click', function() {
                    var icon = this.querySelector('.collapse-icon');
                    if (icon) {
                        icon.classList.toggle('rotated');
                    }
                });
            });

            // --- New JavaScript for Offcanvas Hiding ---
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
            // --- End New JavaScript ---
        });
    </script>
</x-app-layout>