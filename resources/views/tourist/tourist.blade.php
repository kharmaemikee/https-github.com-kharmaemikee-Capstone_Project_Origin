<x-app-layout>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        <div class="main-content flex-grow-1">
            {{-- Modern Header Section --}}
            <div class="tourist-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="header-text">
                        <h1 class="page-title">Welcome to Subic Beach</h1>
                        <p class="page-subtitle">Discover amazing resorts and create unforgettable memories</p>
                    </div>
                </div>
                <div class="header-decoration">
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                    <div class="decoration-circle"></div>
                </div>
            </div>

            {{-- Recommendations Section --}}
            <div class="recommendations-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-star me-2"></i>
                        Recommendations
                    </h2>
                    <p class="section-subtitle">Explore our featured resorts and accommodations</p>
                </div>

                <div class="recommendations-grid">
                    <div class="recommendation-card">
                        <a href="{{ route('tourist.reminders') }}" class="recommendation-link">
                            <div class="card-image-container">
                                <img src="{{ asset('images/cottages.png') }}" class="card-image" alt="Resorts">
                                <div class="card-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-hotel overlay-icon"></i>
                                        <span class="overlay-text">Explore Resorts</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-icon">
                                    <i class="fas fa-hotel"></i>
                                </div>
                                <h3 class="card-title">Resorts</h3>
                                <p class="card-description">Discover amazing resorts and accommodations</p>
                                <div class="card-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Most Visited Resorts Section --}}
            <div class="most-visited-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-fire me-2"></i>
                        Most Visited Resorts
                    </h2>
                    <p class="section-subtitle">Popular destinations loved by our visitors</p>
                </div>
                <div class="resorts-carousel">
                    @forelse ($mostVisitedResorts as $resort)
                        <div class="resort-card">
                            <div class="resort-image-container">
                                <img src="{{ asset($resort->image_path ?? 'images/cottages.png') }}" 
                                     class="resort-image" 
                                     alt="{{ $resort->resort_name }}" 
                                     onerror="handleImageError(this, '{{ asset('images/cottages.png') }}');">
                                <div class="resort-overlay">
                                    <div class="overlay-content">
                                        <i class="fas fa-eye overlay-icon"></i>
                                        <span class="overlay-text">View Resort</span>
                                    </div>
                                </div>
                                <div class="visit-badge">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $resort->visit_count ?? 0 }}</span>
                                </div>
                            </div>
                            <div class="resort-content">
                                <div class="resort-header">
                                    <div class="resort-icon">
                                        <i class="fas fa-hotel"></i>
                                    </div>
                                    <div class="resort-info">
                                        <h4 class="resort-title">{{ $resort->resort_name }}</h4>
                                        <p class="resort-location">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $resort->address }}
                                        </p>
                                    </div>
                                </div>
                                <div class="resort-stats">
                                    <div class="stat-item">
                                        <i class="fas fa-chart-line"></i>
                                        <span>{{ $resort->visit_count ?? 0 }} visits</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-star"></i>
                                        <span>{{ number_format($resort->ratings_avg ?? ($resort->average_rating ?? 0), 1) }} / 5</span>
                                    </div>
                                </div>
                                <a href="{{ route('explore.show', $resort->id) }}" class="resort-btn">
                                    <i class="fas fa-eye me-2"></i>
                                    View Resort
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-hotel"></i>
                            </div>
                            <h3 class="empty-title">No Resorts Yet</h3>
                            <p class="empty-description">Check back later for popular resorts</p>
                        </div>
                    @endforelse
                </div>
            </div>
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
            position: relative;
            overflow: hidden;
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

        /* Modern Tourist Page Styling */
        .tourist-container {
            background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);
            min-height: 100vh;
            display: flex;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Header Section */
        .tourist-header {
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

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 1rem 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .section-title i {
            color: #007bff;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
        }

        /* Recommendations Section */
        .recommendations-section {
            margin-bottom: 4rem;
        }

        .recommendations-grid {
            display: flex;
            justify-content: center;
        }

        .recommendation-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
            width: 100%;
        }

        .recommendation-card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .recommendation-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .recommendation-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .card-image-container {
            position: relative;
            overflow: hidden;
            height: 250px;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .recommendation-card:hover .card-image {
            transform: scale(1.1);
        }

        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .recommendation-card:hover .card-overlay {
            opacity: 1;
        }

        .overlay-content {
            text-align: center;
            color: white;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .recommendation-card:hover .overlay-content {
            transform: translateY(0);
        }

        .overlay-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .overlay-text {
            font-size: 1.3rem;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .card-content {
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .card-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border-radius: 0 0 4px 4px;
        }

        .card-icon {
            font-size: 2.5rem;
            color: #007bff;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 1rem 0;
        }

        .card-description {
            font-size: 1rem;
            color: #6c757d;
            margin: 0 0 1.5rem 0;
            line-height: 1.6;
        }

        .card-arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .recommendation-card:hover .card-arrow {
            transform: translateX(10px);
        }

        /* Most Visited Section */
        .most-visited-section {
            margin-bottom: 2rem;
        }

        .resorts-carousel {
            display: flex;
            gap: 2rem;
            overflow-x: auto;
            padding: 1rem 0;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .resorts-carousel::-webkit-scrollbar {
            height: 8px;
        }

        .resorts-carousel::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .resorts-carousel::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        .resorts-carousel::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .resort-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 320px;
            max-width: 350px;
            flex-shrink: 0;
        }

        .resort-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .resort-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .resort-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .resort-card:hover .resort-image {
            transform: scale(1.1);
        }

        .resort-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .resort-card:hover .resort-overlay {
            opacity: 1;
        }

        .visit-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
            z-index: 2;
        }

        .visit-badge i {
            font-size: 0.7rem;
        }

        .resort-content {
            padding: 1.5rem;
        }

        .resort-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .resort-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .resort-info {
            flex: 1;
        }

        .resort-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
            line-height: 1.3;
        }

        .resort-location {
            font-size: 0.9rem;
            color: #6c757d;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .resort-location i {
            color: #007bff;
        }

        .resort-stats {
            margin-bottom: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }

        .stat-item i {
            color: #007bff;
        }

        .resort-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .resort-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
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
            color: #007bff;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 1rem 0;
        }

        .empty-description {
            font-size: 1rem;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .tourist-header {
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

            .section-title {
                font-size: 2rem;
            }

            .recommendation-card {
                max-width: 350px;
            }

            .card-image-container {
                height: 200px;
            }

            .resort-card {
                min-width: 280px;
                max-width: 300px;
            }

            .resort-image-container {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .tourist-header {
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .recommendation-card {
                max-width: 320px;
            }

            .card-image-container {
                height: 180px;
            }

            .resort-card {
                min-width: 260px;
                max-width: 280px;
            }

            .resort-image-container {
                height: 160px;
            }
        }

        /* Animation for cards */
        .recommendation-card,
        .resort-card {
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

        /* Staggered animation for resort cards */
        .resort-card:nth-child(1) { animation-delay: 0.1s; }
        .resort-card:nth-child(2) { animation-delay: 0.2s; }
        .resort-card:nth-child(3) { animation-delay: 0.3s; }
        .resort-card:nth-child(4) { animation-delay: 0.4s; }
        .resort-card:nth-child(5) { animation-delay: 0.5s; }

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

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
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