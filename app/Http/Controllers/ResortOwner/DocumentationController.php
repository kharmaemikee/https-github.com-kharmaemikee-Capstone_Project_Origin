<?php

namespace App\Http\Controllers\ResortOwner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ResortOwnerNotification;
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

        $query = Booking::query()
            ->with(['user', 'room.resort'])
            ->where(function ($q) {
                $q->where('resort_owner_id', Auth::id())
                  ->orWhereHas('room.resort', function ($qq) {
                      $qq->where('user_id', Auth::id());
                  });
            })
            ->where('status', '!=', 'rejected');

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
            // Normalize dates
            $start = $startDate ? date('Y-m-d', strtotime($startDate)) : null;
            $end = $endDate ? date('Y-m-d', strtotime($endDate)) : null;

            // Filter bookings that overlap the given date range
            $query->where(function ($q) use ($start, $end) {
                if ($start && $end) {
                    $q->where(function ($qq) use ($start, $end) {
                        $qq->where('check_in_date', '<=', $end)
                           ->where(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->orWhere('check_out_date', '>=', $start);
                           });
                    });
                } elseif ($start) {
                    $q->where(function ($qq) use ($start) {
                        $qq->where('check_out_date', '>=', $start)
                           ->orWhere(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->where('check_in_date', '>=', $start);
                           });
                    });
                } elseif ($end) {
                    $q->where('check_in_date', '<=', $end);
                }
            });
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

        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('resort.owner.documentation', $request->query())
                ->with('error', 'PDF export is unavailable. Please install barryvdh/laravel-dompdf.');
        }

        $search = trim((string) $request->input('search'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Booking::query()
            ->with(['user', 'room.resort'])
            ->where(function ($q) {
                $q->where('resort_owner_id', Auth::id())
                  ->orWhereHas('room.resort', function ($qq) {
                      $qq->where('user_id', Auth::id());
                  });
            })
            ->where('status', '!=', 'rejected');

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
            $query->where(function ($q) use ($start, $end) {
                if ($start && $end) {
                    $q->where(function ($qq) use ($start, $end) {
                        $qq->where('check_in_date', '<=', $end)
                           ->where(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->orWhere('check_out_date', '>=', $start);
                           });
                    });
                } elseif ($start) {
                    $q->where(function ($qq) use ($start) {
                        $qq->where('check_out_date', '>=', $start)
                           ->orWhere(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->where('check_in_date', '>=', $start);
                           });
                    });
                } elseif ($end) {
                    $q->where('check_in_date', '<=', $end);
                }
            });
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
                'Tour Type', 'Day Tour Departure', 'Day Tour Pickup Time', 'Overnight Pickup DateTime', 'Seniors', 'PWDs',
                'Check-in', 'Check-out', 'Nights', 'Guests', 'Status', 'Created At'
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
                        optional($booking->day_tour_departure_time) instanceof \Carbon\Carbon ? $booking->day_tour_departure_time->format('H:i') : (string) $booking->day_tour_departure_time,
                        optional($booking->day_tour_time_of_pickup) instanceof \Carbon\Carbon ? $booking->day_tour_time_of_pickup->format('H:i') : (string) $booking->day_tour_time_of_pickup,
                        optional($booking->overnight_date_time_of_pickup) instanceof \Carbon\Carbon ? $booking->overnight_date_time_of_pickup->format('Y-m-d H:i') : (string) $booking->overnight_date_time_of_pickup,
                        $booking->num_senior_citizens,
                        $booking->num_pwds,
                        optional($booking->check_in_date)->format('Y-m-d'),
                        optional($booking->check_out_date)->format('Y-m-d'),
                        $booking->number_of_nights,
                        $booking->number_of_guests,
                        $booking->status,
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

        $query = Booking::query()
            ->with(['user', 'room.resort'])
            ->where(function ($q) {
                $q->where('resort_owner_id', Auth::id())
                  ->orWhereHas('room.resort', function ($qq) {
                      $qq->where('user_id', Auth::id());
                  });
            })
            ->where('status', '!=', 'rejected');

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
            $query->where(function ($q) use ($start, $end) {
                if ($start && $end) {
                    $q->where(function ($qq) use ($start, $end) {
                        $qq->where('check_in_date', '<=', $end)
                           ->where(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->orWhere('check_out_date', '>=', $start);
                           });
                    });
                } elseif ($start) {
                    $q->where(function ($qq) use ($start) {
                        $qq->where('check_out_date', '>=', $start)
                           ->orWhere(function ($qqq) use ($start) {
                               $qqq->whereNull('check_out_date')->where('check_in_date', '>=', $start);
                           });
                    });
                } elseif ($end) {
                    $q->where('check_in_date', '<=', $end);
                }
            });
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


