@if ($images->isEmpty())
    <div class="empty-gallery">
        <div class="empty-gallery-icon">
            <i class="fas fa-images"></i>
        </div>
        <h5 class="empty-gallery-title">No Images Available</h5>
        <p class="empty-gallery-text">This room doesn't have any images uploaded yet.</p>
    </div>
@else
    <div id="roomImagesCarousel" class="carousel slide modern-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($images as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="image-container">
                        <img src="{{ asset($image->image_path) }}" class="d-block w-100 gallery-image" alt="Room Image">
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev modern-carousel-prev" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next modern-carousel-next" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @if (count($images) > 1)
            <div class="carousel-indicators modern-carousel-indicators">
                @foreach ($images as $index => $image)
                    <button type="button" data-bs-target="#roomImagesCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </div>
    @if ($room->description)
        <div class="amenities-section">
            <h6 class="amenities-title">
                <i class="fas fa-star me-2"></i>
                Room Amenities
            </h6>
            @php
                $amenities = preg_split('/[•\n,]+/', $room->description);
            @endphp
            <div class="amenities-grid">
                @foreach ($amenities as $amenity)
                    @php $amenity = trim($amenity); @endphp
                    @if (!empty($amenity))
                        <div class="amenity-item">
                            <i class="fas fa-check amenity-icon"></i>
                            <span class="amenity-text">{{ $amenity }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
@endif


