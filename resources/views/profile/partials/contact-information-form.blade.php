<section>
    <header>
        <p>{{ __('View your contact details.') }}</p>
    </header>

    <div class="contact-info-grid">
        <div class="contact-info-item">
            <div class="contact-info-icon">
                <i class="fas fa-phone"></i>
            </div>
            <div class="contact-info-content">
                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                <input type="text" class="form-control" id="phone" value="{{ Auth::user()->phone }}" readonly>
            </div>
        </div>

        <div class="contact-info-item">
            <div class="contact-info-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="contact-info-content">
                <label for="address" class="form-label">{{ __('Address') }}</label>
                <textarea class="form-control" id="address" rows="3" readonly>{{ Auth::user()->address }}</textarea>
            </div>
        </div>
    </div>
</section>