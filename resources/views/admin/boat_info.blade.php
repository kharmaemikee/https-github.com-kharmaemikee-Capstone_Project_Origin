<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Desktop Sidebar --}}
        <div class="modern-sidebar d-none d-md-block">
            {{-- Sidebar Header --}}
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="brand-icon">
                        <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" class="brand-icon-img">
                    </div>
                    <div class="brand-text">
                        <h4 class="brand-title">Admin Menu</h4>
                        <p class="brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
            </div>
            
            {{-- Sidebar Navigation --}}
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.resort') }}" class="nav-link {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Resort Management</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.boat') }}" class="nav-link {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Boat Management</span>
                    </a>
                </li>
                    
                    <li class="nav-item">
                        <button class="nav-link w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapse" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapse">
                            <div class="nav-icon">
                                <img src="{{ asset('images/users.png') }}" alt="Users Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Users</span>
                        <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                    </button>
                    <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapse">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.resorts') }}" class="nav-link {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                            </li>
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.boats') }}" class="nav-link {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                            </li>
                            <li class="nav-item">
                                    <a href="{{ route('admin.users.tourists') }}" class="nav-link {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                            </li>
                        </ul>
                    </div>
                </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.documentation') }}" class="nav-link {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
                            <div class="nav-icon">
                                <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" class="nav-icon-img">
                            </div>
                            <span class="nav-text">Documentation</span>
                    </a>
                </li>
            </ul>
            </div>
        </div>


        {{-- Mobile Offcanvas Sidebar --}}
        <div class="offcanvas offcanvas-start modern-mobile-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
            <div class="offcanvas-header">
                <div class="mobile-sidebar-brand">
                    <div class="mobile-brand-icon">
                        <img src="{{ asset('images/admin.png') }}" alt="Admin Icon" class="mobile-brand-icon-img">
                    </div>
                    <div class="mobile-brand-text">
                        <h5 class="mobile-brand-title" id="mobileSidebarLabel">Admin Menu</h5>
                        <p class="mobile-brand-subtitle">Management Dashboard</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="mobile-sidebar-nav">
                <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.resort') }}" class="nav-link {{ request()->routeIs('admin.resort') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/management.png') }}" alt="Resort Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Resort Management</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.boat') }}" class="nav-link {{ request()->routeIs('admin.boat') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/boat-steering.png') }}" alt="Boat Management Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Boat Management</span>
                        </a>
                    </li>
                        
                        <li class="nav-item">
                            <button class="nav-link w-100 border-0 bg-transparent" data-bs-toggle="collapse" data-bs-target="#usersCollapseMobile" aria-expanded="{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}" aria-controls="usersCollapseMobile">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/users.png') }}" alt="Users Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Users</span>
                                <img src="{{ asset('image/arrow-down.png') }}" alt="Toggle" class="ms-auto collapse-icon {{ request()->routeIs('admin.users*') ? 'rotated' : '' }}" style="width: 14px; height: 14px;">
                            </button>
                            <div class="collapse {{ request()->routeIs('admin.users*') ? 'show' : '' }}" id="usersCollapseMobile">
                                <ul class="nav flex-column ms-3 mt-1">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.resorts') }}" class="nav-link {{ request()->routeIs('admin.users.resorts') ? 'active' : '' }}">Resort Users</a>
                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.boats') }}" class="nav-link {{ request()->routeIs('admin.users.boats') ? 'active' : '' }}">Boat Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.users.tourists') }}" class="nav-link {{ request()->routeIs('admin.users.tourists') ? 'active' : '' }}">Tourist Users</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.documentation') }}" class="nav-link {{ request()->routeIs('admin.documentation') ? 'active' : '' }}">
                                <div class="nav-icon">
                                    <img src="{{ asset('images/documentation.png') }}" alt="Documentation Icon" class="nav-icon-img">
                                </div>
                                <span class="nav-text">Documentation</span>
                        </a>
                    </li>
                </ul>
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="main-content flex-grow-1">
            {{-- Page Header --}}
            <div class="page-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="page-title-section">
                        <h1 class="page-title">
                            <i class="fas fa-ship me-2"></i>
                            Boat Information
                        </h1>
                        <p class="page-subtitle">Manage and monitor all boat registrations</p>
                    </div>
                    <div class="page-stats">
                        <div class="stat-card">
                            <div class="stat-number">{{ $boats->count() }}</div>
                            <div class="stat-label">Total Boats</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alert Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Boats Table --}}
            <div class="table-container">
            <div class="table-responsive">
                    <table class="table modern-table">
                        <thead class="table-header">
                        <tr>
                                <th scope="col">Boat Number</th>
                                <th scope="col" class="text-center">Image</th>
                            <th scope="col">Boat Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Length</th>
                            <th scope="col">Owner</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($boats as $boat)
                                <tr class="table-row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="image-cell">
                                        <div class="boat-image-wrapper">
                                    @if ($boat->image_path)
                                        <img src="{{ asset($boat->image_path) }}"
                                             alt="{{ $boat->boat_name }}"
                                             class="boat-table-image">
                                    @else
                                        <img src="{{ asset('images/default_boat.png') }}"
                                             alt="Default Boat Image"
                                                    class="boat-table-image">
                                    @endif
                                        </div>
                                </td>
                                    <td class="boat-name-cell">
                                        <div class="boat-name">{{ $boat->boat_name }}</div>
                                    </td>
                                    
                                    <td class="price-cell">
                                        <div class="price-info">
                                            <i class="fas fa-tag text-success me-1"></i>
                                            ₱{{ number_format($boat->boat_prices, 2) }}
                                        </div>
                                    </td>
                                    <td class="capacity-cell">
                                        <div class="capacity-info">
                                            <i class="fas fa-users text-info me-1"></i>
                                            {{ $boat->boat_capacities }} pax
                                        </div>
                                    </td>
                                    <td>
                                        <div class="capacity-info">
                                            <i class="fas fa-ruler-horizontal text-muted me-1"></i>
                                            {{ $boat->boat_length ?? 'N/A' }}
                                        </div>
                                    </td>
                                    
                                    <td class="owner-cell">
                                    @if($boat->user)
                                            <div class="owner-info">
                                                <div class="owner-name">
                                                    <i class="fas fa-user text-primary me-1"></i>
                                                    {{ $boat->user->first_name }} {{ $boat->user->last_name }}
                                                </div>
                                                <div class="owner-email">
                                                    <i class="fas fa-envelope text-muted me-1"></i>
                                                    {{ $boat->user->email }}
                                                </div>
                                        </div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                    <td class="status-cell text-center">
                                    @php
                                        $badgeClass = '';
                                        switch ($boat->status) {
                                                case \App\Models\Boat::STATUS_OPEN:
                                            case \App\Models\Boat::STATUS_APPROVED:
                                                    $badgeClass = 'badge-success';
                                                    break;
                                                case \App\Models\Boat::STATUS_CLOSED:
                                                    $badgeClass = 'badge-dark';
                                                break;
                                            case \App\Models\Boat::STATUS_REJECTED:
                                                    $badgeClass = 'badge-danger';
                                                break;
                                            case \App\Models\Boat::STATUS_REHAB:
                                                    $badgeClass = 'badge-warning';
                                                break;
                                            case \App\Models\Boat::STATUS_PENDING:
                                                    $badgeClass = 'badge-info';
                                                break;
                                            default:
                                                    $badgeClass = 'badge-secondary';
                                                break;
                                        }
                                    @endphp
                                        <span class="badge {{ $badgeClass }} status-badge">
                                        {{ ucfirst($boat->status) }}
                                    </span>
                                    @if ($boat->status === \App\Models\Boat::STATUS_REJECTED && $boat->rejection_reason)
                                            <div class="rejection-reason-small">
                                                <small class="text-muted">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    {{ Str::limit($boat->rejection_reason, 30) }}
                                                </small>
                                            </div>
                                    @elseif ($boat->status === \App\Models\Boat::STATUS_REHAB && $boat->rejection_reason)
                                            <div class="rejection-reason-small">
                                                <small class="text-muted">
                                                    <i class="fas fa-tools me-1"></i>
                                                    {{ Str::limit($boat->rejection_reason, 30) }}
                                                </small>
                                            </div>
                                    @endif
                                </td>
                                    <td class="actions-cell text-center">
                                        <div class="action-buttons">
                                        <button type="button" class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewBoatModal"
                                                data-boat-name="{{ $boat->boat_name }}"
                                                data-assign-no="{{ $loop->iteration }}"
                                                data-boat-length="{{ $boat->boat_length ?? '' }}"
                                                data-captain-name="{{ $boat->captain_name ?? 'N/A' }}"
                                                data-captain-contact="{{ $boat->captain_contact ?? 'N/A' }}"
                                                
                                                data-boat-image="{{ $boat->image_path ? asset($boat->image_path) : asset('images/default_boat.png') }}">
                                            <i class="fas fa-eye me-1"></i>
                                            View
                                        </button>

                                        @if ($boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED)
                                                <form action="{{ route('admin.boat.approve', $boat->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check me-1"></i>
                                                        Approve
                                                    </button>
                                            </form>
                                        @endif

                                        @if ($boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_APPROVED)
                                                <button type="button" class="btn btn-sm btn-danger"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#rejectBoatModal"
                                                     data-boat-id="{{ $boat->id }}"
                                                     data-boat-name="{{ $boat->boat_name }}">
                                                    <i class="fas fa-times me-1"></i>
                                                Reject
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                    <td colspan="9" class="text-center empty-state-cell">
                                        <div class="empty-state">
                                            <i class="fas fa-ship empty-icon"></i>
                                            <h5 class="empty-title">No Boats Found</h5>
                                            <p class="empty-description">There are no boats registered in the system yet.</p>
                                        </div>
                                    </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Boat Modal --}}
    <div class="modal fade" id="rejectBoatModal" tabindex="-1" aria-labelledby="rejectBoatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="modal-title-section">
                        <div class="modal-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    <h5 class="modal-title" id="rejectBoatModalLabel">Reject Boat</h5>
                    </div>
                    <button type="button" class="btn-close modern-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="rejectBoatForm" method="POST" action="">
                    @csrf
                    <div class="modal-body modern-modal-body">
                        <div class="action-message">
                        <p>Are you sure you want to reject the boat: <strong id="modalRejectBoatName"></strong>?</p>
                        </div>
                        <div class="rejection-reason-section">
                            <label for="rejection_reason" class="form-label modern-label">
                                <i class="fas fa-edit me-2"></i>Reason for Rejection (Required)
                            </label>
                            <textarea class="form-control modern-textarea" id="rejection_reason" name="rejection_reason" rows="3" required placeholder="Please provide a detailed reason for rejection..."></textarea>
                            <div class="text-danger mt-2" id="rejectionReasonError"></div>
                    </div>
                    </div>
                    <div class="modal-footer modern-modal-footer">
                        <button type="button" class="btn btn-outline-secondary modern-btn" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-danger modern-btn">
                            <i class="fas fa-times me-2"></i>Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- View Boat Modal --}}
    <div class="modal fade" id="viewBoatModal" tabindex="-1" aria-labelledby="viewBoatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="modal-title-section">
                        <div class="modal-icon">
                            <i class="fas fa-ship"></i>
                        </div>
                    <h5 class="modal-title" id="viewBoatModalLabel">Boat Details</h5>
                </div>
                    <button type="button" class="btn-close modern-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body modern-modal-body">
                    <div class="row g-4 align-items-start">
                        <div class="col-12 col-md-6 text-center">
                            <div class="boat-image-container">
                                <img id="viewBoatImage" src="" alt="Boat" class="boat-detail-image" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="boat-details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-ship me-2"></i>Boat Name
                                </div>
                                    <div class="detail-value" id="viewBoatName">N/A</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-hashtag me-2"></i>Assignment No
                                </div>
                                    <div class="detail-value" id="viewAssignNo">N/A</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-ruler-horizontal me-2"></i>Boat Length
                                </div>
                                    <div class="detail-value" id="viewBoatLength">N/A</div>
                            </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-user-tie me-2"></i>Captain
                        </div>
                                    <div class="detail-value" id="viewCaptainName">N/A</div>
                    </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-phone me-2"></i>Captain Contact
                </div>
                                    <div class="detail-value" id="viewCaptainContact">N/A</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="btn btn-outline-secondary modern-btn" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Modern Sidebar Styling - Dark Theme */
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

        .modern-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            pointer-events: none;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

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

        .brand-icon-img {
            width: 28px;
            height: 28px;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            flex: 1;
        }

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

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav .nav {
            padding: 0 1rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

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

        .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
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

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .collapse-icon { 
            transition: transform 0.3s ease; 
        }
        .collapse-icon.rotated { 
            transform: rotate(180deg); 
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
            padding: 1rem 0;
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

        .mobile-sidebar-nav {
            padding: 1rem 0;
        }

        .mobile-sidebar-nav .nav {
            padding: 0 1rem;
        }

        .mobile-sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
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

        /* Navbar offset and hamburger visibility (match boat owner) */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
        }

        .hamburger-btn {
            display: none !important;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
            margin-left: 280px;
            overflow-y: auto;
        }

        /* Page Header Styles */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border-left: 4px solid #007bff;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .page-title i {
            color: #007bff;
            font-size: 1.8rem;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
            font-weight: 400;
        }

        .page-stats {
            display: flex;
            gap: 1rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            min-width: 120px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Modern Alert Styles */
        .modern-alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .modern-alert.alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .modern-alert.alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid #dc3545;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 1rem;
            max-width: 100%;
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            table-layout: fixed;
        }

        /* Modern Table */
        .modern-table {
            margin: 0;
            border: none;
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 2px solid #dee2e6;
        }

        .table-header th {
            border: none;
            padding: 1.5rem 1rem;
            font-weight: 700;
            color: #495057;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            vertical-align: middle;
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .table-row:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table-row td {
            border: none;
            padding: 1.5rem 1rem;
            vertical-align: middle;
        }

        /* Image Cell */
        .image-cell {
            width: 8%;
        }

        .boat-image-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            margin: 0 auto;
        }

        .boat-image-wrapper:hover {
            transform: scale(1.1);
        }

        .boat-table-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Boat Name Cell */
        .boat-name-cell {
            width: 14%;
        }

        .boat-name {
            font-weight: 700;
            color: #2c3e50;
            font-size: 0.9rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .boat-name:hover {
            transform: scale(1.05);
            color: #007bff;
            font-size: 0.95rem;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.25rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Boat Number Cell */
        .boat-number-cell {
            width: 8%;
        }

        .boat-number {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-weight: 500;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .boat-number:hover {
            transform: scale(1.05);
            color: #007bff;
            font-size: 0.85rem;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.25rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Price Cell */
        .price-cell {
            width: 10%;
        }

        .price-info {
            display: flex;
            align-items: center;
            color: #28a745;
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .price-info:hover {
            transform: scale(1.05);
            color: #20c997;
            font-size: 0.85rem;
        }

        /* Capacity Cell */
        .capacity-cell {
            width: 6%;
        }

        .capacity-info {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-weight: 500;
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .capacity-info:hover {
            transform: scale(1.05);
            color: #007bff;
            font-size: 0.85rem;
        }

        /* Captain Cell */
        .captain-cell {
            width: 20%;
        }

        .captain-info {
            font-size: 0.8rem;
        }

        .captain-name {
            display: flex;
            align-items: center;
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .captain-name:hover {
            transform: scale(1.05);
            color: #007bff;
            font-size: 0.85rem;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.25rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .captain-contact {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-size: 0.7rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .captain-contact:hover {
            transform: scale(1.05);
            color: #28a745;
            font-size: 0.75rem;
        }

        /* Owner Cell */
        .owner-cell {
            width: 20%;
        }

        .owner-info {
            font-size: 0.8rem;
        }

        .owner-name {
            display: flex;
            align-items: center;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .owner-name:hover {
            transform: scale(1.05);
            color: #007bff;
            font-size: 0.85rem;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            position: relative;
            z-index: 10;
            background: white;
            padding: 0.25rem;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .owner-email {
            display: flex;
            align-items: center;
            color: #6c757d;
            font-size: 0.7rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .owner-email:hover {
            transform: scale(1.05);
            color: #28a745;
            font-size: 0.75rem;
        }

        /* Status Cell */
        .status-cell {
            width: 10%;
        }

        .status-badge {
            padding: 0.3rem 0.6rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
        }

        .status-badge:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .rejection-reason-small {
            margin-top: 0.5rem;
        }

        /* Actions Cell */
        .actions-cell {
            width: 14%;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .action-buttons .btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .action-buttons .btn:hover {
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        /* Empty State */
        .empty-state-cell {
            padding: 4rem 2rem !important;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            color: #adb5bd;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .table-container {
                margin: 1rem 0;
                overflow-x: auto;
            }
            
            .table-header th,
            .table-row td {
                padding: 1rem 0.5rem;
            }
            
            .boat-name-cell {
                width: 16%;
            }
            
            .captain-cell {
                width: 20%;
            }
            
            .owner-cell {
                width: 20%;
            }
            
            .status-cell {
                width: 12%;
            }
            
            .actions-cell {
                width: 16%;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                margin-left: 0;
            }

            .modern-sidebar {
                display: none !important;
            }

            .hamburger-btn {
                display: block !important;
            }

            .modern-navbar {
                left: 0;
                width: 100%;
            }
            
            .page-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .page-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .stat-card {
                min-width: 100px;
                padding: 1rem;
            }
            
            .table-container {
                margin: 1rem 0;
                border-radius: 12px;
                overflow-x: auto;
            }
            
            .modern-table {
                min-width: 800px;
            }
            
            .table-header th,
            .table-row td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .boat-image-wrapper {
                width: 50px;
                height: 50px;
            }
            
            .boat-name {
                font-size: 0.85rem;
            }
            
            .captain-info,
            .owner-info {
                font-size: 0.75rem;
            }
            
            .captain-name,
            .owner-name {
                font-size: 0.8rem;
            }
            
            .captain-contact,
            .owner-email {
                font-size: 0.7rem;
            }
            
            .status-badge {
                padding: 0.25rem 0.5rem;
                font-size: 0.65rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .action-buttons .btn {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
            
            .page-header {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.3rem;
            }
            
            .page-subtitle {
                font-size: 0.9rem;
            }
            
            .stat-card {
                padding: 0.75rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .table-container {
                margin: 0.75rem 0;
                border-radius: 8px;
                overflow-x: auto;
            }
            
            .modern-table {
                min-width: 700px;
            }
            
            .table-header th {
                padding: 0.5rem 0.25rem;
                font-size: 0.7rem;
            }
            
            .table-row td {
                padding: 0.5rem 0.25rem;
                font-size: 0.75rem;
            }
            
            .boat-image-wrapper {
                width: 40px;
                height: 40px;
            }
            
            .boat-name {
                font-size: 0.75rem;
            }
            
            .captain-info,
            .owner-info {
                font-size: 0.7rem;
            }
            
            .captain-name,
            .owner-name {
                font-size: 0.75rem;
            }
            
            .captain-contact,
            .owner-email {
                font-size: 0.65rem;
            }
            
            .status-badge {
                padding: 0.2rem 0.4rem;
                font-size: 0.6rem;
            }
            
            .action-buttons .btn {
                font-size: 0.65rem;
                padding: 0.2rem 0.4rem;
            }
            
            .empty-state {
                padding: 1.5rem 1rem;
            }
            
            .empty-icon {
                font-size: 2.5rem;
            }
            
            .empty-title {
                font-size: 1rem;
            }
            
            .empty-description {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            .table-container {
                margin: 0.5rem 0;
                overflow-x: auto;
            }
            
            .modern-table {
                min-width: 600px;
            }
            
            .table-header th,
            .table-row td {
                padding: 0.4rem 0.2rem;
                font-size: 0.65rem;
            }
            
            .boat-image-wrapper {
                width: 35px;
                height: 35px;
            }
            
            .boat-name {
                font-size: 0.7rem;
            }
            
            .captain-info,
            .owner-info {
                font-size: 0.65rem;
            }
            
            .captain-name,
            .owner-name {
                font-size: 0.7rem;
            }
            
            .captain-contact,
            .owner-email {
                font-size: 0.6rem;
            }
            
            .status-badge {
                padding: 0.15rem 0.3rem;
                font-size: 0.55rem;
            }
            
            .action-buttons .btn {
                font-size: 0.6rem;
                padding: 0.15rem 0.3rem;
            }
        }

        /* Enhanced Status Badge Colors for Better Visibility */
        .badge-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            color: white !important;
            border: 2px solid #1e7e34 !important;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3) !important;
        }

        .badge-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
            color: #212529 !important;
            border: 2px solid #e0a800 !important;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3) !important;
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            color: white !important;
            border: 2px solid #bd2130 !important;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;
        }

        .badge-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
            color: white !important;
            border: 2px solid #117a8b !important;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3) !important;
        }

        .badge-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
            color: white !important;
            border: 2px solid #545b62 !important;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3) !important;
        }

        .badge-dark {
            background: linear-gradient(135deg, #343a40 0%, #212529 100%) !important;
            color: white !important;
            border: 2px solid #1d2124 !important;
            box-shadow: 0 2px 8px rgba(52, 58, 64, 0.3) !important;
        }

        /* Legacy badge styles for compatibility */
        .badge-light-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
            color: #155724 !important;
            border: 2px solid #b8dacc !important;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2) !important;
        }

        .badge-light-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
            color: #85640a !important;
            border: 2px solid #ffd43b !important;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2) !important;
        }

        .badge-light-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
            color: #721c24 !important;
            border: 2px solid #f1b0b7 !important;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2) !important;
        }

        .badge-light-info {
            background: linear-gradient(135deg, #e0f7fa 0%, #b8daff 100%) !important;
            color: #0c5460 !important;
            border: 2px solid #9fcdff !important;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2) !important;
        }

        .badge-light-secondary {
            background: linear-gradient(135deg, #e2e3e5 0%, #d3d6da 100%) !important;
            color: #383d41 !important;
            border: 2px solid #c6c8ca !important;
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.2) !important;
        }

        .badge-light-black {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
            color: #212529 !important;
            border: 2px solid #dee2e6 !important;
            box-shadow: 0 2px 8px rgba(52, 58, 64, 0.2) !important;
        }

        /* Modern Modal Design */
        .modern-modal {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .modern-modal-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border: none;
            padding: 1.5rem;
            position: relative;
        }

        .modal-title-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .modern-modal-header .modal-title {
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .modern-close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 8px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .modern-close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .modern-close-btn i {
            font-size: 1rem;
            color: white;
        }

        .modern-modal-body {
            padding: 2rem;
            background: #f8f9fa;
        }

        .action-message p {
            font-size: 1rem;
            color: #495057;
            margin: 0;
            line-height: 1.6;
        }

        .rejection-reason-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            margin-top: 1rem;
        }

        .modern-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .modern-textarea {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            resize: vertical;
        }

        .modern-textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .modern-modal-footer {
            background: white;
            border: none;
            padding: 1.5rem 2rem;
            gap: 1rem;
        }

        .modern-btn {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Boat Details Modal Specific Styles */
        .boat-image-container {
            background: white;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
        }

        .boat-detail-image {
            width: 100%;
            max-height: 60vh;
            object-fit: contain;
            border-radius: 8px;
        }

        .boat-details-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .detail-item {
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
        }

        /* Responsive Modal Design */
        @media (max-width: 768px) {
            .modern-modal-header {
                padding: 1rem;
            }

            .modern-modal-body {
                padding: 1.5rem;
            }

            .modern-modal-footer {
                padding: 1rem 1.5rem;
                flex-direction: column;
            }

            .modern-btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .modal-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .modern-modal-header .modal-title {
                font-size: 1.1rem;
            }

            .boat-details-grid {
                gap: 1rem;
            }

            .detail-item {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .modern-modal {
                margin: 1rem;
            }

            .modern-modal-header {
                padding: 0.75rem;
            }

            .modern-modal-body {
                padding: 1rem;
            }

            .modern-modal-footer {
                padding: 0.75rem 1rem;
            }

            .rejection-reason-section {
                padding: 1rem;
            }

            .boat-details-grid {
                gap: 0.75rem;
            }

            .detail-item {
                padding: 0.75rem;
            }

            .detail-label {
                font-size: 0.8rem;
            }

            .detail-value {
                font-size: 1rem;
            }
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

            // View Boat Modal population
            const viewBoatModal = document.getElementById('viewBoatModal');
            if (viewBoatModal) {
                viewBoatModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    if (!button) return;
                    const boatName = button.getAttribute('data-boat-name') || 'N/A';
                    const assignNo = button.getAttribute('data-assign-no') || 'N/A';
                    const boatNumber = button.getAttribute('data-boat-number') || 'N/A';
                    const boatLength = button.getAttribute('data-boat-length') || 'N/A';
                    const captainName = button.getAttribute('data-captain-name') || 'N/A';
                    const captainContact = button.getAttribute('data-captain-contact') || 'N/A';
                    const boatImage = button.getAttribute('data-boat-image') || '';

                    const nameEl = document.getElementById('viewBoatName');
                    const assignEl = document.getElementById('viewAssignNo');
                    const numberEl = document.getElementById('viewBoatNumber');
                    const lengthEl = document.getElementById('viewBoatLength');
                    const capEl = document.getElementById('viewCaptainName');
                    const contactEl = document.getElementById('viewCaptainContact');
                    const imgEl = document.getElementById('viewBoatImage');
                    if (nameEl) nameEl.textContent = boatName;
                    if (assignEl) assignEl.textContent = assignNo;
                    if (numberEl) numberEl.textContent = boatNumber;
                    if (lengthEl) lengthEl.textContent = boatLength;
                    if (capEl) capEl.textContent = captainName;
                    if (contactEl) contactEl.textContent = captainContact;
                    if (imgEl) {
                        imgEl.src = boatImage;
                        imgEl.onerror = function(){ this.src='{{ asset("images/default_boat.png") }}'; };
                    }
                });
            }
        });
    </script>
</x-app-layout>