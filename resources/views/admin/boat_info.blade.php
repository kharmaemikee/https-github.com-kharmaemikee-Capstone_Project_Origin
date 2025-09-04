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
            <h4 class="fw-bold">BOAT INFORMATION</h4>
            <h5 class="text-muted">MANAGE BOATS</h5>

            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- The h2 "Manage Boats" from the original is replaced by the updated heading above --}}
                {{-- No "Add Boat" button for Admin (as per original request) --}}
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
                            <th scope="col">Boat Image</th>
                            <th scope="col">Boat Name</th>
                            <th scope="col">Boat No</th>
                            <th scope="col">Price</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Boat Captain</th>
                            <th scope="col">Captain Contact</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Status</th> {{-- Added Status Column --}}
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($boats as $boat)
                            <tr>
                                <td>
                                    @if ($boat->image_path)
                                        <img src="{{ asset('storage/' . $boat->image_path) }}"
                                             alt="{{ $boat->boat_name }}"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                                             onerror="handleImageError(this, '{{ asset('images/default_boat.png') }}')">
                                    @else
                                        <img src="{{ asset('images/default_boat.png') }}"
                                             alt="Default Boat Image"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                </td>
                                <td>{{ $boat->boat_name }}</td>
                                <td>{{ $boat->boat_number }}</td>
                                <td>${{ number_format($boat->boat_prices, 2) }}</td>
                                <td>{{ $boat->boat_capacities }} pax</td>
                                <td>{{ $boat->captain_name ?? 'N/A' }}</td>
                                <td>{{ $boat->captain_contact ?? 'N/A' }}</td>
                                <td>{{ $boat->user->name ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $badgeClass = '';
                                        switch ($boat->status) {
                                            case \App\Models\Boat::STATUS_OPEN: // Add this case for 'open'
                                                $badgeClass = 'badge-light-success';
                                                break;
                                            case \App\Models\Boat::STATUS_CLOSED: // Add this case for 'closed'
                                                $badgeClass = 'badge-light-danger';
                                                break;
                                            case \App\Models\Boat::STATUS_APPROVED:
                                                $badgeClass = 'badge-light-success';
                                                break;
                                            case \App\Models\Boat::STATUS_REJECTED:
                                                $badgeClass = 'badge-light-danger';
                                                break;
                                            case \App\Models\Boat::STATUS_REHAB:
                                                $badgeClass = 'badge-light-warning'; // Using warning for rehab as per resort info
                                                break;
                                            case \App\Models\Boat::STATUS_PENDING:
                                                $badgeClass = 'badge-light-info'; // Using info for pending as per resort info
                                                break;
                                            default:
                                                $badgeClass = 'badge-light-secondary'; // Default for other/unknown statuses
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} rounded-pill">
                                        {{ ucfirst($boat->status) }}
                                    </span>
                                    @if ($boat->status === \App\Models\Boat::STATUS_REJECTED && $boat->rejection_reason)
                                        <br><small class="text-danger">(Reason: {{ $boat->rejection_reason }})</small>
                                    @elseif ($boat->status === \App\Models\Boat::STATUS_REHAB && $boat->rejection_reason)
                                        <br><small class="text-muted">(Rehab Reason: {{ $boat->rejection_reason }})</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        {{-- Approve Button (visible if pending or rejected) --}}
                                        @if ($boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED)
                                            <form action="{{ route('admin.boat.approve', $boat->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">Approve</button>
                                            </form>
                                        @endif

                                        {{-- Reject Button (visible if pending or approved, allowing admin to revert approval) --}}
                                        @if ($boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_APPROVED)
                                            <button type="button" class="btn btn-danger btn-sm "
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#rejectBoatModal"
                                                     data-boat-id="{{ $boat->id }}"
                                                     data-boat-name="{{ $boat->boat_name }}">
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No boats found in the system for administration.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Reject Boat Modal --}}
    <div class="modal fade" id="rejectBoatModal" tabindex="-1" aria-labelledby="rejectBoatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectBoatModalLabel">Reject Boat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectBoatForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to reject the boat: <strong id="modalRejectBoatName"></strong>?</p>
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Reason for Rejection (Required)</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                            <div class="text-danger mt-1" id="rejectionReasonError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger rounded-pill">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Custom CSS for sidebar nav-link hover and focus and custom badges --}}
    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Specific blue for active/hover */
        }

        /* Custom Light Background Badges */
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
            border: 1px solid #b8daff !important; /* Changed this border color to match info more closely */
        }

        .badge-light-secondary {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
            border: 1px solid #d3d6da !important;
        }

        .badge-light-black { /* For 'Closed' status if applicable, or general dark status */
            background-color: #f8f9fa !important; /* Very light gray, almost white */
            color: #212529 !important; /* Dark text for contrast */
            border: 1px solid #dee2e6 !important;
        }

        /* Modal Footer Buttons */
        #rejectBoatModal .modal-footer .btn-secondary {
            border-radius: 25px !important; /* Apply rounded pill to Cancel button */
            padding: 8px 20px;
        }

        #rejectBoatModal .modal-footer .btn-danger {
            border-radius: 25px !important; /* Apply rounded pill to Reject button */
            padding: 8px 20px;
        }
    </style>

    {{-- Custom JavaScript to handle offcanvas hiding and modal logic --}}
    <script>
        // Global function for image error handling
        function handleImageError(imgElement, defaultImagePath) {
            imgElement.onerror = null; // Prevent infinite looping if default image also fails
            imgElement.src = defaultImagePath;
        }

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
            // --- End JavaScript ---

            // Reject Boat Modal Logic
            var rejectBoatModal = document.getElementById('rejectBoatModal');
            rejectBoatModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var boatId = button.getAttribute('data-boat-id');
                var boatName = button.getAttribute('data-boat-name');

                var modalRejectBoatName = rejectBoatModal.querySelector('#modalRejectBoatName');
                var rejectForm = rejectBoatModal.querySelector('#rejectBoatForm');
                var rejectionReasonInput = rejectBoatModal.querySelector('#rejection_reason');
                var rejectionReasonError = rejectBoatModal.querySelector('#rejectionReasonError');

                modalRejectBoatName.textContent = boatName;
                rejectForm.setAttribute('action', '/admin/boats/' + boatId + '/reject');
                rejectionReasonInput.value = ''; // Clear previous input
                rejectionReasonError.textContent = ''; // Clear previous errors
            });

            // Handle rejection form submission (client-side validation for reason)
            document.getElementById('rejectBoatForm').addEventListener('submit', function(event) {
                const reason = document.getElementById('rejection_reason').value;
                const rejectionReasonError = document.getElementById('rejectionReasonError');
                if (!reason.trim()) {
                    event.preventDefault(); // Prevent form submission
                    rejectionReasonError.textContent = 'Rejection reason is required.';
                } else {
                    rejectionReasonError.textContent = ''; // Clear error if valid
                }
            });
        });
    </script>
</x-app-layout>