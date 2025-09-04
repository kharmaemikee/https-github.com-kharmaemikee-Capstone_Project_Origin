<?php

namespace App\Http\Controllers\BoatOwner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Boat;
use App\Models\BoatOwnerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentationController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'boat_owner') {
            abort(403, 'Unauthorized');
        }

        $unreadCount = BoatOwnerNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        $search = trim((string) $request->input('search'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $showAll = (bool) $request->boolean('all');

        $ownerBoatIds = Boat::where('user_id', Auth::id())->pluck('id');

        $query = Booking::query()
            ->with(['user', 'room.resort', 'assignedBoat'])
            ->whereIn('assigned_boat_id', $ownerBoatIds)
            ->where('status', '!=', 'rejected');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('middle_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  })
                  ->orWhereHas('assignedBoat', function ($bq) use ($search) {
                      $bq->where('boat_name', 'like', "%{$search}%")
                         ->orWhere('boat_number', 'like', "%{$search}%");
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

        $bookings = $showAll
            ? $query->orderByDesc('check_in_date')->get()
            : $query->orderByDesc('check_in_date')->paginate(15)->withQueryString();

        return view('boat_owner.documentation', [
            'bookings' => $bookings,
            'unreadCount' => $unreadCount,
            'filters' => [
                'search' => $search,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'showAll' => $showAll,
        ]);
    }
}


