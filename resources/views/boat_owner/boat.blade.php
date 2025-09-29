<x-app-layout>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('boat_owner.partials.sidebar')


        <div class="main-content flex-grow-1">
            {{-- Main Content Area (Boat Management) --}}
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
                {{-- Page Header --}}
            <div class="page-header mb-4">
                <div class="page-title-section">
                    <h1 class="page-title">
                        <i class="fas fa-ship me-2"></i>
                        Boat Management
                    </h1>
                    <p class="page-subtitle">Manage your boat fleet and monitor boat status</p>
                </div>
                <div class="page-actions">
                    <div class="action-buttons">
                        <a href="{{ route('boat.owner.add') }}" class="btn btn-primary modern-btn">
                            <i class="fas fa-plus me-2"></i>
                            Add Boat
                        </a>
                        <a href="{{ route('boat.owner.archive') }}" class="btn btn-light modern-btn archive-btn-header">
                            <i class="fas fa-archive me-2"></i>
                            Archive
                        </a>
                    </div>
                </div>
            </div>


            @if (session('error'))
            
                <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Boats Grid --}}
            <div class="boats-section">
                <div class="section-header">
                    <h5 class="section-title">
                        <i class="fas fa-list me-2"></i>
                        Your Boats
                    </h5>
                    <div class="boats-count">
                        <span class="count-badge">{{ $boats->count() }} boats</span>
                    </div>
                </div>

                @if($boats->count() > 0)
                    <div class="boats-grid">
                        @foreach($boats as $boat)
                            <div class="boat-card">
                                <div class="boat-image-container">
                                    @if ($boat->image_path)
                                        <img src="{{ asset($boat->image_path) }}"
                                             alt="{{ $boat->boat_name }}"
                                             class="boat-image"
                                             onerror="handleImageError(this, '{{ asset('images/boat.png') }}')">
                                    @else
                                        <img src="{{ asset('images/boat.png') }}"
                                             alt="Default Boat Image"
                                             class="boat-image">
                                    @endif
                                    <div class="boat-status-overlay">
                                        @php
                                            $statusClass = '';
                                            $displayText = '';
                                            switch ($boat->status) {
                                                case \App\Models\Boat::STATUS_APPROVED:
                                                    $statusClass = 'status-approved';
                                                    $displayText = 'Approved';
                                                    break;
                                                case \App\Models\Boat::STATUS_REJECTED:
                                                    $statusClass = 'status-rejected';
                                                    $displayText = 'Rejected';
                                                    break;
                                                case \App\Models\Boat::STATUS_PENDING:
                                                    $statusClass = 'status-pending';
                                                    $displayText = 'Pending';
                                                    break;
                                                case \App\Models\Boat::STATUS_OPEN:
                                                    $statusClass = 'status-open';
                                                    $displayText = 'Open';
                                                    break;
                                                case \App\Models\Boat::STATUS_ASSIGNED:
                                                    $statusClass = 'status-assigned';
                                                    $displayText = 'Assigned';
                                                    break;
                                                case \App\Models\Boat::STATUS_CLOSED:
                                                    $statusClass = 'status-closed';
                                                    $displayText = 'Not Available';
                                                    break;
                                                case \App\Models\Boat::STATUS_REHAB:
                                                    $statusClass = 'status-rehab';
                                                    $displayText = 'Rehab';
                                                    break;
                                                default:
                                                    $statusClass = 'status-unknown';
                                                    $displayText = 'N/A';
                                                    break;
                                            }
                                        @endphp
                                        <span class="boat-status {{ $statusClass }}">{{ $displayText }}</span>
                                    </div>
                                </div>
                                
                                <div class="boat-content">
                                    <div class="boat-header">
                                        <h6 class="boat-name">{{ $boat->boat_name }}</h6>
                                        <span class="boat-number">Boat No.: #{{ $loop->iteration }}</span>
                                    </div>
                                    
                                    <div class="boat-details">
                                       
                                        <div class="detail-item">
                                            <i class="fas fa-peso-sign detail-icon"></i>
                                            <span class="detail-label">Price:</span>
                                            <span class="detail-value">₱{{ number_format($boat->boat_prices, 2) }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-users detail-icon"></i>
                                            <span class="detail-label">Capacity:</span>
                                            <span class="detail-value">{{ $boat->boat_capacities }} pax</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-ruler detail-icon"></i>
                                            <span class="detail-label">Length:</span>
                                            <span class="detail-value">{{ $boat->boat_length ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fas fa-user-tie detail-icon"></i>
                                            <span class="detail-label">Captain:</span>
                                            <span class="detail-value">
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
                                            </span>
                                        </div>
                                        @if($boat->captain_contact)
                                            <div class="detail-item">
                                                <i class="fas fa-phone detail-icon"></i>
                                                <span class="detail-label">Contact:</span>
                                                <span class="detail-value">{{ $boat->captain_contact }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if (($boat->status ?? '') === \App\Models\Boat::STATUS_REJECTED && $boat->rejection_reason)
                                        <div class="rejection-reason">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <strong>Reason:</strong> {{ $boat->rejection_reason }}
                                        </div>
                                    @elseif (($boat->status ?? '') === \App\Models\Boat::STATUS_REHAB && $boat->rejection_reason)
                                        <div class="rejection-reason">
                                            <i class="fas fa-tools me-1"></i>
                                            <strong>Rehab Reason:</strong> {{ $boat->rejection_reason }}
                                        </div>
                                    @endif
                                    
                                    <div class="boat-actions">
                                        <a href="{{ route('boat.edit', $boat->id) }}" class="btn btn-primary btn-sm action-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Boat">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm action-btn archive-btn"
                                                data-boat-id="{{ $boat->id }}"
                                                data-boat-name="{{ $boat->boat_name }}"
                                                data-bs-placement="top" 
                                                title="Archive Boat">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-ship"></i>
                        </div>
                        <h5 class="empty-title">No Boats Added Yet</h5>
                        <p class="empty-text">Start building your boat fleet by adding your first boat.</p>
                        <a href="{{ route('boat.owner.add') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add Your First Boat
                        </a>
                    </div>
                @endif
            </div>

            {{-- Legacy Table View (Hidden by default, can be toggled) --}}
            <div class="table-view-toggle mb-3" style="display: none;">
                <button class="btn btn-outline-secondary btn-sm" onclick="toggleTableView()">
                    <i class="fas fa-table me-1"></i>
                    Toggle Table View
                </button>
            </div>

            <div class="table-responsive table-view" style="display: none;">
                <table class="table table-hover table-striped modern-table">
                    <thead class="table-header">
                        <tr>
                            <th scope="col">
                                <i class="fas fa-hashtag me-1"></i>
                                #
                            </th>
                            <th scope="col">
                                <i class="fas fa-image me-1"></i>
                                Image
                            </th>
                            <th scope="col">
                                <i class="fas fa-ship me-1"></i>
                                Boat Name
                            </th>
                            <th scope="col">
                                <i class="fas fa-tag me-1"></i>
                                Plate Number
                            </th>
                            <th scope="col">
                                <i class="fas fa-dollar-sign me-1"></i>
                                Price
                            </th>
                            <th scope="col">
                                <i class="fas fa-users me-1"></i>
                                Capacity
                            </th>
                            <th scope="col">
                                <i class="fas fa-ruler me-1"></i>
                                Length
                            </th>
                            <th scope="col">
                                <i class="fas fa-user-tie me-1"></i>
                                Captain
                            </th>
                            <th scope="col">
                                <i class="fas fa-phone me-1"></i>
                                Contact
                            </th>
                            <th scope="col">
                                <i class="fas fa-info-circle me-1"></i>
                                Status
                            </th>
                            <th scope="col">
                                <i class="fas fa-cogs me-1"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($boats as $boat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($boat->image_path)
                                        <img src="{{ asset($boat->image_path) }}"
                                             alt="{{ $boat->boat_name }}"
                                             class="table-boat-image"
                                             onerror="handleImageError(this, '{{ asset('images/boat.png') }}')">
                                    @else
                                        <img src="{{ asset('images/boat.png') }}"
                                             alt="Default Boat Image"
                                             class="table-boat-image">
                                    @endif
                                </td>
                                <td>{{ $boat->boat_name }}</td>
                                <td>-</td>
                                <td>₱{{ number_format($boat->boat_prices, 2) }}</td>
                                <td>{{ $boat->boat_capacities }} pax</td>
                                <td>{{ $boat->boat_length ?? 'N/A' }}</td>
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
                                                $statusClass = 'badge-light-secondary';
                                                $displayText = 'Not Available';
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
                                        <a href="{{ route('boat.edit', $boat->id) }}" class="btn btn-primary btn-sm action-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm action-btn archive-btn"
                                                data-boat-id="{{ $boat->id }}"
                                                data-boat-name="{{ $boat->boat_name }}"
                                                data-bs-placement="top" 
                                                title="Archive">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-ship empty-icon"></i>
                                        <h6 class="empty-title">No Boats Found</h6>
                                        <p class="empty-text">No boats added yet. Click "Add Boat" to get started!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
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
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            margin: 0;
            line-height: 1.2;
        }

        .sidebar-nav {
            padding: 1rem 0;
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
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-badge {
            background: #e74c3c;
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: auto;
            font-weight: 600;
        }

        .notification-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }


        /* Mobile Sidebar */
            .modern-mobile-sidebar {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                backdrop-filter: blur(20px);
                border-right: 1px solid rgba(255, 255, 255, 0.1);
                width: 90vw !important;
                max-width: 350px;
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
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
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
        }

        .mobile-brand-subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
            margin: 0;
        }

        .mobile-sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0.25rem 1rem;
        }

        .mobile-sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
        }


        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
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
        }

        /* Hamburger Button Styles */
        .hamburger-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1050;
            display: none;
        }

        .hamburger-btn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .hamburger-btn:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
            color: white;
        }

        .hamburger-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

        @media (max-width: 768px) {
            .hamburger-btn {
                width: 36px;
                height: 36px;
                padding: 6px 10px;
            }
        }

        @media (max-width: 576px) {
            .hamburger-btn {
                width: 32px;
                height: 32px;
                padding: 4px 8px;
            }
        }

        @media (max-width: 480px) {
            .hamburger-btn {
                width: 30px;
                height: 30px;
                padding: 3px 6px;
            }
            
            .modern-navbar {
                left: 0;
                width: 100%;
            }
        }

        /* Modern Boat Management Styling */
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .page-title-section {
            flex: 1;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0.5rem 0 0 0;
        }

        .page-actions {
            display: flex;
            align-items: center;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
        }

        .modern-btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: none;
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .archive-btn-header {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #495057 !important;
            border: 2px solid rgba(255, 255, 255, 0.3) !important;
            font-weight: 600;
        }

        .archive-btn-header:hover {
            background: white !important;
            color: #2c3e50 !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        /* Boats Section */
        .boats-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section-header {
            background: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            color: #495057;
            font-weight: 600;
            margin: 0;
            font-size: 1.25rem;
        }

        .boats-count {
            display: flex;
            align-items: center;
        }

        .count-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        /* Boats Grid */
        .boats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        /* Boat Card */
        .boat-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .boat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .boat-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .boat-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .boat-card:hover .boat-image {
            transform: scale(1.05);
        }

        .boat-status-overlay {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .boat-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .status-approved {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-rejected {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, #17a2b8, #6f42c1);
            color: white;
        }

        .status-open {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-assigned {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .status-closed {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .status-rehab {
            background: linear-gradient(135deg, #fd7e14, #dc3545);
            color: white;
        }

        .status-unknown {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .boat-content {
            padding: 1.5rem;
        }

        .boat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f3f4;
        }

        .boat-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .boat-number {
            background: #e9ecef;
            color: #6c757d;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .boat-details {
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
        }

        .detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-icon {
            width: 20px;
            color: #667eea;
            margin-right: 0.75rem;
            text-align: center;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            margin-right: 0.5rem;
            min-width: 80px;
        }

        .detail-value {
            color: #6c757d;
            font-weight: 500;
        }

        .rejection-reason {
            background: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid #dc3545;
            font-size: 0.9rem;
        }

        .boat-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid #f1f3f4;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .action-btn i {
            font-size: 14px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            color: #667eea;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .empty-text {
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        /* Modern Table */
        .modern-table {
            margin: 0;
            border: none;
        }

        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table-header th {
            font-weight: 600;
            padding: 1rem 0.75rem;
            border: none;
            color: white;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-boat-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Modern Alert */
        .modern-alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
                text-align: center;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .page-actions {
                margin-top: 1rem;
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .modern-btn {
                width: 100%;
            }

            .boats-grid {
                grid-template-columns: 1fr;
                padding: 1rem;
                gap: 1rem;
            }

            .boat-card {
                margin-bottom: 1rem;
            }

            .boat-image-container {
                height: 150px;
            }

            .boat-content {
                padding: 1rem;
            }

            .boat-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .boat-actions {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .page-subtitle {
                font-size: 0.9rem;
            }

            .boats-grid {
                padding: 0.75rem;
            }

            .boat-content {
                padding: 0.75rem;
            }

            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .detail-label {
                min-width: auto;
                margin-right: 0;
            }
        }

        /* Responsive Design */

        @media (max-width: 576px) {
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
            
            .main-content {
                padding: 0.75rem;
            }
        }

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

        /* SweetAlert2 Responsive Styles */
        .swal2-popup-responsive {
            font-size: 14px !important;
            max-width: 90% !important;
            width: 400px !important;
        }

        .swal2-title-responsive {
            font-size: 18px !important;
            line-height: 1.4 !important;
        }

        .swal2-content-responsive {
            font-size: 14px !important;
            line-height: 1.5 !important;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .swal2-popup-responsive {
                font-size: 12px !important;
                max-width: 95% !important;
                width: 350px !important;
                margin: 10px !important;
            }

            .swal2-title-responsive {
                font-size: 16px !important;
            }

            .swal2-content-responsive {
                font-size: 12px !important;
            }
        }

        @media (max-width: 480px) {
            .swal2-popup-responsive {
                font-size: 11px !important;
                max-width: 98% !important;
                width: 320px !important;
                margin: 5px !important;
            }

            .swal2-title-responsive {
                font-size: 14px !important;
            }

            .swal2-content-responsive {
                font-size: 11px !important;
            }
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

            // Handle archive buttons with SweetAlert2
            document.querySelectorAll('.archive-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const boatId = this.getAttribute('data-boat-id');
                    const boatName = this.getAttribute('data-boat-name');
                    
                    Swal.fire({
                        title: "Archive Boat",
                        html: `Are you sure you want to archive <strong>${boatName}</strong>? You can restore it later from the Archive page.`,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#f0ad4e",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Yes, archive it!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive',
                            confirmButton: 'swal2-confirm-responsive',
                            cancelButton: 'swal2-cancel-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Archiving...',
                                text: 'Please wait while we archive the boat.',
                                icon: 'info',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                customClass: {
                                    popup: 'swal2-popup-responsive',
                                    title: 'swal2-title-responsive',
                                    content: 'swal2-content-responsive'
                                }
                            });
                            
                            // Create form data for archive (DELETE route repurposed to archive)
                            const formData = new FormData();
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('_method', 'DELETE');
                            
                            // Send request
                            fetch(`/boats/${boatId}`, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    // Remove the boat row from the table immediately
                                    const boatRow = this.closest('tr');
                                    if (boatRow) {
                                        boatRow.remove();
                                    }
                                    
                                    // Show success message
                                    Swal.fire({
                                        title: "Archived!",
                                        text: "The boat has been archived.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive',
                                            confirmButton: 'swal2-confirm-responsive'
                                        }
                                    });
                                } else {
                                    throw new Error('Archive failed');
                                }
                            })
                            .catch(error => {
                                console.error('Error archiving boat:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to archive boat. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive',
                                        confirmButton: 'swal2-confirm-responsive'
                                    }
                                });
                            });
                        }
                    });
                });
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
            
            // Check for success message and show SweetAlert2 popup
            @if (session('success'))
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "You have successfully added the boats, wait for admin approval.",
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'swal2-popup-responsive',
                        title: 'swal2-title-responsive',
                        content: 'swal2-content-responsive'
                    }
                });
            @endif
        });

        // Toggle between card and table view
        function toggleTableView() {
            const boatsSection = document.querySelector('.boats-section');
            const tableView = document.querySelector('.table-view');
            const toggleBtn = document.querySelector('.table-view-toggle button');
            
            if (boatsSection.style.display === 'none') {
                boatsSection.style.display = 'block';
                tableView.style.display = 'none';
                toggleBtn.innerHTML = '<i class="fas fa-table me-1"></i> Toggle Table View';
            } else {
                boatsSection.style.display = 'none';
                tableView.style.display = 'block';
                toggleBtn.innerHTML = '<i class="fas fa-th-large me-1"></i> Toggle Card View';
            }
        }
    </script>
            </div>
        </div>
    </div>

</x-app-layout>
