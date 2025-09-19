<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\ResortOwnerNotification;
use App\Models\BoatOwnerNotification;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $users = User::orderBy('created_at', 'desc')->get();
        $userType = 'All Users';
        return view('admin.users_info', compact('users', 'userType'));
    }

    /**
     * List only resort owners.
     */
    public function resortUsers()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $users = User::where('role', 'resort_owner')->orderBy('created_at', 'desc')->get();
        $userType = 'Resort Users';
        return view('admin.users_info', compact('users', 'userType'));
    }

    /**
     * List only boat owners.
     */
    public function boatUsers()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $users = User::where('role', 'boat_owner')->orderBy('created_at', 'desc')->get();
        $userType = 'Boat Users';
        return view('admin.users_info', compact('users', 'userType'));
    }

    /**
     * List only tourists.
     */
    public function touristUsers()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $users = User::where('role', 'tourist')->orderBy('created_at', 'desc')->get();
        $userType = 'Tourist Users';
        return view('admin.users_info', compact('users', 'userType'));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Approve a user's account.
     * This might be used for approving resort_owner or boat_owner roles.
     */
    public function approve(string $id)
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $user->is_approved = true; // Assuming you have an 'is_approved' column
        $user->save();

        return redirect()->route('admin.users')->with('success', 'User approved successfully.');
    }

    /**
     * Approve a specific permit document for a user via AJAX.
     */
    public function approvePermit(Request $request, string $id): JsonResponse
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            // Owner image is auto-approved on upload; exclude from admin approval
            'document_type' => 'required|string|in:bir_permit,dti_permit,business_permit,lgu_resolution,marina_cpc,boat_association,tourism_registration',
        ]);

        $user = User::findOrFail($id);

        // Check if this permit has been requested for resubmission
        $resubmitField = $validated['document_type'] . '_resubmitted';
        if ($user->$resubmitField) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot approve permit that has been requested for resubmission. Please wait for the owner to upload a new permit.',
            ], 400);
        }

        $map = [
            'bir_permit' => 'bir_approved',
            'dti_permit' => 'dti_approved',
            'business_permit' => 'business_permit_approved',
            'lgu_resolution' => 'lgu_resolution_approved',
            'marina_cpc' => 'marina_cpc_approved',
            'boat_association' => 'boat_association_approved',
            'tourism_registration' => 'tourism_registration_approved',
        ];

        $flagField = $map[$validated['document_type']];
        $user->$flagField = true;

        // Check if all permits are approved based on user role
        if ($user->role === 'tourist') {
            // Tourists are automatically approved and don't need permit approval
            $allApproved = true;
        } elseif ($user->role === 'boat_owner') {
            $allApproved = (
                (bool) $user->bir_approved &&
                (bool) $user->dti_approved &&
                (bool) $user->business_permit_approved &&
                (bool) $user->lgu_resolution_approved &&
                (bool) $user->marina_cpc_approved &&
                (bool) $user->boat_association_approved
            );
        } else {
            // Resort owner
            $allApproved = (
                (bool) $user->bir_approved &&
                (bool) $user->dti_approved &&
                (bool) $user->business_permit_approved &&
                (bool) $user->tourism_registration_approved
            );
        }
        
        if ($allApproved) {
            $user->is_approved = true;
        }

        $user->save();

        // Notify owner upon approval of resubmitted permit
        $documentLabelMap = [
            'bir_permit' => 'BIR Permit',
            'dti_permit' => 'DTI Permit',
            'business_permit' => 'Business Permit',
            'lgu_resolution' => 'LGU Resolution',
            'marina_cpc' => 'Marina CPC',
            'boat_association' => 'Boat Association Membership',
            'tourism_registration' => 'Tourism Registration',
        ];

        $label = $documentLabelMap[$validated['document_type']] ?? null;
        if ($label) {
            if ($user->role === 'resort_owner') {
                ResortOwnerNotification::create([
                    'user_id' => $user->id,
                    'booking_id' => null,
                    'message' => $label . ' approved. Thank you for your patience.',
                    'type' => 'permit_resubmit_approved',
                    'is_read' => false,
                ]);
            } elseif ($user->role === 'boat_owner') {
                BoatOwnerNotification::create([
                    'user_id' => $user->id,
                    'booking_id' => null,
                    'message' => $label . ' approved. Thank you for your patience.',
                    'type' => 'permit_resubmit_approved',
                    'is_read' => false,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'is_approved' => (bool) $user->is_approved,
        ]);
    }

    /**
     * Request a specific permit document to be resubmitted by the owner via AJAX.
     */
    public function requestPermitResubmit(Request $request, string $id): JsonResponse
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            // Owner image is auto-approved; exclude from resubmit requests
            'document_type' => 'required|string|in:bir_permit,dti_permit,business_permit,lgu_resolution,marina_cpc,boat_association,tourism_registration',
            'reason' => 'required|string|max:500',
        ]);

        $user = User::findOrFail($id);

        // Create notifications for resort or boat owner depending on role
        $documentLabelMap = [
            'bir_permit' => 'BIR Permit',
            'dti_permit' => 'DTI Permit',
            'business_permit' => 'Business Permit',
            'lgu_resolution' => 'LGU Resolution',
            'marina_cpc' => 'Marina CPC',
            'boat_association' => 'Boat Association Membership',
            'tourism_registration' => 'Tourism Registration',
        ];

        $message = 'Please resubmit your ' . ($documentLabelMap[$validated['document_type']] ?? 'document') . ' because the previous file was not accepted. Reason: ' . $validated['reason'];

        // Set the resubmit flag for the specific document type
        $resubmitField = $validated['document_type'] . '_resubmitted';
        $user->update([$resubmitField => true]);

        if ($user->role === 'resort_owner') {
            ResortOwnerNotification::create([
                'user_id' => $user->id,
                'booking_id' => null,
                'message' => $message,
                'type' => 'permit_resubmit',
                'is_read' => false,
            ]);
        } elseif ($user->role === 'boat_owner') {
            BoatOwnerNotification::create([
                'user_id' => $user->id,
                'booking_id' => null,
                'message' => $message,
                'type' => 'permit_resubmit',
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Approve all permits for a user at once via AJAX.
     */
    public function approveAllPermits(string $id): JsonResponse
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);

        // Approve all individual permits
        $user->bir_approved = true;
        $user->dti_approved = true;
        $user->business_permit_approved = true;
        $user->owner_pic_approved = true;
        
        if ($user->role === 'boat_owner') {
            $user->lgu_resolution_approved = true;
            $user->marina_cpc_approved = true;
            $user->boat_association_approved = true;
        } elseif ($user->role === 'resort_owner') {
            $user->tourism_registration_approved = true;
        }
        
        // Set overall approval status
        $user->is_approved = true;

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'All permits approved successfully'
        ]);
    }

    /**
     * Show a list of all foreign users and guests.
     */
    public function showForeigners()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        
        // Get registered foreign users
        $registeredForeigners = User::whereRaw('LOWER(nationality) != ?', ['filipino'])
            ->whereNotNull('nationality')
            ->where('nationality', '!=', '')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get foreign guests from bookings - parse individual guest nationalities
        $allBookings = \App\Models\Booking::whereNotNull('guest_name')
            ->where('guest_name', '!=', '')
            ->select('guest_name', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $guestForeigners = collect();
        $guestFilipinos = collect();
        
        foreach ($allBookings as $booking) {
            // Parse guest names to extract individual guests with their nationalities
            $guestNames = explode(';', $booking->guest_name);
            foreach ($guestNames as $guestName) {
                // Extract nationality from format: "Name (Age) - Nationality"
                if (preg_match('/\s-\s([^-]+)$/', trim($guestName), $matches)) {
                    $nationality = trim($matches[1]);
                    $guestData = (object)[
                        'guest_name' => trim($guestName),
                        'guest_nationality' => $nationality,
                        'created_at' => $booking->created_at
                    ];
                    
                    if (strtolower($nationality) !== 'filipino') {
                        $guestForeigners->push($guestData);
                    } else {
                        $guestFilipinos->push($guestData);
                    }
                }
            }
        }
        
        return view('admin.foreign', compact('registeredForeigners', 'guestForeigners', 'guestFilipinos'));
    }

    /**
     * Show a list of all Filipinos (nationality is 'filipino').
     */
    public function showFilipinos()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        // Correct logic: Select users where nationality is 'filipino' (case-insensitive)
        $filipinos = User::whereRaw('LOWER(nationality) = ?', ['filipino'])->orderBy('created_at', 'desc')->get();
        return view('admin.total-filipino', compact('filipinos'));
    }
}