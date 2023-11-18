<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reservations = Reservation::withCount(['guests as confirmed_guests_count' => function ($query) {
                    $query;
                }])->orderBy('res_date', 'asc')->get();


        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tables = Category::get();
        return view('admin.reservations.create', compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request)
    {
        $table = Category::findOrFail($request->table_id);
        if ($request->guest_number > $table->guest_number) {
            return back()->with('warning', 'Por favor, escolha um pacote de comidas');
        }
        $request_date = Carbon::parse($request->res_date);
        foreach ($table->reservations as $res) {
            if ($res->res_date->format('d-m-Y') == $request_date->format('d-m-Y')) {
                return back()->with('warning', 'Este horário não está disponível');
            }
        }
        Reservation::create($request->validated());

        return to_route('admin.reservations.index')->with('success', 'Reserva efetuada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $tables = Category::get();
        return view('admin.reservations.edit', compact('reservation', 'tables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationStoreRequest $request, Reservation $reservation)
    {
        $table = Category::findOrFail($request->table_id);
        if ($request->guest_number > $table->guest_number) {
            return back()->with('warning', 'Por favor, escolha um pacote de comidas');
        }
        $request_date = Carbon::parse($request->res_date);
        $reservations = $table->reservations()->where('id', '!=', $reservation->id)->get();
        foreach ($reservations as $res) {
            if ($res->res_date->format('d-m-Y') == $request_date->format('d-m-Y')) {
                return back()->with('warning', 'Esse horário não está disponível!');
            }
        }

        $reservation->update($request->validated());
        return to_route('admin.reservations.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return to_route('admin.reservations.index')->with('warning', 'Reserva deletada com sucesso!');
    }

    public function pending(Reservation $reservation)
    {
        $reservation->status = 0;
        $msg = 'Reserva definida como pendente com sucesso!';

        $reservation->save();

        return to_route('admin.reservations.index')->with('warning', $msg);
    }

    public function confirm(Reservation $reservation)
    {
        $reservation->status = 1;
        $msg = 'Reserva confirmada com sucesso!';

        $reservation->save();

        return to_route('admin.reservations.index')->with('warning', $msg);
    }

    public function cancel(Reservation $reservation)
    {
        $reservation->status = 2;
        $msg = 'Reserva cancelada com sucesso!';

        $reservation->save();

        return to_route('admin.reservations.index')->with('warning', $msg);
    }

    public function start(Reservation $reservation)
    {
        $reservation->status = 3;
        $msg = 'Reserva iniciada com sucesso!';

        $reservation->save();

        return to_route('admin.reservations.index')->with('warning', $msg);
    }

    public function finish(Reservation $reservation)
    {
        $reservation->status = 4;
        $msg = 'Reserva finalizada com sucesso!';

        $reservation->save();

        return to_route('admin.reservations.index')->with('warning', $msg);
    }

    public function confirmedGuests(Reservation $reservation)
    {
        $confirmedGuests = $reservation->guests()->get();

        return view('admin.guests.confirmed', compact('confirmedGuests', 'reservation'));
    }


}
