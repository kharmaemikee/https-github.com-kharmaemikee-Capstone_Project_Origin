<x-app-layout>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        <div class="main-content flex-grow-1">
            {{-- Main Content Area --}}
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
                <div class="row">
                    <div class="col-12">
                        {{-- Header Section --}}
                        <div class="feedback-header mb-4">
                            <div class="d-flex align-items-center mb-3">
                                
                                <div>
                                    <h1 class="feedback-title mb-1">
                                        <i class="fas fa-comments text-primary me-2"></i>
                                        Room Reviews
                                    </h1>
                                    <p class="feedback-subtitle text-muted mb-0">
                                        Customer feedback for {{ $room->room_name }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Room Info Section --}}
                        <div class="room-info-card mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="room-image">
                                        <img src="{{ asset($room->image_path ?: 'images/default_room.png') }}" 
                                             alt="{{ $room->room_name }}"
                                             class="room-main-image">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="room-details">
                                        <h3 class="room-name">{{ $room->room_name }}</h3>
                                        <p class="room-type">{{ ucfirst($room->accommodation_type) }}</p>
                                        <div class="room-specs">
                                            <span class="spec-item">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $room->max_guests }} guests
                                            </span>
                                            <span class="spec-item">
                                                <i class="fas fa-tag me-1"></i>
                                                ₱{{ number_format($room->price_per_night, 2) }}/night
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Rating Summary Section --}}
                        <div class="rating-summary-card mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="rating-overview text-center">
                                        <div class="average-rating">
                                            <span class="rating-number">{{ number_format($ratingStats['average_rating'], 1) }}</span>
                                            <div class="rating-stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($ratingStats['average_rating']))
                                                        <i class="fas fa-star text-warning"></i>
                                                    @elseif($i - 0.5 <= $ratingStats['average_rating'])
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="rating-count">{{ $ratingStats['total_ratings'] }} {{ $ratingStats['total_ratings'] == 1 ? 'review' : 'reviews' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="rating-breakdown">
                                        <h6 class="mb-3">Rating Distribution</h6>
                                        @for($i = 5; $i >= 1; $i--)
                                            <div class="rating-bar-item">
                                                <span class="rating-label">{{ $i }} star{{ $i > 1 ? 's' : '' }}</span>
                                                <div class="rating-bar">
                                                    <div class="rating-bar-fill" style="width: {{ $ratingStats['total_ratings'] > 0 ? ($ratingStats['rating_breakdown'][$i] / $ratingStats['total_ratings']) * 100 : 0 }}%"></div>
                                                </div>
                                                <span class="rating-count">{{ $ratingStats['rating_breakdown'][$i] }}</span>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Reviews Section --}}
                        <div class="reviews-section">
                            <h4 class="reviews-title mb-4">
                                <i class="fas fa-star me-2"></i>Customer Reviews
                            </h4>

                            @if($ratings->count() > 0)
                                <div class="reviews-list">
                                    @foreach($ratings as $rating)
                                        <div class="review-card">
                                            <div class="review-header">
                                                <div class="reviewer-info">
                                                    <div class="reviewer-avatar">
                                                        @if($rating->user->owner_image_path)
                                                            <img src="{{ asset($rating->user->owner_image_path) }}" 
                                                                 alt="{{ $rating->user->name }}" 
                                                                 class="reviewer-image"
                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            <div class="reviewer-image-fallback" style="display: none;">
                                                                <i class="fas fa-user-circle"></i>
                                                            </div>
                                                        @else
                                                            <div class="reviewer-image-fallback">
                                                                <i class="fas fa-user-circle"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="reviewer-details">
                                                        <h6 class="reviewer-name">{{ $rating->user->name }}</h6>
                                                        <p class="review-date">{{ $rating->created_at->format('M d, Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="review-rating">
                                                    <div class="stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $rating->rating)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>

                                            @if($rating->comment)
                                                <div class="review-comment">
                                                    <p>{{ $rating->comment }}</p>
                                                </div>
                                            @endif

                                            @if($rating->booking && $rating->booking->check_in_date && $rating->booking->check_out_date)
                                                <div class="booking-info">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        Stayed {{ $rating->booking->check_in_date->format('M d, Y') }} - {{ $rating->booking->check_out_date->format('M d, Y') }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Pagination --}}
                                <div class="pagination-wrapper mt-4">
                                    {{ $ratings->links() }}
                                </div>
                            @else
                                <div class="no-reviews">
                                    <div class="text-center py-5">
                                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                        <h5>No Reviews Yet</h5>
                                        <p class="text-muted">Be the first to review this room!</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
        
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

        /* Main content styling to work with sidebar */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
        }

        /* Feedback specific styles */
        .feedback-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            padding: 2rem;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .feedback-title {
            color: #2c3e50;
            font-weight: 700;
        }

        .room-info-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .room-main-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .room-name {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .room-type {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .room-specs {
            display: flex;
            gap: 2rem;
        }

        .spec-item {
            color: #495057;
            font-weight: 500;
        }

        .rating-summary-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .average-rating {
            margin-bottom: 1rem;
        }

        .rating-number {
            font-size: 3rem;
            font-weight: 700;
            color: #2c3e50;
            display: block;
        }

        .rating-stars {
            margin: 0.5rem 0;
        }

        .rating-stars i {
            font-size: 1.2rem;
            margin: 0 2px;
        }

        .rating-count {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .rating-breakdown h6 {
            color: #2c3e50;
            font-weight: 600;
        }

        .rating-bar-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .rating-label {
            width: 80px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .rating-bar {
            flex: 1;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            margin: 0 1rem;
            overflow: hidden;
        }

        .rating-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #ffc107 0%, #ff8c00 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .reviews-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .reviews-title {
            color: #2c3e50;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        .review-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background: #f8f9fa;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .reviewer-info {
            display: flex;
            align-items: center;
        }

        .reviewer-avatar {
            margin-right: 1rem;
            position: relative;
        }

        .reviewer-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .reviewer-image-fallback {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .reviewer-image-fallback i {
            font-size: 1.5rem;
            color: #6c757d;
        }

        .reviewer-name {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .review-date {
            margin: 0;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .review-rating .stars i {
            font-size: 1rem;
            margin: 0 1px;
        }

        .review-comment {
            background: #ffffff;
            padding: 1rem;
            border-radius: 6px;
            border-left: 4px solid #007bff;
            margin-bottom: 1rem;
        }

        .review-comment p {
            margin: 0;
            color: #495057;
            line-height: 1.6;
        }

        .booking-info {
            background: #e9ecef;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border-left: 3px solid #6c757d;
        }

        .no-reviews {
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
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
            
            .feedback-header {
                padding: 1rem;
            }
            
            .room-info-card,
            .rating-summary-card,
            .reviews-section {
                padding: 1rem;
            }
            
            .review-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .review-rating {
                margin-top: 0.5rem;
            }
            
            .room-specs {
                flex-direction: column;
                gap: 0.5rem;
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
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>
</x-app-layout>
