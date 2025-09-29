<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">

        {{-- Include Shared Sidebar --}}
        @include('boat_owner.partials.sidebar')

        {{-- Main Content Area --}}
        <div class="main-content flex-grow-1 p-4">
            {{-- Page Header --}}
            <div class="page-header mb-4">
                <div class="page-title-section">
                    <h1 class="page-title">
                        <i class="fas fa-edit me-2"></i>
                        Edit Boat: {{ $boat->boat_name }}
                    </h1>
                    <p class="page-subtitle">Update your boat information and manage status</p>
                </div>
                <div class="page-actions">
                @php
                    $totalBoats = isset($allBoats) ? $allBoats->count() : (isset($boats) ? $boats->count() : null);
                    $position = null;
                    if(isset($allBoats)){
                        $position = $allBoats->pluck('id')->search($boat->id);
                        $position = $position === false ? null : ($position + 1);
                    } elseif(isset($boats)) {
                        $position = $boats->pluck('id')->search($boat->id);
                        $position = $position === false ? null : ($position + 1);
                    }
                @endphp
                @if($position && $totalBoats)
                        <div class="assignment-badge">
                            <i class="fas fa-hashtag me-1"></i>
                            Assignment #{{ $position }} of {{ $totalBoats }}
                        </div>
                @endif
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Boat Information Form --}}
            <div class="form-section">
                <div class="section-header">
                    <h5 class="section-title">
                        <i class="fas fa-ship me-2"></i>
                        Boat Information
                    </h5>
                </div>
                <div class="modern-card">
                <form action="{{ route('boat.update', $boat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Use PUT method for updates --}}

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="boat_name" class="form-label">
                                    <i class="fas fa-ship me-1"></i>
                                    Boat Name
                                </label>
                                <input type="text" class="form-control modern-input" id="boat_name" name="boat_name" value="{{ old('boat_name', $boat->boat_name) }}" required>
                        @error('boat_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                            </div>
                    </div>

                        

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="boat_prices" class="form-label">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    Price
                                </label>
                                <input type="number" class="form-control modern-input" id="boat_prices" name="boat_prices" value="{{ old('boat_prices', $boat->boat_prices) }}" step="0.01" required>
                        @error('boat_prices')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                            </div>
                    </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="boat_capacities" class="form-label">
                                    <i class="fas fa-users me-1"></i>
                                    Capacity (pax)
                                </label>
                                <input type="number" class="form-control modern-input" id="boat_capacities" name="boat_capacities" value="{{ old('boat_capacities', $boat->boat_capacities) }}" required>
                        @error('boat_capacities')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                            </div>
                    </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="boat_length" class="form-label">
                                    <i class="fas fa-ruler me-1"></i>
                                    Boat Length
                                </label>
                                <input type="text" class="form-control modern-input" id="boat_length" name="boat_length" value="{{ old('boat_length', $boat->boat_length ?? '') }}" placeholder="e.g., 24 ft or 7.3 m">
                        @error('boat_length')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Boat Captain fields --}}
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="captain_name" class="form-label">
                                    <i class="fas fa-user-tie me-1"></i>
                                    Boat Captain Name
                                </label>
                                <input type="text" class="form-control modern-input" id="captain_name" name="captain_name" value="{{ old('captain_name', $boat->captain_name ?? '') }}" placeholder="Enter captain full name">
                        @error('captain_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="captain_contact" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Boat Captain Contact
                                </label>
                        <input type="text" 
                                       class="form-control modern-input" 
                               id="captain_contact" 
                               name="captain_contact" 
                               value="{{ old('captain_contact', $boat->captain_contact ?? '') }}" 
                               placeholder="e.g., 09123456789"
                               pattern="[0-9]{11}" 
                               maxlength="11" 
                               minlength="11"
                               title="Please enter exactly 11 digits for the captain contact number." 
                               inputmode="numeric"
                               oninput="validateCaptainContact(this)">
                        <div id="captain_contact_error" class="text-danger mt-1" style="display: none;">
                            Invalid Contact Number. It must be exactly 11 digits.
                        </div>
                        @error('captain_contact')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Image Upload Section --}}
                    <div class="form-group">
                        <label for="image_path" class="form-label">
                            <i class="fas fa-image me-1"></i>
                            Boat Image
                        </label>
                        <input type="file" class="form-control modern-input" id="image_path" name="image_path" accept="image/*">
                        @error('image_path')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        <div class="image-preview mt-3">
                        @if ($boat->image_path)
                                <div class="current-image">
                                    <p class="mb-2"><strong>Current Image:</strong></p>
                                    <img src="{{ asset($boat->image_path) }}" alt="{{ $boat->boat_name }}" class="preview-image">
                            </div>
                        @else
                                <div class="default-image">
                                    <p class="mb-2"><strong>No image uploaded yet. Using default image.</strong></p>
                                    <img src="{{ asset('images/default_boat.png') }}" alt="Default Boat Image" class="preview-image">
                            </div>
                        @endif
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary modern-btn">
                            <i class="fas fa-save me-2"></i>
                            Update Boat
                        </button>
                    </div>
                </form>

                </div>

                {{-- Boat Status Management Section --}}
                <div class="form-section mt-4">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="fas fa-cogs me-2"></i>
                            Boat Status Management
                        </h5>
                    </div>
                    <div class="modern-card">
                        <div class="status-info">
                            <div class="current-status">
                                <span class="status-label">Current Status:</span>
                    @php
                        $statusClass = '';
                        switch ($boat->status) {
                            case \App\Models\Boat::STATUS_OPEN:
                            case \App\Models\Boat::STATUS_APPROVED:
                                            $statusClass = 'status-approved';
                                break;
                            case \App\Models\Boat::STATUS_ASSIGNED:
                                            $statusClass = 'status-assigned';
                                break;
                            case \App\Models\Boat::STATUS_CLOSED:
                            case \App\Models\Boat::STATUS_REJECTED:
                                            $statusClass = 'status-rejected';
                                break;
                            case \App\Models\Boat::STATUS_REHAB:
                                            $statusClass = 'status-rehab';
                                break;
                            case \App\Models\Boat::STATUS_PENDING:
                            default:
                                            $statusClass = 'status-pending';
                                break;
                        }
                    @endphp
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($boat->status ?? 'N/A') }}</span>
                            </div>
                            
                    @if ($boat->status === \App\Models\Boat::STATUS_REHAB && $boat->rejection_reason)
                                <div class="status-reason">
                                    <i class="fas fa-tools me-1"></i>
                                    <strong>Maintenance Reason:</strong> {{ $boat->rejection_reason }}
                                </div>
                    @elseif ($boat->status === \App\Models\Boat::STATUS_REJECTED && $boat->rejection_reason)
                                <div class="status-reason">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <strong>Rejection Reason:</strong> {{ $boat->rejection_reason }}
                                </div>
                    @elseif ($boat->status === \App\Models\Boat::STATUS_ASSIGNED)
                                <div class="status-reason">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <strong>Note:</strong> Currently assigned to a booking - status will automatically change to "Open" when booking period ends
                                </div>
                    @endif
                        </div>

                        <div class="status-actions">
                            <div class="action-buttons">
                    {{-- Open Button --}}
                                <form id="status-open-form" action="{{ route('boat.owner.update_status', $boat->id) }}" method="POST" class="status-form d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ \App\Models\Boat::STATUS_OPEN }}">
                                    <button type="submit" class="btn btn-success modern-btn status-btn" {{ ($boat->status === \App\Models\Boat::STATUS_OPEN || $boat->status === \App\Models\Boat::STATUS_APPROVED || $boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED || $boat->status === \App\Models\Boat::STATUS_ASSIGNED) ? 'disabled' : '' }}>
                                        <i class="fas fa-play me-1"></i>
                                        Open
                                    </button>
                    </form>

                                {{-- Maintenance Button --}}
                                <button type="button" class="btn btn-warning modern-btn status-btn" id="rehab-button"
                            {{ ($boat->status === \App\Models\Boat::STATUS_REHAB || $boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED || $boat->status === \App\Models\Boat::STATUS_ASSIGNED) ? 'disabled' : '' }}
                            data-current-status="{{ $boat->status ?? '' }}">
                                    <i class="fas fa-tools me-1"></i>
                        Maintenance
                    </button>

                                {{-- Close Button --}}
                                <button type="button" class="btn btn-danger modern-btn status-btn"
                            {{ ($boat->status === \App\Models\Boat::STATUS_CLOSED || $boat->status === \App\Models\Boat::STATUS_PENDING || $boat->status === \App\Models\Boat::STATUS_REJECTED || $boat->status === \App\Models\Boat::STATUS_ASSIGNED) ? 'disabled' : '' }}
                            data-bs-toggle="modal" data-bs-target="#closeConfirmationModal">
                                    <i class="fas fa-stop me-1"></i>
                        Close
                    </button>
                            </div>
                </div>

                        {{-- Maintenance Reason Form --}}
                <form id="status-rehab-form" action="{{ route('boat.owner.update_status', $boat->id) }}" method="POST"
                      class="{{ ($boat->status === \App\Models\Boat::STATUS_REHAB) ? 'd-block' : 'd-none' }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ \App\Models\Boat::STATUS_REHAB }}">
                            <div class="maintenance-reason-section">
                                <h6 class="reason-title">
                                    <i class="fas fa-edit me-2"></i>
                                    Maintenance Reason
                                </h6>
                                <div class="form-group">
                                    <label for="rehab_reason" class="form-label">Please provide a reason for maintenance:</label>
                                    <textarea class="form-control modern-input" id="rehab_reason" name="rehab_reason" rows="3" placeholder="Enter the reason for putting this boat under maintenance...">{{ old('rehab_reason', $boat->rejection_reason) }}</textarea>
                                    @error('rehab_reason')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        This reason will be displayed on the public page when the boat is under maintenance.
                                    </small>
                                </div>
                                <div class="reason-actions">
                                    <button type="submit" class="btn btn-warning modern-btn">
                                        <i class="fas fa-save me-2"></i>
                                        Update Maintenance Status & Reason
                                    </button>
                                </div>
                    </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Close Confirmation Modal (for owner to close boat) --}}
    <div class="modal fade" id="closeConfirmationModal" tabindex="-1" aria-labelledby="closeConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="closeConfirmationModalLabel">Confirm Close Boat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this boat as **Closed**? This will make it unavailable for bookings.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <form id="closeStatusForm" method="POST" action="{{ route('boat.owner.update_status', $boat->id) }}" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ \App\Models\Boat::STATUS_CLOSED }}">
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill">Confirm Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Maintenance Confirmation Modal (for owner to put boat in maintenance) --}}
    <div class="modal fade" id="rehabConfirmationModal" tabindex="-1" aria-labelledby="rehabConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rehabConfirmationModalLabel">Confirm Maintenance Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this boat as **Under Maintenance**? You will need to provide a reason for the maintenance.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning btn-sm rounded-pill" id="confirmRehabAndShowReason">Confirm Maintenance</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Modern Sidebar Styles */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: #2c3e50;
            border-right: 1px solid #34495e;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #34495e;
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

        /* Main Content */
        .main-content {
            background: transparent;
            min-height: 100vh;
            margin-left: 280px;
            overflow-y: auto;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .page-subtitle {
            color: #6c757d;
            margin: 0.5rem 0 0 0;
            font-size: 1.1rem;
        }

        .page-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .assignment-badge {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 2rem;
        }

        .section-header {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            display: flex;
            align-items: center;
        }

        /* Modern Cards */
        .modern-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .modern-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .modern-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background: white;
        }

        /* Image Preview */
        .image-preview {
            text-align: center;
        }

        .preview-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 3px solid #fff;
        }

        /* Form Actions */
        .form-actions {
            margin-top: 2rem;
            text-align: center;
        }

        .modern-btn {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Status Management */
        .status-info {
            margin-bottom: 2rem;
        }

        .current-status {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .status-label {
            font-weight: 600;
            color: #495057;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-approved {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-assigned {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .status-rejected {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-rehab {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-pending {
            background: linear-gradient(135deg, #e2e3e5, #d3d6da);
            color: #383d41;
            border: 1px solid #d3d6da;
        }

        .status-reason {
            background: rgba(0, 123, 255, 0.1);
            border: 1px solid rgba(0, 123, 255, 0.2);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
            color: #0c5460;
        }

        /* Status Actions */
        .status-actions {
            margin-top: 2rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .status-btn {
            min-width: 140px;
        }

        /* Maintenance Reason Section */
        .maintenance-reason-section {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .reason-title {
            color: #856404;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .reason-actions {
            margin-top: 1rem;
            text-align: center;
        }

        /* Modern Alerts */
        .modern-alert {
            border: none;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-sidebar {
                display: none !important;
            }
            
            .main-content {
                padding: 1rem;
                margin-left: 0;
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
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .page-actions {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .action-buttons {
                flex-direction: column;
                width: 100%;
            }

            .status-btn {
                width: 100%;
            }

            .modern-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
            
            .main-content {
                padding: 0.75rem;
            }

            .page-header {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.3rem;
            }

            .modern-card {
                padding: 1rem;
            }

            .preview-image {
                width: 150px;
                height: 150px;
            }
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

        /* Styles for the collapse icon rotation */
        .collapse-icon {
            transition: transform 0.3s ease-in-out;
            min-width: 1em; /* Ensure arrow takes up space */
            display: flex; /* Use flexbox for image alignment if needed */
            align-items: center; /* Center vertically if using an image */
            justify-content: center; /* Center horizontally if using an image */
        }

        .collapse-icon.rotated {
            transform: rotate(180deg);
        }

        /* Styles for active parent link */
        .nav-link.active-parent {
            background-color: #6c757d !important; /* A slightly darker gray for active parent */
        }

        /* Custom Light Background Badges (consistent with explore/showex.blade.php) */
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
            background-color: #f8f9fa !important;
            color: #212529 !important;
            border: 1px solid #dee2e6 !important;
        }
    </style>

    <script>
        // Function to validate captain contact input
        function validateCaptainContact(input) {
            const value = input.value;
            const errorDiv = document.getElementById('captain_contact_error');
            
            // Remove any non-digit characters
            const digitsOnly = value.replace(/\D/g, '');
            
            // Update the input value to only contain digits
            if (value !== digitsOnly) {
                input.value = digitsOnly;
            }
            
            // Check if the length is exactly 11 digits
            if (digitsOnly.length > 0 && digitsOnly.length !== 11) {
                errorDiv.style.display = 'block';
                input.classList.add('is-invalid');
            } else {
                errorDiv.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

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

            // Global function for image error handling (also used in other views)
            window.handleImageError = function(imgElement, defaultImagePath) {
                imgElement.onerror = null; // Prevent infinite looping if default image also fails
                imgElement.src = defaultImagePath;
            };

            const rehabButton = document.getElementById('rehab-button');
            const rehabReasonContainer = document.getElementById('status-rehab-form');
            const rehabReasonInput = document.getElementById('rehab_reason');
            const confirmRehabAndShowReasonButton = document.getElementById('confirmRehabAndShowReason');

            // Function to show/hide maintenance reason container
            function toggleRehabReasonVisibility(forceShow = false) {
                const currentStatusBadge = document.querySelector('p.text-muted .badge');
                // Check for null before accessing textContent
                const isCurrentlyMaintenance = currentStatusBadge && currentStatusBadge.textContent.trim().toLowerCase() === 'maintenance';

                if (forceShow || isCurrentlyMaintenance) {
                    rehabReasonContainer.style.display = 'block';
                    rehabReasonInput.setAttribute('required', 'required');
                    if (forceShow && !rehabReasonInput.value) { // Focus if forced show and input is empty
                        rehabReasonInput.focus();
                    }
                } else {
                    rehabReasonContainer.style.display = 'none';
                    rehabReasonInput.removeAttribute('required');
                    // Only clear the reason if it's not currently being edited for maintenance status
                    // And only if the status actually changed away from maintenance.
                    if (!isCurrentlyMaintenance) {
                        rehabReasonInput.value = '';
                    }
                }
            }

            // Event listener for the Maintenance button click
            if (rehabButton) {
                rehabButton.addEventListener('click', function(event) {
                    const currentStatusBadge = document.querySelector('p.text-muted .badge');
                    const isCurrentlyMaintenance = currentStatusBadge && currentStatusBadge.textContent.trim().toLowerCase() === 'maintenance';

                    if (isCurrentlyMaintenance) {
                        // If already in maintenance, just toggle visibility of reason input directly
                        rehabReasonContainer.style.display = (rehabReasonContainer.style.display === 'none' || rehabReasonContainer.style.display === '') ? 'block' : 'none';
                        rehabReasonInput.setAttribute('required', 'required');
                        if (rehabReasonContainer.style.display === 'block') {
                            rehabReasonInput.focus();
                        } else {
                            rehabReasonInput.removeAttribute('required');
                        }
                    } else {
                        // If not in maintenance, show the confirmation modal
                        var rehabModal = new bootstrap.Modal(document.getElementById('rehabConfirmationModal'));
                        rehabModal.show();
                    }
                });
            }

            // Event listener for "Confirm Rehab" button inside the Rehab modal
            if (confirmRehabAndShowReasonButton) {
                confirmRehabAndShowReasonButton.addEventListener('click', function() {
                    var rehabModal = bootstrap.Modal.getInstance(document.getElementById('rehabConfirmationModal'));
                    if (rehabModal) {
                        rehabModal.hide(); // Hide the modal
                    }
                    toggleRehabReasonVisibility(true); // Force show rehab reason input
                });
            }

            // Add click listener to 'Open' and 'Close' forms to hide rehab reason container if visible
            // And to potentially clear the reason if status is no longer rehab.
            const statusForms = document.querySelectorAll('.status-form'); // Get all status forms
            statusForms.forEach(form => {
                form.addEventListener('submit', function() {
                    const statusInput = this.querySelector('input[name="status"]');
                    if (statusInput && statusInput.value !== '{{ \App\Models\Boat::STATUS_REHAB }}') {
                        // If changing to 'open' or 'closed', hide and clear rehab reason input
                        toggleRehabReasonVisibility(false);
                    }
                });
            });

            // Initialize visibility on page load based on current boat status
            toggleRehabReasonVisibility();

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