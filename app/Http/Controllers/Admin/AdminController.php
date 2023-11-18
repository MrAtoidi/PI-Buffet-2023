<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Guest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // public function index()
    // {
    //     $totalConfirmedGuests = Guest::whereHas('reservation', function ($query) {
    //         $query->where('status', 1); // Status de reserva confirmada
    //     })->count();

    //     // Total de convidados que chegaram para todas as reservas
    //     $totalArrivedGuests = Guest::whereHas('reservation', function ($query) {
    //         $query->where('status', 1); // Status de reserva confirmada
    //     })->where('arrived', true)->count();

    //     $nearestReservation = Reservation::where('status', 1)->orderBy('res_date', 'asc')
    //         ->first();

    //     $happeningReservation = Reservation::where('status', 3)->orderBy('res_date', 'asc')->get();
    //     $countHappeningReservations = $happeningReservation->count();

    //     $reservations = Reservation::orderBy('res_date', 'asc')->get();
    //     return view('admin.index', compact('reservations', 'nearestReservation', 'countHappeningReservations'));
    // }

    public function index()
{
    $nearestReservation = Reservation::where('status', 1)->orderBy('res_date', 'asc')
            ->first();

        $happeningReservation = Reservation::where('status', 3)->orderBy('res_date', 'asc')->get();
        $countHappeningReservations = $happeningReservation->count();


    $reservations = Reservation::withCount([
        'guests as confirmed_guests_count' => function ($query) {
            $query->where('arrived', true);
        },
        'guests as confirmed_presence_count' => function ($query) {
            $query->whereNotNull('arrived');
        }
    ])->get();

    return view('admin.index', compact('reservations', 'nearestReservation', 'countHappeningReservations'));
}
}
