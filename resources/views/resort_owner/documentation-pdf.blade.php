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


