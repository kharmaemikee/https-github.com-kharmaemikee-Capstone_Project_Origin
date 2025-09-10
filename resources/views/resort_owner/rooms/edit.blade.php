<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Resort Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Resort Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Resorts Menu
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
                        <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Resort Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
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
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                            <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
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

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Edit Room: {{ $room->room_name }} ({{ $room->resort->resort_name }})</h2>
            </div>

            <div class="card shadow-sm p-4">
                <form action="{{ route('resort.owner.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="accommodation_type" class="form-label">Type</label>
                        <select class="form-select @error('accommodation_type') is-invalid @enderror" id="accommodation_type" name="accommodation_type" required>
                            <option value="room" {{ old('accommodation_type', $room->accommodation_type ?? 'room') === 'room' ? 'selected' : '' }}>Room</option>
                            <option value="cottage" {{ old('accommodation_type', $room->accommodation_type ?? 'room') === 'cottage' ? 'selected' : '' }}>Cottage</option>
                        </select>
                        @error('accommodation_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_name" class="form-label">Room Name</label>
                        <input type="text" class="form-control @error('room_name') is-invalid @enderror" id="room_name" name="room_name" value="{{ old('room_name', $room->room_name) }}" required>
                        @error('room_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price_per_night" class="form-label" id="priceLabel">Price Per Night (₱)</label>
                        <input type="number" step="0.01" class="form-control @error('price_per_night') is-invalid @enderror" id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" required min="0">
                        @error('price_per_night')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="max_guests" class="form-label">Maximum Guests</label>
                        <input type="number" class="form-control @error('max_guests') is-invalid @enderror" id="max_guests" name="max_guests" value="{{ old('max_guests', $room->max_guests) }}" required min="1">
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

                        @if ($room->image_path)
                            <div class="mt-3">
                                <h6>Current Image:</h6>
                                <img src="{{ asset($room->image_path) }}" alt="{{ $room->room_name }}" style="max-width: 200px; height: auto; border-radius: 5px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="delete_image" name="delete_image_flag" value="1">
                                    <label class="form-check-label" for="delete_image">Delete current image</label>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Room Status Selection (Open, Closed, Under Maintenance) --}}
                    <div class="mb-3">
                        <label class="form-label">Room Status</label>
                        <div class="d-flex gap-3">
                            <div class="status-option">
                                <input class="form-check-input d-none" type="radio" name="status" id="statusOpen" value="open" {{ old('status', $room->status) == 'open' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success btn-icon status-btn" for="statusOpen" title="Open - Room is available for booking">
                                    <i class="fas fa-door-open"></i>
                                </label>
                            </div>
                            <div class="status-option">
                                <input class="form-check-input d-none" type="radio" name="status" id="statusClosed" value="closed" {{ old('status', $room->status) == 'closed' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary btn-icon status-btn" for="statusClosed" title="Closed - Room is temporarily unavailable">
                                    <i class="fas fa-door-closed"></i>
                                </label>
                            </div>
                            <div class="status-option">
                                <input class="form-check-input d-none" type="radio" name="status" id="statusRehab" value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning btn-icon status-btn" for="statusRehab" title="Under Maintenance - Room is being renovated">
                                    <i class="fas fa-tools"></i>
                                </label>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Maintenance Reason (conditionally displayed) --}}
                    <div class="mb-3" id="rehabReasonContainer" style="display: none;">
                        <label for="rehab_reason" class="form-label">Maintenance Reason</label>
                        <textarea class="form-control @error('rehab_reason') is-invalid @enderror" id="rehab_reason" name="rehab_reason" rows="2">{{ old('rehab_reason', $room->rehab_reason) }}</textarea>
                        @error('rehab_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Required if status is "Under Maintenance".</div>
                    </div>

                    {{-- The `is_available` checkbox is redundant if you're using `status`.
                         It's good practice to deprecate it or integrate its logic into 'status'.
                         For now, I'll keep it as "Legacy" as you might have existing logic relying on it. --}}
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" {{ old('is_available', $room->is_available) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_available">Available for Booking (Legacy - Status field preferred)</label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('resort.owner.rooms.index', $room->resort->id) }}" class="btn btn-secondary btn-icon" title="Cancel - Return to rooms list">
                            <i class="fas fa-times"></i>
                        </a>
                        <button type="submit" class="btn btn-primary btn-icon" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);" title="Update Room - Save changes">
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Custom CSS for icon buttons */
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .btn-icon:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-icon i {
            font-size: 14px;
        }
        
        /* Status button styling */
        .status-btn {
            width: 40px;
            height: 40px;
            border-width: 2px;
            transition: all 0.3s ease;
        }
        
        .status-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        /* Active status button styling */
        .status-btn.active {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
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
        document.addEventListener('DOMContentLoaded', function() {
            // Price label update by type
            var typeSelect = document.getElementById('accommodation_type');
            var priceLabel = document.getElementById('priceLabel');
            function updatePriceLabel() {
                if (!typeSelect || !priceLabel) return;
                priceLabel.textContent = typeSelect.value === 'cottage' ? 'Price Per Stay (₱)' : 'Price Per Night (₱)';
            }
            updatePriceLabel();
            if (typeSelect) {
                typeSelect.addEventListener('change', updatePriceLabel);
            }
            // Sidebar collapse logic
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

            // Status button interactions and styling
            const statusButtons = document.querySelectorAll('.status-btn');
            const statusRadios = document.querySelectorAll('input[name="status"]');
            
            console.log('Status buttons found:', statusButtons.length);
            console.log('Status radios found:', statusRadios.length);
            
            // Function to update active status button
            function updateActiveStatusButton() {
                statusButtons.forEach(btn => btn.classList.remove('active'));
                const checkedRadio = document.querySelector('input[name="status"]:checked');
                if (checkedRadio) {
                    const correspondingBtn = document.querySelector(`label[for="${checkedRadio.id}"]`);
                    if (correspondingBtn) {
                        correspondingBtn.classList.add('active');
                        console.log('Active button updated:', checkedRadio.id);
                    }
                }
            }
            
            // Add click event to status buttons
            statusButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    statusButtons.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                });
            });
            
            // Update active button when radio changes
            statusRadios.forEach(radio => {
                radio.addEventListener('change', updateActiveStatusButton);
            });
            
            // Conditional display for rehab_reason
            const rehabReasonContainer = document.getElementById('rehabReasonContainer');
            const rehabReasonInput = document.getElementById('rehab_reason');

            function toggleRehabReason() {
                if (document.getElementById('statusRehab').checked) {
                    rehabReasonContainer.style.display = 'block';
                    rehabReasonInput.setAttribute('required', 'required'); // Make required when visible
                } else {
                    rehabReasonContainer.style.display = 'none';
                    rehabReasonInput.removeAttribute('required'); // Remove required when hidden
                    rehabReasonInput.value = ''; // Clear value when hidden
                }
            }

            statusRadios.forEach(radio => {
                radio.addEventListener('change', toggleRehabReason);
            });

            // Initialize Bootstrap tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
                console.log('Tooltips initialized:', tooltipList.length);
            } else {
                console.log('Bootstrap not loaded or Tooltip not available');
            }
            
            // Initial setup
            updateActiveStatusButton();
            toggleRehabReason();

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