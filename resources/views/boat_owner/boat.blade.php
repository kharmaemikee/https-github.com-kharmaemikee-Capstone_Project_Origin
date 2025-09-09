<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            {{-- Icon added here for Boat Owner using <img> --}}
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                {{ Auth::user()->username }}
            </h4>
            <ul class="nav flex-column mt-3">
                
                <li class="nav-item mt-2">
                    <a href="{{ route('boat.owner.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('boat') }}" class="nav-link text-white rounded p-2 active d-flex align-items-center">
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
                    {{ Auth::user()->username }}
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

        {{-- Main Content Area --}}
        <div class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Manage Boat</h2>
                <a href="{{ route('boat.owner.add') }}" class="btn btn-dark d-flex align-items-center gap-2 text-white text-decoration-none">
                    Add Boat
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
                            <th scope="col">Boat Image</th>
                            <th scope="col">Boat Name</th>
                            <th scope="col">Boat No</th>
                            <th scope="col">Price</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Boat Captain</th>
                            <th scope="col">Captain Contact</th>
                            <th scope="col">Status</th>
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
                                             onerror="handleImageError(this, '{{ asset('images/boat.png') }}')">
                                    @else
                                        <img src="{{ asset('images/boat.png') }}"
                                             alt="Default Boat Image"
                                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                    @endif
                                </td>
                                <td>{{ $boat->boat_name }}</td>
                                <td>{{ $boat->boat_number }}</td>
                                <td>₱{{ number_format($boat->boat_prices, 2) }}</td>
                                <td>{{ $boat->boat_capacities }} pax</td>
                                <td>
                                    @php
                                        $captainName = !empty($boat->captain_name) ? $boat->captain_name : null;
                                        $hasCaptain = false;
                                        if ($captainName) {
                                            $hasCaptain = true;
                                        } elseif (!empty($boat->has_captain)) {
                                            $hasCaptain = (bool) $boat->has_captain;
                                        } elseif (!empty($boat->captain_user_id)) {
                                            $hasCaptain = true;
                                        }
                                    @endphp
                                    {{ $captainName ?? ($hasCaptain ? 'Yes' : 'No') }}
                                </td>
                                <td>{{ $boat->captain_contact ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $statusClass = '';
                                        $displayText = '';
                                        switch ($boat->status) {
                                            case \App\Models\Boat::STATUS_APPROVED:
                                                $statusClass = 'badge-light-success';
                                                $displayText = 'Approved';
                                                break;
                                            case \App\Models\Boat::STATUS_REJECTED:
                                                $statusClass = 'badge-light-danger';
                                                $displayText = 'Rejected';
                                                break;
                                            case \App\Models\Boat::STATUS_PENDING:
                                                $statusClass = 'badge-light-info';
                                                $displayText = 'Pending';
                                                break;
                                            case \App\Models\Boat::STATUS_OPEN:
                                                $statusClass = 'badge-light-success';
                                                $displayText = 'Open';
                                                break;
                                            case \App\Models\Boat::STATUS_ASSIGNED:
                                                $statusClass = 'badge-light-info';
                                                $displayText = 'Assigned';
                                                break;
                                            case \App\Models\Boat::STATUS_CLOSED:
                                                $statusClass = 'badge-light-secondary'; // You can define a new badge style if you want a specific color for 'Not Available'
                                                $displayText = 'Not Available'; // Changed text here
                                                break;
                                            case \App\Models\Boat::STATUS_REHAB:
                                                $statusClass = 'badge-light-warning';
                                                $displayText = 'Rehab';
                                                break;
                                            default:
                                                $statusClass = 'badge-light-secondary';
                                                $displayText = 'N/A';
                                                break;
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ $displayText }}
                                    </span>
                                    @if (($boat->status ?? '') === \App\Models\Boat::STATUS_REJECTED && $boat->rejection_reason)
                                        <small class="d-block text-muted">Reason: {{ $boat->rejection_reason }}</small>
                                    @elseif (($boat->status ?? '') === \App\Models\Boat::STATUS_REHAB && $boat->rejection_reason)
                                        <small class="d-block text-muted">Rehab Reason: {{ $boat->rejection_reason }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Edit button is now always enabled --}}
                                        <a href="{{ route('boat.edit', $boat->id) }}" class="btn btn-primary btn-sm action-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm action-btn delete-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteBoatModal"
                                                data-boat-id="{{ $boat->id }}"
                                                data-boat-name="{{ $boat->boat_name }}"
                                                data-bs-placement="top" 
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No boats added yet. Click "Add Boat" to get started!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteBoatModal" tabindex="-1" aria-labelledby="deleteBoatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBoatModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the boat: <strong id="modalBoatName"></strong>? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteBoatForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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

        /* Custom CSS for light background badges */
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
            border: 1px solid #f5c2c7 !important;
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

        /* Set width for mobile offcanvas sidebar */
        #mobileSidebar {
            width: 50vw; /* This makes it half the viewport width */
        }

        /* Styles for the collapse icon rotation */
        .collapse-icon img {
            transition: transform 0.3s ease-in-out;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        /* Action button styles */
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .action-btn i {
            font-size: 14px;
        }

        /* Custom tooltip for delete button */
        .delete-btn {
            position: relative;
        }

        .delete-btn::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 1000;
            margin-bottom: 5px;
        }

        .delete-btn:hover::after {
            opacity: 1;
            visibility: visible;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            window.handleImageError = function(imgElement, defaultImagePath) {
                imgElement.onerror = null;
                imgElement.src = defaultImagePath;
            };

            var deleteBoatModal = document.getElementById('deleteBoatModal');
            deleteBoatModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var boatId = button.getAttribute('data-boat-id');
                var boatName = button.getAttribute('data-boat-name');
                var modalBoatName = deleteBoatModal.querySelector('#modalBoatName');
                var deleteForm = deleteBoatModal.querySelector('#deleteBoatForm');

                modalBoatName.textContent = boatName;
                deleteForm.action = '/boats/' + boatId;
            });

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

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</x-app-layout>
