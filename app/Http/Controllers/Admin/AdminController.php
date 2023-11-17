<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $nearestReservation = Reservation::where('status', 1)->orderBy('res_date', 'asc')
            ->first();

        $happeningReservation = Reservation::where('status', 3)->orderBy('res_date', 'asc')->get();
        $countHappeningReservations = $happeningReservation->count();

        $reservations = Reservation::orderBy('res_date', 'asc')->get();
        return view('admin.index', compact('reservations', 'nearestReservation', 'countHappeningReservations'));
    }
}
