<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
{
    // Obter as reservas do usuário logado
    $user = auth()->user();
    $reservations = Reservation::where('user_id', $user->id)->get();

    return view('dashboard', compact('reservations'));
}

}
