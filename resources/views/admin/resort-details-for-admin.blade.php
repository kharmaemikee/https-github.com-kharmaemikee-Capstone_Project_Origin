<x-app-layout>
    {{-- Apply min-vh-100 to the main flex container and background gradient --}}
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="p-3 d-none d-md-block" style="width: 250px; min-width: 250px; background-color: #2C3E50;">
            <h4 class="fw-bold text-white text-center d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                Admin Menu
            </h4>
            <ul class="nav flex-column mt-3">
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mt-2">
                    {{-- Active link for Resort Information --}}
                    <a href="{{ route('admin.resort') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                        <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Resort Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                        <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Boat Management
                    </a>
                </li>
                <li class="nav-item mt-2">
                    <button class="nav-link text-white rounded p-2 d-flex align-items-center w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapse" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapse">
                        <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Users
                        <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                    </button>
                    <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapse">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a href="{{ route('admin.users.resorts') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.boats') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.tourists') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
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
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center justify-content-center" id="mobileSidebarLabel">
                    <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" style="width: 24px; height: 24px; margin-right: 8px;">
                    Admin Menu
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
                            <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Resort Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('admin.boat') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                            <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Boat Management
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <button class="nav-link text-white rounded p-2 d-flex align-items-center w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapseMobile" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapseMobile">
                            <img src="{{ asset('images/users.png') }}" alt="Users Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Users
                            <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                        </button>
                        <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapseMobile">
                            <ul class="nav flex-column ms-3 mt-1">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.resorts') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.boats') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.tourists') }}" class="nav-link text-white rounded p-2 {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                                </li>
                            </ul>
                        </div>
                    </li>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                {{-- Changed the heading to reflect it's a detail page --}}
                <h2 class="mb-0">Resort Details</h2>
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

            {{-- Start of Resort Information Section --}}
            <div class="card p-4 shadow-sm mb-4">
                <h4 class="mb-3">Resort Information: {{ $resort->resort_name }}</h4>
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if ($resort->image_path)
                            <img src="{{ asset($resort->image_path) }}"
                                alt="{{ $resort->resort_name }}"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default_resort.png') }}"
                                alt="Default Resort Image"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 250px; object-fit: cover;">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <p><strong>Name:</strong> {{ $resort->resort_name }}</p>
                        <p><strong>Location:</strong> {{ $resort->location }}</p>
                        <p><strong>Contact:</strong> {{ $resort->contact_number }}</p>
                        <p><strong>Owner Status:</strong>
                            @php
                                $ownerStatusClass = '';
                                switch ($resort->status) {
                                    case 'open': $ownerStatusClass = 'badge-light-success'; break;
                                    case 'closed': $ownerStatusClass = 'badge-light-black'; break;
                                    case 'rehab': $ownerStatusClass = 'badge-light-warning'; break;
                                    default: $ownerStatusClass = 'badge-light-secondary'; break;
                                }
                            @endphp
                            <span class="badge {{ $ownerStatusClass }} rounded-pill">{{ ucfirst($resort->status ?? 'N/A') }}</span>
                            @if ($resort->status === 'rehab' && $resort->rehab_reason)
                                <small class="d-block text-muted">Reason: {{ $resort->rehab_reason }}</small>
                            @endif
                        </p>
                        <p><strong>Admin Status:</strong>
                            @php
                                $adminStatusClass = '';
                                switch ($resort->admin_status) {
                                    case 'pending': $adminStatusClass = 'badge-light-info'; break;
                                    case 'approved': $adminStatusClass = 'badge-light-success'; break;
                                    case 'rejected': $adminStatusClass = 'badge-light-danger'; break;
                                    default: $adminStatusClass = 'badge-light-secondary'; break;
                                }
                            @endphp
                            <span class="badge {{ $adminStatusClass }} rounded-pill">{{ ucfirst($resort->admin_status ?? 'N/A') }}</span>
                            @if (($resort->admin_status ?? '') === 'rejected' && $resort->rejection_reason)
                                <small class="d-block text-danger">Rejection Reason: {{ $resort->rejection_reason }}</small>
                            @endif
                        </p>

                        @if (($resort->admin_status ?? '') === 'pending')
                            <div class="d-flex gap-2 mt-3">
                                {{-- Approve Button - Triggers unified modal for Resort --}}
                                <button type="button" class="btn btn-success rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                        data-item-id="{{ $resort->id }}"
                                        data-item-name="{{ $resort->resort_name }}"
                                        data-action-type="approve"
                                        data-target-type="resort">
                                    Approve Resort
                                </button>

                                {{-- Reject Button - Triggers unified modal for Resort --}}
                                <button type="button" class="btn btn-danger rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                        data-item-id="{{ $resort->id }}"
                                        data-item-name="{{ $resort->resort_name }}"
                                        data-action-type="reject"
                                        data-target-type="resort">
                                    Reject Resort
                                </button>
                            </div>
                        @else
                            <p class="mt-3">This resort is currently <strong>{{ ucfirst($resort->admin_status) }}</strong>.</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- End of Resort Information Section --}}

            {{-- Rooms Section --}}
            <h3 class="mb-3">Rooms for {{ $resort->resort_name }}</h3>
            @forelse ($resort->rooms as $room)
                <div class="card shadow-sm mb-3">
                    <div class="card-body row align-items-center">
                        <div class="col-md-3 text-center">
                            @if ($room->image_path)
                                <img src="{{ asset($room->image_path) }}"
                                    alt="{{ $room->room_name }}"
                                    class="img-fluid rounded"
                                    style="max-height: 120px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default_room.png') }}"
                                    alt="Default Room Image"
                                    class="img-fluid rounded"
                                    style="max-height: 120px; object-fit: cover;">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>{{ $room->room_name }}</h5>
                            <p class="mb-1">{{ $room->description }}</p>
                            <p class="mb-1"><strong>Price:</strong> ₱{{ number_format($room->price_per_night, 2) }} per night</p>
                            <p class="mb-1"><strong>Max Guests:</strong> {{ $room->max_guests }}</p>
                            {{-- Display Availability --}}
                            <p class="mb-1">
                                <strong>Availability:</strong>
                                <span class="badge {{ $room->is_available ? 'badge-light-success' : 'badge-light-danger' }} rounded-pill">
                                    {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </p>
                            {{-- Display Room Status --}}
                            <p class="mb-1">
                                <strong>Owner Status:</strong>
                                @php
                                    $roomOwnerStatusClass = '';
                                    switch ($room->status) {
                                        case 'open':
                                            $roomOwnerStatusClass = 'badge-light-success';
                                            break;
                                        case 'closed':
                                            $roomOwnerStatusClass = 'badge-light-black';
                                            break;
                                        case 'rehab':
                                            $roomOwnerStatusClass = 'badge-light-warning';
                                            break;
                                        default:
                                            $roomOwnerStatusClass = 'badge-light-secondary';
                                            break;
                                    }
                                @endphp
                                <span class="badge {{ $roomOwnerStatusClass }} rounded-pill">{{ ucfirst($room->status ?? 'N/A') }}</span>
                                @if (($room->status ?? '') === 'rehab' && $room->rehab_reason)
                                    <small class="d-block text-muted">Reason: {{ Str::limit($room->rehab_reason, 50) }}</small>
                                @endif
                            </p>
                            <p><strong>Admin Status:</strong>
                                @php
                                    $roomAdminStatusClass = '';
                                    switch ($room->admin_status) {
                                        case 'pending': $roomAdminStatusClass = 'badge-light-info'; break;
                                        case 'approved': $roomAdminStatusClass = 'badge-light-success'; break;
                                        case 'rejected': $roomAdminStatusClass = 'badge-light-danger'; break;
                                        default: $roomAdminStatusClass = 'badge-light-secondary'; break;
                                    }
                                @endphp
                                <span class="badge {{ $roomAdminStatusClass }} rounded-pill">{{ ucfirst($room->admin_status ?? 'N/A') }}</span>
                                @if (($room->admin_status ?? '') === 'rejected' && $room->rejection_reason)
                                    <small class="d-block text-danger">Rejection Reason: {{ $room->rejection_reason }}</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3 d-flex align-items-center justify-content-end">
                            @if (($room->admin_status ?? '') === 'pending')
                                <div class="d-flex flex-column gap-2">
                                    {{-- Approve Button - Triggers unified modal for Room --}}
                                    <button type="button" class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                            data-item-id="{{ $room->id }}"
                                            data-item-name="{{ $room->room_name }}"
                                            data-action-type="approve"
                                            data-target-type="room">
                                        Approve
                                    </button>
                                    {{-- Reject Button - Triggers unified modal for Room --}}
                                    <button type="button" class="btn btn-danger btn-sm "
                                            data-bs-toggle="modal" data-bs-target="#adminActionModal"
                                            data-item-id="{{ $room->id }}"
                                            data-item-name="{{ $room->room_name }}"
                                            data-action-type="reject"
                                            data-target-type="room">
                                        Reject
                                    </button>
                                </div>
                            @else
                                <span class="text-muted">{{ ucfirst($room->admin_status ?? 'N/A') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No rooms found for this resort.</p>
            @endforelse
        </div>
    </div>

    {{-- Unified Admin Action Confirmation Modal (for both resort and room actions) --}}
    <div class="modal fade" id="adminActionModal" tabindex="-1" aria-labelledby="adminActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="adminActionForm" method="POST">
                    @csrf
                    @method('PATCH') {{-- Both approve and reject will use PATCH --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminActionModalLabel">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modalActionMessage"></p>
                        <div id="rejectionReasonGroup" class="mb-3" style="display: none;">
                            <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="confirmActionButton" class="btn rounded-pill">Confirm</button>
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
            background-color: rgb(6, 58, 170) !important; /* This is the specific blue from your provided images */
        }

        .collapse-icon { transition: transform 0.3s ease; }
        .collapse-icon.rotated { transform: rotate(180deg); }

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
            border: 1px solid #b8daff !important;
        }

        .badge-light-secondary {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
            border: 1px solid #d3d6da !important;
        }

        .badge-light-black { /* For 'Closed' status */
            background-color: #f8f9fa !important; /* Very light gray, almost white */
            color: #212529 !important; /* Dark text for contrast */
            border: 1px solid #dee2e6 !important;
        }

        /* Modal Footer Buttons */
        #adminActionModal .modal-footer .btn-secondary {
            border-radius: 25px !important; /* Apply rounded pill to Cancel button */
            padding: 8px 20px;
        }

        #adminActionModal #confirmActionButton {
            border-radius: 25px !important; /* Apply rounded pill to Confirm button */
            padding: 8px 20px;
        }

        /* Ensure confirm button gets its specific color from BS classes if not overridden */
        #adminActionModal #confirmActionButton.btn-success {
             background-color: #198754 !important; /* Bootstrap success green */
             border-color: #198754 !important;
        }

        #adminActionModal #confirmActionButton.btn-danger {
             background-color: #dc3545 !important; /* Bootstrap danger red */
             border-color: #dc3545 !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ['usersCollapse','usersCollapseMobile'].forEach(function(id){
                var container = document.getElementById(id);
                if(!container) return;
                var triggerBtn = document.querySelector('[data-bs-target="#'+id+'"]');
                var arrow = triggerBtn ? triggerBtn.querySelector('.collapse-icon') : null;
                if(!arrow) return;
                container.addEventListener('show.bs.collapse', function(){ arrow.classList.add('rotated'); });
                container.addEventListener('hide.bs.collapse', function(){ arrow.classList.remove('rotated'); });
            });
        });
    </script>

    {{-- Custom JavaScript for image error handling and modal logic --}}
    <script>
        // Global function for image error handling
        function handleImageError(imgElement, defaultImagePath) {
            imgElement.onerror = null; // Prevent infinite looping if default image also fails
            imgElement.src = defaultImagePath;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var adminActionModal = document.getElementById('adminActionModal');
            adminActionModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var itemId = button.getAttribute('data-item-id'); // Can be resort or room ID
                var itemName = button.getAttribute('data-item-name'); // Can be resort or room name
                var actionType = button.getAttribute('data-action-type'); // 'approve' or 'reject'
                var targetType = button.getAttribute('data-target-type'); // 'resort' or 'room'

                var modalTitle = adminActionModal.querySelector('#adminActionModalLabel');
                var modalActionMessage = adminActionModal.querySelector('#modalActionMessage');
                var rejectionReasonGroup = adminActionModal.querySelector('#rejectionReasonGroup');
                var rejectionReasonTextarea = adminActionModal.querySelector('#rejection_reason');
                var adminActionForm = adminActionModal.querySelector('#adminActionForm');
                var confirmActionButton = adminActionModal.querySelector('#confirmActionButton');

                // Reset modal state
                rejectionReasonGroup.style.display = 'none';
                rejectionReasonTextarea.required = false;
                rejectionReasonTextarea.value = '';
                // Reset button classes to allow new ones to be added cleanly
                confirmActionButton.className = 'btn rounded-pill';

                let routePrefix = '';
                let itemTypeDisplay = '';

                // Dynamically set route prefix based on target type and ensure it matches routes/web.php
                if (targetType === 'resort') {
                    routePrefix = '/admin/resort/'; // Matches Route::patch('/admin/resort/{resort}/...
                    itemTypeDisplay = 'Resort';
                } else if (targetType === 'room') {
                    routePrefix = '/admin/room/'; // Matches Route::patch('/admin/room/{room}/...
                    itemTypeDisplay = 'Room';
                }

                if (actionType === 'approve') {
                    modalTitle.textContent = 'Approve ' + itemTypeDisplay;
                    modalActionMessage.textContent = 'Are you sure you want to approve "' + itemName + '"?';
                    adminActionForm.action = routePrefix + itemId + '/approve';
                    confirmActionButton.textContent = 'Confirm Approve';
                    confirmActionButton.classList.add('btn-success');
                } else if (actionType === 'reject') {
                    modalTitle.textContent = 'Reject ' + itemTypeDisplay;
                    modalActionMessage.textContent = 'Are you sure you want to reject "' + itemName + '"? Please provide a reason.';
                    rejectionReasonGroup.style.display = 'block';
                    rejectionReasonTextarea.required = true;
                    adminActionForm.action = routePrefix + itemId + '/reject';
                    confirmActionButton.textContent = 'Confirm Reject';
                    confirmActionButton.classList.add('btn-danger');
                }
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
        });
    </script>
</x-app-layout>