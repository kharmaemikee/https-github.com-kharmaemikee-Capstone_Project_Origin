<section>
    <header>
        <p>{{ __('Update your account\'s personal information.') }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="modern-form">
        @csrf
        @method('patch')

        <div class="form-row">
            <div class="form-group">
                <label for="first_name" class="form-label">
                    <i class="fas fa-user me-2"></i>{{ __('First Name') }}
                </label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus>
                @error('first_name') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name" class="form-label">
                    <i class="fas fa-user me-2"></i>{{ __('Last Name') }}
                </label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                @error('last_name') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="middle_name" class="form-label">
                    <i class="fas fa-user me-2"></i>{{ __('Middle Name (optional)') }}
                </label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}">
                @error('middle_name') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="username" class="form-label">
                    <i class="fas fa-at me-2"></i>{{ __('Username') }}
                </label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                @error('username') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="birthday" class="form-label">
                    <i class="fas fa-birthday-cake me-2"></i>{{ __('Birthday') }}
                </label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user->birthday) }}" max="{{ date('Y-m-d') }}" onchange="validateProfileAge(this)">
                @error('birthday') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
                <div id="profile-age-error" class="error-message" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">
                    <i class="fas fa-venus-mars me-2"></i>{{ __('Gender') }}
                </label>
                <select class="form-control" id="gender" name="gender">
                    <option value="">{{ __('Select Gender') }}</option>
                    <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                    <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                    <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                </select>
                @error('gender') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nationality" class="form-label">
                    <i class="fas fa-flag me-2"></i>{{ __('Nationality') }}
                </label>
                <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality', $user->nationality) }}">
                @error('nationality') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
            </div>

            <div class="form-group">
                <label for="address" class="form-label">
                    <i class="fas fa-map-marker-alt me-2"></i>{{ __('Address') }}
                </label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                @error('address') 
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div> 
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>{{ __('Save Changes') }}
            </button>
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