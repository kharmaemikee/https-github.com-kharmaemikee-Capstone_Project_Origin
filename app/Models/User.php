<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens; // Make sure HasApiTokens is included if you use Sanctum

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'phone',
        'phone_verified_at', // Added for OTP verification
        'birthday',
        'gender',
        'nationality', // <<< ADDED THIS LINE >>>
        'address',
        'password',
        'role', // Make sure 'role' is fillable
        'bir_permit_path',
        'dti_permit_path',
        'business_permit_path',
        'owner_image_path',
        'lgu_resolution_path',
        'marina_cpc_path',
        'boat_association_path',
        'tourism_registration_path',
        'is_approved',
        'bir_approved',
        'dti_approved',
        'business_permit_approved',
        'owner_pic_approved',
        'lgu_resolution_approved',
        'marina_cpc_approved',
        'boat_association_approved',
        'tourism_registration_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Removed cast for phone_verified_at so we can store 6-digit OTP strings temporarily
        'password' => 'hashed',
        'birthday' => 'date', // Cast birthday to a date
        'is_approved' => 'boolean', // Cast is_approved to boolean
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'tourist', // Default role for new registrations if not explicitly set
    ];

    /**
     * Get the dashboard route name based on the user's role.
     * This method should return the route name string.
     */
    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'resort_owner' => 'resort.owner.information', // Corrected to the information page
            'boat_owner' => 'boat',
            'tourist' => 'tourist.tourist', // Assuming you have a tourist dashboard route
            default => 'dashboard',
        };
    }

    /**
     * Get the boats for the user (boat owner).
     */
    public function boats(): HasMany
    {
        return $this->hasMany(Boat::class);
    }

    /**
     * Get the resorts for the user (resort owner).
     * ADDED THIS METHOD
     */
    public function resorts(): HasMany
    {
        return $this->hasMany(Resort::class);
    }

    /**
     * Get the bookings made by the user (tourist).
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    /**
     * Get the notifications for the user.
     * NOTE: This relationship assumes a 'notifications' table exists with a 'user_id' column.
     * Given your constraint of "no new files", we will primarily rely on BookingNotification
     * for resort owners, and status changes for tourists/boat owners.
     * If you later decide to implement a generic notification system for all users,
     * you would create a new 'notifications' table with 'user_id' and link it here.
     */
    public function notifications(): HasMany
    {
        // This is a placeholder. If you create a generic 'notifications' table,
        // this relationship would be used. For now, it might not be directly used
        // for tourist/boat owner notifications due to the 'no new files' constraint.
        return $this->hasMany(Notification::class, 'user_id');
    }

    /**
     * Check if all permits are approved for the user.
     */
    public function hasAllPermitsApproved(): bool
    {
        if (!in_array($this->role, ['resort_owner', 'boat_owner'])) {
            return true; // Non-owners don't need permits
        }

        if ($this->role === 'boat_owner') {
            // Boat owners need: BIR, DTI, Business Permit, Owner Image, LGU Resolution, Marina CPC, Boat Association
            return (bool) $this->bir_approved &&
                   (bool) $this->dti_approved &&
                   (bool) $this->business_permit_approved &&
                   (bool) $this->owner_pic_approved &&
                   (bool) $this->lgu_resolution_approved &&
                   (bool) $this->marina_cpc_approved &&
                   (bool) $this->boat_association_approved;
        } else {
            // Resort owners need: BIR, DTI, Business Permit, Owner Image, Tourism Registration
            return (bool) $this->bir_approved &&
                   (bool) $this->dti_approved &&
                   (bool) $this->business_permit_approved &&
                   (bool) $this->owner_pic_approved &&
                   (bool) $this->tourism_registration_approved;
        }
    }

    /**
     * Check if user can access main features (resort/boat information).
     */
    public function canAccessMainFeatures(): bool
    {
        if (!in_array($this->role, ['resort_owner', 'boat_owner'])) {
            return true; // Non-owners can access everything
        }

        // Check if user has submitted at least one permit
        if ($this->role === 'boat_owner') {
            $hasSubmittedPermits = $this->bir_permit_path || 
                                  $this->dti_permit_path || 
                                  $this->business_permit_path || 
                                  $this->owner_image_path ||
                                  $this->lgu_resolution_path ||
                                  $this->marina_cpc_path ||
                                  $this->boat_association_path;
        } else {
            $hasSubmittedPermits = $this->bir_permit_path || 
                                  $this->dti_permit_path || 
                                  $this->business_permit_path || 
                                  $this->owner_image_path ||
                                  $this->tourism_registration_path;
        }

        // If no permits submitted yet, allow basic access but restrict main features
        if (!$hasSubmittedPermits) {
            return false;
        }

        // If permits are submitted, check if all are approved
        return $this->hasAllPermitsApproved();
    }

    /**
     * Check if user can access basic features (dashboard, account management).
     */
    public function canAccessBasicFeatures(): bool
    {
        // All authenticated users can access basic features
        return true;
    }

    /**
     * Determine if the user has verified their phone number.
     */
    public function hasVerifiedPhone(): bool
    {
        // Unverified when null or a 6-digit OTP string
        if ($this->phone_verified_at === null) {
            return false;
        }

        // Treat 6-digit numeric value as an OTP (unverified)
        if (is_string($this->phone_verified_at) && preg_match('/^\d{6}$/', $this->phone_verified_at)) {
            return false;
        }

        // Any non-6-digit value indicates a verification timestamp/value
        return true;
    }
}