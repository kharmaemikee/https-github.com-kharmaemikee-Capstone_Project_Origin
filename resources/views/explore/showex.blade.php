<x-app-layout>
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
                    <h1 class="resort-title mb-3">
                        <i class="fas fa-hotel text-primary me-3"></i>{{ $resort->resort_name }}
                    </h1>
                    {{-- Display Resort Status Badge --}}
                    @php
                        $resortStatusClass = match($resort->status) {
                            'open' => 'status-open',
                            'closed' => 'status-closed',
                            'maintenance' => 'status-maintenance',
                            default => 'status-unknown',
                        };
                    @endphp
                    <div class="resort-status-badge {{ $resortStatusClass }}">
                        <i class="fas fa-circle me-2"></i>{{ ucfirst($resort->status ?? 'Unknown') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Resort Status Alerts --}}
        @if (($resort->status ?? '') === 'maintenance' && $resort->rehab_reason)
            <div class="status-alert maintenance-alert">
                <div class="alert-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="alert-content">
                    <h5>Resort Under Maintenance</h5>
                    <p>{{ $resort->rehab_reason }}</p>
                </div>
            </div>
        @elseif (($resort->status ?? '') === 'closed')
            <div class="status-alert closed-alert">
                <div class="alert-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="alert-content">
                    <h5>Resort Closed</h5>
                    <p>This resort is currently not operating.</p>
                </div>
            </div>
        @endif

        {{-- Contact Information Section --}}
        <div class="contact-info-section mb-5">
            <div class="contact-cards">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h6>Contact Number</h6>
                        <p>{{ $resort->contact_number ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fab fa-facebook"></i>
                    </div>
                    <div class="contact-details">
                        <h6>Facebook Page</h6>
                        @if ($resort->facebook_page_link)
                            <a href="{{ $resort->facebook_page_link }}" target="_blank" rel="noopener noreferrer" class="facebook-link">
                                Visit Page
                            </a>
                        @else
                            <p>N/A</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Accommodations Section --}}
        <div class="accommodations-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-bed me-3"></i>View Accommodations
                </h2>
                <div class="accommodation-tabs">
                    <a href="{{ request()->fullUrlWithQuery(['show' => 'rooms']) }}" 
                       class="accommodation-tab {{ request('show', 'rooms') === 'rooms' ? 'active' : '' }}">
                        <i class="fas fa-bed me-2"></i>Rooms
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['show' => 'cottages']) }}" 
                       class="accommodation-tab {{ request('show') === 'cottages' ? 'active' : '' }}">
                        <i class="fas fa-home me-2"></i>Cottages
                    </a>
                </div>
            </div>

            <div class="accommodations-grid">
                <div class="row g-4">
                @php
                    $show = request('show', 'rooms');
                    $list = $show === 'cottages' ? $resort->rooms->where('accommodation_type','cottage') : $resort->rooms->where('accommodation_type','room');
                @endphp
                    @forelse ($list as $room)
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="accommodation-card modern-accommodation-card">
                                <div class="accommodation-image-container">
                                    <img src="{{ asset($room->image_path ? $room->image_path : 'images/default_room.png') }}"
                                         class="accommodation-image"
                                         alt="{{ $room->room_name }}"
                                         onerror="handleImageError(this, '{{ asset('images/default_room.png') }}')">
                                    
                                    <div class="accommodation-overlay">
                                        <div class="overlay-content">
                                            <i class="fas fa-eye overlay-icon"></i>
                                            <span class="overlay-text">View Details</span>
                                        </div>
                                    </div>

                                    {{-- Room Status Badge --}}
                                    @php
                                        $roomStatusClass = match($room->status) {
                                            'open' => 'status-open',
                                            'closed' => 'status-closed',
                                            'maintenance' => 'status-maintenance',
                                            default => 'status-unknown',
                                        };
                                    @endphp
                                    <div class="status-badge {{ $roomStatusClass }}">
                                        <i class="fas fa-circle me-1"></i>
                                        {{ ucfirst($room->status ?? 'Unknown') }}
                                    </div>
                                </div>

                                <div class="accommodation-content">
                                    <div class="accommodation-header">
                                        <h3 class="accommodation-title">{{ $room->room_name }}</h3>
                                        <div class="accommodation-details">
                                            <div class="detail-item">
                                                <i class="fas fa-users me-1"></i>
                                                <span>{{ $room->max_guests }} guests</span>
                                            </div>
                                            <div class="detail-item price">
                                                <i class="fas fa-tag me-1"></i>
                                                <span>₱{{ number_format($room->price_per_night, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($room->description)
                                        <div class="amenities-section">
                                            <h6>Amenities:</h6>
                                            <div class="amenities-list">
                                                @php
                                                    $amenities = explode('•', $room->description);
                                                @endphp
                                                @foreach ($amenities as $amenity)
                                                    @php
                                                        $amenity = trim($amenity);
                                                    @endphp
                                                    @if (!empty($amenity))
                                                        <div class="amenity-item">
                                                            <i class="fas fa-check me-1"></i>
                                                            {{ $amenity }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Display Room Rehab Reason if applicable --}}
                                    @if (($room->status ?? '') === 'maintenance' && $room->rehab_reason)
                                        <div class="rehab-reason">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <span>{{ $room->rehab_reason }}</span>
                                        </div>
                                    @endif

                                    <div class="accommodation-actions">
                                        @php
                                            $canBook = $room->status === 'open' && $room->admin_status === 'approved' && in_array($resort->status, ['open', 'rehab']);
                                        @endphp
                                        @if ($canBook)
                                            @auth
                                                <a href="{{ route('booking.create', $room->id) }}" class="btn btn-primary accommodation-btn">
                                                    <i class="fas fa-calendar-plus me-2"></i>Book Now
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-primary accommodation-btn"
                                                   data-bs-toggle="modal" data-bs-target="#loginRequiredModal"
                                                   data-room-id="{{ $room->id }}" data-room-name="{{ $room->room_name }}">
                                                    <i class="fas fa-calendar-plus me-2"></i>Book Now
                                                </a>
                                            @endauth
                                        @elseif ($room->admin_status !== 'approved')
                                            <button class="btn btn-secondary accommodation-btn" disabled>
                                                <i class="fas fa-clock me-2"></i>Awaiting Approval
                                            </button>
                                        @elseif ($room->status === 'closed')
                                            <button class="btn btn-secondary accommodation-btn" disabled>
                                                <i class="fas fa-times-circle me-2"></i>Closed
                                            </button>
                                        @elseif ($room->status === 'maintenance')
                                            <button class="btn btn-secondary accommodation-btn" disabled>
                                                <i class="fas fa-tools me-2"></i>Under Maintenance
                                            </button>
                                        @else
                                            <button class="btn btn-secondary accommodation-btn" disabled>
                                                <i class="fas fa-ban me-2"></i>Unavailable
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-accommodations">
                                <div class="empty-icon">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <h3 class="empty-title">No Accommodations Available</h3>
                                <p class="empty-message">This resort doesn't have any {{ request('show', 'rooms') }} available yet. Please check back later!</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>

{{-- Login Modal --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginRequiredModalLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>You must be logged in to book <strong id="roomNameForLogin"></strong>.</p>
                <p>Please log in or register to continue.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('login') }}" class="btn btn-book-now">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
            </div>
        </div>
    </div>
</div>

{{-- JS --}}
<script>
    function handleImageError(imgElement, fallbackPath) {
        imgElement.onerror = null;
        imgElement.src = fallbackPath;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.btn-book-now').forEach(button => {
            button.addEventListener('click', () => {
                const roomName = button.getAttribute('data-room-name');
                if (roomName) {
                    document.getElementById('roomNameForLogin').textContent = roomName;
                }
            });
        });
    });
</script>

<style>
    /* ===== MODERN EXPLORE RESORT DETAILS PAGE STYLES ===== */
    
    /* ===== RESORT HEADER SECTION ===== */
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

    .resort-status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        margin-top: 1rem;
    }

    .status-open {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .status-closed {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .status-maintenance {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
    }

    .status-unknown {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
    }

    /* ===== STATUS ALERTS ===== */
    .status-alert {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .maintenance-alert {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border: 2px solid #ffc107;
    }

    .closed-alert {
        background: linear-gradient(135deg, #f8d7da, #fab1a0);
        border: 2px solid #dc3545;
    }

    .alert-icon {
        font-size: 2rem;
        margin-right: 1rem;
        color: #856404;
    }

    .closed-alert .alert-icon {
        color: #721c24;
    }

    .alert-content h5 {
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .alert-content p {
        margin: 0;
        font-size: 1rem;
    }

    /* ===== CONTACT INFORMATION SECTION ===== */
    .contact-info-section {
        margin-bottom: 3rem;
    }

    .contact-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .contact-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 2px solid rgba(0, 123, 255, 0.1);
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 123, 255, 0.15);
        border-color: rgba(0, 123, 255, 0.3);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.5rem;
    }

    .contact-card:nth-child(1) .contact-icon {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .contact-card:nth-child(2) .contact-icon {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .contact-details h6 {
        margin: 0 0 0.5rem 0;
        font-weight: 700;
        color: #2c3e50;
    }

    .contact-details p {
        margin: 0;
        color: #6c757d;
    }

    .facebook-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .facebook-link:hover {
        color: #0056b3;
    }

    /* ===== ACCOMMODATIONS SECTION ===== */
    .accommodations-section {
        margin-bottom: 3rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .accommodation-tabs {
        display: flex;
        gap: 0.5rem;
    }

    .accommodation-tab {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
        border: 2px solid transparent;
    }

    .accommodation-tab:hover {
        background: rgba(0, 123, 255, 0.2);
        color: #0056b3;
        transform: translateY(-2px);
    }

    .accommodation-tab.active {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    /* ===== ACCOMMODATION CARDS ===== */
    .accommodations-grid {
        margin-top: 2rem;
    }

    .modern-accommodation-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid rgba(0, 123, 255, 0.1);
        overflow: hidden;
        height: 100%;
        position: relative;
    }

    .modern-accommodation-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 123, 255, 0.15);
        border-color: rgba(0, 123, 255, 0.3);
    }

    /* Accommodation Image Container */
    .accommodation-image-container {
        position: relative;
        overflow: hidden;
        height: 220px;
    }

    .accommodation-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .modern-accommodation-card:hover .accommodation-image {
        transform: scale(1.1);
    }

    /* Accommodation Overlay */
    .accommodation-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.8) 0%, rgba(0, 86, 179, 0.9) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modern-accommodation-card:hover .accommodation-overlay {
        opacity: 1;
    }

    .overlay-content {
        text-align: center;
        color: white;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .modern-accommodation-card:hover .overlay-content {
        transform: translateY(0);
    }

    .overlay-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .overlay-text {
        font-size: 1.1rem;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Status Badge */
    .status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    /* Accommodation Content */
    .accommodation-content {
        padding: 1.5rem;
    }

    .accommodation-header {
        margin-bottom: 1rem;
    }

    .accommodation-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .accommodation-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .detail-item.price {
        color: #28a745;
        font-weight: 600;
        font-size: 1rem;
    }

    /* Amenities Section */
    .amenities-section {
        margin: 1rem 0;
    }

    .amenities-section h6 {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
    }

    .amenities-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .amenity-item {
        display: flex;
        align-items: center;
        color: #6c757d;
        font-size: 0.85rem;
    }

    .amenity-item i {
        color: #28a745;
    }

    /* Rehab Reason */
    .rehab-reason {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-radius: 10px;
        padding: 0.75rem;
        margin: 1rem 0;
        color: #856404;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
    }

    /* Accommodation Actions */
    .accommodation-actions {
        margin-top: 1.5rem;
    }

    .accommodation-btn {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: none;
    }

    .accommodation-btn.btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .accommodation-btn.btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        background: linear-gradient(135deg, #0056b3, #004085);
    }

    .accommodation-btn.btn-secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
    }

    /* ===== EMPTY STATE ===== */
    .empty-accommodations {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 2px solid rgba(0, 123, 255, 0.1);
    }

    .empty-icon {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .empty-message {
        font-size: 1.1rem;
        color: #6c757d;
        margin: 0;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 768px) {
        .resort-header-section {
            padding: 1.5rem;
        }

        .resort-title {
            font-size: 2rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .accommodation-tabs {
            width: 100%;
            justify-content: center;
        }

        .contact-cards {
            grid-template-columns: 1fr;
        }

        .accommodation-image-container {
            height: 200px;
        }

        .accommodation-content {
            padding: 1.25rem;
        }

        .accommodation-title {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .resort-header-section {
            padding: 1rem;
        }

        .resort-title {
            font-size: 1.75rem;
        }

        .accommodation-image-container {
            height: 180px;
        }

        .accommodation-content {
            padding: 1rem;
        }

        .accommodation-title {
            font-size: 1.1rem;
        }

        .status-badge {
            top: 10px;
            right: 10px;
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }

        .accommodation-tab {
            padding: 0.6rem 1.25rem;
            font-size: 0.9rem;
        }
    }
</style>
</x-app-layout>
