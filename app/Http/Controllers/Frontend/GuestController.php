<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Guest;

class GuestController extends Controller
{
    public function form($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        return view('guests.index', compact('reservation'));
    }

    public function adminForm($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        return view('admin.guests.index', compact('reservation'));
    }


    public function save(Request $request, $reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);

        $guestsData = $request->input('guests');

        foreach ($guestsData as $guestData) {
            $guest = new Guest($guestData);
            $reservation->guests()->save($guest);
        }

        return redirect()->route('thankyou');
    }
    public function adminSave(Request $request, $reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);

        $guestsData = $request->input('guests');

        foreach ($guestsData as $guestData) {
            $guest = new Guest($guestData);
            $reservation->guests()->save($guest);
        }

        return redirect()->route('reservations.confirmed-guests', ['reservation' => $reservation_id]);
    }

    public function removeGuest(Guest $guest)
    {
        $guest->delete();

        return redirect()->back()->with('success', 'Convidado removido com sucesso');
    }

    public function cancelGuest($id)
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return redirect()->back()->with('error', 'Convidado não encontrado.');
        }

        if ($guest->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Você não tem permissão para cancelar este convidado.');
        }

        $guest->delete();
        return redirect()->back()->with('success', 'Convidado cancelado com sucesso!');
    }

    public function confirmPresence($id)
{
    $guest = Guest::findOrFail($id);

    $guest->arrived = 1; // Define o campo 'arrived' como 1
    $guest->save(); // Salva a atualização

    return redirect()->back()->with('success', 'Presença confirmada com sucesso!');
}
}
