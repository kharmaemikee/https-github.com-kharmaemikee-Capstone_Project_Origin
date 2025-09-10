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
                    <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 active d-flex align-items-center" aria-current="page">
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
                <li class="nav-item mt-2">
                    <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                        <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                        Notifications
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger ms-2" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
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
                        <a href="{{ route('resort.owner.information') }}" class="nav-link text-white rounded p-2 d-flex align-items-center active" aria-current="page">
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
                    <li class="nav-item mt-2">
                        <a href="{{ route('resort.owner.notification') }}" class="nav-link text-white rounded p-2 d-flex align-items-center {{ request()->routeIs('resort.owner.notification') ? 'active' : '' }}">
                            <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" style="width: 20px; height: 20px; margin-right: 8px;">
                            Notifications
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="badge bg-danger ms-2" id="unreadBadgeMobile">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
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
                <h2 class="mb-0">{{ $resort->resort_name }}</h2>
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

            {{-- Resort Information Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title text-dark mb-0">Resort Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if ($resort->image_path)
                                <img src="{{ asset($resort->image_path) }}"
                                    alt="{{ $resort->resort_name }}"
                                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                            @else
                                <img src="{{ asset('images/default_resort.png') }}"
                                    alt="Default Resort Image"
                                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Location:</strong> {{ $resort->location }}</p>
                                    <p><strong>Contact:</strong> {{ $resort->contact_number }}</p>
                                    <p><strong>Status:</strong> 
                                        <span @class([
                                            'badge',
                                            'badge-light-success' => ($resort->status ?? '') === 'open',
                                            'badge-light-black text-dark' => ($resort->status ?? '') === 'closed',
                                            'badge-light-warning text-dark' => ($resort->status ?? '') === 'rehab',
                                            'badge-light-secondary text-dark' => !in_array(($resort->status ?? ''), ['open', 'closed', 'rehab']),
                                        ])>
                                            {{ ucfirst($resort->status ?? 'N/A') }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Admin Status:</strong> 
                                        <span class="badge badge-light-success">Approved</span>
                                        <small class="text-muted d-block">Automatically approved on registration</small>
                                    </p>
                                    @if ($resort->facebook_page_link)
                                        <p><strong>Facebook:</strong> 
                                            <a href="{{ $resort->facebook_page_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fab fa-facebook"></i> Visit Page
                                            </a>
                                        </p>
                                    @endif
                                    <div class="mt-3">
                                        <a href="{{ route('resort.owner.edit', $resort->id) }}" class="btn btn-primary btn-sm btn-icon me-2" title="Edit Resort">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#statusModal" title="Change Resort Status">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rooms Management Section --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-dark mb-0">Rooms Management</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('resort.owner.rooms.create', ['resort' => $resort->id, 'type' => 'room']) }}" class="btn btn-success btn-sm btn-icon" title="Add New Room">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="{{ route('resort.owner.rooms.archive.index', $resort->id) }}" class="btn btn-info btn-sm btn-icon" title="View Archived Rooms">
                            <i class="fas fa-archive"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Price / Night</th>
                                    <th scope="col">Max Guests</th>
                                    <th scope="col">Availability / Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms->where('accommodation_type','room') as $room)
                                    <tr>
                                        <td>
                                            @if ($room->image_path)
                                                <img src="{{ asset($room->image_path) }}"
                                                    alt="{{ $room->room_name }}"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                                                    >
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
                                                <button type="button" class="btn btn-warning btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#archiveRoomConfirmationModal" data-room-id="{{ $room->id }}" title="Archive Room">
                                                    <i class="fas fa-archive"></i>
                                                </button>
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

            <hr class="my-4">

            {{-- Cottages Management Section --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-dark mb-0">Cottages Management</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('resort.owner.rooms.create', ['resort' => $resort->id, 'type' => 'cottage']) }}" class="btn btn-success btn-sm btn-icon" title="Add New Cottage">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="{{ route('resort.owner.rooms.archive.index', $resort->id) }}" class="btn btn-info btn-sm btn-icon" title="View Archived Cottages">
                            <i class="fas fa-archive"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Cottage Name</th>
                                    <th scope="col">Price / Day</th>
                                    <th scope="col">Max Guests</th>
                                    <th scope="col">Availability / Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms->where('accommodation_type','cottage') as $room)
                                    <tr>
                                        <td>
                                            @if ($room->image_path)
                                                <img src="{{ asset($room->image_path) }}"
                                                    alt="{{ $room->room_name }}"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;"
                                                    >
                                            @else
                                                <img src="{{ asset('images/default_room.png') }}"
                                                    alt="Default Cottage Image"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                            @endif
                                        </td>
                                        <td>{{ $room->room_name }}</td>
                                        <td>₱{{ number_format($room->price_per_night, 2) }}</td>
                                        <td>{{ $room->max_guests }}</td>
                                        <td>
                                            @php
                                                $availabilityClass = $room->is_available ? 'badge-light-green text-dark' : 'badge-light-red text-dark';
                                            @endphp
                                            <span class="badge {{ $availabilityClass }}">
                                                {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                            </span>
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
                                                <a href="{{ route('resort.owner.rooms.edit', $room->id) }}" class="btn btn-primary btn-sm btn-icon" title="Edit Cottage">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-warning btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#archiveRoomConfirmationModal" data-room-id="{{ $room->id }}" title="Archive Cottage">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#deleteRoomConfirmationModal" data-room-id="{{ $room->id }}" title="Delete Cottage">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No cottages added yet. Click "Add Cottage" to get started!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Change Modal --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Resort Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('resort.owner.update_status', $resort->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="open" {{ $resort->status === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="closed" {{ $resort->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="maintenance" {{ $resort->status === 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3" id="rehabReasonDiv" style="display: none;">
                                                            <label for="rehab_reason" class="form-label">Maintenance Reason</label>
                                                            <textarea class="form-control" id="rehab_reason" name="rehab_reason" rows="3" placeholder="Please provide a reason for maintenance...">{{ $resort->rehab_reason }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Archive Room Confirmation Modal --}}
    <div class="modal fade" id="archiveRoomConfirmationModal" tabindex="-1" aria-labelledby="archiveRoomConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archiveRoomConfirmationModalLabel">Confirm Archive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to archive this room? Archived rooms will be hidden from the main view but can be restored later.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="archiveRoomForm" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning">Confirm Archive</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Room Confirmation Modal --}}
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

        .badge-light-black {
            background-color: #f8f9fa !important; /* Very light gray, almost white */
            color: #212529 !important; /* Dark text for contrast */
            border: 1px solid #dee2e6 !important;
        }

        .badge-light-green {
            background-color: #d4edda !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }

        .badge-light-yellow {
            background-color: #fff3cd !important;
            color: #856404 !important;
            border: 1px solid #ffeeba !important;
        }

        .badge-light-red {
            background-color: #f8d7da !important;
            color: #721c24 !important;
            border: 1px solid #f5c6cb !important;
        }

        /* Set width for mobile offcanvas sidebar */
        #mobileSidebar {
            width: 50vw; /* This makes it half the viewport width */
        }

        /* Added for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease; /* Smooth transition for rotation */
        }

        .collapse-icon.rotated {
            transform: rotate(180deg); /* Rotates the arrow downwards */
        }
    </style>

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

            // Status modal logic
            var statusSelect = document.getElementById('status');
            var rehabReasonDiv = document.getElementById('rehabReasonDiv');
            var rehabReasonInput = document.getElementById('rehab_reason');

                    function toggleRehabReason() {
            if (statusSelect.value === 'maintenance') {
                rehabReasonDiv.style.display = 'block';
                rehabReasonInput.required = true;
            } else {
                rehabReasonDiv.style.display = 'none';
                rehabReasonInput.required = false;
            }
        }

            statusSelect.addEventListener('change', toggleRehabReason);
            toggleRehabReason(); // Initial call

            // Delete room modal logic
            var deleteRoomConfirmationModal = document.getElementById('deleteRoomConfirmationModal');
            deleteRoomConfirmationModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var roomId = button.getAttribute('data-room-id');
                var deleteForm = deleteRoomConfirmationModal.querySelector('#deleteRoomForm');
                deleteForm.action = '/resort_owner/rooms/' + roomId;
            });

            // Archive room modal logic
            var archiveRoomConfirmationModal = document.getElementById('archiveRoomConfirmationModal');
            if (archiveRoomConfirmationModal) {
                archiveRoomConfirmationModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var roomId = button.getAttribute('data-room-id');
                    var archiveForm = archiveRoomConfirmationModal.querySelector('#archiveRoomForm');
                    archiveForm.action = '/resort_owner/rooms/' + roomId + '/archive';
                });
            }

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