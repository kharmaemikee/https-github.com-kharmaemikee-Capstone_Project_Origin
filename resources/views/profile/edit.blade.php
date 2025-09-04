<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title text-dark">{{ __('Personal Information') }}</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-dark mb-0">{{ __('Profile Photo') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ Auth::user()->owner_image_path ? asset(Auth::user()->owner_image_path) : asset('images/default-avatar.png') }}" alt="Current Photo" class="rounded-circle me-3" style="width:64px;height:64px;object-fit:cover;border:1px solid #007bff;">
                            <div>
                                <div class="text-muted small mb-1">{{ __('This photo appears in your navigation menu.') }}</div>
                                @if(in_array(Auth::user()->role, ['resort_owner', 'boat_owner']))
                                    <div class="text-warning small mb-2">
                                        <i class="fas fa-info-circle"></i> 
                                        {{ __('New photos require admin approval before appearing in navigation.') }}
                                    </div>
                                @endif
                                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="file" name="owner_image" accept="image/jpeg,image/png" class="form-control" style="max-width:300px;">
                                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Change Photo') }}</button>
                                </form>
                                @error('owner_image') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                                @if (session('status')) <div class="text-success small mt-2">{{ session('status') }}</div> @endif
                            </div>
                        </div>
                        <div class="small text-muted">{{ __('Accepted formats: JPG, JPEG, PNG. Max size: 2MB.') }}</div>
                        @if(in_array(Auth::user()->role, ['resort_owner', 'boat_owner']) && Auth::user()->owner_image_path)
                            <div class="small mt-2">
                                @if(Auth::user()->owner_pic_approved)
                                    <span class="text-success"><i class="fas fa-check-circle"></i> {{ __('Photo approved and visible in navigation') }}</span>
                                @else
                                    <span class="text-warning"><i class="fas fa-clock"></i> {{ __('Photo pending admin approval') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title text-dark">{{ __('Contact Information') }}</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.contact-information-form')
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title text-dark">{{ __('Update Password') }}</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title text-dark">{{ __('Delete Account') }}</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>