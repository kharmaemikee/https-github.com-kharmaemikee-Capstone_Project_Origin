<x-explore-layout>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbf2);">
    <main class="py-4 px-3 flex-grow-1">
        {{-- Enhanced Header Section --}}
        <div class="resort-header-section mb-5">
            <div class="resort-header-content">
                <div class="resort-title-section">
                    <div class="d-flex align-items-center mb-3">
                        
                    </div>
                    <h1 class="resort-title mb-3">
                        <i class="fas fa-comments text-primary me-3"></i>Room Reviews
                    </h1>
                    <p class="resort-subtitle text-muted mb-0">Customer feedback for {{ $room->room_name }}</p>
                </div>
            </div>
        </div>

        {{-- Room Info Section --}}
        <div class="accommodation-card mb-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="accommodation-image-container">
                        <img src="{{ asset($room->image_path ?: 'images/default_room.png') }}" 
                             alt="{{ $room->room_name }}"
                             class="accommodation-image">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="accommodation-content">
                        <h3 class="accommodation-title">{{ $room->room_name }}</h3>
                        <p class="accommodation-type">{{ ucfirst($room->accommodation_type) }}</p>
                        <div class="accommodation-specs">
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
        <div class="accommodation-card mb-4">
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
        <div class="accommodation-card">
            <div class="section-header mb-4">
                <h4 class="section-title">
                    <i class="fas fa-star me-2"></i>Customer Reviews
                </h4>
            </div>

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
    </main>
</div>

<style>
    /* ===== MODERN EXPLORE FEEDBACK PAGE STYLES ===== */
    
    /* ===== HEADER SECTION ===== */
    .resort-header-section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }

    .resort-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2c3e50;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .resort-subtitle {
        font-size: 1.1rem;
        color: #6c757d;
        margin: 0;
    }

    /* ===== ACCOMMODATION CARDS ===== */
    .accommodation-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 2px solid rgba(0, 123, 255, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .accommodation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 123, 255, 0.15);
        border-color: rgba(0, 123, 255, 0.3);
    }

    .accommodation-image-container {
        position: relative;
        overflow: hidden;
        height: 200px;
        border-radius: 15px;
    }

    .accommodation-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .accommodation-content {
        padding-left: 1.5rem;
    }

    .accommodation-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .accommodation-type {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .accommodation-specs {
        display: flex;
        gap: 2rem;
    }

    .spec-item {
        color: #495057;
        font-weight: 500;
    }

    /* ===== RATING STYLES ===== */
    .rating-overview {
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

    /* ===== SECTION HEADERS ===== */
    .section-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .section-title i {
        color: #007bff;
    }

    /* ===== REVIEW CARDS ===== */
    .review-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 123, 255, 0.1);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
        border-color: rgba(0, 123, 255, 0.3);
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
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        padding: 1rem;
        border-radius: 10px;
        border-left: 4px solid #007bff;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
    }

    .review-comment p {
        margin: 0;
        color: #495057;
        line-height: 1.6;
    }

    .booking-info {
        background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border-left: 3px solid #6c757d;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .no-reviews {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 15px;
        border: 2px dashed #dee2e6;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 768px) {
        .resort-header-section {
            padding: 1.5rem;
        }
        
        .resort-title {
            font-size: 2rem;
        }
        
        .accommodation-card {
            padding: 1.5rem;
        }
        
        .accommodation-content {
            padding-left: 0;
            padding-top: 1rem;
        }
        
        .accommodation-specs {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .review-rating {
            margin-top: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .resort-header-section {
            padding: 1rem;
        }
        
        .resort-title {
            font-size: 1.75rem;
        }
        
        .accommodation-card {
            padding: 1rem;
        }
        
        .accommodation-image-container {
            height: 180px;
        }
    }
</style>
</x-explore-layout>