# Boat Assignment Timing System

## Overview
The boat assignment system has been updated to handle boat status changes based on actual pickup and completion times, rather than immediate assignment upon booking approval.

## How It Works

### 1. Booking Approval Process
- When a resort owner approves a booking, a boat is **assigned** to the booking
- The boat's status remains **"open"** (not "assigned") until pickup time
- Boat numbering sequence is maintained and not reset

### 2. Boat Status Changes

#### Assignment (Pickup Time)
- **Day Tours**: Boat status changes to "assigned" when pickup time arrives
- **Overnight Tours**: Boat status changes to "assigned" when check-in date arrives
- Command: `php artisan boats:assign-on-pickup`

#### Completion (Checkout Time)
- **Day Tours**: Boat status changes back to "open" when departure time passes
- **Overnight Tours**: Boat status changes back to "open" when check-out date passes
- Command: `php artisan boats:update-statuses`

### 3. Boat Numbering System
- Boats are assigned in sequential order (1, 2, 3, 4, etc.)
- The sequence continues from where it left off
- No resetting to initial numbers
- Maintained through the `last_assigned_boat_id` setting

### 4. Commands

#### Assign Boats on Pickup
```bash
php artisan boats:assign-on-pickup
```
- Runs to mark boats as "assigned" when pickup time arrives
- Should be scheduled to run frequently (every 15-30 minutes)

#### Update Boat Statuses
```bash
php artisan boats:update-statuses
```
- Runs to mark boats as "open" when bookings are completed
- Should be scheduled to run frequently (every 15-30 minutes)

### 5. Scheduling
Add these commands to your cron schedule or task scheduler:

```bash
# Every 15 minutes
*/15 * * * * cd /path/to/project && php artisan boats:assign-on-pickup
*/15 * * * * cd /path/to/project && php artisan boats:update-statuses
```

### 6. Status Flow
1. **Booking Created** → Status: "pending"
2. **Booking Approved** → Status: "approved", Boat assigned but status remains "open"
3. **Pickup Time Arrives** → Boat status: "open" → "assigned"
4. **Booking Completes** → Boat status: "assigned" → "open"

### 7. Benefits
- Boats remain available for other bookings until actual pickup
- Accurate boat availability tracking
- Sequential boat assignment without reset
- Clear separation between booking assignment and actual boat usage
