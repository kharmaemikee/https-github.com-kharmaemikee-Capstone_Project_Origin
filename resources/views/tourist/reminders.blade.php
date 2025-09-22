<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        <div class="main-content flex-grow-1">
            {{-- Main Content Area --}}
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
                {{-- Enhanced Header Section --}}
                <div class="header-section mb-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <div class="header-content">
                        <h1 class="page-title mb-2">
                            <i class="fas fa-bell text-primary me-3"></i>Reminders
                        </h1>
                        <p class="page-subtitle text-muted mb-0">Important information for your Matnog adventure</p>
                    </div>
                    <div class="header-actions mt-3 mt-md-0">
                        <a href="{{ route('tourist.list') }}" class="btn btn-primary btn-lg shadow-lg rounded-pill px-4 py-3 modern-btn">
                            <i class="fas fa-home me-2"></i>View All Resorts
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Registration Step Box --}}
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="step-box modern-step-box registration-step">
                        <div class="step-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="step-content">
                            <div class="step-number">01</div>
                            <h3>REGISTRATION</h3>
                            <p>Fill out the required information: name, address, age, nationality, and contact number.</p>
                        </div>
                    </div>
                </div>

                {{-- Payment Step Box --}}
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="step-box modern-step-box payment-step">
                        <div class="step-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="step-content">
                            <div class="step-number">02</div>
                            <h3>PAYMENT</h3>
                            <div class="pricing-section">
                                <div class="pricing-category">
                                    <h5><i class="fas fa-ship me-2"></i>BOAT RENTAL</h5>
                                    <div class="price-tags">
                                        <span class="price-tag day-tour">P 3,000 Day Tour</span>
                                        <span class="price-tag overnight">P 3,500 Overnight</span>
                                    </div>
                                </div>
                                <div class="pricing-category">
                                    <h5><i class="fas fa-ticket-alt me-2"></i>REGISTRATION FEE</h5>
                                    <div class="price-tags">
                                        <span class="price-tag local">P 150 Local</span>
                                        <span class="price-tag foreign">P 300 Foreign</span>
                                    </div>
                                </div>
                                <div class="pricing-notes">
                                    <small><i class="fas fa-child me-1"></i>7 years old and below - No Registration Fee</small>
                                    <small><i class="fas fa-percentage me-1"></i>20% discount for Senior Citizen & PWDs</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Juag Lagoon Fish Sanctuary Card --}}
                <div class="col-12 mb-5">
                    <div class="attraction-card modern-attraction-card">
                        <div class="attraction-header">
                            <div class="attraction-icon">
                                <i class="fas fa-fish"></i>
                            </div>
                            <h3 class="attraction-title">Juag Lagoon Fish Sanctuary</h3>
                            <p class="attraction-subtitle">Explore the underwater wonders</p>
                        </div>
                        <div class="attraction-gallery">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/juag.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/juag2.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/juag3.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/juag4.png') }}" class="img-fluid rounded-3" alt="Juag Lagoon" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Calintaan Cave Card --}}
                <div class="col-12 mb-5">
                    <div class="attraction-card modern-attraction-card">
                        <div class="attraction-header">
                            <div class="attraction-icon">
                                <i class="fas fa-mountain"></i>
                            </div>
                            <h3 class="attraction-title">Calintaan Cave</h3>
                            <p class="attraction-subtitle">Discover the hidden underground beauty</p>
                        </div>
                        <div class="attraction-gallery">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/cave.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/cave2.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/cave3.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/cave4.png') }}" class="img-fluid rounded-3" alt="Calintaan Cave" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Subic Beach Card --}}
                <div class="col-12 mb-5">
                    <div class="attraction-card modern-attraction-card">
                        <div class="attraction-header">
                            <div class="attraction-icon">
                                <i class="fas fa-umbrella-beach"></i>
                            </div>
                            <h3 class="attraction-title">Subic Beach</h3>
                            <p class="attraction-subtitle">Experience pristine white sand beaches</p>
                        </div>
                        <div class="attraction-gallery">
                            <div class="row g-3">
                                <div class="col-6 col-md-4">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/subic2.png') }}" class="img-fluid rounded-3" alt="Subic Beach" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/subic3.png') }}" class="img-fluid rounded-3" alt="Subic Beach" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="gallery-item">
                                        <img src="{{ asset('images/subic4.png') }}" class="img-fluid rounded-3" alt="Subic Beach" onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 10 Persons per Boat Trip Reminder --}}
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="info-card boat-capacity-card">
                        <div class="info-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="info-content">
                            <h3>10 PERSONS PER BOAT TRIP</h3>
                            <p>Enjoy your trip with up to 10 individuals per boat for the best experience.</p>
                        </div>
                    </div>
                </div>

                {{-- Contact Us Box --}}
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="info-card contact-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-content">
                            <h3>CONTACT US!</h3>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-phone text-primary"></i>
                                    <span>0909-515-9274</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fab fa-facebook text-primary"></i>
                                    <span>Matnog Tourism Culture and Arts Office</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                    <span>Camcaman, Matnog, Sorsogon</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Icons CSS and Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* ===== MODERN REMINDERS PAGE STYLES ===== */
        
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
        
        /* Sidebar Navigation */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

        /* ===== HEADER SECTION ===== */
        .header-section {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2c3e50;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin: 0;
        }

        .modern-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
            background: linear-gradient(135deg, #0056b3, #004085);
        }

        /* ===== MODERN STEP BOXES ===== */
        .modern-step-box {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 2px solid rgba(0, 123, 255, 0.1);
            border-left: 6px solid #007bff;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .modern-step-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border-radius: 20px 20px 0 0;
        }

        .modern-step-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 123, 255, 0.15);
            border-color: rgba(0, 123, 255, 0.3);
        }

        .registration-step {
            border-left-color: #28a745;
        }

        .registration-step::before {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .payment-step {
            border-left-color: #ffc107;
        }

        .payment-step::before {
            background: linear-gradient(90deg, #ffc107, #fd7e14);
        }

        .step-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 1rem;
            text-align: center;
        }

        .step-number {
            display: inline-block;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .step-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .step-content p {
            font-size: 1rem;
            color: #6c757d;
            line-height: 1.6;
            margin: 0;
        }

        /* ===== PRICING SECTION ===== */
        .pricing-section {
            margin-top: 1rem;
        }

        .pricing-category {
            margin-bottom: 1.5rem;
        }

        .pricing-category h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }

        .price-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .price-tag {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .day-tour { background: linear-gradient(135deg, #28a745, #20c997); }
        .overnight { background: linear-gradient(135deg, #ffc107, #fd7e14); }
        .local { background: linear-gradient(135deg, #17a2b8, #138496); }
        .foreign { background: linear-gradient(135deg, #dc3545, #c82333); }

        .pricing-notes {
            margin-top: 1rem;
        }

        .pricing-notes small {
            display: block;
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        /* ===== ATTRACTION CARDS ===== */
        .modern-attraction-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 25px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(0, 123, 255, 0.1);
        }

        .modern-attraction-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 123, 255, 0.15);
        }

        .attraction-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .attraction-icon {
            font-size: 4rem;
            color: #007bff;
            margin-bottom: 1rem;
        }

        .attraction-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .attraction-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin: 0;
        }

        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.8), rgba(0, 86, 179, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay i {
            font-size: 2rem;
            color: white;
        }

        /* ===== INFO CARDS ===== */
        .info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            border: 2px solid rgba(0, 123, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border-radius: 20px 20px 0 0;
        }

        .info-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 123, 255, 0.15);
        }

        .boat-capacity-card::before {
            background: linear-gradient(90deg, #ff9800, #f57c00);
        }

        .contact-card::before {
            background: linear-gradient(90deg, #6c757d, #495057);
        }

        .info-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 1rem;
            text-align: center;
        }

        .boat-capacity-card .info-icon {
            color: #ff9800;
        }

        .contact-card .info-icon {
            color: #6c757d;
        }

        .info-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-content p {
            font-size: 1rem;
            color: #6c757d;
            line-height: 1.6;
            text-align: center;
            margin: 0;
        }

        .contact-info {
            margin-top: 1rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.5rem;
            background: rgba(0, 123, 255, 0.05);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(0, 123, 255, 0.1);
            transform: translateX(5px);
        }

        .contact-item i {
            font-size: 1.2rem;
            margin-right: 0.75rem;
            width: 20px;
        }

        .contact-item span {
            font-size: 0.95rem;
            color: #2c3e50;
            font-weight: 500;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .header-section {
                padding: 1.5rem;
                margin-bottom: 2rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .modern-btn {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
            }

            .modern-step-box {
                padding: 1.5rem;
            }

            .step-content h3 {
                font-size: 1.3rem;
            }

            .attraction-title {
                font-size: 1.5rem;
            }

            .attraction-icon {
                font-size: 3rem;
            }

            .gallery-item img {
                height: 150px;
            }

            .info-card {
                padding: 1.5rem;
            }

            .info-content h3 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .header-section {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .modern-step-box {
                padding: 1.25rem;
            }

            .step-content h3 {
                font-size: 1.2rem;
            }

            .attraction-title {
                font-size: 1.3rem;
            }

            .attraction-icon {
                font-size: 2.5rem;
            }

            .gallery-item img {
                height: 120px;
            }

            .info-card {
                padding: 1.25rem;
            }

            .price-tags {
                flex-direction: column;
            }

            .price-tag {
                text-align: center;
            }
        }

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
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
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

        /* Mobile Toggle Button */
        .mobile-toggle {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .mobile-toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .mobile-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 85vw !important;
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
            .main-content {
                padding: 0.75rem;
                margin-left: 0;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
                margin-left: 0;
            }
            
            .modern-mobile-sidebar {
                width: 95vw !important;
            }
            
            .mobile-toggle {
                padding: 0.75rem;
            }
            
            .mobile-toggle-btn {
                padding: 0.5rem 0.75rem;
                font-size: 1rem;
            }
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>

    {{-- Custom JavaScript for image error handling and mobile sidebar behavior --}}
    <script>
        function handleImageError(imgElement, defaultImagePath) {
            imgElement.onerror = null;
            imgElement.src = defaultImagePath;
        }

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