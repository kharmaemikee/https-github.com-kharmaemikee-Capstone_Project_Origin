# Automatic Booking Status System

## Overview
This system automatically updates booking statuses to "completed" when the check-out time (for overnight) or departure time (for day tour) has passed. This makes rooms available again for new bookings.

## How It Works

### 1. Automatic Status Detection
- **Day Tours**: Completed after departure time on check-in date
- **Overnight**: Completed after check-out date or calculated check-out (check-in + number of nights)

### 2. Room Availability
- When a booking is marked as "completed", the room becomes available again
- The `isAvailableForDate()` method automatically excludes completed bookings
- No more double-booking issues for completed stays

### 3. Tourist View Updates
- In "Your Visit" page, booking status automatically shows "Completed" when time has passed
- Uses `display_status` attribute that checks actual completion time
- Status badges and buttons update automatically

## Commands

### Manual Status Update
```bash
php artisan bookings:update-statuses
```

### Test Route (Development)
```
GET /test/update-booking-statuses
```

## Scheduling (Recommended for Production)

Add this to your server's cron job to run every hour:

```bash
* * * * * cd /path/to/your/project && php artisan bookings:update-statuses >> /dev/null 2>&1
```

Or add to Laravel's scheduler in `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('bookings:update-statuses')->hourly();
}
```

## Database Changes

The system uses existing fields:
- `check_in_date` - Date of arrival
- `check_out_date` - Date of departure (nullable for day tours)
- `day_tour_departure_time` - Departure time for day tours
- `number_of_nights` - Number of nights for overnight stays
- `tour_type` - 'day_tour' or 'overnight'
- `status` - Current booking status

## Benefits

1. **Automatic Room Availability**: Rooms become available immediately after completion
2. **Real-time Status Updates**: Tourist sees accurate status in "Your Visit" page
3. **No Manual Intervention**: System runs automatically
4. **Prevents Double-booking**: Completed bookings don't block new reservations
5. **Accurate Reporting**: Status reflects actual completion time, not just manual updates

## Testing

1. Create a test booking with a past date/time
2. Run: `php artisan bookings:update-statuses`
3. Check that the booking status changed to "completed"
4. Verify the room is now available for new bookings
5. Check that the tourist sees "Completed" status in their visit page

## Troubleshooting

- **Command not working**: Check if the command exists with `php artisan list`
- **Status not updating**: Verify the booking has the correct date/time fields
- **Room still unavailable**: Check if the booking was actually marked as completed
- **View not updating**: Clear view cache with `php artisan view:clear`
