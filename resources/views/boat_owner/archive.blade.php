<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        <div class="modern-sidebar d-none d-md-block">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/summer.png') }}" alt="Boat Owner Icon" class="brand-icon-img">
                    </div>
                    <div class="brand-text">
                        <h4 class="brand-title">Boats Menu</h4>
                        <p class="brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
            </div>
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('boat.owner.dashboard') }}" class="nav-link {{ request()->routeIs('boat.owner.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('boat') }}" class="nav-link {{ request()->routeIs('boat') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Boat Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('boat.owner.verified') }}" class="nav-link {{ request()->routeIs('boat.owner.verified') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/verified.png') }}" alt="Account Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Account Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('boat.owner.notification') }}" class="nav-link {{ request()->routeIs('boat.owner.notification') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/bell.png') }}" alt="Notification Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Notifications</span>
                            @php
                                $unreadCount = \App\Models\BoatOwnerNotification::where('user_id', auth()->id())->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="nav-badge notification-badge" id="unreadBadgeDesktop">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>

        <div class="main-content flex-grow-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="h4 mb-0">Archived Boats</h3>
                        <a href="{{ route('boat') }}" class="btn btn-outline-primary">Back to Boats</a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="px-4">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col">Boat Name</th>
                                        <th scope="col">Boat Plate Number</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Capacity</th>
                                        <th scope="col">Archived Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($boats as $boat)
                                        <tr>
                                            <td>
                                                @if ($boat->image_path)
                                                    <img src="{{ asset($boat->image_path) }}" alt="{{ $boat->boat_name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                                @else
                                                    <img src="{{ asset('images/boat.png') }}" alt="Default Boat Image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                                @endif
                                            </td>
                                            <td>{{ $boat->boat_name }}</td>
                                            <td>{{ $boat->boat_number }}</td>
                                            <td>₱{{ number_format($boat->boat_prices, 2) }}</td>
                                            <td>{{ $boat->boat_capacities }}</td>
                                            <td>
                                                <span class="text-muted">
                                                    @if($boat->archived_at)
                                                        @if($boat->archived_at instanceof \Carbon\Carbon)
                                                            {{ $boat->archived_at->format('M d, Y H:i') }}
                                                        @else
                                                            {{ is_string($boat->archived_at) ? $boat->archived_at : 'Invalid Date' }}
                                                        @endif
                                                    @else
                                                        Unknown
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-success btn-sm btn-icon restore-btn" data-boat-id="{{ $boat->id }}" data-boat-name="{{ $boat->boat_name }}" title="Restore Boat">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm btn-icon delete-btn" data-boat-id="{{ $boat->id }}" data-boat-name="{{ $boat->boat_name }}" title="Delete Boat">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-archive fa-3x mb-3"></i>
                                                    <p>No archived boats found.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($boats->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $boats->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips like in boat.blade.php
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            document.querySelectorAll('.restore-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const boatId = this.getAttribute('data-boat-id');
                    const boatName = this.getAttribute('data-boat-name');
                    const boatRow = this.closest('tr');

                    Swal.fire({
                        title: "Restore Boat",
                        html: `Are you sure you want to restore <strong>${boatName}</strong>? It will appear again in your boats list and admin boat info.`,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, restore it!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'PUT');

                            fetch(`/boat_owner/archive/${boatId}/restore`, {
                                method: 'POST',
                                body: formData,
                                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                            }).then(response => {
                                if (response.ok) {
                                    if (boatRow) boatRow.remove();
                                    Swal.fire({ title: "Restored!", text: "Boat restored successfully.", icon: "success" });
                                } else { throw new Error('Restore failed'); }
                            }).catch(() => {
                                Swal.fire({ title: "Error!", text: "Failed to restore boat.", icon: "error" });
                            });
                        }
                    });
                });
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const boatId = this.getAttribute('data-boat-id');
                    const boatName = this.getAttribute('data-boat-name');
                    const boatRow = this.closest('tr');

                    Swal.fire({
                        title: "Permanently Delete Boat",
                        html: `This action cannot be undone. Delete <strong>${boatName}</strong> permanently?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, delete permanently!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');

                            fetch(`/boat_owner/archive/${boatId}/force`, {
                                method: 'POST',
                                body: formData,
                                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                            }).then(response => {
                                if (response.ok) {
                                    if (boatRow) boatRow.remove();
                                    Swal.fire({ title: "Deleted!", text: "Boat permanently deleted.", icon: "success" });
                                } else { throw new Error('Delete failed'); }
                            }).catch(() => {
                                Swal.fire({ title: "Error!", text: "Failed to delete boat.", icon: "error" });
                            });
                        }
                    });
                });
            });
        });
    </script>

    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
        /* Match sidebar styling from boat.blade.php */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: #2c3e50;
            border-right: 1px solid #34495e;
            position: relative;
        }
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #34495e;
        }
        .sidebar-brand { display: flex; align-items: center; gap: 1rem; }
        .brand-icon {
            width: 50px; height: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            backdrop-filter: blur(10px);
        }
        .brand-icon-img { width: 28px; height: 28px; filter: brightness(0) invert(1); }
        .brand-title { color: white; font-size: 1.1rem; font-weight: 600; margin: 0; line-height: 1.2; }
        .brand-subtitle { color: rgba(255,255,255,0.7); font-size: 0.85rem; margin: 0; line-height: 1.2; }
        .sidebar-nav { padding: 1rem 0; }
        .sidebar-nav .nav-item { margin-bottom: 0.5rem; }
        .sidebar-nav .nav-link {
            display: flex; align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative; overflow: hidden;
        }
        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0; transition: opacity 0.3s ease;
        }
        .sidebar-nav .nav-link:hover::before { opacity: 1; }
        .sidebar-nav .nav-link:hover {
            color: white; transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar-nav .nav-link.active::before { opacity: 1; }
        .nav-icon {
            width: 40px; height: 40px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-right: 1rem; transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        .nav-icon-img { width: 20px; height: 20px; filter: brightness(0) invert(1); }

        /* Main Content matches boat.blade */
        .main-content { padding: 2rem; background: #f8f9fa; min-height: 100vh; }

        /* Notification badge styles (match boat.blade.php) */
        .nav-badge {
            background: #e74c3c;
            color: #fff;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: auto;
            font-weight: 600;
        }
        .notification-badge { animation: pulse 2s infinite; }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Mobile sidebar (keep simple) */
        .modern-mobile-sidebar { background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); width: 85vw !important; max-width: 350px; }

        /* Buttons */
        .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; }
    </style>
</x-app-layout>


