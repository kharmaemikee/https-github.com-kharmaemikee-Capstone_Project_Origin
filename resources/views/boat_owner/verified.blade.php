<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('boat_owner.partials.sidebar')

        <div class="main-content flex-grow-1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">
                                    <i class="fas fa-user-check me-2"></i>
                                    Account Management - Permit Submission
                                </h4>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        @if(auth()->user()->is_approved)
                                            <div class="alert alert-success mb-3">
                                                <h6 class="mb-0">🎉 Congratulations! Your account has been fully approved.</h6>
                                            </div>
                                        @elseif(auth()->user()->bir_permit_path || auth()->user()->dti_permit_path || auth()->user()->business_permit_path || auth()->user()->lgu_resolution_path || auth()->user()->marina_cpc_path || auth()->user()->boat_association_path)
                                            <div class="alert alert-warning mb-3">
                                                <h6 class="mb-0">⏳ Your permits are under review.</h6>
                                                <small class="mb-0">Please wait for admin approval. You'll be able to access Boat Information once all permits are approved.</small>
                                            </div>
                                        @elseif(!auth()->user()->bir_permit_path && !auth()->user()->dti_permit_path && !auth()->user()->business_permit_path && !auth()->user()->lgu_resolution_path && !auth()->user()->marina_cpc_path && !auth()->user()->boat_association_path)
                                            <div class="alert alert-info mb-3">
                                                <h6 class="mb-0">👋 Welcome! You can explore your dashboard and access basic features.</h6>
                                                <small class="mb-0">To unlock Boat Information, please upload your permits (BIR, DTI, Business Permit, LGU Resolution, Marina CPC, and Boat Association Membership).</small>
                                            </div>
                                        @endif
                                        <h5 class="text-primary mb-3">Current Status</h5>
                                        <div class="status-cards">
                                            <div class="card mb-3 {{ auth()->user()->bir_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">BIR Permit</span>
                                                        @if(auth()->user()->bir_approved)
                                                            <span class="badge badge-light-success">✓ Approved</span>
                                                        @elseif(auth()->user()->bir_permit_path)
                                                            @if(auth()->user()->bir_resubmitted)
                                                                <span class="badge badge-light-warning">Please resubmit your permit</span>
                                                            @else
                                                                <span class="badge badge-light-warning">Pending Review</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-light-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->dti_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">DTI Permit</span>
                                                        @if(auth()->user()->dti_approved)
                                                            <span class="badge badge-light-success">✓ Approved</span>
                                                        @elseif(auth()->user()->dti_permit_path)
                                                            @if(auth()->user()->dti_resubmitted)
                                                                <span class="badge badge-light-warning">Please resubmit your permit</span>
                                                            @else
                                                                <span class="badge badge-light-warning">Pending Review</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-light-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->business_permit_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Business Permit</span>
                                                        @if(auth()->user()->business_permit_approved)
                                                            <span class="badge badge-light-success">✓ Approved</span>
                                                        @elseif(auth()->user()->business_permit_path)
                                                            @if(auth()->user()->business_permit_resubmitted)
                                                                <span class="badge badge-light-warning">Please resubmit your permit</span>
                                                            @else
                                                                <span class="badge badge-light-warning">Pending Review</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-light-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card mb-3 {{ auth()->user()->lgu_resolution_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">LGU Resolution</span>
                                                        @if(auth()->user()->lgu_resolution_approved)
                                                            <span class="badge badge-light-success">✓ Approved</span>
                                                        @elseif(auth()->user()->lgu_resolution_path)
                                                            @if(auth()->user()->lgu_resolution_resubmitted)
                                                                <span class="badge badge-light-warning">Please resubmit your permit</span>
                                                            @else
                                                                <span class="badge badge-light-warning">Pending Review</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-light-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->marina_cpc_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Marina CPC</span>
                                                        @if(auth()->user()->marina_cpc_approved)
                                                            <span class="badge badge-light-success">✓ Approved</span>
                                                        @elseif(auth()->user()->marina_cpc_path)
                                                            @if(auth()->user()->marina_cpc_resubmitted)
                                                                <span class="badge badge-light-warning">Please resubmit your permit</span>
                                                            @else
                                                                <span class="badge badge-light-warning">Pending Review</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-light-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3 {{ auth()->user()->boat_association_approved ? 'border-success' : 'border-warning' }}">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">Boat Association</span>
                                                        @if(auth()->user()->boat_association_approved)
                                                            <span class="badge badge-light-success">✓ Approved</span>
                                                        @elseif(auth()->user()->boat_association_path)
                                                            @if(auth()->user()->boat_association_resubmitted)
                                                                <span class="badge badge-light-warning">Please resubmit your permit</span>
                                                            @else
                                                                <span class="badge badge-light-warning">Pending Review</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-light-secondary">Not Submitted</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3">Upload Permits</h5>
                                        <form action="{{ route('boat.owner.upload-permits') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="mb-3">
                                                <label for="bir_permit" class="form-label">BIR Permit <span class="text-danger"></span></label>
                                                <input type="file" class="form-control @error('bir_permit') is-invalid @enderror" 
                                                       id="bir_permit" name="bir_permit" accept=".pdf" 
                                                       {{ auth()->user()->bir_approved ? 'disabled' : '' }}>
                                                @error('bir_permit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload BIR permit (PDF only)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="dti_permit" class="form-label">DTI Permit <span class="text-danger"></span></label>
                                                <input type="file" class="form-control @error('dti_permit') is-invalid @enderror" 
                                                       id="dti_permit" name="dti_permit" accept=".pdf"
                                                       {{ auth()->user()->dti_approved ? 'disabled' : '' }}>
                                                @error('dti_permit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload DTI permit (PDF only)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="business_permit" class="form-label">Business Permit <span class="text-danger"></span></label>
                                                <input type="file" class="form-control @error('business_permit') is-invalid @enderror" 
                                                       id="business_permit" name="business_permit" accept=".pdf"
                                                       {{ auth()->user()->business_permit_approved ? 'disabled' : '' }}>
                                                @error('business_permit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload business permit (PDF only)</small>
                                            </div>


                                            <div class="mb-3">
                                                <label for="lgu_resolution" class="form-label">LGU Resolution <span class="text-danger"></span></label>
                                                <input type="file" class="form-control @error('lgu_resolution') is-invalid @enderror" 
                                                       id="lgu_resolution" name="lgu_resolution" accept=".pdf"
                                                       {{ auth()->user()->lgu_resolution_approved ? 'disabled' : '' }}>
                                                @error('lgu_resolution')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload LGU Resolution (PDF only)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="marina_cpc" class="form-label">Marina CPC <span class="text-danger"></span></label>
                                                <input type="file" class="form-control @error('marina_cpc') is-invalid @enderror" 
                                                       id="marina_cpc" name="marina_cpc" accept=".pdf"
                                                       {{ auth()->user()->marina_cpc_approved ? 'disabled' : '' }}>
                                                @error('marina_cpc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload Marina CPC (PDF only)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="boat_association" class="form-label">Boat/Owners Association Membership <span class="text-danger"></span></label>
                                                <input type="file" class="form-control @error('boat_association') is-invalid @enderror" 
                                                       id="boat_association" name="boat_association" accept=".pdf"
                                                       {{ auth()->user()->boat_association_approved ? 'disabled' : '' }}>
                                                @error('boat_association')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Upload Boat/Owners Association Membership (PDF only)</small>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100" 
                                                    {{ auth()->user()->is_approved ? 'disabled' : '' }}>
                                                <i class="fas fa-upload me-2"></i>
                                                {{ auth()->user()->is_approved ? 'All Permits Approved' : 'Upload Permits' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
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

        /* Main Content */
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
        }

        /* Style for the rotated icon */
        .collapse-icon img {
            transition: transform 0.3s ease;
        }

        .collapse-icon.rotated img {
            transform: rotate(180deg);
        }

        .status-cards .card {
            transition: all 0.3s ease;
        }

        .status-cards .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 0.6;
        }

        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .text-white-50 {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        /* Light Badge Styles */
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

        .badge-light-secondary {
            background-color: #e2e3e5 !important;
            color: #383d41 !important;
            border: 1px solid #d3d6da !important;
        }
    </style>

    {{-- SweetAlert2 for notifications --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- Custom JavaScript to handle arrow rotation and mobile sidebar behavior --}}
    <script>
        // Listen for real-time updates from admin panel
        window.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'permit_resubmitted') {
                const { documentType, reason } = event.data;
                
                // Update the status badge for the specific permit
                const permitCards = document.querySelectorAll('.status-cards .card');
                permitCards.forEach(card => {
                    const permitName = card.querySelector('.fw-bold').textContent.toLowerCase();
                    let permitType = '';
                    
                    // Map permit names to document types
                    if (permitName.includes('bir')) permitType = 'bir_permit';
                    else if (permitName.includes('dti')) permitType = 'dti_permit';
                    else if (permitName.includes('business')) permitType = 'business_permit';
                    else if (permitName.includes('lgu')) permitType = 'lgu_resolution';
                    else if (permitName.includes('marina')) permitType = 'marina_cpc';
                    else if (permitName.includes('boat') || permitName.includes('association')) permitType = 'boat_association';
                    
                    if (permitType === documentType) {
                        const badge = card.querySelector('.badge');
                        if (badge) {
                            badge.className = 'badge badge-light-warning';
                            badge.textContent = 'Please resubmit your permit';
                        }
                        
                        // Show a notification about the resubmit request
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Permit Resubmission Required',
                                text: `Your ${permitName} permit needs to be resubmitted. Reason: ${reason}`,
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });

        // Handle upload permits form submission
        // Helper function to determine which document type was uploaded
        function getDocumentTypeFromForm(form) {
            const inputs = form.querySelectorAll('input[type="file"]');
            for (let input of inputs) {
                if (input.files && input.files.length > 0) {
                    const name = input.name;
                    if (name === 'bir_permit') return 'bir_permit';
                    if (name === 'dti_permit') return 'dti_permit';
                    if (name === 'business_permit') return 'business_permit';
                    if (name === 'owner_image') return 'owner_image';
                    if (name === 'lgu_resolution') return 'lgu_resolution';
                    if (name === 'marina_cpc') return 'marina_cpc';
                    if (name === 'boat_association') return 'boat_association';
                }
            }
            return 'unknown';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const uploadForm = document.querySelector('form[action*="upload-permits"]');
            if (uploadForm) {
                uploadForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show SweetAlert2 popup
                    Swal.fire({
                        title: "You uploaded successfully!",
                        icon: "success",
                        draggable: true
                    }).then(() => {
                        // Submit the form after popup is closed
                        uploadForm.submit();
                        
                        // Notify admin panel that permit has been resubmitted
                        if (window.parent !== window) {
                            window.parent.postMessage({
                                type: 'permit_resubmitted_by_user',
                                userId: '{{ auth()->id() }}',
                                documentType: getDocumentTypeFromForm(uploadForm)
                            }, '*');
                        }
                    });
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

            collapseToggles.forEach(function(toggle) {
                // Initialize arrow state based on collapse 'show' class
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

                // Add click listener for arrow rotation
                toggle.addEventListener('click', function() {
                    var icon = this.querySelector('.collapse-icon');
                    if (icon) {
                        icon.classList.toggle('rotated');
                    }
                });
            });

            // --- JavaScript for Offcanvas Hiding on Desktop ---
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
            // --- End JavaScript for Offcanvas Hiding ---
        });
    </script>
</x-app-layout>