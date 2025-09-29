{{-- resources/views/bookings/show.blade.php --}}

<x-app-layout>
    <head>
        {{-- Font Awesome CDN for Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        {{-- Bootstrap Icons CDN --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        {{-- SweetAlert2 CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
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

            /* Custom CSS for sidebar nav-link hover and focus */
            .nav-link.text-white:hover,
            .nav-link.text-white:focus,
            .nav-link.text-white.active {
                background-color: rgb(6, 58, 170) !important;
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

            /* Mobile Sidebar */
            .modern-mobile-sidebar {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                backdrop-filter: blur(20px);
                border-right: 1px solid rgba(255, 255, 255, 0.1);
                width: 85vw !important;
            }

            /* Ensure proper offcanvas behavior */
            .offcanvas-backdrop {
                z-index: 1040;
            }

            .offcanvas.show {
                z-index: 1045;
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

            .mobile-sidebar-nav .nav-icon {
                width: 40px;
                height: 40px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.15);
            }

            .mobile-sidebar-nav .nav-icon-img {
                width: 20px;
                height: 20px;
                filter: brightness(0) invert(1);
            }

            .mobile-sidebar-nav .nav-text {
                font-weight: 500;
                font-size: 0.95rem;
            }

            .mobile-sidebar-nav .nav-badge {
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
                color: white;
                font-size: 0.75rem;
                font-weight: 600;
                padding: 0.25rem 0.5rem;
                border-radius: 12px;
                margin-left: auto;
                box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
            }

            /* Page Header */
            .page-header {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-radius: 25px;
                padding: 3rem 2rem;
                margin-bottom: 3rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
            }

            .header-content {
                display: flex;
                align-items: center;
                gap: 2rem;
                position: relative;
                z-index: 2;
            }

            .header-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 2.5rem;
                box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
            }

            .header-text {
                flex: 1;
            }

            .page-title {
                font-size: 3rem;
                font-weight: 700;
                background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin: 0 0 0.5rem 0;
            }

            .page-subtitle {
                font-size: 1.2rem;
                color: #6c757d;
                margin: 0;
                font-weight: 500;
            }

            .header-decoration {
                position: absolute;
                top: -50px;
                right: -50px;
                width: 200px;
                height: 200px;
                opacity: 0.1;
            }

            .decoration-circle {
                position: absolute;
                border-radius: 50%;
                background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            }

            .decoration-circle:nth-child(1) {
                width: 80px;
                height: 80px;
                top: 20px;
                right: 20px;
            }

            .decoration-circle:nth-child(2) {
                width: 60px;
                height: 60px;
                top: 60px;
                right: 60px;
            }

            .decoration-circle:nth-child(3) {
                width: 40px;
                height: 40px;
                top: 100px;
                right: 100px;
            }

            /* Alerts */
            .alerts-container {
                margin-bottom: 2rem;
            }

            .alert {
                border-radius: 12px;
                border: none;
                padding: 1rem 1.5rem;
                margin-bottom: 1rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .alert-success {
                background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
                color: #155724;
            }

            .alert-danger {
                background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
                color: #721c24;
            }

            /* Main Booking Card */
            .booking-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .booking-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            }

            .booking-header {
                background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                color: white;
                padding: 2rem;
                position: relative;
                overflow: hidden;
            }

            .booking-header::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200px;
                height: 200px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
            }

            .booking-title {
                font-size: 2rem;
                font-weight: 700;
                margin: 0;
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .booking-title i {
                font-size: 1.5rem;
            }

            .booking-content {
                padding: 2rem;
            }

            /* Information Sections */
            .info-section {
                margin-bottom: 2rem;
            }

            .section-title {
                font-size: 1.3rem;
                font-weight: 700;
                color: #2c3e50;
                margin: 0 0 1.5rem 0;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding-bottom: 0.75rem;
                border-bottom: 2px solid #e9ecef;
            }

            .section-title i {
                color: #007bff;
                font-size: 1.1rem;
            }

            .info-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }

            @media (max-width: 992px) {
                .info-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 768px) {
                .info-item {
                    padding: 1rem;
                    min-height: 70px;
                }
            }

            .info-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1.25rem;
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 12px;
                border-left: 4px solid #007bff;
                transition: all 0.3s ease;
                min-height: 80px;
            }

            .info-item:hover {
                transform: translateX(5px);
                box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
            }

            .info-item i {
                color: #007bff;
                font-size: 1.2rem;
                width: 20px;
                text-align: center;
            }

            .info-content {
                flex: 1;
                display: flex;              /* align label and value in a row */
                align-items: baseline;      /* align text baselines for neatness */
                gap: 0.5rem;                /* spacing between label and value */
            }

            .info-label {
                font-size: 0.8rem;
                color: #6c757d;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0 0 0.25rem 0;
                min-width: 140px;          /* fixed label width so values align */
            }

            .info-value {
                font-size: 1rem;
                color: #2c3e50;
                font-weight: 600;
                margin: 0;
            }

            /* Guest chips styling (to mirror resort owner guest list look) */
            .guest-chips {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .guest-chip {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                background: linear-gradient(135deg, #f1f3f5 0%, #e9ecef 100%);
                color: #212529;
                border: 1px solid rgba(0,0,0,0.08);
                padding: 0.35rem 0.75rem;
                border-radius: 999px;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            }

            .guest-chip i {
                color: #0d6efd;
                font-size: 0.9rem;
            }

            /* Cleaner styling for the Name row in Tourist Information */
            .name-label {
                text-transform: none;       /* normal case for cleaner look */
                letter-spacing: 0;          /* remove extra spacing */
                color: #495057;             /* slightly darker for readability */
                min-width: 80px;            /* reduce left space for Name row */
            }

            .name-value {
                font-size: 1.05rem;         /* slightly larger for emphasis */
                font-weight: 400;           /* normal weight for details */
                color: #212529;             /* strong readable color */
                word-break: break-word;     /* handle long names */
                white-space: normal;        /* allow wrapping */
            }

            .name-line {
                display: block;             /* each name on its own line */
            }

            .name-strong {
                font-weight: 700;           /* only the name is bold */
            }

            .name-meta {
                font-weight: 400;           /* age/nationality normal weight */
            }

            /* Status Badge */
            .status-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: capitalize;
                gap: 0.5rem;
            }

            .status-pending {
                background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
                color: #856404;
            }

            .status-approved {
                background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
                color: #155724;
            }

            .status-rejected {
                background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
                color: #721c24;
            }

            .status-cancelled {
                background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
                color: #721c24;
            }

            .status-completed {
                background: linear-gradient(135deg, #cce5ff 0%, #b3d9ff 100%);
                color: #004085;
            }

            /* Price Section */
            .price-section {
                background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
                border-radius: 12px;
                padding: 1.5rem;
                margin: 1.5rem 0;
                border-left: 4px solid #4caf50;
            }

            .price-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: #2c3e50;
                margin: 0 0 1rem 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .price-title i {
                color: #4caf50;
            }

            .price-breakdown {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .price-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 0;
            }

            .price-item.total {
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                margin-top: 0.5rem;
                padding-top: 1rem;
                font-weight: 700;
                font-size: 1.1rem;
            }

            .price-label {
                color: #6c757d;
                font-weight: 500;
            }

            .price-value {
                color: #2c3e50;
                font-weight: 600;
            }

            /* Special Requirements */
            .requirements-section {
                background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);
                border-radius: 12px;
                padding: 1.5rem;
                margin: 1.5rem 0;
                border-left: 4px solid #e91e63;
            }

            .requirements-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: #2c3e50;
                margin: 0 0 1rem 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .requirements-title i {
                color: #e91e63;
            }

            .requirements-list {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .requirement-badge {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                background: linear-gradient(135deg, #e91e63 0%, #f06292 100%);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            /* Boat Information */
            .boat-section {
                background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                border-radius: 12px;
                padding: 1.5rem;
                margin: 1.5rem 0;
                border-left: 4px solid #2196f3;
            }

            .boat-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: #2c3e50;
                margin: 0 0 1rem 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .boat-title i {
                color: #2196f3;
            }

            .boat-details {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            }

            .boat-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem;
                background: rgba(255, 255, 255, 0.7);
                border-radius: 8px;
            }

            .boat-item i {
                color: #2196f3;
                font-size: 0.9rem;
                width: 16px;
            }

            .boat-label {
                font-size: 0.8rem;
                color: #6c757d;
                font-weight: 500;
                min-width: 80px;
            }

            .boat-value {
                font-size: 0.9rem;
                color: #2c3e50;
                font-weight: 600;
            }

            /* Card Footer */
            .booking-footer {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                padding: 1.5rem 2rem;
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                display: flex;
                justify-content: flex-end;
                gap: 1rem;
            }

            .action-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                border-radius: 8px;
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 600;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
            }

            .cancel-btn {
                background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
                color: #212529;
            }

            .cancel-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
                color: #212529;
                text-decoration: none;
            }

            .delete-btn {
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                color: white;
            }

            .delete-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .main-content {
                    padding: 1rem;
                }

                .page-header {
                    padding: 2rem 1.5rem;
                    margin-bottom: 2rem;
                }

                .header-content {
                    flex-direction: column;
                    text-align: center;
                    gap: 1.5rem;
                }

                .page-title {
                    font-size: 2.5rem;
                }

                .page-subtitle {
                    font-size: 1rem;
                }

                .booking-content {
                    padding: 1.5rem;
                }

                .boat-details {
                    grid-template-columns: 1fr;
                }

                .booking-footer {
                    flex-direction: column;
                    align-items: stretch;
                }

                .action-btn {
                    justify-content: center;
                }
            }

            @media (max-width: 576px) {
                .main-content {
                    margin-left: 0;
                }
                
                .page-title {
                    font-size: 2rem;
                }

                .booking-content {
                    padding: 1rem;
                }

                .booking-footer {
                    padding: 1rem;
                }

                .action-btn {
                    padding: 0.6rem 1rem;
                    font-size: 0.8rem;
                }
            }

            /* Small mobile devices (≤475px) */
            @media (max-width: 475px) {
                .main-content {
                    padding: 0.75rem;
                    margin-left: 0;
                }

                .page-header {
                    padding: 1.5rem 1rem;
                    margin-bottom: 1.5rem;
                }

                .header-icon {
                    width: 60px;
                    height: 60px;
                    font-size: 2rem;
                }

                .page-title {
                    font-size: 1.8rem;
                }

                .page-subtitle {
                    font-size: 0.9rem;
                }

                .booking-content {
                    padding: 0.75rem;
                }

                .booking-header {
                    padding: 1.5rem 1rem;
                }

                .booking-title {
                    font-size: 1.5rem;
                }

                .section-title {
                    font-size: 1.1rem;
                }

                .info-item {
                    padding: 0.75rem;
                    gap: 0.75rem;
                }

                .info-item i {
                    font-size: 1rem;
                    width: 16px;
                }

                .info-label {
                    font-size: 0.7rem;
                }

                .info-value {
                    font-size: 0.9rem;
                }

                .status-badge {
                    padding: 0.4rem 0.8rem;
                    font-size: 0.75rem;
                }

                .price-section, .requirements-section, .boat-section {
                    padding: 1rem;
                    margin: 1rem 0;
                }

                .price-title, .requirements-title, .boat-title {
                    font-size: 1rem;
                }

                .price-item, .boat-item {
                    padding: 0.5rem 0;
                }

                .requirement-badge {
                    padding: 0.4rem 0.8rem;
                    font-size: 0.7rem;
                }

                .booking-footer {
                    padding: 0.75rem;
                    gap: 0.5rem;
                }

                .action-btn {
                    padding: 0.5rem 0.8rem;
                    font-size: 0.75rem;
                }
            }

            /* Very small mobile devices (≤375px) */
            @media (max-width: 375px) {
                .main-content {
                    padding: 0.5rem;
                    margin-left: 0;
                }

                .page-header {
                    padding: 1.25rem 0.75rem;
                    margin-bottom: 1.25rem;
                }

                .header-icon {
                    width: 50px;
                    height: 50px;
                    font-size: 1.5rem;
                }

                .page-title {
                    font-size: 1.6rem;
                }

                .page-subtitle {
                    font-size: 0.8rem;
                }

                .booking-content {
                    padding: 0.5rem;
                }

                .booking-header {
                    padding: 1.25rem 0.75rem;
                }

                .booking-title {
                    font-size: 1.3rem;
                }

                .section-title {
                    font-size: 1rem;
                    margin-bottom: 1rem;
                }

                .info-item {
                    padding: 0.6rem;
                    gap: 0.6rem;
                }

                .info-item i {
                    font-size: 0.9rem;
                    width: 14px;
                }

                .info-label {
                    font-size: 0.65rem;
                }

                .info-value {
                    font-size: 0.85rem;
                }

                .status-badge {
                    padding: 0.3rem 0.6rem;
                    font-size: 0.7rem;
                }

                .price-section, .requirements-section, .boat-section {
                    padding: 0.75rem;
                    margin: 0.75rem 0;
                }

                .price-title, .requirements-title, .boat-title {
                    font-size: 0.9rem;
                }

                .price-item, .boat-item {
                    padding: 0.4rem 0;
                }

                .requirement-badge {
                    padding: 0.3rem 0.6rem;
                    font-size: 0.65rem;
                }

                .booking-footer {
                    padding: 0.6rem;
                    gap: 0.4rem;
                }

                .action-btn {
                    padding: 0.4rem 0.6rem;
                    font-size: 0.7rem;
                }
            }

            /* Ultra small mobile devices (≤320px) */
            @media (max-width: 320px) {
                .main-content {
                    padding: 0.4rem;
                    margin-left: 0;
                }

                .page-header {
                    padding: 1rem 0.5rem;
                    margin-bottom: 1rem;
                }

                .header-icon {
                    width: 45px;
                    height: 45px;
                    font-size: 1.3rem;
                }

                .page-title {
                    font-size: 1.4rem;
                }

                .page-subtitle {
                    font-size: 0.75rem;
                }

                .booking-content {
                    padding: 0.4rem;
                }

                .booking-header {
                    padding: 1rem 0.5rem;
                }

                .booking-title {
                    font-size: 1.2rem;
                }

                .section-title {
                    font-size: 0.9rem;
                    margin-bottom: 0.75rem;
                }

                .info-item {
                    padding: 0.5rem;
                    gap: 0.5rem;
                }

                .info-item i {
                    font-size: 0.8rem;
                    width: 12px;
                }

                .info-label {
                    font-size: 0.6rem;
                }

                .info-value {
                    font-size: 0.8rem;
                }

                .status-badge {
                    padding: 0.25rem 0.5rem;
                    font-size: 0.65rem;
                }

                .price-section, .requirements-section, .boat-section {
                    padding: 0.6rem;
                    margin: 0.6rem 0;
                }

                .price-title, .requirements-title, .boat-title {
                    font-size: 0.8rem;
                }

                .price-item, .boat-item {
                    padding: 0.3rem 0;
                }

                .requirement-badge {
                    padding: 0.25rem 0.5rem;
                    font-size: 0.6rem;
                }

                .booking-footer {
                    padding: 0.5rem;
                    gap: 0.3rem;
                }

                .action-btn {
                    padding: 0.35rem 0.5rem;
                    font-size: 0.65rem;
                }
            }

            /* SweetAlert2 Responsive Styles */
            @media (max-width: 768px) {
                .swal2-popup {
                    width: 90% !important;
                    max-width: 400px !important;
                }
                
                .swal2-title {
                    font-size: 1.2rem !important;
                }
                
                .swal2-content {
                    font-size: 0.9rem !important;
                }
                
                .swal2-actions {
                    flex-direction: column !important;
                    gap: 0.5rem !important;
                }
                
                .swal2-confirm,
                .swal2-cancel {
                    width: 100% !important;
                    margin: 0 !important;
                }
            }

            @media (max-width: 480px) {
                .swal2-popup {
                    width: 95% !important;
                    margin: 0.5rem !important;
                }
                
                .swal2-title {
                    font-size: 1.1rem !important;
                }
                
                .swal2-content {
                    font-size: 0.85rem !important;
                }
            }

            /* Animation */
            .booking-card {
                animation: fadeInUp 0.6s ease-out;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>

    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        @include('tourist.partials.sidebar')

        {{-- Main Content Area --}}
        <div class="main-content flex-grow-1">
            {{-- Main Content --}}
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
                {{-- Modern Header Section --}}
                <div class="page-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="header-text">
                        <h1 class="page-title">Booking Details</h1>
                        <p class="page-subtitle">Complete information about your reservation</p>
                    </div>
                </div>
                <div class="header-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                </div>
            </div>

            {{-- Alerts Section --}}
            <div class="alerts-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            {{-- Main Booking Card --}}
            <div class="booking-card">
                <!-- <div class="booking-header">
                    <h2 class="booking-title">
                        <i class="fas fa-hashtag"></i>
                        Booking Reference: #{{ $booking->id }}
                    </h2>
                </div> -->
                <div class="booking-content">
                    {{-- Booking Information Section --}}
                    <div class="info-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Booking Information
                        </h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <i class="fas fa-flag"></i>
                                <div class="info-content">
                                    <p class="info-label">Status</p>
                                    <p class="info-value">
                                        @if ($booking->status === 'pending')
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock"></i>
                                                Awaiting Approval
                                            </span>
                                        @elseif ($booking->status === 'approved')
                                            <span class="status-badge status-approved">
                                                <i class="fas fa-check-circle"></i>
                                                Approved!
                                            </span>
                                        @elseif ($booking->status === 'rejected')
                                            <span class="status-badge status-rejected">
                                                <i class="fas fa-times-circle"></i>
                                                Rejected
                                            </span>
                                        @elseif ($booking->status === 'cancelled')
                                            <span class="status-badge status-cancelled">
                                                <i class="fas fa-ban"></i>
                                                Cancelled
                                            </span>
                                        @elseif ($booking->status === 'completed')
                                            <span class="status-badge status-completed">
                                                <i class="fas fa-check-double"></i>
                                                Completed
                                            </span>
                                        @else
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-question"></i>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="info-item">
                                <i class="fas fa-calendar-plus"></i>
                                <div class="info-content">
                                    <p class="info-label">Booked On</p>
                                    <p class="info-value">
                                        @php
                                            try {
                                                echo \Carbon\Carbon::parse($booking->created_at)->format('M d, Y h:i A');
                                            } catch(\Exception $e) {
                                                echo $booking->created_at;
                                            }
                                        @endphp
                                    </p>
                                </div>
                            </div>

                            <div class="info-item">
                                <i class="fas fa-map-marked-alt"></i>
                                <div class="info-content">
                                    <p class="info-label">Tour Type</p>
                                    <p class="info-value">{{ ucfirst(str_replace('_', ' ', $booking->tour_type)) }}</p>
                                </div>
                            </div>

                            @php
                                $ci = null; $co = null; $ciTime = null; $coTime = null;
                                try { $ci = \Carbon\Carbon::parse((string)$booking->check_in_date); } catch (\Exception $e) { $ci = null; }
                                try { $co = $booking->check_out_date ? \Carbon\Carbon::parse((string)$booking->check_out_date) : null; } catch (\Exception $e) { $co = null; }
                                if (($booking->tour_type ?? '') === 'day_tour') {
                                    try { $ciTime = $booking->day_tour_departure_time ? \Carbon\Carbon::parse((string)$booking->check_in_date.' '.(string)$booking->day_tour_departure_time) : null; } catch (\Exception $e) { $ciTime = null; }
                                    try { $coTime = ($booking->day_tour_time_of_pickup ?? null) ? \Carbon\Carbon::parse((string)($co?->toDateString() ?: $ci?->toDateString()).' '.(string)$booking->day_tour_time_of_pickup) : null; } catch (\Exception $e) { $coTime = null; }
                                } else {
                                    try { $ciTime = $booking->overnight_date_time_of_departure ? \Carbon\Carbon::parse((string)$booking->overnight_date_time_of_departure) : ($booking->overnight_departure_time ? \Carbon\Carbon::parse((string)$booking->overnight_departure_time) : null); } catch (\Exception $e) { $ciTime = null; }
                                    try { $coTime = $booking->overnight_date_time_of_pickup ? \Carbon\Carbon::parse((string)$booking->overnight_date_time_of_pickup) : null; } catch (\Exception $e) { $coTime = null; }
                                }
                                $ciDateStr = $ci ? $ci->format('M d, Y') : ($booking->check_in_date ?? '');
                                $coDateStr = ($co ?: $ci) ? ($co ?: $ci)->format('M d, Y') : ($booking->check_out_date ?? $booking->check_in_date ?? '');
                                $ciTimeStr = $ciTime ? $ciTime->format('h:i A') : null;
                                $coTimeStr = $coTime ? $coTime->format('h:i A') : null;
                                if (!$ciTimeStr) {
                                    if (($booking->tour_type ?? '') === 'day_tour' && $booking->day_tour_departure_time) {
                                        try { $ciTimeStr = \Carbon\Carbon::parse((string)$booking->day_tour_departure_time)->format('h:i A'); } catch (\Exception $e) { $ciTimeStr = (string)$booking->day_tour_departure_time; }
                                    } elseif (($booking->tour_type ?? '') === 'overnight' && ($booking->overnight_date_time_of_departure ?? $booking->overnight_departure_time)) {
                                        try { $ciTimeStr = \Carbon\Carbon::parse((string)($booking->overnight_date_time_of_departure ?? $booking->overnight_departure_time))->format('h:i A'); } catch (\Exception $e) { $ciTimeStr = (string)($booking->overnight_date_time_of_departure ?? $booking->overnight_departure_time); }
                                    }
                                }
                                if (!$coTimeStr) {
                                    if (($booking->tour_type ?? '') === 'day_tour' && ($booking->day_tour_time_of_pickup ?? null)) {
                                        try { $coTimeStr = \Carbon\Carbon::parse((string)$booking->day_tour_time_of_pickup)->format('h:i A'); } catch (\Exception $e) { $coTimeStr = (string)$booking->day_tour_time_of_pickup; }
                                    } elseif (($booking->tour_type ?? '') === 'overnight' && $booking->overnight_date_time_of_pickup) {
                                        try { $coTimeStr = \Carbon\Carbon::parse((string)$booking->overnight_date_time_of_pickup)->format('h:i A'); } catch (\Exception $e) { $coTimeStr = (string)$booking->overnight_date_time_of_pickup; }
                                    }
                                }
                            @endphp

                            <div class="info-item">
                                <i class="fas fa-calendar-plus"></i>
                                <div class="info-content">
                                    <p class="info-label">Check-In</p>
                                    <p class="info-value">{{ ($ciTimeStr ? ($ciTimeStr.' - ') : '') . $ciDateStr }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar-times"></i>
                                <div class="info-content">
                                    <p class="info-label">Check-Out</p>
                                    <p class="info-value">{{ ($coTimeStr ? ($coTimeStr.' - ') : '') . $coDateStr }}</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <i class="fas fa-users"></i>
                                <div class="info-content">
                                    <p class="info-label">Number of Guests</p>
                                    <p class="info-value">{{ $booking->number_of_guests }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Price Section --}}
                    @php
                        $roomPrice = $booking->base_room_price ?? ($booking->room ? $booking->room->price_per_night : 0);
                        $extraPersonCharge = $booking->extra_person_charge ?? 0;
                        $seniorDiscount = $booking->senior_discount ?? 0;
                        $pwdDiscount = $booking->pwd_discount ?? 0;
                        $finalRoomPrice = $booking->final_total_price ?? $roomPrice;
                        
                        $boatPrice = 0;
                        if ($booking->assignedBoat) {
                            $boatPrice = $booking->assignedBoat->boat_prices ?? 0;
                        } elseif ($booking->boat_price) {
                            $boatPrice = $booking->boat_price;
                        }
                        $totalPrice = $finalRoomPrice + $boatPrice;
                        
                        // Calculate subtotal for discount calculation display
                        $subtotal = $roomPrice + $extraPersonCharge;
                        $pricePerPerson = $booking->number_of_guests > 0 ? $subtotal / $booking->number_of_guests : 0;
                    @endphp

                    <div class="price-section">
                        <h4 class="price-title">
                            <i class="fas fa-calculator"></i>
                            Price Breakdown
                        </h4>
                        <div class="price-breakdown">
                            <div class="price-item">
                                <span class="price-label">Room Base Price</span>
                                <span class="price-value">₱{{ number_format($roomPrice, 2) }}</span>
                            </div>
                            @if($extraPersonCharge > 0)
                                <div class="price-item">
                                    <span class="price-label">Extra Person Charge</span>
                                    <span class="price-value">₱{{ number_format($extraPersonCharge, 2) }}</span>
                                </div>
                            @endif
                            @if($seniorDiscount > 0)
                                <div class="price-item discount">
                                    <span class="price-label">
                                        Senior Discount (20%)
                                        @if($booking->num_senior_citizens > 0)
                                            (₱{{ number_format($pricePerPerson, 2) }} × {{ $booking->num_senior_citizens }} senior{{ $booking->num_senior_citizens > 1 ? 's' : '' }})
                                        @endif
                                    </span>
                                    <span class="price-value">-₱{{ number_format($seniorDiscount, 2) }}</span>
                                </div>
                            @endif
                            @if($pwdDiscount > 0)
                                <div class="price-item discount">
                                    <span class="price-label">
                                        PWD Discount (20%)
                                        @if($booking->num_pwds > 0)
                                            (₱{{ number_format($pricePerPerson, 2) }} × {{ $booking->num_pwds }} PWD{{ $booking->num_pwds > 1 ? 's' : '' }})
                                        @endif
                                    </span>
                                    <span class="price-value">-₱{{ number_format($pwdDiscount, 2) }}</span>
                                </div>
                            @endif
                            <div class="price-item">
                                <span class="price-label">Boat Price</span>
                                <span class="price-value">₱{{ number_format($boatPrice, 2) }}</span>
                            </div>
                            <div class="price-item total">
                                <span class="price-label">Total Price</span>
                                <span class="price-value">₱{{ number_format($totalPrice, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tour Specifics removed to avoid duplicate times; consolidated above. --}}

                    {{-- Tourist Information Section --}}
                    <div class="info-section">
                        <h3 class="section-title">
                            <i class="fas fa-user"></i>
                            Tourist Information
                        </h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <i class="fas fa-id-card"></i>
                                <div class="info-content">
                                    <p class="info-label name-label">Name</p>
                                    <p class="info-value name-value">
                                        @php
                                            $raw = $booking->guest_name ?? '';
                                            $segments = $raw !== '' ? preg_split('/(;|,|\r?\n)\s*/', $raw, -1, PREG_SPLIT_NO_EMPTY) : [];
                                            $fallbackNat = trim($booking->guest_nationality ?? '');
                                        @endphp
                                        @if(!empty($segments))
                                            @foreach($segments as $idx => $seg)
                                                @php
                                                    $seg = trim($seg);
                                                    $name = $seg; $ageNum = ''; $natLine = '';
                                                    if (preg_match('/^\s*(.*?)\s*(?:\((\d{1,3})(?:\s*y\/o)?\))?\s*(?:-\s*(.+))?$/i', $seg, $m)) {
                                                        $name   = trim($m[1] ?? '');
                                                        $ageNum = isset($m[2]) ? trim($m[2]) : '';
                                                        $natLine= isset($m[3]) ? trim($m[3]) : '';
                                                    }
                                                    // If nationality absent on line, use booking nationality for first line only
                                                    if ($natLine === '' && $idx === 0 && $fallbackNat !== '') {
                                                        $natLine = $fallbackNat;
                                                    }
                                                @endphp
                                                <span class="name-line">
                                                    <span class="name-strong">{{ $name }}</span>
                                                    @if($ageNum !== '') <span class="name-meta"> ({{ $ageNum }}y/o)</span>@endif
                                                    @if($natLine !== '') <span class="name-meta"> - {{ $natLine }}</span>@endif
                                                </span>
                                            @endforeach
                                        @else
                                            @php
                                                $seg = trim($booking->guest_name ?? '');
                                                $name = $seg; $ageNum = ''; $natLine = '';
                                                if (preg_match('/^\s*(.*?)\s*(?:\((\d{1,3})(?:\s*y\/o)?\))?\s*(?:-\s*(.+))?$/i', $seg, $m)) {
                                                    $name   = trim($m[1] ?? '');
                                                    $ageNum = isset($m[2]) ? trim($m[2]) : '';
                                                    $natLine= isset($m[3]) ? trim($m[3]) : '';
                                                }
                                                if ($natLine === '' && $fallbackNat !== '') { $natLine = $fallbackNat; }
                                            @endphp
                                            <span class="name-line">
                                                <span class="name-strong">{{ $name }}</span>
                                                @if($ageNum !== '') <span class="name-meta"> ({{ $ageNum }}y/o)</span>@endif
                                                @if($natLine !== '') <span class="name-meta"> - {{ $natLine }}</span>@endif
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <i class="fas fa-venus-mars"></i>
                                <div class="info-content">
                                    <p class="info-label">Gender</p>
                                    <p class="info-value">{{ $booking->guest_gender }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="info-content">
                                    <p class="info-label">Address</p>
                                    <p class="info-value">{{ $booking->guest_address }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-flag"></i>
                                <div class="info-content">
                                    <p class="info-label">Nationality</p>
                                    <p class="info-value">{{ $booking->guest_nationality }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone"></i>
                                <div class="info-content">
                                    <p class="info-label">Contact Number</p>
                                    <p class="info-value">{{ $booking->phone_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Special Requirements Section --}}
                    @if ($booking->num_senior_citizens > 0 || $booking->num_pwds > 0)
                        <div class="requirements-section">
                            <h4 class="requirements-title">
                                <i class="fas fa-heart"></i>
                                Special Requirements
                            </h4>
                            <div class="requirements-list">
                                @if ($booking->num_senior_citizens > 0)
                                    <span class="requirement-badge">
                                        <i class="fas fa-user-clock"></i>
                                        {{ $booking->num_senior_citizens }} Senior Citizens
                                    </span>
                                @endif
                                @if ($booking->num_pwds > 0)
                                    <span class="requirement-badge">
                                        <i class="fas fa-wheelchair"></i>
                                        {{ $booking->num_pwds }} PWDs
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif


                    {{-- Resort Information Section --}}
                    @if ($booking->room && $booking->room->resort)
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-hotel"></i>
                                Resort Information
                            </h3>
                            <div class="info-grid">
                                <div class="info-item">
                                    <i class="fas fa-building"></i>
                                    <div class="info-content">
                                        <p class="info-label">Resort Name</p>
                                        <p class="info-value">{{ $booking->room->resort->resort_name }}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="info-content">
                                        <p class="info-label">Location</p>
                                        <p class="info-value">{{ $booking->room->resort->location }}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-phone"></i>
                                    <div class="info-content">
                                        <p class="info-label">Contact</p>
                                        <p class="info-value">{{ $booking->room->resort->contact_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Room Information Section --}}
                    @if ($booking->room)
                        <div class="info-section">
                            <h3 class="section-title">
                                <i class="fas fa-bed"></i>
                                Room Information
                            </h3>
                            <div class="info-grid">
                                <div class="info-item">
                                    <i class="fas fa-door-open"></i>
                                    <div class="info-content">
                                        <p class="info-label">Room Name</p>
                                        <p class="info-value">{{ $booking->room->room_name }}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-users"></i>
                                    <div class="info-content">
                                        <p class="info-label">Capacity</p>
                                        <p class="info-value">{{ $booking->room->capacity }} persons</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-tag"></i>
                                    <div class="info-content">
                                        <p class="info-label">Price</p>
                                        <p class="info-value">₱{{ number_format($booking->room->price_per_night, 2) }}</p>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-info-circle"></i>
                                    <div class="info-content">
                                        <p class="info-label">Description</p>
                                        <p class="info-value">{{ $booking->room->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Boat Information Section --}}
                    @if ($booking->status === 'approved' && ($booking->assignedBoat || $booking->boat_captain_crew))
                        <div class="boat-section">
                            <h4 class="boat-title">
                                <i class="fas fa-ship"></i>
                                Assigned Boat Information
                            </h4>
                            <div class="boat-details">
                                @if($booking->assignedBoat)
                                    <div class="boat-item">
                                        <i class="fas fa-ship"></i>
                                        <span class="boat-label">Boat Name</span>
                                        <span class="boat-value">{{ $booking->assignedBoat->boat_name }}</span>
                                    </div>
                                    
                                    <div class="boat-item">
                                        <i class="fas fa-tag"></i>
                                        <span class="boat-label">Boat Price</span>
                                        <span class="boat-value">₱{{ number_format($booking->assignedBoat->boat_prices ?? 0, 2) }}</span>
                                    </div>
                                    <div class="boat-item">
                                        <i class="fas fa-users"></i>
                                        <span class="boat-label">Capacity</span>
                                        <span class="boat-value">{{ $booking->assignedBoat->boat_capacities }} persons</span>
                                    </div>
                                    @if($booking->assignedBoat->captain_name)
                                        <div class="boat-item">
                                            <i class="fas fa-user"></i>
                                            <span class="boat-label">Captain</span>
                                            <span class="boat-value">{{ $booking->assignedBoat->captain_name }}</span>
                                        </div>
                                        <div class="boat-item">
                                            <i class="fas fa-phone"></i>
                                            <span class="boat-label">Captain Contact</span>
                                            <span class="boat-value">{{ $booking->assignedBoat->captain_contact ?? 'N/A' }}</span>
                                        </div>
                                    @elseif($booking->assignedBoat->user)
                                        <div class="boat-item">
                                            <i class="fas fa-user"></i>
                                            <span class="boat-label">Boat Owner</span>
                                            <span class="boat-value">{{ $booking->assignedBoat->user->name }}</span>
                                        </div>
                                        <div class="boat-item">
                                            <i class="fas fa-phone"></i>
                                            <span class="boat-label">Owner Contact</span>
                                            <span class="boat-value">{{ $booking->assignedBoat->user->phone ?? 'N/A' }}</span>
                                        </div>
                                    @endif
                                @elseif($booking->boat_captain_crew && $booking->boat_captain_crew !== 'N/A')
                                    <div class="boat-item">
                                        <i class="fas fa-ship"></i>
                                        <span class="boat-label">Boat Name</span>
                                        <span class="boat-value">{{ $booking->assigned_boat ?? 'N/A' }}</span>
                                    </div>
                                    <div class="boat-item">
                                        <i class="fas fa-tag"></i>
                                        <span class="boat-label">Boat Price</span>
                                        <span class="boat-value">₱{{ number_format($booking->boat_price ?? 0, 2) }}</span>
                                    </div>
                                    <div class="boat-item">
                                        <i class="fas fa-user"></i>
                                        <span class="boat-label">Captain</span>
                                        <span class="boat-value">{{ $booking->boat_captain_crew }}</span>
                                    </div>
                                    <div class="boat-item">
                                        <i class="fas fa-phone"></i>
                                        <span class="boat-label">Captain Contact</span>
                                        <span class="boat-value">{{ $booking->boat_contact_number ?? 'N/A' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Card Footer --}}
                <div class="booking-footer">
                    @if ($booking->status === 'pending')
                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="action-btn cancel-btn">
                                <i class="fas fa-times"></i>
                                Cancel Booking
                            </button>
                        </form>
                    @endif

                    @if (in_array($booking->status, ['approved', 'rejected', 'cancelled', 'completed']))
                        <button type="button" class="action-btn delete-btn delete-booking-btn" data-booking-id="{{ $booking->id }}">
                            <i class="fas fa-trash"></i>
                            Delete Booking
                        </button>
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }
                hideOffcanvasOnDesktop();
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Delete Booking Confirmation with SweetAlert2
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-booking-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.delete-booking-btn');
                    const bookingId = button.getAttribute('data-booking-id');
                    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this! This will permanently delete the booking record.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        customClass: {
                            popup: 'swal2-popup-responsive',
                            title: 'swal2-title-responsive',
                            content: 'swal2-content-responsive'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send AJAX request to delete booking
                            fetch(`/tourist/bookings/${bookingId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "The booking has been deleted successfully.",
                                        icon: "success",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive'
                                        }
                                    }).then(() => {
                                        // Redirect to the visit page after successful deletion
                                        window.location.href = '/tourist/visit';
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: data.message || "Failed to delete the booking. Please try again.",
                                        icon: "error",
                                        customClass: {
                                            popup: 'swal2-popup-responsive',
                                            title: 'swal2-title-responsive',
                                            content: 'swal2-content-responsive'
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while deleting the booking. Please try again.",
                                    icon: "error",
                                    customClass: {
                                        popup: 'swal2-popup-responsive',
                                        title: 'swal2-title-responsive',
                                        content: 'swal2-content-responsive'
                                    }
                                });
                            });
                        }
                    });
                }
            });
        });

        // Mobile sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</x-app-layout>