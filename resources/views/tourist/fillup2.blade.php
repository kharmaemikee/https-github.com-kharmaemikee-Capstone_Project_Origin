<x-app-layout>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        {{-- Font Awesome CDN for Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        {{-- Include Shared Sidebar --}}
        @include('tourist.partials.sidebar')

        <div class="main-content flex-grow-1">
            <div class="container-fluid">
                {{-- Modern Header Section --}}
                <div class="registration-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="header-text">
                            <h1 class="page-title">Complete Your Registration</h1>
                            <p class="page-subtitle">Fill in your personal details to finalize your booking</p>
                        </div>
                    </div>
                    <div class="header-decoration">
                        <div class="decoration-circle"></div>
                        <div class="decoration-circle"></div>
                        <div class="decoration-circle"></div>
                    </div>
                </div>

                {{-- Room Availability Notification --}}
                @if(isset($conflictingBooking) && $conflictingBooking)
                    <div class="error-state">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="error-title">Room Unavailable</h3>
                        <p class="error-description">
                            Sorry! This room is no longer available for the selected date 
                            <strong>
                                @php
                                    try {
                                        echo \Carbon\Carbon::parse($requestData['reservation_date'])->format('M d, Y');
                                    } catch(\Exception $e) {
                                        echo $requestData['reservation_date'];
                                    }
                                @endphp
                            </strong>.
                        </p>
                        <div class="conflict-details">
                            <p><strong>Conflicting Booking:</strong></p>
                            <p>Guest: {{ $conflictingBooking->guest_name }} | 
                            Date: 
                            @php
                                try {
                                    echo \Carbon\Carbon::parse($conflictingBooking->check_in_date)->format('M d, Y');
                                } catch(\Exception $e) {
                                    echo $conflictingBooking->check_in_date;
                                }
                            @endphp</p>
                        </div>
                        <div class="error-actions">
                            <a href="{{ route('tourist.list') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Go Back to Rooms.
                            </a>
                            <a href="{{ route('tourist.list') }}" class="btn btn-secondary">
                                <i class="fas fa-search"></i> Find Available Rooms
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Display success or error messages --}}
                @if (session('success'))
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="success-content">
                            <h4>Success!</h4>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="error-content">
                            <h4>Error!</h4>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="registration-container">
                    <div class="registration-form-card">
                        <div class="form-header">
                            <h3 class="form-title">
                                <i class="fas fa-edit"></i>
                                Personal Information
                            </h3>
                            <p class="form-subtitle">Please provide your personal details to complete the booking</p>
                        </div>
                        
                        <form action="{{ route('bookings.store') }}" method="POST" class="registration-form" enctype="multipart/form-data">
                            @csrf
                            {{-- Hidden fields to carry over data from fillup.blade.php --}}
                            {{-- Use old() helper to retain values on validation failure --}}
                            <input type="hidden" name="room_id" value="{{ old('room_id', $requestData['room_id'] ?? '') }}">
                            
                            {{-- Tourist Account Information --}}
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-user-circle"></i>
                                    Tourist Account Information
                                </h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            First Name
                                        </label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Enter your first name" value="{{ old('first_name', $user->first_name ?? '') }}" required>
                                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Middle Name
                                        </label>
                                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" placeholder="Enter your middle name (optional)" value="{{ old('middle_name', $user->middle_name ?? '') }}">
                                        @error('middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Last Name
                                        </label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Enter your last name" value="{{ old('last_name', $user->last_name ?? '') }}" required>
                                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Address field - full width --}}
                            <div class="form-section">
                                <div class="form-group full-width">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Address
                                    </label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter your complete address" value="{{ old('address', $user->address ?? '') }}" required>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>


                            {{-- Primary Guest Information --}}
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-user-friends"></i>
                                    Primary Guest Information
                                </h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Primary Guest Name
                                        </label>
                                        <input type="text" class="form-control @error('guest_name') is-invalid @enderror" name="guest_name" placeholder="Enter primary guest name" value="{{ old('guest_name', $user->first_name . ' ' . $user->last_name ?? '') }}" required>
                                        @error('guest_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="help-text">This is the main guest for the booking (usually the tourist making the booking)</small>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-flag"></i>
                                            Nationality
                                        </label>
                                        <select class="form-control @error('nationality') is-invalid @enderror" name="nationality" required>
                                            <option value="">Select your nationality</option>
                                            <option value="Afghan" {{ old('nationality', $user->nationality ?? '') == 'Afghan' ? 'selected' : '' }}>Afghan</option>
                                            <option value="Albanian" {{ old('nationality', $user->nationality ?? '') == 'Albanian' ? 'selected' : '' }}>Albanian</option>
                                            <option value="Algerian" {{ old('nationality', $user->nationality ?? '') == 'Algerian' ? 'selected' : '' }}>Algerian</option>
                                            <option value="American" {{ old('nationality', $user->nationality ?? '') == 'American' ? 'selected' : '' }}>American</option>
                                            <option value="Andorran" {{ old('nationality', $user->nationality ?? '') == 'Andorran' ? 'selected' : '' }}>Andorran</option>
                                            <option value="Angolan" {{ old('nationality', $user->nationality ?? '') == 'Angolan' ? 'selected' : '' }}>Angolan</option>
                                            <option value="Antiguan" {{ old('nationality', $user->nationality ?? '') == 'Antiguan' ? 'selected' : '' }}>Antiguan</option>
                                            <option value="Argentine" {{ old('nationality', $user->nationality ?? '') == 'Argentine' ? 'selected' : '' }}>Argentine</option>
                                            <option value="Armenian" {{ old('nationality', $user->nationality ?? '') == 'Armenian' ? 'selected' : '' }}>Armenian</option>
                                            <option value="Australian" {{ old('nationality', $user->nationality ?? '') == 'Australian' ? 'selected' : '' }}>Australian</option>
                                            <option value="Austrian" {{ old('nationality', $user->nationality ?? '') == 'Austrian' ? 'selected' : '' }}>Austrian</option>
                                            <option value="Azerbaijani" {{ old('nationality', $user->nationality ?? '') == 'Azerbaijani' ? 'selected' : '' }}>Azerbaijani</option>
                                            <option value="Bahamian" {{ old('nationality', $user->nationality ?? '') == 'Bahamian' ? 'selected' : '' }}>Bahamian</option>
                                            <option value="Bahraini" {{ old('nationality', $user->nationality ?? '') == 'Bahraini' ? 'selected' : '' }}>Bahraini</option>
                                            <option value="Bangladeshi" {{ old('nationality', $user->nationality ?? '') == 'Bangladeshi' ? 'selected' : '' }}>Bangladeshi</option>
                                            <option value="Barbadian" {{ old('nationality', $user->nationality ?? '') == 'Barbadian' ? 'selected' : '' }}>Barbadian</option>
                                            <option value="Belarusian" {{ old('nationality', $user->nationality ?? '') == 'Belarusian' ? 'selected' : '' }}>Belarusian</option>
                                            <option value="Belgian" {{ old('nationality', $user->nationality ?? '') == 'Belgian' ? 'selected' : '' }}>Belgian</option>
                                            <option value="Belizean" {{ old('nationality', $user->nationality ?? '') == 'Belizean' ? 'selected' : '' }}>Belizean</option>
                                            <option value="Beninese" {{ old('nationality', $user->nationality ?? '') == 'Beninese' ? 'selected' : '' }}>Beninese</option>
                                            <option value="Bhutanese" {{ old('nationality', $user->nationality ?? '') == 'Bhutanese' ? 'selected' : '' }}>Bhutanese</option>
                                            <option value="Bolivian" {{ old('nationality', $user->nationality ?? '') == 'Bolivian' ? 'selected' : '' }}>Bolivian</option>
                                            <option value="Bosnian" {{ old('nationality', $user->nationality ?? '') == 'Bosnian' ? 'selected' : '' }}>Bosnian</option>
                                            <option value="Botswanan" {{ old('nationality', $user->nationality ?? '') == 'Botswanan' ? 'selected' : '' }}>Botswanan</option>
                                            <option value="Brazilian" {{ old('nationality', $user->nationality ?? '') == 'Brazilian' ? 'selected' : '' }}>Brazilian</option>
                                            <option value="British" {{ old('nationality', $user->nationality ?? '') == 'British' ? 'selected' : '' }}>British</option>
                                            <option value="Bruneian" {{ old('nationality', $user->nationality ?? '') == 'Bruneian' ? 'selected' : '' }}>Bruneian</option>
                                            <option value="Bulgarian" {{ old('nationality', $user->nationality ?? '') == 'Bulgarian' ? 'selected' : '' }}>Bulgarian</option>
                                            <option value="Burkinabé" {{ old('nationality', $user->nationality ?? '') == 'Burkinabé' ? 'selected' : '' }}>Burkinabé</option>
                                            <option value="Burundian" {{ old('nationality', $user->nationality ?? '') == 'Burundian' ? 'selected' : '' }}>Burundian</option>
                                            <option value="Cambodian" {{ old('nationality', $user->nationality ?? '') == 'Cambodian' ? 'selected' : '' }}>Cambodian</option>
                                            <option value="Cameroonian" {{ old('nationality', $user->nationality ?? '') == 'Cameroonian' ? 'selected' : '' }}>Cameroonian</option>
                                            <option value="Canadian" {{ old('nationality', $user->nationality ?? '') == 'Canadian' ? 'selected' : '' }}>Canadian</option>
                                            <option value="Cape Verdean" {{ old('nationality', $user->nationality ?? '') == 'Cape Verdean' ? 'selected' : '' }}>Cape Verdean</option>
                                            <option value="Central African" {{ old('nationality', $user->nationality ?? '') == 'Central African' ? 'selected' : '' }}>Central African</option>
                                            <option value="Chadian" {{ old('nationality', $user->nationality ?? '') == 'Chadian' ? 'selected' : '' }}>Chadian</option>
                                            <option value="Chilean" {{ old('nationality', $user->nationality ?? '') == 'Chilean' ? 'selected' : '' }}>Chilean</option>
                                            <option value="Chinese" {{ old('nationality', $user->nationality ?? '') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                            <option value="Colombian" {{ old('nationality', $user->nationality ?? '') == 'Colombian' ? 'selected' : '' }}>Colombian</option>
                                            <option value="Comoran" {{ old('nationality', $user->nationality ?? '') == 'Comoran' ? 'selected' : '' }}>Comoran</option>
                                            <option value="Congolese" {{ old('nationality', $user->nationality ?? '') == 'Congolese' ? 'selected' : '' }}>Congolese</option>
                                            <option value="Costa Rican" {{ old('nationality', $user->nationality ?? '') == 'Costa Rican' ? 'selected' : '' }}>Costa Rican</option>
                                            <option value="Croatian" {{ old('nationality', $user->nationality ?? '') == 'Croatian' ? 'selected' : '' }}>Croatian</option>
                                            <option value="Cuban" {{ old('nationality', $user->nationality ?? '') == 'Cuban' ? 'selected' : '' }}>Cuban</option>
                                            <option value="Cypriot" {{ old('nationality', $user->nationality ?? '') == 'Cypriot' ? 'selected' : '' }}>Cypriot</option>
                                            <option value="Czech" {{ old('nationality', $user->nationality ?? '') == 'Czech' ? 'selected' : '' }}>Czech</option>
                                            <option value="Danish" {{ old('nationality', $user->nationality ?? '') == 'Danish' ? 'selected' : '' }}>Danish</option>
                                            <option value="Djiboutian" {{ old('nationality', $user->nationality ?? '') == 'Djiboutian' ? 'selected' : '' }}>Djiboutian</option>
                                            <option value="Dominican" {{ old('nationality', $user->nationality ?? '') == 'Dominican' ? 'selected' : '' }}>Dominican</option>
                                            <option value="Dutch" {{ old('nationality', $user->nationality ?? '') == 'Dutch' ? 'selected' : '' }}>Dutch</option>
                                            <option value="Ecuadorian" {{ old('nationality', $user->nationality ?? '') == 'Ecuadorian' ? 'selected' : '' }}>Ecuadorian</option>
                                            <option value="Egyptian" {{ old('nationality', $user->nationality ?? '') == 'Egyptian' ? 'selected' : '' }}>Egyptian</option>
                                            <option value="Emirati" {{ old('nationality', $user->nationality ?? '') == 'Emirati' ? 'selected' : '' }}>Emirati</option>
                                            <option value="Equatorial Guinean" {{ old('nationality', $user->nationality ?? '') == 'Equatorial Guinean' ? 'selected' : '' }}>Equatorial Guinean</option>
                                            <option value="Eritrean" {{ old('nationality', $user->nationality ?? '') == 'Eritrean' ? 'selected' : '' }}>Eritrean</option>
                                            <option value="Estonian" {{ old('nationality', $user->nationality ?? '') == 'Estonian' ? 'selected' : '' }}>Estonian</option>
                                            <option value="Ethiopian" {{ old('nationality', $user->nationality ?? '') == 'Ethiopian' ? 'selected' : '' }}>Ethiopian</option>
                                            <option value="Fijian" {{ old('nationality', $user->nationality ?? '') == 'Fijian' ? 'selected' : '' }}>Fijian</option>
                                            <option value="Filipino" {{ old('nationality', $user->nationality ?? '') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                            <option value="Finnish" {{ old('nationality', $user->nationality ?? '') == 'Finnish' ? 'selected' : '' }}>Finnish</option>
                                            <option value="French" {{ old('nationality', $user->nationality ?? '') == 'French' ? 'selected' : '' }}>French</option>
                                            <option value="Gabonese" {{ old('nationality', $user->nationality ?? '') == 'Gabonese' ? 'selected' : '' }}>Gabonese</option>
                                            <option value="Gambian" {{ old('nationality', $user->nationality ?? '') == 'Gambian' ? 'selected' : '' }}>Gambian</option>
                                            <option value="Georgian" {{ old('nationality', $user->nationality ?? '') == 'Georgian' ? 'selected' : '' }}>Georgian</option>
                                            <option value="German" {{ old('nationality', $user->nationality ?? '') == 'German' ? 'selected' : '' }}>German</option>
                                            <option value="Ghanaian" {{ old('nationality', $user->nationality ?? '') == 'Ghanaian' ? 'selected' : '' }}>Ghanaian</option>
                                            <option value="Greek" {{ old('nationality', $user->nationality ?? '') == 'Greek' ? 'selected' : '' }}>Greek</option>
                                            <option value="Grenadian" {{ old('nationality', $user->nationality ?? '') == 'Grenadian' ? 'selected' : '' }}>Grenadian</option>
                                            <option value="Guatemalan" {{ old('nationality', $user->nationality ?? '') == 'Guatemalan' ? 'selected' : '' }}>Guatemalan</option>
                                            <option value="Guinean" {{ old('nationality', $user->nationality ?? '') == 'Guinean' ? 'selected' : '' }}>Guinean</option>
                                            <option value="Guyanese" {{ old('nationality', $user->nationality ?? '') == 'Guyanese' ? 'selected' : '' }}>Guyanese</option>
                                            <option value="Haitian" {{ old('nationality', $user->nationality ?? '') == 'Haitian' ? 'selected' : '' }}>Haitian</option>
                                            <option value="Honduran" {{ old('nationality', $user->nationality ?? '') == 'Honduran' ? 'selected' : '' }}>Honduran</option>
                                            <option value="Hungarian" {{ old('nationality', $user->nationality ?? '') == 'Hungarian' ? 'selected' : '' }}>Hungarian</option>
                                            <option value="Icelandic" {{ old('nationality', $user->nationality ?? '') == 'Icelandic' ? 'selected' : '' }}>Icelandic</option>
                                            <option value="Indian" {{ old('nationality', $user->nationality ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                            <option value="Indonesian" {{ old('nationality', $user->nationality ?? '') == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                                            <option value="Iranian" {{ old('nationality', $user->nationality ?? '') == 'Iranian' ? 'selected' : '' }}>Iranian</option>
                                            <option value="Iraqi" {{ old('nationality', $user->nationality ?? '') == 'Iraqi' ? 'selected' : '' }}>Iraqi</option>
                                            <option value="Irish" {{ old('nationality', $user->nationality ?? '') == 'Irish' ? 'selected' : '' }}>Irish</option>
                                            <option value="Israeli" {{ old('nationality', $user->nationality ?? '') == 'Israeli' ? 'selected' : '' }}>Israeli</option>
                                            <option value="Italian" {{ old('nationality', $user->nationality ?? '') == 'Italian' ? 'selected' : '' }}>Italian</option>
                                            <option value="Ivorian" {{ old('nationality', $user->nationality ?? '') == 'Ivorian' ? 'selected' : '' }}>Ivorian</option>
                                            <option value="Jamaican" {{ old('nationality', $user->nationality ?? '') == 'Jamaican' ? 'selected' : '' }}>Jamaican</option>
                                            <option value="Japanese" {{ old('nationality', $user->nationality ?? '') == 'Japanese' ? 'selected' : '' }}>Japanese</option>
                                            <option value="Jordanian" {{ old('nationality', $user->nationality ?? '') == 'Jordanian' ? 'selected' : '' }}>Jordanian</option>
                                            <option value="Kazakhstani" {{ old('nationality', $user->nationality ?? '') == 'Kazakhstani' ? 'selected' : '' }}>Kazakhstani</option>
                                            <option value="Kenyan" {{ old('nationality', $user->nationality ?? '') == 'Kenyan' ? 'selected' : '' }}>Kenyan</option>
                                            <option value="Kuwaiti" {{ old('nationality', $user->nationality ?? '') == 'Kuwaiti' ? 'selected' : '' }}>Kuwaiti</option>
                                            <option value="Kyrgyzstani" {{ old('nationality', $user->nationality ?? '') == 'Kyrgyzstani' ? 'selected' : '' }}>Kyrgyzstani</option>
                                            <option value="Laotian" {{ old('nationality', $user->nationality ?? '') == 'Laotian' ? 'selected' : '' }}>Laotian</option>
                                            <option value="Latvian" {{ old('nationality', $user->nationality ?? '') == 'Latvian' ? 'selected' : '' }}>Latvian</option>
                                            <option value="Lebanese" {{ old('nationality', $user->nationality ?? '') == 'Lebanese' ? 'selected' : '' }}>Lebanese</option>
                                            <option value="Liberian" {{ old('nationality', $user->nationality ?? '') == 'Liberian' ? 'selected' : '' }}>Liberian</option>
                                            <option value="Libyan" {{ old('nationality', $user->nationality ?? '') == 'Libyan' ? 'selected' : '' }}>Libyan</option>
                                            <option value="Liechtensteiner" {{ old('nationality', $user->nationality ?? '') == 'Liechtensteiner' ? 'selected' : '' }}>Liechtensteiner</option>
                                            <option value="Lithuanian" {{ old('nationality', $user->nationality ?? '') == 'Lithuanian' ? 'selected' : '' }}>Lithuanian</option>
                                            <option value="Luxembourgish" {{ old('nationality', $user->nationality ?? '') == 'Luxembourgish' ? 'selected' : '' }}>Luxembourgish</option>
                                            <option value="Macedonian" {{ old('nationality', $user->nationality ?? '') == 'Macedonian' ? 'selected' : '' }}>Macedonian</option>
                                            <option value="Malagasy" {{ old('nationality', $user->nationality ?? '') == 'Malagasy' ? 'selected' : '' }}>Malagasy</option>
                                            <option value="Malawian" {{ old('nationality', $user->nationality ?? '') == 'Malawian' ? 'selected' : '' }}>Malawian</option>
                                            <option value="Malaysian" {{ old('nationality', $user->nationality ?? '') == 'Malaysian' ? 'selected' : '' }}>Malaysian</option>
                                            <option value="Maldivian" {{ old('nationality', $user->nationality ?? '') == 'Maldivian' ? 'selected' : '' }}>Maldivian</option>
                                            <option value="Malian" {{ old('nationality', $user->nationality ?? '') == 'Malian' ? 'selected' : '' }}>Malian</option>
                                            <option value="Maltese" {{ old('nationality', $user->nationality ?? '') == 'Maltese' ? 'selected' : '' }}>Maltese</option>
                                            <option value="Marshallese" {{ old('nationality', $user->nationality ?? '') == 'Marshallese' ? 'selected' : '' }}>Marshallese</option>
                                            <option value="Mauritanian" {{ old('nationality', $user->nationality ?? '') == 'Mauritanian' ? 'selected' : '' }}>Mauritanian</option>
                                            <option value="Mauritian" {{ old('nationality', $user->nationality ?? '') == 'Mauritian' ? 'selected' : '' }}>Mauritian</option>
                                            <option value="Mexican" {{ old('nationality', $user->nationality ?? '') == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                                            <option value="Micronesian" {{ old('nationality', $user->nationality ?? '') == 'Micronesian' ? 'selected' : '' }}>Micronesian</option>
                                            <option value="Moldovan" {{ old('nationality', $user->nationality ?? '') == 'Moldovan' ? 'selected' : '' }}>Moldovan</option>
                                            <option value="Monacan" {{ old('nationality', $user->nationality ?? '') == 'Monacan' ? 'selected' : '' }}>Monacan</option>
                                            <option value="Mongolian" {{ old('nationality', $user->nationality ?? '') == 'Mongolian' ? 'selected' : '' }}>Mongolian</option>
                                            <option value="Montenegrin" {{ old('nationality', $user->nationality ?? '') == 'Montenegrin' ? 'selected' : '' }}>Montenegrin</option>
                                            <option value="Moroccan" {{ old('nationality', $user->nationality ?? '') == 'Moroccan' ? 'selected' : '' }}>Moroccan</option>
                                            <option value="Mozambican" {{ old('nationality', $user->nationality ?? '') == 'Mozambican' ? 'selected' : '' }}>Mozambican</option>
                                            <option value="Myanmar" {{ old('nationality', $user->nationality ?? '') == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                                            <option value="Namibian" {{ old('nationality', $user->nationality ?? '') == 'Namibian' ? 'selected' : '' }}>Namibian</option>
                                            <option value="Nauruan" {{ old('nationality', $user->nationality ?? '') == 'Nauruan' ? 'selected' : '' }}>Nauruan</option>
                                            <option value="Nepalese" {{ old('nationality', $user->nationality ?? '') == 'Nepalese' ? 'selected' : '' }}>Nepalese</option>
                                            <option value="New Zealand" {{ old('nationality', $user->nationality ?? '') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                            <option value="Nicaraguan" {{ old('nationality', $user->nationality ?? '') == 'Nicaraguan' ? 'selected' : '' }}>Nicaraguan</option>
                                            <option value="Nigerian" {{ old('nationality', $user->nationality ?? '') == 'Nigerian' ? 'selected' : '' }}>Nigerian</option>
                                            <option value="Nigerien" {{ old('nationality', $user->nationality ?? '') == 'Nigerien' ? 'selected' : '' }}>Nigerien</option>
                                            <option value="North Korean" {{ old('nationality', $user->nationality ?? '') == 'North Korean' ? 'selected' : '' }}>North Korean</option>
                                            <option value="Norwegian" {{ old('nationality', $user->nationality ?? '') == 'Norwegian' ? 'selected' : '' }}>Norwegian</option>
                                            <option value="Omani" {{ old('nationality', $user->nationality ?? '') == 'Omani' ? 'selected' : '' }}>Omani</option>
                                            <option value="Pakistani" {{ old('nationality', $user->nationality ?? '') == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                                            <option value="Palauan" {{ old('nationality', $user->nationality ?? '') == 'Palauan' ? 'selected' : '' }}>Palauan</option>
                                            <option value="Panamanian" {{ old('nationality', $user->nationality ?? '') == 'Panamanian' ? 'selected' : '' }}>Panamanian</option>
                                            <option value="Papua New Guinean" {{ old('nationality', $user->nationality ?? '') == 'Papua New Guinean' ? 'selected' : '' }}>Papua New Guinean</option>
                                            <option value="Paraguayan" {{ old('nationality', $user->nationality ?? '') == 'Paraguayan' ? 'selected' : '' }}>Paraguayan</option>
                                            <option value="Peruvian" {{ old('nationality', $user->nationality ?? '') == 'Peruvian' ? 'selected' : '' }}>Peruvian</option>
                                            <option value="Polish" {{ old('nationality', $user->nationality ?? '') == 'Polish' ? 'selected' : '' }}>Polish</option>
                                            <option value="Portuguese" {{ old('nationality', $user->nationality ?? '') == 'Portuguese' ? 'selected' : '' }}>Portuguese</option>
                                            <option value="Qatari" {{ old('nationality', $user->nationality ?? '') == 'Qatari' ? 'selected' : '' }}>Qatari</option>
                                            <option value="Romanian" {{ old('nationality', $user->nationality ?? '') == 'Romanian' ? 'selected' : '' }}>Romanian</option>
                                            <option value="Russian" {{ old('nationality', $user->nationality ?? '') == 'Russian' ? 'selected' : '' }}>Russian</option>
                                            <option value="Rwandan" {{ old('nationality', $user->nationality ?? '') == 'Rwandan' ? 'selected' : '' }}>Rwandan</option>
                                            <option value="Saint Kitts and Nevis" {{ old('nationality', $user->nationality ?? '') == 'Saint Kitts and Nevis' ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                                            <option value="Saint Lucian" {{ old('nationality', $user->nationality ?? '') == 'Saint Lucian' ? 'selected' : '' }}>Saint Lucian</option>
                                            <option value="Saint Vincent and the Grenadines" {{ old('nationality', $user->nationality ?? '') == 'Saint Vincent and the Grenadines' ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
                                            <option value="Samoan" {{ old('nationality', $user->nationality ?? '') == 'Samoan' ? 'selected' : '' }}>Samoan</option>
                                            <option value="San Marinese" {{ old('nationality', $user->nationality ?? '') == 'San Marinese' ? 'selected' : '' }}>San Marinese</option>
                                            <option value="Sao Tomean" {{ old('nationality', $user->nationality ?? '') == 'Sao Tomean' ? 'selected' : '' }}>Sao Tomean</option>
                                            <option value="Saudi Arabian" {{ old('nationality', $user->nationality ?? '') == 'Saudi Arabian' ? 'selected' : '' }}>Saudi Arabian</option>
                                            <option value="Senegalese" {{ old('nationality', $user->nationality ?? '') == 'Senegalese' ? 'selected' : '' }}>Senegalese</option>
                                            <option value="Serbian" {{ old('nationality', $user->nationality ?? '') == 'Serbian' ? 'selected' : '' }}>Serbian</option>
                                            <option value="Seychellois" {{ old('nationality', $user->nationality ?? '') == 'Seychellois' ? 'selected' : '' }}>Seychellois</option>
                                            <option value="Sierra Leonean" {{ old('nationality', $user->nationality ?? '') == 'Sierra Leonean' ? 'selected' : '' }}>Sierra Leonean</option>
                                            <option value="Singaporean" {{ old('nationality', $user->nationality ?? '') == 'Singaporean' ? 'selected' : '' }}>Singaporean</option>
                                            <option value="Slovak" {{ old('nationality', $user->nationality ?? '') == 'Slovak' ? 'selected' : '' }}>Slovak</option>
                                            <option value="Slovenian" {{ old('nationality', $user->nationality ?? '') == 'Slovenian' ? 'selected' : '' }}>Slovenian</option>
                                            <option value="Solomon Islander" {{ old('nationality', $user->nationality ?? '') == 'Solomon Islander' ? 'selected' : '' }}>Solomon Islander</option>
                                            <option value="Somali" {{ old('nationality', $user->nationality ?? '') == 'Somali' ? 'selected' : '' }}>Somali</option>
                                            <option value="South African" {{ old('nationality', $user->nationality ?? '') == 'South African' ? 'selected' : '' }}>South African</option>
                                            <option value="South Korean" {{ old('nationality', $user->nationality ?? '') == 'South Korean' ? 'selected' : '' }}>South Korean</option>
                                            <option value="South Sudanese" {{ old('nationality', $user->nationality ?? '') == 'South Sudanese' ? 'selected' : '' }}>South Sudanese</option>
                                            <option value="Spanish" {{ old('nationality', $user->nationality ?? '') == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                                            <option value="Sri Lankan" {{ old('nationality', $user->nationality ?? '') == 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                                            <option value="Sudanese" {{ old('nationality', $user->nationality ?? '') == 'Sudanese' ? 'selected' : '' }}>Sudanese</option>
                                            <option value="Surinamese" {{ old('nationality', $user->nationality ?? '') == 'Surinamese' ? 'selected' : '' }}>Surinamese</option>
                                            <option value="Swazi" {{ old('nationality', $user->nationality ?? '') == 'Swazi' ? 'selected' : '' }}>Swazi</option>
                                            <option value="Swedish" {{ old('nationality', $user->nationality ?? '') == 'Swedish' ? 'selected' : '' }}>Swedish</option>
                                            <option value="Swiss" {{ old('nationality', $user->nationality ?? '') == 'Swiss' ? 'selected' : '' }}>Swiss</option>
                                            <option value="Syrian" {{ old('nationality', $user->nationality ?? '') == 'Syrian' ? 'selected' : '' }}>Syrian</option>
                                            <option value="Taiwanese" {{ old('nationality', $user->nationality ?? '') == 'Taiwanese' ? 'selected' : '' }}>Taiwanese</option>
                                            <option value="Tajikistani" {{ old('nationality', $user->nationality ?? '') == 'Tajikistani' ? 'selected' : '' }}>Tajikistani</option>
                                            <option value="Tanzanian" {{ old('nationality', $user->nationality ?? '') == 'Tanzanian' ? 'selected' : '' }}>Tanzanian</option>
                                            <option value="Thai" {{ old('nationality', $user->nationality ?? '') == 'Thai' ? 'selected' : '' }}>Thai</option>
                                            <option value="Togolese" {{ old('nationality', $user->nationality ?? '') == 'Togolese' ? 'selected' : '' }}>Togolese</option>
                                            <option value="Tongan" {{ old('nationality', $user->nationality ?? '') == 'Tongan' ? 'selected' : '' }}>Tongan</option>
                                            <option value="Trinidadian" {{ old('nationality', $user->nationality ?? '') == 'Trinidadian' ? 'selected' : '' }}>Trinidadian</option>
                                            <option value="Tunisian" {{ old('nationality', $user->nationality ?? '') == 'Tunisian' ? 'selected' : '' }}>Tunisian</option>
                                            <option value="Turkish" {{ old('nationality', $user->nationality ?? '') == 'Turkish' ? 'selected' : '' }}>Turkish</option>
                                            <option value="Turkmen" {{ old('nationality', $user->nationality ?? '') == 'Turkmen' ? 'selected' : '' }}>Turkmen</option>
                                            <option value="Tuvaluan" {{ old('nationality', $user->nationality ?? '') == 'Tuvaluan' ? 'selected' : '' }}>Tuvaluan</option>
                                            <option value="Ugandan" {{ old('nationality', $user->nationality ?? '') == 'Ugandan' ? 'selected' : '' }}>Ugandan</option>
                                            <option value="Ukrainian" {{ old('nationality', $user->nationality ?? '') == 'Ukrainian' ? 'selected' : '' }}>Ukrainian</option>
                                            <option value="Uruguayan" {{ old('nationality', $user->nationality ?? '') == 'Uruguayan' ? 'selected' : '' }}>Uruguayan</option>
                                            <option value="Uzbekistani" {{ old('nationality', $user->nationality ?? '') == 'Uzbekistani' ? 'selected' : '' }}>Uzbekistani</option>
                                            <option value="Vanuatuan" {{ old('nationality', $user->nationality ?? '') == 'Vanuatuan' ? 'selected' : '' }}>Vanuatuan</option>
                                            <option value="Vatican" {{ old('nationality', $user->nationality ?? '') == 'Vatican' ? 'selected' : '' }}>Vatican</option>
                                            <option value="Venezuelan" {{ old('nationality', $user->nationality ?? '') == 'Venezuelan' ? 'selected' : '' }}>Venezuelan</option>
                                            <option value="Vietnamese" {{ old('nationality', $user->nationality ?? '') == 'Vietnamese' ? 'selected' : '' }}>Vietnamese</option>
                                            <option value="Yemeni" {{ old('nationality', $user->nationality ?? '') == 'Yemeni' ? 'selected' : '' }}>Yemeni</option>
                                            <option value="Zambian" {{ old('nationality', $user->nationality ?? '') == 'Zambian' ? 'selected' : '' }}>Zambian</option>
                                            <option value="Zimbabwean" {{ old('nationality', $user->nationality ?? '') == 'Zimbabwean' ? 'selected' : '' }}>Zimbabwean</option>
                                        </select>
                                        @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="numGuests" class="form-label">
                                            <i class="fas fa-users"></i>
                                            Number of Guests
                                        </label>
                                        <input type="number" class="form-control @error('num_guests') is-invalid @enderror" id="numGuests" name="num_guests" min="1" value="{{ old('num_guests', $requestData['num_guests'] ?? 1) }}" required>
                                        @error('num_guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="contact_number" value="{{ old('contact_number', $requestData['contact_number'] ?? ($user ? $user->phone : '')) }}">
                            <input type="hidden" name="reservation_date" value="{{ old('reservation_date', $requestData['reservation_date'] ?? '') }}">
                            <input type="hidden" name="num_nights" value="{{ old('num_nights', $requestData['num_nights'] ?? 1) }}">
                            <input type="hidden" name="age" value="{{ old('age', $user->age ?? 25) }}">
                            <input type="hidden" name="gender" value="{{ old('gender', $user->gender ?? 'male') }}">
                            <input type="hidden" name="special_requests" value="">

                            {{-- Dynamic guest names --}}
                            <div id="guestNamesContainer" class="form-section" style="display: none;">
                                <h4 class="section-title">
                                    <i class="fas fa-user-plus"></i>
                                    Additional Guest Names
                                </h4>
                                <div id="guestInputs" class="guest-inputs-container"></div>
                                <small class="help-text">Minimum age for guests is 7 years old.</small>
                                <small class="help-text">Enter the names of all additional guests (excluding primary guest), one per input.</small>
                            </div>

                            {{-- Tour Type - appears below guest names on all screen sizes --}}
                            <div class="form-section">
                                <h4 class="section-title">
                                    <i class="fas fa-route"></i>
                                    Tour Type Selection
                                </h4>
                                <div class="form-group full-width">
                                    <label for="tour_type" class="form-label">
                                        <i class="fas fa-map"></i>
                                        Type of Tour
                                    </label>
                                    <select class="form-control @error('tour_type') is-invalid @enderror" id="tour_type" name="tour_type" required>
                                    <option value="">Select Tour Type</option>
                                    <option value="day_tour" {{ old('tour_type') == 'day_tour' ? 'selected' : '' }}>Day Tour</option>
                                    <option value="overnight" {{ old('tour_type') == 'overnight' ? 'selected' : '' }}>Overnight</option>
                                </select>
                                @error('tour_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </div>
                            </div>


                            {{-- Tour type specific fields - positioned below tour type selection --}}
                            <div id="dayTourSpecificFields" class="form-section" style="display: none;">
                                <h4 class="section-title">
                                    <i class="fas fa-sun"></i>
                                    Day Tour Details
                                </h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="day_tour_departure_time" class="form-label">
                                            <i class="fas fa-clock"></i>
                                            Departure Time
                                        </label>
                                            <input type="time" class="form-control @error('day_tour_departure_time') is-invalid @enderror" id="day_tour_departure_time" name="day_tour_departure_time" value="{{ old('day_tour_departure_time') }}">
                                            @error('day_tour_departure_time')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    <div class="form-group">
                                        <label for="day_tour_time_of_pickup" class="form-label">
                                            <i class="fas fa-car"></i>
                                            Time of Pick-up
                                        </label>
                                            <input type="time" class="form-control @error('day_tour_time_of_pickup') is-invalid @enderror" id="day_tour_time_of_pickup" name="day_tour_time_of_pickup" value="{{ old('day_tour_time_of_pickup') }}">
                                            @error('day_tour_time_of_pickup')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Overnight specific fields - positioned below tour type selection --}}
                            <div id="overnightSpecificFields" class="form-section" style="display: none;">
                                <h4 class="section-title">
                                    <i class="fas fa-moon"></i>
                                    Overnight Tour Details
                                </h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="overnight_departure_time_time" class="form-label">
                                            <i class="fas fa-clock"></i>
                                            Departure Time
                                    </label>
                                        <input type="time" class="form-control" id="overnight_departure_time_time" value="">
                                        <input type="hidden" id="overnight_departure_time" name="overnight_departure_time" value="{{ old('overnight_departure_time') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="overnight_pickup_time" class="form-label">
                                            <i class="fas fa-clock"></i>
                                            Time of Pick-up
                                        </label>
                                        <input type="time" class="form-control" id="overnight_pickup_time" value="">
                                        <input type="hidden" class="form-control @error('overnight_date_time_of_pickup') is-invalid @enderror" id="overnight_date_time_of_pickup" name="overnight_date_time_of_pickup" value="{{ old('overnight_date_time_of_pickup') }}">
                                    @error('overnight_date_time_of_pickup')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="num_senior_citizens_display" class="form-label">
                                            <i class="fas fa-user-clock"></i>
                                            No. of Senior Citizens
                                        </label>
                                            <input type="number" class="form-control" id="num_senior_citizens_display" value="{{ old('num_senior_citizens', 0) }}" readonly style="background-color:#e9ecef; cursor: default;">
                                            <input type="hidden" id="num_senior_citizens" name="num_senior_citizens" value="{{ old('num_senior_citizens', 0) }}">
                                            @error('num_senior_citizens')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    <div class="form-group">
                                        <label for="num_pwds" class="form-label">
                                            <i class="fas fa-wheelchair"></i>
                                            No. of PWDs
                                        </label>
                                            <input type="number" class="form-control @error('num_pwds') is-invalid @enderror" id="num_pwds" name="num_pwds" min="0" value="{{ old('num_pwds', 0) }}">
                                            @error('num_pwds')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>

                                <div class="form-section" id="seniorPwdUploadsRow" style="display:none;">
                                    <h4 class="section-title">
                                        <i class="fas fa-id-badge"></i>
                                        Senior/PWD ID Uploads
                                    </h4>
                                    <div class="form-row">
                                        <div class="form-group full-width">
                                            <label class="form-label">
                                                <i class="fas fa-user-clock"></i>
                                                Senior ID Images
                                            </label>
                                            <div id="seniorUploads"></div>
                                            <small class="help-text">One image per senior.</small>
                                        </div>
                                        <div class="form-group full-width">
                                            <label class="form-label">
                                                <i class="fas fa-wheelchair"></i>
                                                PWD ID Images
                                            </label>
                                            <div id="pwdUploads"></div>
                                            <small class="help-text">One image per PWD.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr> {{-- Separator --}}

                            {{-- IMPORTANT: These fields are NOT to be filled by the tourist.
                                They will be populated automatically by the system upon booking approval.
                                They are kept here as disabled inputs to avoid validation errors if they
                                were explicitly required by the backend, but their values will be ignored
                                and overwritten by the backend logic. --}}
                            <div id="commonFields" style="display: none;">
                                <div class="mb-3">
                                    <label for="assigned_boat" class="form-label">Assigned Boat:</label>
                                    <input type="text" class="form-control" id="assigned_boat" name="assigned_boat" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="boat_captain_crew" class="form-label">Boat Captain/Crew:</label>
                                    <input type="text" class="form-control" id="boat_captain_crew" name="boat_captain_crew" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="boat_contact_number" class="form-label">Boat Contact Number:</label>
                                    <input type="text" class="form-control" id="boat_contact_number" name="boat_contact_number" disabled>
                                </div>
                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" {{ isset($conflictingBooking) && $conflictingBooking ? 'disabled' : '' }}>
                                @if(isset($conflictingBooking) && $conflictingBooking)
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Room Unavailable
                                @else
                                        <i class="fas fa-check-circle"></i>
                                        Proceed to Confirmation
                                @endif
                            </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Font Awesome CDN for icons */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

        /* Adjust navbar width to match sidebar */
        .modern-navbar {
            left: 280px;
            right: 0;
            width: calc(100% - 280px);
        }

        /* Hide hamburger button by default on larger screens */
        .hamburger-btn {
            display: none !important;
        }

        /* Modern Sidebar Styling - Dark Theme */
        .modern-sidebar {
            width: 280px;
            min-width: 280px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }

        .modern-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            pointer-events: none;
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .brand-icon-img {
            width: 28px;
            height: 28px;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            flex: 1;
        }

        .brand-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin: 0;
            font-weight: 400;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .sidebar-nav .nav {
            padding: 0 1rem;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        .nav-link:hover .nav-icon {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .nav-link.active .nav-icon {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .nav-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }

        .notification-badge {
            background: linear-gradient(135deg, #ff6b6b, #ff4757);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
            overflow-y: auto;
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 1rem;
            }
        }

        /* Modern Registration Page Styling */
        .registration-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            z-index: 2;
        }

        .header-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 123, 255, 0.3);
        }

        .header-text {
            flex: 1;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 0.5rem 0;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
        }

        .header-decoration {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            opacity: 0.1;
        }

        .decoration-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .decoration-circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20px;
            right: 20px;
        }

        .decoration-circle:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60px;
            right: 60px;
        }

        .decoration-circle:nth-child(3) {
            width: 40px;
            height: 40px;
            top: 100px;
            right: 100px;
        }

        /* Registration Container */
        .registration-container {
            margin-bottom: 2rem;
        }

        /* Registration Form Card */
        .registration-form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .registration-form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .form-header {
            padding: 2rem 2rem 1rem 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-title i {
            color: #007bff;
        }

        .form-subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin: 0;
        }

        .registration-form {
            padding: 2rem;
        }

        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(248, 249, 250, 0.5);
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title i {
            color: #007bff;
            width: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
            }
            
            .form-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #007bff;
            width: 16px;
        }

        .form-control {
            padding: 0.875rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            color: #dc3545;
            margin-top: 0.5rem;
        }

        .help-text {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.5rem;
            font-style: italic;
        }

        .guest-inputs-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-actions {
            padding: 2rem;
            display: flex;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            min-width: 200px;
            max-width: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-primary:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            }
            
            .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Error State */
        .error-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .error-icon {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 1.5rem;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 1rem 0;
        }

        .error-description {
            font-size: 1rem;
            color: #6c757d;
            margin: 0 0 1.5rem 0;
        }

        .conflict-details {
            background: rgba(255, 193, 7, 0.1);
            padding: 1rem;
            border-radius: 10px;
            margin: 1.5rem 0;
            border-left: 4px solid #ffc107;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Success/Error Messages */
        .success-message,
        .error-message {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .success-message {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .error-message {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .success-icon,
        .error-icon {
            font-size: 1.5rem;
        }

        .success-icon {
            color: #007bff;
        }

        .error-icon {
            color: #dc3545;
        }

        .success-content h4,
        .error-content h4 {
            margin: 0 0 0.5rem 0;
            font-weight: 600;
        }

        .success-content p,
        .error-content p {
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .registration-header {
                padding: 2rem 1.5rem;
                margin-bottom: 2rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .btn-primary {
                width: 100%;
                max-width: 100%;
                min-width: auto;
            }

            .error-actions {
                flex-direction: column;
            }

            .error-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .registration-header {
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .registration-form {
                padding: 1.5rem;
            }

            .form-section {
                padding: 1rem;
            }

            .form-actions {
                padding: 1.5rem;
            }
        }

        /* Animation for cards */
        .registration-form-card {
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

        /* Staggered animation for form sections */
        .form-section {
            animation: slideInLeft 0.6s ease-out;
        }

        .form-section:nth-child(2) { animation-delay: 0.1s; }
        .form-section:nth-child(3) { animation-delay: 0.2s; }
        .form-section:nth-child(4) { animation-delay: 0.3s; }
        .form-section:nth-child(5) { animation-delay: 0.4s; }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }


        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 85vw !important;
        }

        .mobile-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
        }

        .mobile-brand-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .mobile-brand-icon-img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        .mobile-brand-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mobile-brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin: 0;
            font-weight: 400;
        }

        .mobile-sidebar-nav {
            padding: 1rem 0;
        }

        .mobile-sidebar-nav .nav {
            padding: 0 1rem;
        }

        .mobile-sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .mobile-sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mobile-sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .mobile-sidebar-nav .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .mobile-sidebar-nav .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .mobile-sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

        /* Mobile Sidebar */
        .modern-mobile-sidebar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            width: 85vw !important;
        }

        /* Ensure proper offcanvas behavior */
        .offcanvas-backdrop {
            z-index: 1040;
        }

        .offcanvas.show {
            z-index: 1045;
        }

        .mobile-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
        }

        .mobile-brand-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .mobile-brand-icon-img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        .mobile-brand-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mobile-brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin: 0;
            font-weight: 400;
        }

        .mobile-sidebar-nav {
            padding: 1rem 0;
        }

        .mobile-sidebar-nav .nav {
            padding: 0 1rem;
        }

        .mobile-sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .mobile-sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mobile-sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-sidebar-nav .nav-link:hover::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-link:hover {
            color: white;
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .mobile-sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-sidebar-nav .nav-link.active::before {
            opacity: 1;
        }

        .mobile-sidebar-nav .nav-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .mobile-sidebar-nav .nav-icon-img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(1);
        }

        .mobile-sidebar-nav .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .mobile-sidebar-nav .nav-badge {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-left: auto;
            box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                margin-left: 0;
            }
            
            .modern-sidebar {
                display: none !important;
            }
            
            /* Ensure hamburger button is visible */
            .hamburger-btn {
                display: block !important;
            }
            
            .modern-navbar {
                left: 0;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
            }
            
            .modern-mobile-sidebar {
                width: 95vw !important;
            }
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .modern-mobile-sidebar {
                width: 90vw !important;
            }
        }

        @media (max-width: 320px) {
            .main-content {
                padding: 0.5rem;
            }
            
            .modern-mobile-sidebar {
                width: 95vw !important;
            }
            
            
            .mobile-brand-title {
                font-size: 1rem;
            }
            
            .mobile-brand-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamic guest inputs
            const numGuestsInput = document.getElementById('numGuests');
            const guestContainer = document.getElementById('guestNamesContainer');
            const guestInputs = document.getElementById('guestInputs');

            function renderGuestInputs(count) {
                // count includes primary guest; we render additional guest names only
                const additional = Math.max((parseInt(count || '1', 10) - 1), 0);
                guestInputs.innerHTML = '';
                for (let i = 1; i <= additional; i++) {
                    const wrap = document.createElement('div');
                    wrap.className = 'input-group';
                    const span = document.createElement('span');
                    span.className = 'input-group-text';
                    span.textContent = `Guest ${i + 1}`; // guest numbering starts at 2
                    const nameInput = document.createElement('input');
                    nameInput.type = 'text';
                    nameInput.name = `guest_names[]`;
                    nameInput.required = additional > 0; // require if there should be any
                    nameInput.className = 'form-control';
                    nameInput.placeholder = `Enter guest ${i + 1} full name`;
                    const ageInput = document.createElement('input');
                    ageInput.type = 'number';
                    ageInput.name = `guest_ages[]`;
                    ageInput.min = '7';
                    ageInput.placeholder = 'Age (7+)';
                    ageInput.className = 'form-control';
                    ageInput.style.maxWidth = '120px';
                    const nationalitySelect = document.createElement('select');
                    nationalitySelect.name = `guest_nationalities[]`;
                    nationalitySelect.required = additional > 0;
                    nationalitySelect.className = 'form-control';
                    nationalitySelect.style.maxWidth = '150px';
                    
                    // Add default option
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Select nationality';
                    nationalitySelect.appendChild(defaultOption);
                    
                    // Add all nationality options
                    const nationalities = [
                        'Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguan', 'Argentine', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani',
                        'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Botswanan', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabé', 'Burundian',
                        'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech',
                        'Danish', 'Djiboutian', 'Dominican', 'Dutch',
                        'Ecuadorian', 'Egyptian', 'Emirati', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian',
                        'Fijian', 'Filipino', 'Finnish', 'French',
                        'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinean', 'Guyanese',
                        'Haitian', 'Honduran', 'Hungarian',
                        'Icelandic', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian',
                        'Jamaican', 'Japanese', 'Jordanian',
                        'Kazakhstani', 'Kenyan', 'Kuwaiti', 'Kyrgyzstani',
                        'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourgish',
                        'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivian', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Montenegrin', 'Moroccan', 'Mozambican', 'Myanmar',
                        'Namibian', 'Nauruan', 'Nepalese', 'New Zealand', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Norwegian',
                        'Omani',
                        'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Qatari',
                        'Romanian', 'Russian', 'Rwandan',
                        'Saint Kitts and Nevis', 'Saint Lucian', 'Saint Vincent and the Grenadines', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi Arabian', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovak', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'South Sudanese', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamese', 'Swazi', 'Swedish', 'Swiss', 'Syrian',
                        'Taiwanese', 'Tajikistani', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian', 'Tunisian', 'Turkish', 'Turkmen', 'Tuvaluan',
                        'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani',
                        'Vanuatuan', 'Vatican', 'Venezuelan', 'Vietnamese',
                        'Yemeni',
                        'Zambian', 'Zimbabwean'
                    ];
                    
                    nationalities.forEach(nationality => {
                        const option = document.createElement('option');
                        option.value = nationality;
                        option.textContent = nationality;
                        nationalitySelect.appendChild(option);
                    });
                    wrap.appendChild(span);
                    wrap.appendChild(nameInput);
                    wrap.appendChild(ageInput);
                    wrap.appendChild(nationalitySelect);
                    guestInputs.appendChild(wrap);
                    // Wire senior detection on age input as they're created
                    ageInput.addEventListener('input', evaluateSeniors);
                }
                // Re-evaluate seniors after rendering
                evaluateSeniors();
            }

            function syncGuestInputs() {
                const v = parseInt(numGuestsInput.value || '1', 10);
                if (v > 1) {
                    guestContainer.style.display = 'block';
                    renderGuestInputs(v);
                } else {
                    guestContainer.style.display = 'none';
                    guestInputs.innerHTML = '';
                }
                // Always re-evaluate tour type specific fields after changing guest count
                toggleFormFields();
            }

            if (numGuestsInput) {
                numGuestsInput.addEventListener('input', syncGuestInputs);
                numGuestsInput.addEventListener('change', syncGuestInputs);
                // Initial render based on current value
                syncGuestInputs();
            }
            const tourTypeSelect = document.getElementById('tour_type');
            const dayTourSpecificFields = document.getElementById('dayTourSpecificFields');
            const overnightSpecificFields = document.getElementById('overnightSpecificFields');

            function resetInputs(container) {
                container.querySelectorAll('input').forEach(input => {
                    if (input.type === 'number') {
                        input.value = input.min || 0;
                    } else if (input.type === 'time' || input.type === 'datetime-local' || input.type === 'text') {
                        input.value = '';
                    }
                });
            }

            function toggleFormFields() {
                var tSel = document.getElementById('tour_type');
                var dayEl = document.getElementById('dayTourSpecificFields');
                var overEl = document.getElementById('overnightSpecificFields');
                if (!tSel || !dayEl || !overEl) { return; }

                var selectedTourType = tSel.value;

                // Hide both sections first (force hidden)
                dayEl.style.display = 'none';
                overEl.style.display = 'none';

                // Remove required attributes
                dayEl.querySelectorAll('input').forEach(function(input){ input.removeAttribute('required'); });
                overEl.querySelectorAll('input').forEach(function(input){ input.removeAttribute('required'); });

                if (selectedTourType === 'day_tour') {
                    dayEl.style.display = 'block';
                    dayEl.querySelectorAll('input').forEach(function(input){ input.setAttribute('required', 'required'); });
                } else if (selectedTourType === 'overnight') {
                    overEl.style.display = 'block';
                    overEl.querySelectorAll('input').forEach(function(input){ input.setAttribute('required', 'required'); });
                }

                // Re-evaluate seniors whenever tour type toggles
                evaluateSeniors();
            }

            // Set initial state on page load
            // Use multiple small delays to ensure all old values are bound and DOM is ready
            setTimeout(function(){ toggleFormFields(); }, 0);
            setTimeout(function(){ toggleFormFields(); }, 200);
            setTimeout(function(){ toggleFormFields(); }, 800);


            // Add event listener for when the tour type changes
            if (tourTypeSelect) {
                var reToggle = function(){
                    toggleFormFields();
                };
                tourTypeSelect.addEventListener('change', reToggle);
                tourTypeSelect.addEventListener('input', reToggle);
                tourTypeSelect.addEventListener('blur', reToggle);
            }

            // Build hidden overnight datetime from reservation date (step 1) + time input here
            const overnightHidden = document.getElementById('overnight_date_time_of_pickup');
            const overnightTime = document.getElementById('overnight_pickup_time');
            const overnightDepartureHidden = document.getElementById('overnight_departure_time');
            const overnightDepartureTime = document.getElementById('overnight_departure_time_time');
            const reservationDate = (document.querySelector('input[name="reservation_date"]')?.value) || '';
            const numNightsStr = (document.querySelector('input[name="num_nights"]')?.value) || '1';
            function addDaysToYMD(ymd, days) {
                try {
                    const [y,m,d] = ymd.split('-').map(x=>parseInt(x,10));
                    if (!y || !m || !d) return ymd;
                    const dt = new Date(y, m - 1, d);
                    dt.setDate(dt.getDate() + (days||0));
                    const yy = dt.getFullYear();
                    const mm = String(dt.getMonth()+1).padStart(2,'0');
                    const dd = String(dt.getDate()).padStart(2,'0');
                    return `${yy}-${mm}-${dd}`;
                } catch(e) { return ymd; }
            }
            function syncOvernightDateTime() {
                if (!overnightHidden) return;
                if (!reservationDate || !overnightTime || !overnightTime.value) {
                    overnightHidden.value = '';
                    return;
                }
                // For overnight, pickup is next morning (checkout). Use reservation_date + num_nights days
                const nights = parseInt(numNightsStr || '1', 10) || 1;
                const pickupDateYMD = addDaysToYMD(reservationDate, nights);
                overnightHidden.value = `${pickupDateYMD}T${overnightTime.value}`;
            }
            if (overnightTime) {
                overnightTime.addEventListener('input', syncOvernightDateTime);
                overnightTime.addEventListener('change', syncOvernightDateTime);
                // Initialize if old value exists
                syncOvernightDateTime();
            }

            function syncOvernightDeparture() {
                if (!overnightDepartureHidden) return;
                if (!reservationDate || !overnightDepartureTime || !overnightDepartureTime.value) {
                    overnightDepartureHidden.value = '';
                    return;
                }
                overnightDepartureHidden.value = `${reservationDate}T${overnightDepartureTime.value}`;
            }
            if (overnightDepartureTime) {
                overnightDepartureTime.addEventListener('input', syncOvernightDeparture);
                overnightDepartureTime.addEventListener('change', syncOvernightDeparture);
                syncOvernightDeparture();
            }

            // Ensure departure time is synced before form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Sync overnight departure time before submission
                    if (overnightDepartureTime && overnightDepartureTime.value) {
                        syncOvernightDeparture();
                    }
                    
                    // Ensure day tour departure time is properly formatted
                    const dayTourDepartureTime = document.getElementById('day_tour_departure_time');
                    if (dayTourDepartureTime && dayTourDepartureTime.value) {
                        // Day tour departure time is already in H:i format, no conversion needed
                        console.log('Day tour departure time:', dayTourDepartureTime.value);
                    }
                });
            }

            // Senior citizen auto-detection for Overnight
            function evaluateSeniors() {
                const tourType = (document.getElementById('tour_type')?.value) || '';
                const seniorsHidden = document.getElementById('num_senior_citizens');
                const seniorsDisplay = document.getElementById('num_senior_citizens_display');
                if (!seniorsHidden || !seniorsDisplay) return;

                // Only apply for overnight
                if (tourType !== 'overnight') {
                    // For day tour keep value as-is but ensure it's readable-only in display
                    seniorsDisplay.value = seniorsHidden.value || 0;
                    return;
                }

                const ageInputs = Array.from(document.querySelectorAll('input[name="guest_ages[]"]'));
                const seniorCount = ageInputs.reduce((acc, inp) => {
                    const v = parseInt(inp.value || '');
                    return acc + (!isNaN(v) && v >= 60 ? 1 : 0);
                }, 0);

                seniorsHidden.value = seniorCount;
                seniorsDisplay.value = seniorCount;
                // Toggle and render dynamic inputs per senior/PWD
                const pwds = parseInt((document.getElementById('num_pwds')?.value)||'0',10)||0;
                const row = document.getElementById('seniorPwdUploadsRow');
                const seniorWrap = document.getElementById('seniorUploads');
                const pwdWrap = document.getElementById('pwdUploads');
                const showUploads = (seniorCount > 0) || (pwds > 0);
                if (row) row.style.display = showUploads ? 'block' : 'none';
                if (seniorWrap) {
                    seniorWrap.innerHTML = '';
                    for (let i = 0; i < seniorCount; i++) {
                        const inp = document.createElement('input');
                        inp.type = 'file'; inp.accept = 'image/*';
                        inp.name = 'senior_id_images[]';
                        inp.className = 'form-control mb-2';
                        inp.required = true;
                        seniorWrap.appendChild(inp);
                    }
                }
                if (pwdWrap) {
                    pwdWrap.innerHTML = '';
                    for (let i = 0; i < pwds; i++) {
                        const inp = document.createElement('input');
                        inp.type = 'file'; inp.accept = 'image/*';
                        inp.name = 'pwd_id_images[]';
                        inp.className = 'form-control mb-2';
                        inp.required = true;
                        pwdWrap.appendChild(inp);
                    }
                }
            }

            // Initial seniors evaluation
            setTimeout(evaluateSeniors, 0);
            // Also watch guestInputs container for changes (in case of autofill)
            guestInputs.addEventListener('input', function(e){
                if (e.target && e.target.name === 'guest_ages[]') {
                    evaluateSeniors();
                }
            });

            // Also react to PWD count changes to show upload row
            const numPwdsInput = document.getElementById('num_pwds');
            if (numPwdsInput) {
                numPwdsInput.addEventListener('input', evaluateSeniors);
                numPwdsInput.addEventListener('change', evaluateSeniors);
            }
        });

        // Mobile sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    if (window.innerWidth >= 768) { // Bootstrap's 'md' breakpoint is 768px
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }
        });
    </script>

</x-app-layout>