<section>
    <header>
        <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>
    
    <form method="post" action="{{ route('password.update') }}" class="modern-form" id="passwordUpdateForm">
        @csrf
        @method('put')
        
        <div class="form-group">
            <label for="current_password" class="form-label">
                <i class="fas fa-lock me-2"></i>{{ __('Current Password') }}
            </label>
            <div class="input-group">
                <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">
                <i class="fas fa-key me-2"></i>{{ __('New Password') }}
            </label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-check-circle me-2"></i>{{ __('Confirm Password') }}
            </label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>{{ __('Update Password') }}
            </button>
        </div>
        
        @if ($errors->updatePassword->any())
            <div class="error-message">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>{{ __('Please correct the following errors:') }}</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->updatePassword->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password').forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = this.dataset.target;
                const passwordInput = document.getElementById(targetId);
                const eyeIcon = this.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('fas', 'fa-eye');
                    eyeIcon.classList.add('fas', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('fas', 'fa-eye-slash');
                    eyeIcon.classList.add('fas', 'fa-eye');
                }
            });
        });
    });
</script>