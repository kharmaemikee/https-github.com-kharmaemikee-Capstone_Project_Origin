<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Documentation PDF</title>
    <style>
        @page { 
            size: A4 portrait; 
            margin: 15mm; 
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .date-range {
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }
        .booking-container {
            page-break-inside: avoid;
            margin-bottom: 100px;
        }
        
        .booking-container:not(:last-child) {
            page-break-after: always;
        }
        
        .booking-container h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 15px 0;
            color: #333;
        }
        .booking-details {
            margin-left: 20px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 8px;
            align-items: flex-start;
        }
        .detail-label {
            font-weight: bold;
            min-width: 150px;
            margin-right: 10px;
        }
        .detail-value {
            flex: 1;
        }
        
        .resort-name {
            font-size: 12px;
            font-weight: bold;
        }
        
        .bold-text {
            font-weight: bold;
        }
        
        .guest-table-section {
            margin-top: 20px;
            margin-left: 20px;
        }
        
        .guest-table-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .guest-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .guest-table th,
        .guest-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        .guest-table th {
            background: #f0f0f0;
            font-weight: bold;
        }
        
        .guest-table td {
            background: white;
        }
        
        .page-signature {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            z-index: 1000;
        }
        
        .empty-state {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Tourist Bookings - Documentation</h1>
        <div class="date-range">
            Generated: {{ $generatedAt->format('Y-m-d H:i') }}
            @if(!empty($filters['search'])) | Search: "{{ $filters['search'] }}" @endif
            @if(!empty($filters['start_date'])) | From: {{ $filters['start_date'] }} @endif
            @if(!empty($filters['end_date'])) | To: {{ $filters['end_date'] }} @endif
        </div>
    </div>

    @forelse($bookings as $booking)
        <div class="booking-container">
            
            <div class="booking-details">
                <div class="detail-row">
                    <span class="detail-label">Resort:</span>
                    <span class="detail-value resort-name">{{ optional(optional($booking->room)->resort)->resort_name ?? ($booking->name_of_resort ?? '—') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Room:</span>
                    <span class="detail-value">{{ optional($booking->room)->room_name ?? '—' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Guest Name:</span>
                    <span class="detail-value">
                        @php
                            $guestNames = explode(';', $booking->guest_name ?? '');
                            $nameList = [];
                        @endphp
                        
                        @for($i = 0; $i < count($guestNames); $i++)
                            @if(trim($guestNames[$i] ?? '') !== '')
                                @php
                                    $guestName = trim($guestNames[$i] ?? '');
                                    
                                    // Extract name from the guest name if it contains age and nationality
                                    // Format: "Name (Age) - Nationality"
                                    if (preg_match('/^(.+?)\s*\((\d+)\)\s*-\s*(.+)$/', $guestName, $matches)) {
                                        $cleanName = trim($matches[1]);
                                        $finalName = $cleanName;
                                    } else {
                                        // If no pattern match, use the name as-is
                                        $finalName = $guestName;
                                    }
                                    
                                    $nameList[] = $finalName;
                                @endphp
                            @endif
                        @endfor
                        
                        {{ implode(', ', $nameList) ?: '—' }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Age:</span>
                    <span class="detail-value">
                        @php
                            $guestAges = explode(';', $booking->guest_age ?? '');
                            $ageList = [];
                        @endphp
                        
                        @for($i = 0; $i < count($guestNames); $i++)
                            @if(trim($guestNames[$i] ?? '') !== '')
                                @php
                                    $guestName = trim($guestNames[$i] ?? '');
                                    $guestAge = trim($guestAges[$i] ?? '');
                                    
                                    // Extract age from the guest name if it contains age and nationality
                                    // Format: "Name (Age) - Nationality"
                                    if (preg_match('/^(.+?)\s*\((\d+)\)\s*-\s*(.+)$/', $guestName, $matches)) {
                                        $extractedAge = trim($matches[2]);
                                        $finalAge = $extractedAge ?: $guestAge;
                                    } else {
                                        // If no pattern match, use separate age field
                                        $finalAge = $guestAge;
                                    }
                                    
                                    $ageList[] = $finalAge ?: '—';
                                @endphp
                            @endif
                        @endfor
                        
                        {{ implode(', ', $ageList) ?: '—' }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Nationality:</span>
                    <span class="detail-value">
                        @php
                            $guestNationalities = explode(';', $booking->guest_nationality ?? '');
                            $nationalityList = [];
                        @endphp
                        
                        @for($i = 0; $i < count($guestNames); $i++)
                            @if(trim($guestNames[$i] ?? '') !== '')
                                @php
                                    $guestName = trim($guestNames[$i] ?? '');
                                    $guestNationality = trim($guestNationalities[$i] ?? '');
                                    
                                    // Extract nationality from the guest name if it contains age and nationality
                                    // Format: "Name (Age) - Nationality"
                                    if (preg_match('/^(.+?)\s*\((\d+)\)\s*-\s*(.+)$/', $guestName, $matches)) {
                                        $extractedNationality = trim($matches[3]);
                                        $finalNationality = $extractedNationality ?: $guestNationality;
                                    } else {
                                        // If no pattern match, use separate nationality field
                                        $finalNationality = $guestNationality;
                                    }
                                    
                                    $nationalityList[] = $finalNationality ?: '—';
                                @endphp
                            @endif
                        @endfor
                        
                        {{ implode(', ', $nationalityList) ?: '—' }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value">{{ $booking->guest_address ?? '—' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Contact:</span>
                    <span class="detail-value">{{ $booking->phone_number ?? '—' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Tour Type:</span>
                    <span class="detail-value">{{ ucfirst($booking->tour_type ?? '—') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Departure Time:</span>
                    <span class="detail-value">
                        @if($booking->tour_type === 'day_tour' && $booking->day_tour_departure_time)
                            @php
                                try { 
                                    $departureTime = \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('g:i A'); 
                                } catch (\Exception $e) { 
                                    $departureTime = $booking->day_tour_departure_time; 
                                }
                            @endphp
                            {{ $departureTime }}
                        @elseif($booking->tour_type === 'overnight')
                            @if($booking->overnight_departure_time)
                                @php
                                    try { 
                                        $departureTime = \Carbon\Carbon::parse($booking->overnight_departure_time)->format('g:i A'); 
                                    } catch (\Exception $e) { 
                                        $departureTime = $booking->overnight_departure_time; 
                                    }
                                @endphp
                                {{ $departureTime }}
                            @elseif($booking->check_in_date)
                                @php
                                    $checkInDate = \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d');
                                @endphp
                                {{ $checkInDate }} (Check-in Date)
                            @else
                                —
                            @endif
                        @else
                            —
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Pick-up Time:</span>
                    <span class="detail-value">
                        @if($booking->tour_type === 'day_tour' && $booking->day_tour_time_of_pickup)
                            @php
                                try { 
                                    $pickupTime = \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('g:i A'); 
                                } catch (\Exception $e) { 
                                    $pickupTime = $booking->day_tour_time_of_pickup; 
                                }
                            @endphp
                            {{ $pickupTime }}
                        @elseif($booking->tour_type === 'overnight' && $booking->overnight_date_time_of_pickup)
                            @php
                                try { 
                                    $pickupTime = \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('g:i A'); 
                                } catch (\Exception $e) { 
                                    $pickupTime = $booking->overnight_date_time_of_pickup; 
                                }
                            @endphp
                            {{ $pickupTime }}
                        @else
                            —
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Check-in:</span>
                    <span class="detail-value">{{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->format('Y-m-d') : '—' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Check-out:</span>
                    <span class="detail-value">{{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->format('Y-m-d') : '—' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Valid ID Type:</span>
                    <span class="detail-value">{{ $booking->valid_id_type ?? '—' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Valid ID Number:</span>
                    <span class="detail-value">{{ $booking->valid_id_number ?? '—' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Boat Name:</span>
                    <span class="detail-value">{{ optional($booking->assignedBoat)->boat_name ?? $booking->assigned_boat ?? '—' }}</span>
                </div>
            </div>
            
            {{-- Guest Information Table --}}
            <div class="guest-table-section">
                <h3>Guest Information</h3>
                <table class="guest-table">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Age</th>
                            <th>Nationality</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $guestNames = explode(';', $booking->guest_name ?? '');
                            $guestAges = explode(';', $booking->guest_age ?? '');
                            $guestNationalities = explode(';', $booking->guest_nationality ?? '');
                        @endphp
                        
                        @for($i = 0; $i < count($guestNames); $i++)
                            @if(trim($guestNames[$i] ?? '') !== '')
                                @php
                                    $guestName = trim($guestNames[$i] ?? '');
                                    $guestAge = trim($guestAges[$i] ?? '');
                                    $guestNationality = trim($guestNationalities[$i] ?? '');
                                    
                                    // Extract name, age, and nationality from the guest name if it contains them
                                    // Format: "Name (Age) - Nationality"
                                    if (preg_match('/^(.+?)\s*\((\d+)\)\s*-\s*(.+)$/', $guestName, $matches)) {
                                        $cleanName = trim($matches[1]);
                                        $extractedAge = trim($matches[2]);
                                        $extractedNationality = trim($matches[3]);
                                        
                                        // Use extracted values if available, otherwise use separate fields
                                        $finalName = $cleanName;
                                        $finalAge = $extractedAge ?: $guestAge;
                                        $finalNationality = $extractedNationality ?: $guestNationality;
                                    } else {
                                        // If no pattern match, use the name as-is and separate fields
                                        $finalName = $guestName;
                                        $finalAge = $guestAge;
                                        $finalNationality = $guestNationality;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $finalName }}</td>
                                    <td>{{ $finalAge ?: '—' }}</td>
                                    <td>{{ $finalNationality ?: '—' }}</td>
                                </tr>
                            @endif
                        @endfor
                        
                        @if(empty($guestNames) || (count($guestNames) === 1 && trim($guestNames[0]) === ''))
                            <tr>
                                <td colspan="3" style="text-align: center; color: #666;">No guest information available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <h3>No bookings found</h3>
            <p>There are no bookings matching the current filters.</p>
        </div>
    @endforelse

    {{-- Page Signature --}}
    <div class="page-signature">
        <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
            @if(isset($bookings) && $bookings->count() > 0)
                {{ optional($bookings->first()->user)->first_name ?? 'Admin' }} {{ optional($bookings->first()->user)->last_name ?? 'User' }}
            @else
                Admin User
            @endif
        </div>
    </div>
</body>
</html>

