<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        <div class="main-content flex-grow-1">
            {{-- Main Content Area (Resort Details and Rooms) --}}
            <div class="container-fluid flex-grow-1 p-3 p-md-4">
                {{-- Enhanced Header Section --}}
                <div class="resort-header-section mb-5">
                <div class="resort-header-content">
                    <div class="resort-title-section">
                        <h1 class="resort-title mb-3">
                            <i class="fas fa-hotel text-primary me-3"></i>{{ $resort->resort_name }}
                        </h1>
                        {{-- Display Resort Status Badge --}}
                        @php
                            $resortStatusClass = '';
                            $resortStatusText = ucfirst($resort->status ?? 'Unknown');
                            switch ($resort->status) {
                                case 'open':
                                    $resortStatusClass = 'status-open';
                                    break;
                                case 'closed':
                                    $resortStatusClass = 'status-closed';
                                    break;
                                case 'maintenance':
                                    $resortStatusClass = 'status-maintenance';
                                    break;
                                default:
                                    $resortStatusClass = 'status-unknown';
                                    break;
                            }
                        @endphp
                        <div class="resort-status-badge {{ $resortStatusClass }}">
                            <i class="fas fa-circle me-2"></i>{{ $resortStatusText }}
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
                                             alt="{{ $room->room_name }}" />
                                        
                                        <div class="accommodation-overlay">
                                            <div class="overlay-content">
                                                <i class="fas fa-eye overlay-icon"></i>
                                                <span class="overlay-text">View Details</span>
                                            </div>
                                        </div>

                                        {{-- Room Status Badge --}}
                                        @php
                                            $roomStatusClass = '';
                                            $roomStatusText = ucfirst($room->status ?? 'Unknown');
                                            switch ($room->status) {
                                                case 'open':
                                                    $roomStatusClass = 'status-open';
                                                    break;
                                                case 'closed':
                                                    $roomStatusClass = 'status-closed';
                                                    break;
                                                case 'rehab':
                                                    $roomStatusClass = 'status-rehab';
                                                    break;
                                                default:
                                                    $roomStatusClass = 'status-unknown';
                                                    break;
                                            }
                                        @endphp
                                        <div class="status-badge {{ $roomStatusClass }}">
                                            <i class="fas fa-circle me-1"></i>
                                            {{ $roomStatusText }}
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
                                            
                                            {{-- Star Rating Display --}}
                                            <div class="room-rating">
                                                <div class="stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($room->average_rating))
                                                            <i class="fas fa-star text-warning"></i>
                                                        @elseif($i - 0.5 <= $room->average_rating)
                                                            <i class="fas fa-star-half-alt text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="rating-text">
                                                    {{ number_format($room->average_rating, 1) }}
                                                    ({{ $room->rating_count }} {{ $room->rating_count == 1 ? 'review' : 'reviews' }})
                                                </span>
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
                                        @if (($room->status ?? '') === 'rehab' && $room->rehab_reason)
                                            <div class="rehab-reason">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                <span>{{ $room->rehab_reason }}</span>
                                            </div>
                                        @endif

                                        <div class="accommodation-actions">
                                            {{-- View Images Button --}}
                                            @if($room->images && $room->images->count() > 0)
                                                <button type="button" class="btn btn-outline-info accommodation-btn mb-2 view-room-images-btn"
                                                        data-room-id="{{ $room->id }}"
                                                        data-room-name="{{ $room->room_name }}"
                                                        data-room-images="{{ $room->images->pluck('image_path')->toJson() }}">
                                                    <i class="fas fa-images me-2"></i>View Images
                                                </button>
                                            @endif
                                            
                                            {{-- See Feedback Button --}}
                                            @if($room->rating_count > 0)
                                                <a href="{{ route('feedback.room', $room->id) }}" class="btn btn-outline-success accommodation-btn mb-2">
                                                    <i class="fas fa-comments me-2"></i>See Feedback
                                                </a>
                                            @endif
                                            
                                            @if ($room->status === 'open' && ($resort->status === 'open' || $resort->status === 'rehab'))
                                                <a href="#" class="btn btn-primary accommodation-btn"
                                                   data-bs-toggle="modal" data-bs-target="#termsAndConditionsModal"
                                                   data-room-id="{{ $room->id }}"
                                                   data-room-name="{{ $room->room_name }}">
                                                    <i class="fas fa-calendar-plus me-2"></i>Book Now
                                                </a>
                                            @elseif ($room->status === 'closed')
                                                <button class="btn btn-secondary accommodation-btn" disabled>
                                                    <i class="fas fa-times-circle me-2"></i>Closed
                                                </button>
                                            @elseif ($room->status === 'rehab')
                                                <button class="btn btn-secondary accommodation-btn" disabled>
                                                    <i class="fas fa-tools me-2"></i>Under Rehab
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

    {{-- Room Details Modal (Existing) --}}
    <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomDetailsModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalRoomImage" src="" class="img-fluid rounded mb-3" alt="Room Image" style="width: 100%; max-height: 400px; object-fit: cover;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h4 id="modalRoomName" class="mb-0"></h4>
                        <span id="modalRoomStatus" class="badge fs-6 px-3 py-1 rounded-pill"></span>
                    </div>
                    <p class="text-muted mb-1">
                        {{-- Max Guests Icon in Modal --}}
                        <i class="bi bi-people-fill me-1"></i> Max Guests: <span id="modalRoomMaxGuests"></span>
                    </p>
                    <p class="text-muted mb-3">
                        {{-- Price Icon in Modal --}}
                        <i class="bi bi-currency-dollar me-1"></i> Price: <span id="modalRoomPrice"></span>
                    </p>
                    <div id="modalRoomDescription" class="mb-3"></div>
                    <p id="modalRoomRehabReason" class="text-danger small mt-0 mb-0"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- The "Book Now" button in the modal will now trigger the terms and conditions modal --}}
                    <a href="#" id="modalBookNowBtn" class="btn btn-book-now d-none"
                        data-bs-toggle="modal" data-bs-target="#termsAndConditionsModal">Book Now</a>
                </div>
            </div>
        </div>
    </div>

    {{-- NEW: Terms and Conditions Modal --}}
    <div class="modal fade" id="termsAndConditionsModal" tabindex="-1" aria-labelledby="termsAndConditionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header terms-modal-header">
                    <div class="d-flex flex-column">
                        <h5 class="modal-title m-0 d-flex align-items-center gap-2" id="termsAndConditionsModalLabel">
                            <i class="fas fa-bell"></i>
                         REMINDERS <small class="text-white-50 ms-1">for <span id="roomNameForTerms"></span></small>
                        </h5>
                        <small class="text-white-75 modal-subtitle">Please review before continuing your booking.</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-2">Please read the following terms and conditions carefully before proceeding with your booking.</p>
                    <div class="terms-box mb-3">
                        <h6>Terms and Conditions</h6>

                        <h6>Section 1. Boat Assignment</h6>
                        <p>- All boats for transfer and island hopping shall be automatically assigned by the system based on the departure time provided by the tourist.</p>

                        <h6>Section 2. Check-In and Check-Out</h6>
                        <ul class="mb-2">
                            <li>Check-in Time: 2:00 PM</li>
                            <li>Check-out Time: 12:00 Noon</li>
                        </ul>

                        <h6>Section 3. Towels and Amenities</h6>
                        <ul class="mb-2">
                            <li>One (1) towel is provided for Single Rooms, two (2) towels for Quad Rooms, and six (6) towels for Family Rooms.</li>
                            <li>Extra towels may be requested at ₱50.00 per piece.</li>
                            <li>Guests are advised to bring extra towels for personal use.</li>
                        </ul>

                        <h6>Section 4. Cancellation, Refund, and Amendments</h6>
                        <p>- Once confirmed, bookings are strictly non-cancellable, non-refundable, and non-amendable.</p>

                        <h6>Section 5. No-Show Policy</h6>
                        <p>- Guests who fail to arrive on the booking date will have their reservation automatically forfeited without refund.</p>

                        <h6>Section 6. Rebooking</h6>
                        <p>- Rebooking is only allowed in the event of bad weather or official travel suspension.</p>

                        <h6>Section 7. Changes in Booking</h6>
                        <p>- If there are changes and/or additional person, inform us at least 1 week before dates of travel.</p>

                        <h6>Section 8. Additional Guests and Extra Beds</h6>
                        <p>- An additional charge of ₱500.00 per head applies for extra persons or extra beds.</p>

                        <h6>Section 9. Tent Accommodations</h6>
                        <ul class="mb-0">
                            <li>Entrance fee: ₱100.00 per head</li>
                            <li>Tent pitching fee: ₱300.00 per tent</li>
                        </ul>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">
                            I have read and agree to the terms and conditions.
                        </label>
                    </div>
                </div>
                <div class="modal-footer terms-modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-book-now" id="proceedToBookBtn" disabled>
                        <i class="fas fa-arrow-right me-1"></i>Proceed to Book
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Room Images Modal --}}
    <div class="modal fade" id="roomImagesModal" tabindex="-1" aria-labelledby="roomImagesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomImagesModalLabel">Room Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="room-images-container">
                                <div class="image-navigation">
                                    <button type="button" class="btn btn-outline-primary" id="prevImageBtn" disabled>
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </button>
                                    <span class="image-counter">
                                        <span id="currentImageIndex">1</span> of <span id="totalImages">1</span>
                                    </span>
                                    <button type="button" class="btn btn-outline-primary" id="nextImageBtn" disabled>
                                        Next <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="image-display">
                                    <img id="roomImageDisplay" src="" alt="Room Image" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
            </div>
        </div>
    </div>

    <style>
        /* ===== MODERN RESORT DETAILS PAGE STYLES ===== */
        
        /* Room Images Modal Styles */
        .room-images-container {
            text-align: center;
        }
        
        .image-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0 1rem;
        }
        
        .image-counter {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
        }
        
        .image-display {
            max-height: 70vh;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .image-display img {
            width: 100%;
            height: auto;
            max-height: 70vh;
            object-fit: contain;
        }
        
        .view-room-images-btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        /* Sidebar Navigation */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

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
            
            .modern-navbar {
                left: 0;
                width: 100%;
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

        /* Simple Terms Box Styling */
        .terms-box {
            max-height: 320px;
            overflow-y: auto;
            padding: 1rem 1.25rem;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }
        .terms-box h6 {
            font-weight: 700;
            color: #2c3e50;
            margin: 1rem 0 .25rem 0;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .terms-box h6::before {
            content: '\f15c'; /* fa-file-lines */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #007bff;
            font-size: .9rem;
        }
        .terms-box p { margin: .25rem 0 .5rem 0; color: #445; }
        .terms-box ul { margin: .25rem 0 .75rem 1.1rem; }
        .terms-box li { margin: .15rem 0; color: #445; }

        /* Terms Modal Styling */
        .terms-modal-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            border-bottom: none;
        }
        .terms-modal-footer {
            background: #f8f9fa;
            border-top: none;
        }
        .modal-subtitle { font-size: .85rem; }

        /* Room Rating Styles */
        .room-rating {
            margin-top: 0.75rem;
            padding: 0.5rem 0;
            border-top: 1px solid #e9ecef;
        }

        .room-rating .stars {
            display: flex;
            gap: 2px;
            margin-bottom: 0.25rem;
        }

        .room-rating .stars i {
            font-size: 0.9rem;
        }

        .room-rating .rating-text {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
        }
    </style>

    {{-- Custom JavaScript for image error handling, mobile sidebar behavior, and modals --}}
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
                    // Bootstrap's 'md' breakpoint is 768px
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }

            // JavaScript for handling the room details modal
            var roomDetailsModal = document.getElementById('roomDetailsModal');
            var termsAndConditionsModal = document.getElementById('termsAndConditionsModal');
            var proceedToBookBtn = document.getElementById('proceedToBookBtn');
            var agreeTermsCheckbox = document.getElementById('agreeTerms');
            var roomNameForTerms = document.getElementById('roomNameForTerms');
            var selectedRoomId = null; // To store the ID of the room being booked

            // Query modal elements once for efficiency
            var modalTitle = roomDetailsModal.querySelector('.modal-title');
            var modalRoomImage = roomDetailsModal.querySelector('#modalRoomImage');
            var modalRoomName = roomDetailsModal.querySelector('#modalRoomName');
            var modalRoomStatus = roomDetailsModal.querySelector('#modalRoomStatus');
            var modalRoomMaxGuests = roomDetailsModal.querySelector('#modalRoomMaxGuests');
            var modalRoomPrice = roomDetailsModal.querySelector('#modalRoomPrice');
            var modalRoomDescription = roomDetailsModal.querySelector('#modalRoomDescription');
            var modalRoomRehabReason = roomDetailsModal.querySelector('#modalRoomRehabReason');
            var modalBookNowBtn = roomDetailsModal.querySelector('#modalBookNowBtn');


            roomDetailsModal.addEventListener('show.bs.modal', function (event) {
                // Button or element that triggered the modal (now, it's the .room-card-content-clickable div or a button)
                var element = event.relatedTarget;

                // Extract info from data-* attributes
                var roomImage = element.getAttribute('data-room-image');
                var roomName = element.getAttribute('data-room-name');
                var roomDescription = element.getAttribute('data-room-description');
                var roomMaxGuests = element.getAttribute('data-room-max-guests');
                var roomPrice = element.getAttribute('data-room-price');
                var roomStatusText = element.getAttribute('data-room-status-text');
                var roomStatusClass = element.getAttribute('data-room-status-class');
                var roomRehabReason = element.getAttribute('data-room-rehab-reason');
                // Get admin_status and resort_status
                var roomAdminStatus = element.getAttribute('data-room-admin-status');
                var resortStatus = element.getAttribute('data-resort-status');
                selectedRoomId = element.getAttribute('data-room-id'); // Get the room ID from the clicked element

                // Update the modal's content.
                modalTitle.textContent = roomName; // Set modal title to room name
                modalRoomImage.src = roomImage;
                modalRoomImage.alt = roomName;
                modalRoomName.textContent = roomName;

                // Update status badge
                modalRoomStatus.textContent = roomStatusText;
                modalRoomStatus.className = 'badge fs-6 px-3 py-1 rounded-pill ' + roomStatusClass;

                modalRoomMaxGuests.textContent = roomMaxGuests;
                modalRoomPrice.textContent = roomPrice;
                // Render description as bullet list split by periods
                if (modalRoomDescription) {
                    modalRoomDescription.innerHTML = '';
                    if (roomDescription && roomDescription.trim() !== '') {
                        var items = roomDescription.split('.').map(function(s){ return s.trim(); }).filter(function(s){ return s.length > 0; });
                        if (items.length > 0) {
                            var ul = document.createElement('ul');
                            ul.style.paddingLeft = '1.25rem';
                            items.forEach(function(it){
                                var li = document.createElement('li');
                                var b = document.createElement('strong');
                                b.textContent = it + '.';
                                li.appendChild(b);
                                ul.appendChild(li);
                            });
                            modalRoomDescription.appendChild(ul);
                        } else {
                modalRoomDescription.textContent = roomDescription;
                        }
                    }
                }

                if (roomRehabReason) {
                    modalRoomRehabReason.textContent = roomRehabReason;
                    modalRoomRehabReason.classList.remove('d-none'); // Show if reason exists
                } else {
                    modalRoomRehabReason.textContent = '';
                    modalRoomRehabReason.classList.add('d-none'); // Hide if no reason
                }

                // Logic for the "Book Now" button in the room details modal
                if (roomStatusText.toLowerCase() === 'open' && roomAdminStatus === 'approved' && (resortStatus === 'open' || resortStatus === 'rehab')) {
                    modalBookNowBtn.classList.remove('d-none');
                    // Ensure data attributes are correctly set for the terms and conditions modal
                    modalBookNowBtn.setAttribute('data-room-id', selectedRoomId);
                    modalBookNowBtn.setAttribute('data-room-name', roomName);
                } else {
                    modalBookNowBtn.classList.add('d-none');
                }

                // Reset terms and conditions checkbox and button state when opening room details modal
                agreeTermsCheckbox.checked = false;
                proceedToBookBtn.disabled = true;
            });

            // Event listener for the terms and conditions modal
            termsAndConditionsModal.addEventListener('show.bs.modal', function (event) {
                // The relatedTarget for this modal could be a "Book Now" button from a room card or from the room details modal
                var button = event.relatedTarget;
                var roomName = button.getAttribute('data-room-name');
                selectedRoomId = button.getAttribute('data-room-id'); // Ensure selectedRoomId is updated

                roomNameForTerms.textContent = roomName;

                // Ensure the checkbox is unchecked and button disabled when the modal opens
                agreeTermsCheckbox.checked = false;
                proceedToBookBtn.disabled = true;

                // Hide the room details modal if it's open when the terms modal is triggered
                var roomDetailsBootstrapModal = bootstrap.Modal.getInstance(roomDetailsModal);
                if (roomDetailsBootstrapModal) {
                    roomDetailsBootstrapModal.hide();
                }
            });

            agreeTermsCheckbox.addEventListener('change', function() {
                proceedToBookBtn.disabled = !this.checked;
            });

            // THIS IS THE KEY CHANGE: Redirect to fillup.blade.php with room ID
            proceedToBookBtn.addEventListener('click', function() {
                if (agreeTermsCheckbox.checked && selectedRoomId) {
                    // Redirect to the tourist/fillup route, passing the selected room ID
                    window.location.href = `{{ url('tourist/fillup') }}/${selectedRoomId}`;
                }
            });

            // Room Images Modal functionality
            const roomImagesModal = new bootstrap.Modal(document.getElementById('roomImagesModal'));
            let currentImageIndex = 0;
            let roomImages = [];

            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-room-images-btn')) {
                    const btn = e.target.closest('.view-room-images-btn');
                    const roomName = btn.getAttribute('data-room-name');
                    const imagesJson = btn.getAttribute('data-room-images');
                    
                    try {
                        roomImages = JSON.parse(imagesJson);
                        currentImageIndex = 0;
                        
                        if (roomImages.length > 0) {
                            document.getElementById('roomImagesModalLabel').textContent = `${roomName} - Room Images`;
                            updateImageDisplay();
                            updateNavigationButtons();
                            roomImagesModal.show();
                        }
                    } catch (error) {
                        console.error('Error parsing room images:', error);
                    }
                }
            });

            document.getElementById('prevImageBtn').addEventListener('click', function() {
                if (currentImageIndex > 0) {
                    currentImageIndex--;
                    updateImageDisplay();
                    updateNavigationButtons();
                }
            });

            document.getElementById('nextImageBtn').addEventListener('click', function() {
                if (currentImageIndex < roomImages.length - 1) {
                    currentImageIndex++;
                    updateImageDisplay();
                    updateNavigationButtons();
                }
            });

            function updateImageDisplay() {
                if (roomImages.length > 0) {
                    const imagePath = roomImages[currentImageIndex];
                    const img = document.getElementById('roomImageDisplay');
                    img.src = '/' + imagePath;
                    img.alt = `Room Image ${currentImageIndex + 1}`;
                }
            }

            function updateNavigationButtons() {
                const prevBtn = document.getElementById('prevImageBtn');
                const nextBtn = document.getElementById('nextImageBtn');
                const currentIndex = document.getElementById('currentImageIndex');
                const totalImages = document.getElementById('totalImages');

                prevBtn.disabled = currentImageIndex === 0;
                nextBtn.disabled = currentImageIndex === roomImages.length - 1;
                currentIndex.textContent = currentImageIndex + 1;
                totalImages.textContent = roomImages.length;
            }
        });
    </script>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
        
        /* Adjust navbar width to match sidebar */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
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
    </style>
</x-app-layout>