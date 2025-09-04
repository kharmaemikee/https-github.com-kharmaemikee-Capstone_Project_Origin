<section>
    <header>
        <p class="text-muted small">{{ __('View your contact details.') }}</p>
    </header>

    <div class="mb-3">
        <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
        <input type="text" class="form-control" id="phone" value="{{ Auth::user()->phone }}" readonly>
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">{{ __('Address') }}</label>
        <textarea class="form-control" id="address" rows="3" readonly>{{ Auth::user()->address }}</textarea>
    </div>
</section>