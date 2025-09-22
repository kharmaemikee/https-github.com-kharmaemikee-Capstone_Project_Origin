<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('boat_owner.partials.sidebar')

        <div class="main-content flex-grow-1">
            <div class="container-fluid flex-grow-1 p-0">
                {{-- Page Header --}}
                <div class="page-header">
                    <div class="page-title-section">
                        <h1 class="page-title">
                            <i class="fas fa-archive me-2"></i>
                            Archived Boats
                        </h1>
                        <p class="page-subtitle">Manage your archived boats and restore them when needed</p>
                    </div>
                    <div class="page-actions">
                        <a href="{{ route('boat') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Boats
                        </a>
                    </div>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Archive Content --}}
                <div class="archive-container">
                    <div class="archive-card">
                        @if($boats->count() > 0)
                            <div class="archive-stats">
                                <div class="stat-item">
                                    <i class="fas fa-archive"></i>
                                    <span>{{ $boats->count() }} Archived Boat{{ $boats->count() !== 1 ? 's' : '' }}</span>
                                </div>
                            </div>

                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table archive-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <i class="fas fa-image me-1"></i>
                                                    Image
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-ship me-1"></i>
                                                    Boat Name
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-id-card me-1"></i>
                                                    Plate Number
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-tag me-1"></i>
                                                    Price
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-users me-1"></i>
                                                    Capacity
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Archived Date
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-cogs me-1"></i>
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($boats as $boat)
                                                <tr class="archive-row">
                                                    <td class="boat-image-cell">
                                                        <div class="boat-image-wrapper">
                                                            @if ($boat->image_path)
                                                                <img src="{{ asset($boat->image_path) }}" 
                                                                     alt="{{ $boat->boat_name }}" 
                                                                     class="boat-image"
                                                                     data-fallback="{{ asset('images/boat.png') }}">
                                                            @else
                                                                <img src="{{ asset('images/boat.png') }}" 
                                                                     alt="Default Boat Image" 
                                                                     class="boat-image">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="boat-name-cell">
                                                        <div class="boat-name">{{ $boat->boat_name }}</div>
                                                    </td>
                                                    <td class="plate-cell">
                                                        <span class="plate-number">{{ $boat->boat_number }}</span>
                                                    </td>
                                                    <td class="price-cell">
                                                        <span class="price-amount">₱{{ number_format($boat->boat_prices, 2) }}</span>
                                                    </td>
                                                    <td class="capacity-cell">
                                                        <span class="capacity-count">{{ $boat->boat_capacities }}</span>
                                                        <small class="capacity-label">passengers</small>
                                                    </td>
                                                    <td class="date-cell">
                                                        <div class="archived-date">
                                                            @if($boat->archived_at)
                                                                @if($boat->archived_at instanceof \Carbon\Carbon)
                                                                    <div class="date-main">{{ $boat->archived_at->format('M d, Y') }}</div>
                                                                    <div class="date-time">{{ $boat->archived_at->format('H:i') }}</div>
                                                                @else
                                                                    <div class="date-main">{{ is_string($boat->archived_at) ? $boat->archived_at : 'Invalid Date' }}</div>
                                                                @endif
                                                            @else
                                                                <div class="date-main text-muted">Unknown</div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="actions-cell">
                                                        <div class="action-buttons">
                                                            <button type="button" class="btn btn-success btn-sm action-btn restore-btn" 
                                                                    data-boat-id="{{ $boat->id }}" 
                                                                    data-boat-name="{{ $boat->boat_name }}" 
                                                                    title="Restore Boat">
                                                                <i class="fas fa-undo me-1"></i>
                                                                Restore
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm action-btn delete-btn" 
                                                                    data-boat-id="{{ $boat->id }}" 
                                                                    data-boat-name="{{ $boat->boat_name }}" 
                                                                    title="Delete Boat">
                                                                <i class="fas fa-trash me-1"></i>
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-archive"></i>
                                </div>
                                <h3 class="empty-title">No Archived Boats</h3>
                                <p class="empty-description">There are no archived boats in your account.</p>
                                <a href="{{ route('boat') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Manage Boats
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($boats->hasPages())
                        <div class="pagination-container">
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
            // Image error handling
            const boatImages = document.querySelectorAll('.boat-image[data-fallback]');
            boatImages.forEach(img => {
                img.addEventListener('error', function() {
                    this.src = this.getAttribute('data-fallback');
                });
            });

            // Initialize tooltips like in boat.blade.php
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
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
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }
        .sidebar-brand { display: flex; align-items: center; gap: 1rem; }
        .brand-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .brand-icon-img { width: 28px; height: 28px; filter: brightness(0) invert(1); }
        .brand-title { 
            color: white; 
            font-size: 1.25rem; 
            font-weight: 700; 
            margin: 0; 
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
        }
        .brand-subtitle { 
            color: rgba(255, 255, 255, 0.8); 
            font-size: 0.85rem; 
            margin: 0; 
            font-weight: 400; 
        }
        .sidebar-nav { 
            padding: 1.5rem 0; 
            position: relative; 
            z-index: 1; 
        }
        .sidebar-nav .nav {
            padding: 0 1rem;
        }
        .sidebar-nav .nav-item { margin-bottom: 0.5rem; }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav .nav-link.active::before {
            opacity: 1;
        }
        .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .nav-link.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }
        .nav-icon-img { 
            width: 20px; 
            height: 20px; 
            filter: brightness(0) invert(1); 
            transition: all 0.3s ease;
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        /* Adjust navbar width to match sidebar */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
        }

        /* Hide hamburger button by default on larger screens */
        .hamburger-btn {
            display: none !important;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
        }


        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 55vw !important;
        }

        .mobile-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-brand-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .mobile-brand-icon-img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        .mobile-brand-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mobile-brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin: 0;
            font-weight: 400;
        }

        .mobile-sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mobile-sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        /* Notification badge styles (match boat.blade.php) */
        .nav-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }
        .notification-badge { 
            background: linear-gradient(135deg, #ff6b6b, #ff4757);
            animation: pulse 2s infinite; 
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Mobile sidebar (keep simple) */
        .modern-mobile-sidebar { background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); width: 85vw !important; max-width: 350px; }

        /* Page Header */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border-left: 4px solid #007bff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title-section {
            flex: 1;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .page-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Archive Container */
        .archive-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .archive-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Archive Stats */
        .archive-stats {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            color: #495057;
        }

        .stat-item i {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Table Container */
        .table-container {
            padding: 0;
        }

        .archive-table {
            margin-bottom: 0;
            border: none;
        }

        .archive-table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
        }

        .archive-table tbody tr {
            border: none;
            transition: all 0.3s ease;
        }

        .archive-table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .archive-table tbody td {
            padding: 1.5rem;
            border: none;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
        }

        /* Boat Image */
        .boat-image-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .boat-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .boat-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Boat Name */
        .boat-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        /* Plate Number */
        .plate-number {
            font-weight: 600;
            color: #495057;
            font-size: 1rem;
            background: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        /* Price */
        .price-amount {
            font-weight: 700;
            color: #28a745;
            font-size: 1.2rem;
        }

        /* Capacity */
        .capacity-count {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
        }

        .capacity-label {
            color: #6c757d;
            font-size: 0.85rem;
            margin-left: 0.25rem;
        }

        /* Date */
        .archived-date {
            text-align: center;
        }

        .date-main {
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
        }

        .date-time {
            color: #6c757d;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .restore-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
        }

        .restore-btn:hover {
            background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
            color: white;
        }

        .delete-btn {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            border: none;
            color: white;
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #c82333 0%, #e55a00 100%);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 1rem;
        }

        .empty-description {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        /* Pagination */
        .pagination-container {
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                margin-left: 0;
            }
            
            .modern-sidebar {
                display: none !important;
            }
            
            /* Ensure hamburger button is visible */
            .hamburger-btn {
                display: block !important;
            }
            
            .modern-navbar {
                left: 0;
                width: 100%;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .archive-table thead th {
                padding: 1rem 0.75rem;
                font-size: 0.8rem;
            }

            .archive-table tbody td {
                padding: 1rem 0.75rem;
            }

            .boat-image {
                width: 60px;
                height: 60px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }

            .action-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
            
            .main-content {
                padding: 0.75rem;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
            }
            
            .modern-mobile-sidebar {
                width: 95vw !important;
            }

            .page-header {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.3rem;
            }

            .archive-table thead th {
                padding: 0.75rem 0.5rem;
                font-size: 0.75rem;
            }

            .archive-table tbody td {
                padding: 0.75rem 0.5rem;
            }

            .boat-image {
                width: 50px;
                height: 50px;
            }

            .boat-name {
                font-size: 0.9rem;
            }

            .price-amount {
                font-size: 1rem;
            }

            .capacity-count {
                font-size: 1rem;
            }
        }
    </style>
</x-app-layout>


