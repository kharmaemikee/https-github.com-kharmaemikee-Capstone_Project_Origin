<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Rate Your Experience</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Booking Details:</h5>
                        <p><strong>Resort:</strong> {{ $booking->name_of_resort }}</p>
                        <p><strong>Room:</strong> {{ $booking->room->room_name }}</p>
                        <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</p>
                        @if($booking->check_out_date)
                            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</p>
                        @endif
                    </div>

                    <form action="{{ route('ratings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                        <div class="mb-4">
                            <label for="rating" class="form-label">Rating *</label>
                            <div class="rating-input">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star" data-rating="{{ $i }}">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="" required>
                                <div class="rating-text mt-2">
                                    <span id="rating-text">Click on a star to rate</span>
                                </div>
                            </div>
                            @error('rating')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label">Comment (Optional)</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Share your experience with other travelers...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tourist.notifications') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Submit Rating</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating-input .stars {
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
}

.rating-input .star {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.rating-input .star:hover,
.rating-input .star.active {
    color: #ffc107;
}

.rating-input .star:hover ~ .star {
    color: #ddd;
}

.rating-text {
    font-weight: 500;
    color: #666;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('rating-text');
    const submitBtn = document.getElementById('submit-btn');
    
    const ratingTexts = {
        1: 'Poor - 1 star',
        2: 'Fair - 2 stars',
        3: 'Good - 3 stars',
        4: 'Very Good - 4 stars',
        5: 'Excellent - 5 stars'
    };

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = index + 1;
            ratingInput.value = rating;
            
            // Update star display
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            
            // Update text
            ratingText.textContent = ratingTexts[rating];
            
            // Enable submit button
            submitBtn.disabled = false;
        });

        star.addEventListener('mouseenter', function() {
            const rating = index + 1;
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    });

    // Reset stars on mouse leave
    document.querySelector('.stars').addEventListener('mouseleave', function() {
        const currentRating = ratingInput.value;
        stars.forEach((s, i) => {
            if (i < currentRating) {
                s.style.color = '#ffc107';
            } else {
                s.style.color = '#ddd';
            }
        });
    });
});
</script>
</x-app-layout>
