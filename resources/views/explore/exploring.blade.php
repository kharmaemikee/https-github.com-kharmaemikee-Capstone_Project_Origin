<x-explore-layout>
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Main Content Area (Resorts List) --}}
        <div class="container-fluid flex-grow-1 p-3 p-md-4">
            {{-- Enhanced Header Section --}}
            <div class="header-section mb-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                    <div class="header-content">
                        <h1 class="page-title mb-2">
                            <i class="fas fa-compass text-primary me-3"></i>Explore Our Resorts
                        </h1>
                        <p class="page-subtitle text-muted mb-0">Discover amazing resorts and accommodations in Matnog</p>
                    </div>
                    <div class="header-actions mt-3 mt-md-0">
                        <div class="resort-count-badge">
                            <i class="fas fa-building me-2"></i>
                            <span>{{ $resorts->count() }} Resorts Available</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resorts-grid">
                <div class="row g-4">
                    @forelse ($resorts as $resort)
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="resort-card modern-resort-card">
                                <div class="resort-image-container">
                                    @if ($resort->image_path)
                                        <img src="{{ asset($resort->image_path) }}"
                                             class="resort-image"
                                             alt="{{ $resort->resort_name }}"
                                             onerror="handleImageError(this, '{{ asset('images/default_resort.png') }}')">
                                    @else
                                        <img src="{{ asset('images/default_resort.png') }}"
                                             class="resort-image"
                                             alt="Default Resort Image">
                                    @endif
                                    
                                    <div class="resort-overlay">
                                        <div class="overlay-content">
                                            <i class="fas fa-eye overlay-icon"></i>
                                            <span class="overlay-text">View Resort</span>
                                        </div>
                                    </div>

                                    {{-- Resort Status Badge --}}
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
                                            case 'rehab':
                                                $resortStatusClass = 'status-rehab';
                                                break;
                                            default:
                                                $resortStatusClass = 'status-unknown';
                                                break;
                                        }
                                    @endphp
                                    <div class="status-badge {{ $resortStatusClass }}">
                                        <i class="fas fa-circle me-1"></i>
                                        {{ $resortStatusText }}
                                    </div>
                                </div>

                                <div class="resort-content">
                                    <div class="resort-header">
                                        <h3 class="resort-title">{{ $resort->resort_name }}</h3>
                                        <div class="resort-location">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $resort->location }}
                                        </div>
                                    </div>

                                    {{-- Display Rehab Reason for Resort if applicable --}}
                                    @if (($resort->status ?? '') === 'rehab' && $resort->rehab_reason)
                                        <div class="rehab-reason">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <span>{{ $resort->rehab_reason }}</span>
                                        </div>
                                    @endif

                                    {{-- Summary of Room Statuses --}}
                                    @php
                                        $openRoomsCount = $resort->rooms->where('status', 'open')->count();
                                    @endphp

                                    <div class="resort-actions">
                                        @if ($resort->status === 'open' && $openRoomsCount > 0)
                                            <div class="rooms-available">
                                                <i class="fas fa-bed me-1"></i>
                                                <span>{{ $openRoomsCount }} room(s) available</span>
                                            </div>
                                            <a href="{{ route('explore.show', $resort->id) }}" class="btn btn-primary resort-btn">
                                                <i class="fas fa-eye me-2"></i>View Rooms
                                            </a>
                                        @elseif ($resort->status === 'rehab')
                                            <div class="rooms-status rehab">
                                                <i class="fas fa-tools me-1"></i>
                                                <span>Under rehabilitation</span>
                                            </div>
                                            <button type="button" class="btn btn-secondary resort-btn" disabled>
                                                <i class="fas fa-ban me-2"></i>Under Rehab
                                            </button>
                                        @elseif ($resort->status === 'closed')
                                            <div class="rooms-status closed">
                                                <i class="fas fa-times-circle me-1"></i>
                                                <span>Currently closed</span>
                                            </div>
                                            <button type="button" class="btn btn-secondary resort-btn" disabled>
                                                <i class="fas fa-ban me-2"></i>Closed
                                            </button>
                                        @else
                                            <div class="rooms-status unavailable">
                                                <i class="fas fa-question-circle me-1"></i>
                                                <span>No rooms available</span>
                                            </div>
                                            <button type="button" class="btn btn-secondary resort-btn" disabled>
                                                <i class="fas fa-ban me-2"></i>Unavailable
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-hotel"></i>
                                </div>
                                <h3 class="empty-title">No Resorts Available</h3>
                                <p class="empty-message">We're working on adding more amazing resorts. Please check back later!</p>
                                <a href="{{ route('tourist.reminders') }}" class="btn btn-primary empty-btn">
                                    <i class="fas fa-info-circle me-2"></i>Learn More
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ===== MODERN EXPLORE RESORTS PAGE STYLES ===== */
        
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

        .resort-count-badge {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        /* ===== RESORT CARDS ===== */
        .resorts-grid {
            margin-top: 2rem;
        }

        .modern-resort-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(0, 123, 255, 0.1);
            overflow: hidden;
            height: 100%;
            position: relative;
        }

        .modern-resort-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 123, 255, 0.15);
            border-color: rgba(0, 123, 255, 0.3);
        }

        /* Resort Image Container */
        .resort-image-container {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .resort-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        .modern-resort-card:hover .resort-image {
            transform: scale(1.1);
        }

        /* Resort Overlay */
        .resort-overlay {
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

        .modern-resort-card:hover .resort-overlay {
            opacity: 1;
        }

        .overlay-content {
            text-align: center;
            color: white;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .modern-resort-card:hover .overlay-content {
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

        .status-open {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .status-closed {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .status-rehab {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
        }

        .status-unknown {
            background: linear-gradient(135deg, #6c757d, #495057);
        }

        /* Resort Content */
        .resort-content {
            padding: 1.5rem;
        }

        .resort-header {
            margin-bottom: 1rem;
        }

        .resort-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .resort-location {
            color: #6c757d;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .rehab-reason {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            color: #856404;
            font-size: 0.85rem;
        }

        /* Resort Actions */
        .resort-actions {
            margin-top: auto;
        }

        .rooms-available {
            background: rgba(40, 167, 69, 0.1);
            color: #155724;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .rooms-status {
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .rooms-status.rehab {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
        }

        .rooms-status.closed {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
        }

        .rooms-status.unavailable {
            background: rgba(108, 117, 125, 0.1);
            color: #383d41;
        }

        .resort-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
        }

        .resort-btn.btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .resort-btn.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
            background: linear-gradient(135deg, #0056b3, #004085);
        }

        .resort-btn.btn-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
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
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .empty-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
            background: linear-gradient(135deg, #0056b3, #004085);
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

            .resort-count-badge {
                padding: 0.6rem 1.25rem;
                font-size: 0.9rem;
            }

            .resort-image-container {
                height: 200px;
            }

            .resort-content {
                padding: 1.25rem;
            }

            .resort-title {
                font-size: 1.2rem;
            }

            .empty-state {
                padding: 3rem 1.5rem;
            }

            .empty-icon {
                font-size: 3rem;
            }

            .empty-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .header-section {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .resort-image-container {
                height: 180px;
            }

            .resort-content {
                padding: 1rem;
            }

            .resort-title {
                font-size: 1.1rem;
            }

            .status-badge {
                top: 10px;
                right: 10px;
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-icon {
                font-size: 2.5rem;
            }

            .empty-title {
                font-size: 1.3rem;
            }

            .empty-message {
                font-size: 1rem;
            }
        }
    </style>

    {{-- Custom JavaScript for image error handling --}}
    <script>
        function handleImageError(imgElement, defaultImagePath) {
            imgElement.onerror = null; // Prevent infinite loop if default image also fails
            imgElement.src = defaultImagePath;
        }
    </script>
</x-explore-layout>