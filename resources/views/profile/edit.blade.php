<x-app-layout>
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <x-slot name="header">
        <div class="profile-header">
            <div class="profile-header-content">
                <div class="profile-header-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-header-text">
                    <h2 class="profile-title">{{ __('Your Profile') }}</h2>
                    <p class="profile-subtitle">{{ __('Manage your personal information and account settings') }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="profile-container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                @if(Auth::user()->role !== 'admin')
                <div class="profile-card photo-card">
                    <div class="profile-card-header">
                        <div class="profile-card-title">
                            <i class="fas fa-camera me-2"></i>
                            {{ __('Profile Photo') }}
                        </div>
                    </div>
                    <div class="profile-card-body">
                        <div class="photo-upload-section">
                            <div class="current-photo-container">
                                <div class="photo-wrapper">
                                    <img src="{{ Auth::user()->owner_image_path ? asset(Auth::user()->owner_image_path) : asset('images/default-avatar.png') }}" 
                                         alt="Current Photo" 
                                         class="current-photo"
                                         onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                    <div class="photo-overlay">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                </div>
                                <div class="photo-info">
                                    <h6 class="photo-title">{{ __('Current Photo') }}</h6>
                                    <p class="photo-description">{{ __('This photo appears in your navigation menu') }}</p>
                                </div>
                            </div>
                            
                            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="photo-upload-form" id="profilePhotoForm">
                                @csrf
                                <div class="file-upload-container">
                                    <label for="photo-upload" class="file-upload-label">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>
                                        {{ __('Choose New Photo') }}
                                    </label>
                                    <input type="file" 
                                           name="owner_image" 
                                           id="photo-upload"
                                           accept="image/jpeg,image/png" 
                                           class="file-upload-input">
                                </div>
                                <button type="submit" class="btn btn-primary photo-upload-btn">
                                    <i class="fas fa-save me-2"></i>
                                    {{ __('Update Photo') }}
                                </button>
                            </form>
                            
                            @error('owner_image') 
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div> 
                            @enderror
                            
                            @if (session('status')) 
                                <div class="success-message">
                                    <i class="fas fa-check-circle me-1"></i>
                                    {{ session('status') }}
                                </div> 
                            @endif
                            
                            <div class="file-info">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ __('Accepted formats: JPG, JPEG, PNG. Max size: 2MB') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="profile-card">
                    <div class="profile-card-header">
                        <div class="profile-card-title">
                            <i class="fas fa-user me-2"></i>
                            {{ __('Personal Information') }}
                        </div>
                    </div>
                    <div class="profile-card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="profile-card">
                    <div class="profile-card-header">
                        <div class="profile-card-title">
                            <i class="fas fa-address-book me-2"></i>
                            {{ __('Contact Information') }}
                        </div>
                    </div>
                    <div class="profile-card-body">
                        @include('profile.partials.contact-information-form')
                    </div>
                </div>

                <div class="profile-card">
                    <div class="profile-card-header">
                        <div class="profile-card-title">
                            <i class="fas fa-lock me-2"></i>
                            {{ __('Update Password') }}
                        </div>
                    </div>
                    <div class="profile-card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="profile-card danger-card">
                    <div class="profile-card-header">
                        <div class="profile-card-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ __('Delete Account') }}
                        </div>
                    </div>
                    <div class="profile-card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 for profile photo upload success --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Profile Page Modern Styling */
        .profile-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        /* Profile Header */
        .profile-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .profile-header-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .profile-header-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .profile-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
        }

        .profile-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin: 0.5rem 0 0 0;
            font-weight: 500;
        }

        /* Profile Cards */
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .profile-card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .profile-card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .profile-card-title i {
            color: #667eea;
            font-size: 1.2rem;
        }

        .profile-card-body {
            padding: 2rem;
        }

        /* Photo Card Specific Styles */
        .photo-card .profile-card-body {
            padding: 2.5rem;
        }

        .photo-upload-section {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .current-photo-container {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            border: 2px dashed #dee2e6;
        }

        .photo-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .photo-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .current-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .photo-wrapper:hover .photo-overlay {
            opacity: 1;
        }

        .photo-info {
            flex: 1;
        }

        .photo-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
        }

        .photo-description {
            color: #6c757d;
            margin: 0;
            font-size: 0.95rem;
        }

        .photo-upload-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .file-upload-container {
            position: relative;
        }

        .file-upload-label {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            text-decoration: none;
            border: none;
        }

        .file-upload-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .file-upload-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .photo-upload-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            align-self: flex-start;
        }

        .photo-upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .file-info {
            color: #6c757d;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .file-info i {
            color: #667eea;
        }

        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }

        .form-control:read-only {
            background: #f8f9fa;
            color: #6c757d;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
        }

        /* Input Group Styling */
        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border: 2px solid #e9ecef;
            border-left: none;
            background: #f8f9fa;
            color: #6c757d;
        }

        .input-group .btn:hover {
            background: #e9ecef;
            color: #495057;
        }

        /* Error and Success Messages */
        .error-message {
            color: #dc3545;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }

        .success-message {
            color: #28a745;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }

        /* Danger Card */
        .danger-card {
            border-left: 5px solid #dc3545;
        }

        .danger-card .profile-card-title {
            color: #dc3545;
        }

        .danger-card .profile-card-title i {
            color: #dc3545;
        }

        /* Section Headers */
        section header p {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem 0;
            }

            .profile-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .profile-header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .profile-title {
                font-size: 2rem;
            }

            .profile-subtitle {
                font-size: 1rem;
            }

            .profile-card-body {
                padding: 1.5rem;
            }

            .current-photo-container {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .photo-wrapper {
                width: 100px;
                height: 100px;
            }

            .photo-upload-form {
                gap: 1rem;
            }

            .file-upload-label,
            .photo-upload-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .profile-header {
                padding: 1rem;
            }

            .profile-card-body {
                padding: 1rem;
            }

            .profile-title {
                font-size: 1.8rem;
            }

            .profile-card-title {
                font-size: 1.1rem;
            }
        }

        /* Animation for form elements */
        .form-control,
        .btn,
        .profile-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Staggered animation for cards */
        .profile-card:nth-child(1) { animation-delay: 0.1s; }
        .profile-card:nth-child(2) { animation-delay: 0.2s; }
        .profile-card:nth-child(3) { animation-delay: 0.3s; }
        .profile-card:nth-child(4) { animation-delay: 0.4s; }
        .profile-card:nth-child(5) { animation-delay: 0.5s; }

        /* Modern Form Layouts */
        .modern-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-start;
            margin-top: 1rem;
        }

        /* Contact Info Grid */
        .contact-info-grid {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .contact-info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }

        .contact-info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-info-content {
            flex: 1;
        }

        .contact-info-content .form-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }

        /* Delete Account Section */
        .delete-account-section {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .delete-warning {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            border-radius: 15px;
            border: 2px solid #feb2b2;
        }

        .warning-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .warning-content {
            flex: 1;
        }

        .warning-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #c53030;
            margin: 0 0 0.5rem 0;
        }

        .warning-text {
            color: #742a2a;
            margin: 0;
            font-size: 0.95rem;
        }

        .delete-account-btn {
            align-self: flex-start;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Modern Modal */
        .modern-modal {
            border-radius: 20px;
            border: none;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        }

        .modern-modal .modal-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
        }

        .modal-title-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .modal-subtitle {
            color: #6c757d;
            margin: 0.25rem 0 0 0;
            font-size: 0.95rem;
        }

        .modern-modal .modal-body {
            padding: 2rem;
        }

        .delete-confirmation-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .confirmation-text {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }

        .delete-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        /* Responsive Form Layouts */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .contact-info-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .delete-warning {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .modal-title-section {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .modal-actions {
                flex-direction: column;
            }

            .modal-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .contact-info-item,
            .delete-warning {
                padding: 1rem;
            }

            .modern-modal .modal-header,
            .modern-modal .modal-body {
                padding: 1.5rem;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // Debug: Log session values
            console.log('Profile info updated:', @json(session('profile_info_updated')));
            console.log('Profile photo updated:', @json(session('profile_photo_updated')));
            console.log('Password updated:', @json(session('password_updated')));
            console.log('Status:', @json(session('status')));
            console.log('All session data:', @json(session()->all()));

            // Check if profile information was just updated (from server session)
            @if(session('profile_info_updated'))
                console.log('Showing profile info updated toast');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your profile information has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    console.error('SweetAlert2 not loaded');
                }
            @endif

            // Check if profile photo was just updated (from server session)
            @if(session('profile_photo_updated'))
                console.log('Showing profile photo updated toast');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your profile photo has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    console.error('SweetAlert2 not loaded');
                }
            @endif

            // Check if password was just updated (from server session)
            @if(session('password_updated'))
                console.log('Showing password updated toast');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your password has been updated',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    console.error('SweetAlert2 not loaded');
                }
            @endif
        });
    </script>
</x-app-layout>