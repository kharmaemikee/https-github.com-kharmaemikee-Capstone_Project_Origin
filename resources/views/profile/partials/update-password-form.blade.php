<section>
    <header>
        <p class="text-muted small">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>
    <form method="post" action="{{ route('password.update') }}" class="mt-3">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
            <div class="input-group">
                <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('New Password') }}</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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