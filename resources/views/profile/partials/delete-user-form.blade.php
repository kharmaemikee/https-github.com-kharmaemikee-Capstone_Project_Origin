<section>
    <header>
        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </header>
    
    <div class="delete-account-section">
        <div class="delete-warning">
            <div class="warning-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="warning-content">
                <h6 class="warning-title">{{ __('Permanent Action') }}</h6>
                <p class="warning-text">{{ __('This action cannot be undone. All your data will be permanently deleted.') }}</p>
            </div>
        </div>
        
        <button type="button" class="btn btn-danger delete-account-btn" data-bs-toggle="modal" data-bs-target="#confirmUserDeletion">
            <i class="fas fa-trash-alt me-2"></i>{{ __('Delete Account') }}
        </button>
    </div>
    
    <div class="modal fade" id="confirmUserDeletion" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header">
                    <div class="modal-title-section">
                        <div class="modal-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h5 class="modal-title" id="confirmUserDeletionLabel">{{ __('Delete Account') }}</h5>
                            <p class="modal-subtitle">{{ __('This action cannot be undone') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="delete-confirmation-content">
                        <p class="confirmation-text">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}</p>
                        
                        <form method="post" action="{{ route('profile.destroy') }}" class="delete-form">
                            @csrf
                            @method('delete')
                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>{{ __('Password') }}
                                </label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('Enter your password to confirm') }}">
                                @error('password') 
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            
                            <div class="modal-actions">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>{{ __('Cancel') }}
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt me-2"></i>{{ __('Delete Account') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>