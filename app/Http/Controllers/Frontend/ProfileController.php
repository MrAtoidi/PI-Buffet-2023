<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Guest;

class ProfileController extends Controller
{
    public function index(Reservation $reservation)
{
    // Obter as reservas do usuário logado
    $user = auth()->user();
    $confirmedGuestsCount = $reservation->guests()->count();
    $reservations = Reservation::where('user_id', $user->id)->withCount(['guests as confirmed_guests_count' => function ($query) {
                    $query;
                }])->orderBy('res_date', 'asc')->get();

    return view('profile.reservations', compact('reservations', 'confirmedGuestsCount'));
}

public function guestAt()
    {
        $user_id = Auth::id(); // Obtém o ID do usuário logado

        // Obtém todas as reservas em que o usuário logado é um convidado
        $reservations = Guest::where('user_id', $user_id)
            ->with('reservation') // Carrega os detalhes da reserva associada
            ->get();

        return view('profile.guest-at', compact('reservations'));
    }
}
