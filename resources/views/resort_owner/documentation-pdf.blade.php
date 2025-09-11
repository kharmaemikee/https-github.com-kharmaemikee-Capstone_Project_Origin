<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Owner Documentation PDF</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 11px; color: #222; }
        h2 { margin: 0 0 6px 0; font-size: 16px; }
        .meta { font-size: 10px; color: #555; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; }
        th { background: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
    <h2>Resort Bookings - Documentation</h2>
    <div class="meta">
        Owner: {{ $ownerName }}<br>
        Generated: {{ $generatedAt->format('Y-m-d H:i') }}<br>
        @if(!empty($filters['search'])) Search: "{{ $filters['search'] }}"<br>@endif
        @if(!empty($filters['start_date'])) From: {{ $filters['start_date'] }} @endif
        @if(!empty($filters['end_date'])) &nbsp;To: {{ $filters['end_date'] }} @endif
    </div>

    @forelse($bookings as $booking)
        <table style="margin-bottom:8px; page-break-inside: avoid;">
            <thead>
                <tr>
                    <th colspan="4">Booking</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Resort:</strong> {{ optional(optional($booking->room)->resort)->resort_name ?? ($booking->name_of_resort ?? '—') }}</td>
                    <td><strong>Room:</strong> {{ optional($booking->room)->room_name ?? '—' }}</td>
                    <td colspan="2">
                        <strong>Tourist Account:</strong>
                        @php
                            $acctName = trim(((optional($booking->user)->first_name ?? '') . ' ' . (optional($booking->user)->last_name ?? '')));
                        @endphp
                        {{ $acctName !== '' ? $acctName : (optional($booking->user)->username ?? '—') }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Guest Name:</strong> {{ $booking->guest_name ?? '—' }}</td>
                    <td><strong>Age:</strong> {{ $booking->guest_age ?? '—' }}</td>
                    <td><strong>Gender:</strong> {{ ucfirst($booking->guest_gender ?? '—') }}</td>
                    <td><strong>Nationality:</strong> {{ $booking->guest_nationality ?? '—' }}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Address:</strong> {{ $booking->guest_address ?? '—' }}</td>
                    <td colspan="2"><strong>Phone:</strong> {{ $booking->phone_number ?? '—' }}</td>
                </tr>
                <tr>
                    <td><strong>Tour Type:</strong> {{ ucfirst($booking->tour_type ?? '—') }}</td>
                    <td>
                        <strong>Departure (Day):</strong>
                        @if($booking->day_tour_departure_time)
                            @php
                                try { echo \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('H:i'); }
                                catch (\Exception $e) { echo $booking->day_tour_departure_time; }
                            @endphp
                        @else — @endif
                    </td>
                    <td>
                        <strong>Pick-up (Day):</strong>
                        @if($booking->day_tour_time_of_pickup)
                            @php
                                try { echo \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('H:i'); }
                                catch (\Exception $e) { echo $booking->day_tour_time_of_pickup; }
                            @endphp
                        @else — @endif
                    </td>
                    <td>
                        <strong>Pick-up (Overnight):</strong>
                        @if($booking->overnight_date_time_of_pickup)
                            @php
                                try { echo \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('Y-m-d H:i'); }
                                catch (\Exception $e) { echo $booking->overnight_date_time_of_pickup; }
                            @endphp
                        @else — @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Check-in:</strong> {{ optional($booking->check_in_date)->format('Y-m-d') }}</td>
                    <td><strong>Check-out:</strong> {{ optional($booking->check_out_date)->format('Y-m-d') }}</td>
                    <td><strong>Guests:</strong> {{ $booking->number_of_guests ?? '—' }}</td>
                    <td><strong>Seniors / PWDs:</strong> {{ ($booking->num_senior_citizens ?? '—') }} / {{ ($booking->num_pwds ?? '—') }}</td>
                </tr>
                <tr>
                    <td><strong>Assigned Boat:</strong> {{ optional($booking->assignedBoat)->boat_name ?? $booking->assigned_boat ?? '—' }}</td>
                    <td><strong>Boat #:</strong> {{ optional($booking->assignedBoat)->boat_number ?? '—' }}</td>
                    <td><strong>Boat Captain:</strong> {{ optional($booking->assignedBoat)->captain_name ?? $booking->boat_captain_crew ?? '—' }}</td>
                    <td><strong>Boat Contact:</strong> {{ optional($booking->assignedBoat)->captain_contact ?? $booking->boat_contact_number ?? '—' }}</td>
                </tr>
            </tbody>
        </table>
    @empty
        <p style="text-align:center; color:#666;">No bookings found.</p>
    @endforelse
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resort Bookings</title>
    <style>
        @page { size: A4 portrait; margin: 20mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #222; }
        h2 { margin: 0 0 8px 0; }
        .meta { font-size: 11px; color: #555; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; vertical-align: top; }
        th { background: #f5f5f5; text-align: left; }
        .nowrap { white-space: nowrap; }
    </style>
</head>
<body>
    <h2>Resort Bookings</h2>
    <div class="meta">
        Owner: {{ $ownerName }}<br>
        Generated: {{ $generatedAt->format('Y-m-d H:i') }}<br>
        Filters: {{ $filters['search'] ? 'Search=' . $filters['search'] . '; ' : '' }}
                 {{ $filters['start_date'] ? 'From=' . $filters['start_date'] . '; ' : '' }}
                 {{ $filters['end_date'] ? 'To=' . $filters['end_date'] : '' }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Resort</th>
                <th>Room</th>
                <th>Guest</th>
                <th class="nowrap">Phone</th>
                <th class="nowrap">Tour</th>
                <th class="nowrap">Check-in</th>
                <th class="nowrap">Check-out</th>
                <th class="nowrap">Nights</th>
                <th class="nowrap">Guests</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ optional(optional($booking->room)->resort)->resort_name ?? ($booking->name_of_resort ?? '—') }}</td>
                    <td>{{ optional($booking->room)->room_name ?? '—' }}</td>
                    <td>
                        {{ $booking->guest_name ?? (optional($booking->user)->first_name . ' ' . optional($booking->user)->last_name) }}
                        <div style="color:#666; font-size: 10px;">
                            {{ ucfirst($booking->guest_gender ?? '') }}
                            {{ $booking->guest_age ? '(' . $booking->guest_age . ')' : '' }}
                            {{ $booking->guest_nationality ? ' - ' . $booking->guest_nationality : '' }}
                        </div>
                        @if($booking->guest_address)
                            <div style="color:#666; font-size: 10px;">{{ $booking->guest_address }}</div>
                        @endif
                    </td>
                    <td class="nowrap">{{ $booking->phone_number ?? '—' }}</td>
                    <td class="nowrap">{{ ucfirst($booking->tour_type ?? '—') }}</td>
                    <td class="nowrap">{{ optional($booking->check_in_date)->format('Y-m-d') }}</td>
                    <td class="nowrap">{{ optional($booking->check_out_date)->format('Y-m-d') }}</td>
                    <td class="nowrap">{{ $booking->number_of_nights ?? '—' }}</td>
                    <td class="nowrap">{{ $booking->number_of_guests ?? '—' }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center; color:#777;">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>


