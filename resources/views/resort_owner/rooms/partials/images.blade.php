@if ($images->isEmpty())
    <div class="text-center text-muted">No images uploaded.</div>
@else
    <div id="roomImagesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($images as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset($image->image_path) }}" class="d-block w-100" alt="Room Image" style="max-height: 500px; object-fit: contain;">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @if (count($images) > 1)
            <div class="carousel-indicators">
                @foreach ($images as $index => $image)
                    <button type="button" data-bs-target="#roomImagesCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </div>
    @if ($room->description)
        <div class="mt-4">
            <h6 class="mb-2">Amenities</h6>
            @php
                $amenities = preg_split('/[•\n,]+/', $room->description);
            @endphp
            <ul class="list-unstyled mb-0">
                @foreach ($amenities as $amenity)
                    @php $amenity = trim($amenity); @endphp
                    @if (!empty($amenity))
                        <li class="d-flex align-items-center mb-1 text-muted">
                            <i class="fas fa-check text-success me-2"></i>
                            <span>{{ $amenity }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
@endif


