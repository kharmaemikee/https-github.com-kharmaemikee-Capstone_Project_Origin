<section>
    <header>
        <p class="text-muted small">{{ __('Update your account\'s personal information.') }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-3">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="first_name" class="form-label">{{ __('First Name') }}</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus>
            @error('first_name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="middle_name" class="form-label">{{ __('Middle Name (optional)') }}</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}">
            @error('middle_name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
            @error('last_name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">{{ __('Username') }}</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
            @error('username') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="birthday" class="form-label">{{ __('Birthday') }}</label>
            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user->birthday) }}" max="{{ date('Y-m-d') }}" onchange="validateProfileAge(this)">
            @error('birthday') <div class="text-danger small">{{ $message }}</div> @enderror
            <div id="profile-age-error" class="text-danger small" style="display: none;"></div>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">{{ __('Gender') }}</label>
            <select class="form-control" id="gender" name="gender">
                <option value="">{{ __('Select Gender') }}</option>
                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
            @error('gender') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">{{ __('Nationality') }}</label>
            <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality', $user->nationality) }}">
            @error('nationality') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">{{ __('Address') }}</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
            @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success small" role="alert">{{ __('Saved.') }}</div>
            @endif
        </div>
    </form>
</section>

<script>
    // Age validation function for profile updates
    function validateProfileAge(input) {
        const birthday = new Date(input.value);
        const today = new Date();
        const ageError = document.getElementById('profile-age-error');
        
        // Check if date is in the future
        if (birthday > today) {
            ageError.textContent = 'Birthday cannot be in the future.';
            ageError.style.display = 'block';
            input.setCustomValidity('Birthday cannot be in the future.');
            return;
        }
        
        const age = today.getFullYear() - birthday.getFullYear();
        const monthDiff = today.getMonth() - birthday.getMonth();
        
        // Check if birthday has occurred this year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthday.getDate())) {
            age--;
        }
        
        if (age < 18) {
            ageError.textContent = 'You must be at least 18 years old.';
            ageError.style.display = 'block';
            input.setCustomValidity('You must be at least 18 years old.');
        } else {
            ageError.style.display = 'none';
            input.setCustomValidity('');
        }
    }
</script>