<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Review;
use Illuminate\Support\Facades\Log;


class ReviewController extends Controller
{
    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:255',
        'reservation_id' => 'required|exists:reservations,id',
        'user_id' => 'required|integer',
    ]);

    $review = new Review([
        'rating' => $validatedData['rating'],
        'review' => $validatedData['review'],
        'reservation_id' => $validatedData['reservation_id'],
        'user_id' => $validatedData['user_id']
    ]);

    $review->save();

    $review->update(['reviewed' => 1]);

    return redirect()->route('dashboard', $review->id)->with('success', 'Review created successfully');
}

    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.show', compact('review'));
    }

    public function review($id)
    {
        $reservation = Reservation::find($id);
        return view('reviews.create', compact('reservation'));
    }

    public function saveReview(Request $request, Reservation $reservation)
{
    // Valide os dados do formulário de avaliação
    $validatedData = $request->validate([
    'rating' => 'required|integer|min:1|max:5',
    'review' => 'required|string|max:255',
]);
    // Crie a avaliação associada à reserva usando a relação definida
    $review = new Review([
        'rating' => $validatedData['rating'],
        'review' => $validatedData['review'],
    ]);

    // Associe a avaliação à reserva usando a relação definida
    $reservation->reviews()->save($review);

    return redirect()->route('reservations.show', ['reservation' => $reservation->id])
        ->with('success', 'Avaliação salva com sucesso!');
}

    public function showReview($id)
{

        $reservation = Reservation::with('reviews')->find($id);
        Log::info('reservation: ', [$reservation]);

        // Obter as avaliações associadas a esta reserva
        $reviews = $reservation->reviews()->with('user')->get();
        Log::info('reservation: ', [$reservation]);
        Log::info('reservation->reviews: ', [$reservation->reviews]);
        Log::info('reviews: ', [$reviews]);

        // Verificar se existem avaliações para esta reserva
        if ($reviews->isEmpty()) {
            // Se não houver avaliações, retorne uma mensagem ou redirecione para uma página de aviso
            Log::info('CAIU 2');
        }

        // Passar as avaliações para a view
        return view('reviews.show', compact('reservation', 'reviews'));
}

}
