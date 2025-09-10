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
                    <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    {{-- Active class is dynamic based on route --}}
                    <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                        <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Resort Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
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
                        <a href="{{ route('resort.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.dashboard') ? 'active' : '' }}">
                            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.information') ? 'active' : '' }}">
                            <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.verified') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.verified') ? 'active' : '' }}">
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
                <h2 class="mb-0">Rooms for {{ $resort->resort_name }}</h2>
                <a href="{{ route('resort.owner.rooms.create', $resort->id) }}" class="btn btn-dark d-flex align-items-center gap-2 text-white text-decoration-none">
                    Add Room
                    <span style="font-size: 1.2rem;">+</span>
                </a>
            </div>

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

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Room Name</th>
                            <th scope="col">Price / Night</th>
                            <th scope="col">Max Guests</th>
                            <th scope="col">Availability / Status</th> {{-- Updated column header --}}
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)
                            <tr>
                                <td>
                                    @if ($room->image_path)
                                        <img src="{{ asset($room->image_path) }}"
                                            alt="{{ $room->room_name }}"
                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                                            onerror="handleImageError(this, '{{ asset('images/default_room.png') }}')">
                                    @else
                                        <img src="{{ asset('images/default_room.png') }}"
                                            alt="Default Room Image"
                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                </td>
                                <td>{{ $room->room_name }}</td>
                                <td>₱{{ number_format($room->price_per_night, 2) }}</td>
                                <td>{{ $room->max_guests }}</td>
                                <td>
                                    {{-- Display Availability --}}
                                    @php
                                        $availabilityClass = $room->is_available ? 'badge-light-green text-dark' : 'badge-light-red text-dark';
                                    @endphp
                                    <span class="badge {{ $availabilityClass }}">
                                        {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                    {{-- Display Room Status --}}
                                    @php
                                        $roomStatusClass = '';
                                        $roomStatusText = ucfirst($room->status ?? 'Unknown');
                                        switch ($room->status) {
                                            case 'open':
                                                $roomStatusClass = 'badge-light-green text-dark';
                                                break;
                                            case 'closed':
                                                $roomStatusClass = 'badge-light-black text-dark';
                                                break;
                                            case 'maintenance':
                                                $roomStatusClass = 'badge-light-yellow text-dark';
                                                break;
                                            case 'rejected':
                                                $roomStatusClass = 'badge-light-red text-dark';
                                                break;
                                            default:
                                                $roomStatusClass = 'badge-light-secondary text-dark';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $roomStatusClass }} ms-1">
                                        {{ $roomStatusText }}
                                    </span>
                                    @if (($room->status ?? '') === 'maintenance' && $room->rehab_reason)
                                        <div class="text-muted small mt-1">
                                            Reason: {{ Str::limit($room->rehab_reason, 50) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('resort.owner.rooms.edit', $room->id) }}" class="btn btn-primary btn-sm btn-icon" title="Edit Room">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Delete button triggers modal --}}
                                        <button type="button" class="btn btn-danger btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#deleteRoomConfirmationModal" data-room-id="{{ $room->id }}" title="Delete Room">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No rooms added for this resort yet. Click "Add Room" to get started!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Delete Confirmation Modal for Rooms --}}
    <div class="modal fade" id="deleteRoomConfirmationModal" tabindex="-1" aria-labelledby="deleteRoomConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoomConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this room? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    {{-- Form to be dynamically updated with room ID --}}
                    <form id="deleteRoomForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
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
        
        /* Enhanced tooltip styling */
        .tooltip {
            font-size: 12px;
            font-weight: 500;
        }
        
        .tooltip-inner {
            background-color: #333;
            color: white;
            border-radius: 4px;
            padding: 6px 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Darker Blue */
        }

        /* Added for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated {
            transform: rotate(180deg);
        }

        /* Custom badge styles with light backgrounds and dark borders */
        .badge {
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
            border: 1px solid; /* Add border for all badges */
        }

        /* Open / Available (Light Green) */
        .badge-light-green {
            background-color: #d4edda; /* Light green background */
            border-color: #28a745; /* Darker green border */
            color: #155724; /* Dark green text */
        }

        /* Maintenance (Light Yellow) */
        .badge-light-yellow {
            background-color: #fff3cd; /* Light yellow background */
            border-color: #ffc107; /* Darker yellow border */
            color: #856404; /* Dark yellow text */
        }

        /* Close (Light Black / Light Gray) */
        .badge-light-black {
            background-color: #e2e6ea; /* Light gray background */
            border-color: #6c757d; /* Darker gray border */
            color: #343a40; /* Darker text for contrast */
        }

        /* Rejected (Light Red) */
        .badge-light-red {
            background-color: #f8d7da; /* Light red background */
            border-color: #dc3545; /* Darker red border */
            color: #721c24; /* Dark red text */
        }

        /* Default secondary for unknown statuses (if needed) */
        .badge-light-secondary {
            background-color: #e2e6ea; /* Light gray background */
            border-color: #6c757d; /* Darker gray border */
            color: #343a40; /* Darker text for contrast */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            function handleImageError(imgElement, defaultImagePath) {
                imgElement.onerror = null; // Prevent infinite looping if default image also fails
                imgElement.src = defaultImagePath;
            }

            // Make handleImageError globally accessible or attach to window
            window.handleImageError = handleImageError;


            // JavaScript for Delete Room Confirmation Modal
            var deleteRoomConfirmationModal = document.getElementById('deleteRoomConfirmationModal');
            deleteRoomConfirmationModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget;
                // Extract info from data-room-id attribute
                var roomId = button.getAttribute('data-room-id');

                // Update the modal's form action dynamically.
                // It should match your route definition: Route::delete('/resort_owner/rooms/{room}', ...)
                var deleteForm = deleteRoomConfirmationModal.querySelector('#deleteRoomForm');
                deleteForm.action = '/resort_owner/rooms/' + roomId;
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
            
            // Initialize Bootstrap tooltips for better tooltip functionality
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    placement: 'top',
                    trigger: 'hover'
                });
            });
        });
    </script>
</x-app-layout>