<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;

class AdminDocumentationController extends Controller
{
    /**
     * Display the admin documentation page with all tourist bookings.
     */
    public function index(Request $request)
    {
        // Ensure only admin can access this
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Get filter parameters
        $filters = [
            'search' => $request->get('search', ''),
            'start_date' => $request->get('start_date', ''),
            'end_date' => $request->get('end_date', ''),
        ];
        
        $showAll = $request->has('all') && $request->get('all');

        // Build the query for all bookings with relationships
        $query = Booking::with([
            'user', // Tourist who made the booking
            'room.resort', // Room and its resort
            'assignedBoat', // Assigned boat
            'resortOwner' // Resort owner
        ])
        ->orderBy('created_at', 'desc');

        // Apply search filter
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('guest_name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone_number', 'like', "%{$searchTerm}%")
                  ->orWhere('guest_address', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('first_name', 'like', "%{$searchTerm}%")
                               ->orWhere('last_name', 'like', "%{$searchTerm}%")
                               ->orWhere('username', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('room.resort', function ($resortQuery) use ($searchTerm) {
                      $resortQuery->where('resort_name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('assignedBoat', function ($boatQuery) use ($searchTerm) {
                      $boatQuery->where('boat_name', 'like', "%{$searchTerm}%")
                               ->orWhere('boat_number', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Apply date filters
        if (!empty($filters['start_date'])) {
            $query->where('check_in_date', '>=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $query->where('check_in_date', '<=', $filters['end_date']);
        }

        // Get bookings based on showAll parameter
        if ($showAll) {
            $bookings = $query->get();
        } else {
            $bookings = $query->paginate(15);
        }

        return view('admin.documentation', compact('bookings', 'filters', 'showAll'));
    }

    /**
     * Export bookings data (similar to resort owner documentation)
     */
    public function export(Request $request)
    {
        // Ensure only admin can access this
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Get the same filtered data as the index method
        $filters = [
            'search' => $request->get('search', ''),
            'start_date' => $request->get('start_date', ''),
            'end_date' => $request->get('end_date', ''),
        ];

        $query = Booking::with([
            'user',
            'room.resort',
            'assignedBoat',
            'resortOwner'
        ])
        ->orderBy('created_at', 'desc');

        // Apply same filters as index method
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('guest_name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone_number', 'like', "%{$searchTerm}%")
                  ->orWhere('guest_address', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('first_name', 'like', "%{$searchTerm}%")
                               ->orWhere('last_name', 'like', "%{$searchTerm}%")
                               ->orWhere('username', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('room.resort', function ($resortQuery) use ($searchTerm) {
                      $resortQuery->where('resort_name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('assignedBoat', function ($boatQuery) use ($searchTerm) {
                      $boatQuery->where('boat_name', 'like', "%{$searchTerm}%")
                               ->orWhere('boat_number', 'like', "%{$searchTerm}%");
                  });
            });
        }

        if (!empty($filters['start_date'])) {
            $query->where('check_in_date', '>=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $query->where('check_in_date', '<=', $filters['end_date']);
        }

        $bookings = $query->get();

        // Generate CSV content
        $csvContent = $this->generateCsvContent($bookings);

        $filename = 'admin-tourist-bookings-' . Carbon::now()->format('Y-m-d-H-i-s') . '.csv';

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Generate CSV content for export
     */
    private function generateCsvContent($bookings)
    {
        $headers = [
            'Booking ID',
            'Resort Name',
            'Room Name',
            'Tourist Account',
            'Guest Name',
            'Age',
            'Gender',
            'Address',
            'Nationality',
            'Phone Number',
            'Tour Type',
            'Pick-up Time (Day Tour)',
            'Departure Time (Day Tour)',
            'Pick-up Time (Overnight)',
            'Number of Seniors',
            'Number of PWDs',
            'Check-in Date',
            'Check-out Date',
            'Number of Guests',
            'Assigned Boat',
            'Boat Number',
            'Boat Captain',
            'Boat Contact',
            'Created At'
        ];

        $csvContent = implode(',', $headers) . "\n";

        foreach ($bookings as $booking) {
            $row = [
                $booking->id,
                $booking->room->resort->resort_name ?? $booking->name_of_resort ?? 'N/A',
                $booking->room->room_name ?? 'N/A',
                $booking->user ? trim($booking->user->first_name . ' ' . $booking->user->last_name) : 'N/A',
                $booking->guest_name ?? 'N/A',
                $booking->guest_age ?? 'N/A',
                ucfirst($booking->guest_gender ?? 'N/A'),
                $booking->guest_address ?? 'N/A',
                $booking->guest_nationality ?? 'N/A',
                $booking->phone_number ?? 'N/A',
                ucfirst($booking->tour_type ?? 'N/A'),
                $booking->day_tour_time_of_pickup ? (function($time) {
                    try {
                        return Carbon::parse($time)->format('H:i');
                    } catch (\Exception $e) {
                        return $time;
                    }
                })($booking->day_tour_time_of_pickup) : 'N/A',
                $booking->day_tour_departure_time ? (function($time) {
                    try {
                        return Carbon::parse($time)->format('H:i');
                    } catch (\Exception $e) {
                        return $time;
                    }
                })($booking->day_tour_departure_time) : 'N/A',
                $booking->overnight_date_time_of_pickup ? (function($time) {
                    try {
                        return Carbon::parse($time)->format('Y-m-d H:i');
                    } catch (\Exception $e) {
                        return $time;
                    }
                })($booking->overnight_date_time_of_pickup) : 'N/A',
                $booking->num_senior_citizens ?? 0,
                $booking->num_pwds ?? 0,
                $booking->check_in_date ? $booking->check_in_date->format('Y-m-d') : 'N/A',
                $booking->check_out_date ? $booking->check_out_date->format('Y-m-d') : 'N/A',
                $booking->number_of_guests ?? 'N/A',
                $booking->assignedBoat->boat_name ?? $booking->assigned_boat ?? 'N/A',
                $booking->assignedBoat->boat_number ?? 'N/A',
                $booking->assignedBoat->captain_name ?? $booking->boat_captain_crew ?? 'N/A',
                $booking->assignedBoat->captain_contact ?? $booking->boat_contact_number ?? 'N/A',
                $booking->created_at ? $booking->created_at->format('Y-m-d H:i:s') : 'N/A'
            ];

            // Escape CSV values
            $row = array_map(function($value) {
                return '"' . str_replace('"', '""', $value) . '"';
            }, $row);

            $csvContent .= implode(',', $row) . "\n";
        }

        return $csvContent;
    }

    /**
     * Export filtered bookings to PDF including all fields (table + modal fields).
     */
    public function exportPdf(Request $request)
    {
        // Ensure only admin can access this
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Reuse filters from index
        $filters = [
            'search' => $request->get('search', ''),
            'start_date' => $request->get('start_date', ''),
            'end_date' => $request->get('end_date', ''),
        ];

        $query = Booking::with(['user', 'room.resort', 'assignedBoat', 'resortOwner'])
            ->orderBy('created_at', 'desc');

        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('guest_name', 'like', "%{$searchTerm}%")
                  ->orWhere('phone_number', 'like', "%{$searchTerm}%")
                  ->orWhere('guest_address', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('first_name', 'like', "%{$searchTerm}%")
                               ->orWhere('last_name', 'like', "%{$searchTerm}%")
                               ->orWhere('username', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('room.resort', function ($resortQuery) use ($searchTerm) {
                      $resortQuery->where('resort_name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('assignedBoat', function ($boatQuery) use ($searchTerm) {
                      $boatQuery->where('boat_name', 'like', "%{$searchTerm}%")
                               ->orWhere('boat_number', 'like', "%{$searchTerm}%");
                  });
            });
        }

        if (!empty($filters['start_date'])) {
            $query->where('check_in_date', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->where('check_in_date', '<=', $filters['end_date']);
        }

        $bookings = $query->get();

        $data = [
            'bookings' => $bookings,
            'filters' => $filters,
            'generatedAt' => now(),
        ];

        $filename = 'admin-tourist-bookings-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        // Prefer facade if available; otherwise fallback to raw Dompdf
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = Pdf::loadView('admin.documentation-pdf', $data)->setPaper('a4', 'landscape');
            return $pdf->download($filename);
        }

        // Fallback: use Dompdf directly
        $html = view('admin.documentation-pdf', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('a4', 'landscape');
        $dompdf->render();
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
