# Boat Assignment Numbering System

## Overview

This system implements a fair and organized boat assignment process that ensures all boats are assigned before any boat is reassigned. The numbering system maintains a strict sequential order to provide equal opportunities for all boat owners.

## How It Works

### 1. Sequential Assignment Logic

- **Initial Assignment**: Boats are assigned in order starting from Boat ID 1
- **Progressive Assignment**: Each new booking gets the next available boat in sequence
- **Complete Cycle**: When all boats have been assigned, the system cycles back to the first boat
- **No Gaps**: A boat cannot be reassigned until all other boats have been assigned

### 2. Assignment Process

1. **Check Last Assigned**: System retrieves the ID of the last assigned boat from settings
2. **Determine Next Boat**: Finds the next boat in sequence after the last assigned one
3. **Availability Check**: Verifies the boat has:
   - Sufficient capacity for the number of guests
   - No time conflicts with existing bookings
4. **Assignment**: If available, assigns the boat; if not, moves to the next boat in sequence
5. **Update Tracking**: Records the newly assigned boat ID for future assignments

### 3. Example Assignment Sequence

```
Initial State: No boats assigned
Last Assigned Boat ID: 0

Booking 1 → Boat 1 (ID: 1)
Last Assigned Boat ID: 1

Booking 2 → Boat 2 (ID: 2)  
Last Assigned Boat ID: 2

Booking 3 → Boat 3 (ID: 3)
Last Assigned Boat ID: 3

Booking 4 → Boat 1 (ID: 1) - Cycles back to first boat
Last Assigned Boat ID: 1

Booking 5 → Boat 2 (ID: 2)
Last Assigned Boat ID: 2
```

## Key Features

### Fair Distribution
- All boats get equal opportunities for assignments
- No boat is favored or disadvantaged
- Systematic rotation ensures balanced workload

### Conflict Resolution
- **Time Conflicts**: Boats with conflicting schedules are automatically skipped
- **Capacity Issues**: Boats with insufficient capacity are bypassed
- **Smart Skipping**: System continues to next available boat without breaking sequence

### Persistent Tracking
- Last assigned boat ID is stored in database settings
- Survives system restarts and server reboots
- Maintains assignment history across sessions

## Technical Implementation

### Database Structure
```sql
-- Settings table stores the last assigned boat ID
settings.key = 'last_assigned_boat_id'
settings.value = [boat_id_number]
```

### Models and Methods

#### Boat Model
- `isAvailableForTimeSlot()` - Checks for time conflicts
- `hasSufficientCapacity()` - Validates guest capacity
- `getNextBoatForAssignment()` - Gets next boat in sequence
- `getBoatsInAssignmentSequence()` - Returns boats in correct order

#### Booking Model
- `assignedBoat()` - Relationship to assigned boat
- `assigned_boat_id` - Foreign key to boats table

### Controller Logic
The `confirmBooking()` method in `BookingController` handles:
- Sequential boat selection
- Availability validation
- Assignment tracking
- Notification creation

## Management Commands

### View Assignment Sequence
```bash
php artisan boats:sequence
```
Shows:
- Current last assigned boat ID
- Total available boats
- Assignment sequence order
- Next boat to be assigned
- Current boat assignments

### Reset Assignment Counter
```bash
php artisan boats:sequence --reset
```
Resets the last assigned boat ID to 0, restarting the sequence from the beginning.

## Testing

The system includes comprehensive tests in `tests/Feature/BoatAssignmentTest.php`:

- **Sequential Assignment**: Verifies boats are assigned in order
- **Cycle Back**: Confirms system returns to first boat after all assigned
- **Conflict Handling**: Tests time conflict resolution
- **Capacity Validation**: Ensures capacity requirements are met

Run tests with:
```bash
php artisan test --filter=BoatAssignmentTest
```

## Benefits

1. **Fairness**: Equal opportunity for all boat owners
2. **Transparency**: Clear, predictable assignment process
3. **Efficiency**: Automated conflict resolution and capacity checking
4. **Scalability**: Works with any number of boats
5. **Maintainability**: Clean, well-documented code structure

## Configuration

### Boat Status Requirements
Boats must have:
- `status = 'open'` to be available for assignment
- `admin_status = 'approved'` (if applicable)
- Valid boat owner user account

### Settings Management
The system automatically manages the `last_assigned_boat_id` setting. Manual intervention should only be needed for:
- System initialization
- Troubleshooting assignment issues
- Resetting the sequence for special circumstances

## Troubleshooting

### Common Issues

1. **No Boats Available**
   - Check boat status is 'open'
   - Verify boat owner accounts are active
   - Ensure admin approval is granted

2. **Assignment Not Working**
   - Verify `last_assigned_boat_id` setting exists
   - Check boat capacity and availability
   - Review time conflict logic

3. **Sequence Reset**
   - Use `php artisan boats:sequence --reset`
   - Verify setting was updated in database

### Debug Information
Use the management command to view current state:
```bash
php artisan boats:sequence
```

This provides comprehensive information about:
- Current assignment state
- Available boats
- Assignment sequence
- Next boat to be assigned

## Future Enhancements

Potential improvements could include:
- Assignment history tracking
- Performance analytics
- Custom assignment rules
- Integration with external scheduling systems
- Real-time availability updates
