<?php

namespace App\Http\Controllers\ResortOwner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ResortOwnerNotification;
use App\Models\Resort;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentationController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }

        $unreadCount = ResortOwnerNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $search = trim((string) $request->input('search'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fallback by resort names (handles legacy records without room/resort relation)
        $ownedResortNames = Resort::where('user_id', Auth::id())->pluck('resort_name')->filter()->values();
        $ownedRoomIds = Room::whereHas('resort', function ($q) {
                $q->where('user_id', Auth::id());
            })->pluck('id')->filter()->values();

        $query = Booking::query()
            ->with(['user', 'room.resort', 'assignedBoat'])
            ->where('status', 'approved')
            ->where(function ($q) use ($ownedResortNames, $ownedRoomIds) {
                $q->where('resort_owner_id', Auth::id())
                  ->orWhereHas('room.resort', function ($qq) {
                      $qq->where('user_id', Auth::id());
                  })
                  ->when($ownedResortNames->isNotEmpty(), function ($qq) use ($ownedResortNames) {
                      $qq->orWhereIn('name_of_resort', $ownedResortNames);
                  })
                  ->when($ownedRoomIds->isNotEmpty(), function ($qq) use ($ownedRoomIds) {
                      $qq->orWhereIn('room_id', $ownedRoomIds);
                  });
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('middle_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        if ($startDate || $endDate) {
            $start = $startDate ? date('Y-m-d', strtotime($startDate)) : null;
            $end = $endDate ? date('Y-m-d', strtotime($endDate)) : null;

            // If only a single date is provided, match exactly that date
            if ($start && !$end) {
                $query->whereDate('check_in_date', '=', $start);
            } elseif ($end && !$start) {
                $query->whereDate('check_in_date', '=', $end);
            } else {
                // Both dates provided: use overlap range logic
                $query->where(function ($q) use ($start, $end) {
                    $q->where(function ($qq) use ($start, $end) {
                        $qq->where('check_in_date', '<=', $end)
                           ->where(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->orWhere('check_out_date', '>=', $start);
                           });
                    });
                });
            }
        }

        $showAll = (bool) $request->boolean('all');
        if ($showAll) {
            $bookings = $query->orderByDesc('check_in_date')->get();
        } else {
            $bookings = $query->orderByDesc('check_in_date')->paginate(15)->withQueryString();
        }

        $pdfAvailable = class_exists(\Barryvdh\DomPDF\Facade\Pdf::class);

        return view('resort_owner.documentation', [
            'bookings' => $bookings,
            'unreadCount' => $unreadCount,
            'filters' => [
                'search' => $search,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'pdfAvailable' => $pdfAvailable,
            'showAll' => $showAll,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }

        $search = trim((string) $request->input('search'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $ownedResortNames = Resort::where('user_id', Auth::id())->pluck('resort_name')->filter()->values();
        $ownedRoomIds = Room::whereHas('resort', function ($q) {
                $q->where('user_id', Auth::id());
            })->pluck('id')->filter()->values();

        $query = Booking::query()
            ->with(['user', 'room.resort', 'assignedBoat'])
            ->where('status', 'approved')
            ->where(function ($q) use ($ownedResortNames, $ownedRoomIds) {
                $q->where('resort_owner_id', Auth::id())
                  ->orWhereHas('room.resort', function ($qq) {
                      $qq->where('user_id', Auth::id());
                  })
                  ->when($ownedResortNames->isNotEmpty(), function ($qq) use ($ownedResortNames) {
                      $qq->orWhereIn('name_of_resort', $ownedResortNames);
                  })
                  ->when($ownedRoomIds->isNotEmpty(), function ($qq) use ($ownedRoomIds) {
                      $qq->orWhereIn('room_id', $ownedRoomIds);
                  });
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('middle_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        if ($startDate || $endDate) {
            $start = $startDate ? date('Y-m-d', strtotime($startDate)) : null;
            $end = $endDate ? date('Y-m-d', strtotime($endDate)) : null;

            if ($start && !$end) {
                $query->whereDate('check_in_date', '=', $start);
            } elseif ($end && !$start) {
                $query->whereDate('check_in_date', '=', $end);
            } else {
                $query->where(function ($q) use ($start, $end) {
                    $q->where(function ($qq) use ($start, $end) {
                        $qq->where('check_in_date', '<=', $end)
                           ->where(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->orWhere('check_out_date', '>=', $start);
                           });
                    });
                });
            }
        }

        $filename = 'resort-bookings-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Resort', 'Room',
                'Guest Name', 'Age', 'Gender', 'Address', 'Nationality', 'Phone', 'Username',
                'Tour Type', 'Departure Time', 'Pickup Time', 'Seniors', 'PWDs',
                'Check-in', 'Check-out', 'Nights', 'Guests', 'Status', 'Valid ID Type', 'Valid ID Number', 'Created At'
            ]);

            $query->orderByDesc('check_in_date')->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $booking) {
                    $resortName = optional(optional($booking->room)->resort)->resort_name ?? $booking->name_of_resort ?? '';
                    $roomName = optional($booking->room)->room_name ?? '';
                    $username = optional($booking->user)->username ?? '';
                    fputcsv($handle, [
                        $resortName,
                        $roomName,
                        $booking->guest_name ?? (optional($booking->user)->first_name . ' ' . optional($booking->user)->last_name),
                        $booking->guest_age,
                        $booking->guest_gender,
                        $booking->guest_address,
                        $booking->guest_nationality,
                        $booking->phone_number,
                        $username,
                        $booking->tour_type,
                        (function($booking){
                            try {
                                if ($booking->tour_type === 'day_tour') {
                                    return $booking->day_tour_departure_time ? \Carbon\Carbon::parse($booking->day_tour_departure_time)->format('H:i') : 'N/A';
                                }
                                return $booking->overnight_departure_time ? \Carbon\Carbon::parse($booking->overnight_departure_time)->format('H:i') : 'N/A';
                            } catch (\Exception $e) { return 'N/A'; }
                        })($booking),
                        (function($booking){
                            try {
                                if ($booking->tour_type === 'day_tour') {
                                    return $booking->day_tour_time_of_pickup ? \Carbon\Carbon::parse($booking->day_tour_time_of_pickup)->format('H:i') : 'N/A';
                                }
                                return $booking->overnight_date_time_of_pickup ? \Carbon\Carbon::parse($booking->overnight_date_time_of_pickup)->format('H:i') : 'N/A';
                            } catch (\Exception $e) { return 'N/A'; }
                        })($booking),
                        $booking->num_senior_citizens,
                        $booking->num_pwds,
                        optional($booking->check_in_date)->format('Y-m-d'),
                        optional($booking->check_out_date)->format('Y-m-d'),
                        $booking->number_of_nights,
                        $booking->number_of_guests,
                        $booking->status,
                        $booking->valid_id_type,
                        $booking->valid_id_number,
                        optional($booking->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        if (Auth::user()->role !== 'resort_owner') {
            abort(403, 'Unauthorized');
        }

        $search = trim((string) $request->input('search'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $ownedResortNames = Resort::where('user_id', Auth::id())->pluck('resort_name')->filter()->values();
        $ownedRoomIds = Room::whereHas('resort', function ($q) {
                $q->where('user_id', Auth::id());
            })->pluck('id')->filter()->values();

        $query = Booking::query()
            ->with(['user', 'room.resort', 'assignedBoat'])
            ->where('status', 'approved')
            ->where(function ($q) use ($ownedResortNames, $ownedRoomIds) {
                $q->where('resort_owner_id', Auth::id())
                  ->orWhereHas('room.resort', function ($qq) {
                      $qq->where('user_id', Auth::id());
                  })
                  ->when($ownedResortNames->isNotEmpty(), function ($qq) use ($ownedResortNames) {
                      $qq->orWhereIn('name_of_resort', $ownedResortNames);
                  })
                  ->when($ownedRoomIds->isNotEmpty(), function ($qq) use ($ownedRoomIds) {
                      $qq->orWhereIn('room_id', $ownedRoomIds);
                  });
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('middle_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        if ($startDate || $endDate) {
            $start = $startDate ? date('Y-m-d', strtotime($startDate)) : null;
            $end = $endDate ? date('Y-m-d', strtotime($endDate)) : null;

            if ($start && !$end) {
                $query->whereDate('check_in_date', '=', $start);
            } elseif ($end && !$start) {
                $query->whereDate('check_in_date', '=', $end);
            } else {
                $query->where(function ($q) use ($start, $end) {
                    $q->where(function ($qq) use ($start, $end) {
                        $qq->where('check_in_date', '<=', $end)
                           ->where(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->orWhere('check_out_date', '>=', $start);
                           });
                    });
                });
            }
        }

        $bookings = $query->orderByDesc('check_in_date')->get();

        $filters = [
            'search' => $search,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $pdf = Pdf::loadView('resort_owner.documentation-pdf', [
            'bookings' => $bookings,
            'filters' => $filters,
            'ownerName' => Auth::user()->username,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        $filename = 'resort-bookings-' . now()->format('Ymd_His') . '.pdf';
        $relativePath = 'exports/' . $filename;
        Storage::disk('public')->put($relativePath, $pdf->output());

        return response()->download(storage_path('app/public/' . $relativePath), $filename);
    }
}


