<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index(Reservation $reservation)
{
    // Obter as reservas do usuário logado
    $user = auth()->user();
    $confirmedGuestsCount = $reservation->guests()->count();
    $reservations = Reservation::where('user_id', $user->id)->withCount(['guests as confirmed_guests_count' => function ($query) {
                    $query;
                }])->orderBy('res_date', 'asc')->get();

    return view('dashboard', compact('reservations', 'confirmedGuestsCount'));
}

}
