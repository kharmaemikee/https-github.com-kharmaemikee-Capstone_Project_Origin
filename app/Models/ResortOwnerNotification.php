<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortOwnerNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // The ID of the resort owner user who receives the notification
        'booking_id', // The ID of the booking related to the notification
        'message',
        'type', // e.g., 'new_booking', 'booking_cancelled'
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Relationship to the User (Resort Owner) who owns this notification
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to the Booking that triggered this notification
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}