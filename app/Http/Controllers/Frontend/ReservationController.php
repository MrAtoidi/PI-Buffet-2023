<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Category;
use App\Models\BuffetTiming;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function stepOne(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        return view('reservations.step-one', compact('reservation'));
    }

    public function storeStepOne(Request $request)
{
    $validated = $request->validate([
        'first_name' => ['required'],
        'last_name' => ['required'],
        'email' => ['required', 'email'],
        'tel_number' => ['required'],
        'guest_number' => ['required'],
        'cpf' => ['required'],
        'idade' => ['required']
    ]);

    $reservation = new Reservation();
    $reservation->fill($validated);

    // Define o user_id do usuário autenticado
    $reservation->user_id = Auth::id();

    $request->session()->put('reservation', $reservation);

    return to_route('reservations.step.two');
}

public function checkAvailability(Request $request)
{
    $selectedDate = $request->input('selectedDate');
    //Log::info(['Selected Date' => $selectedDate]);
    $selectedTime = $request->input('selectedTime');
    //Log::info(['Selected Time' => $selectedTime]);

    // Combine selectedDate and selectedTime into a Carbon object
    $selectedDateTime = Carbon::createFromFormat('Y-m-d H:i', $selectedDate . ' ' . $selectedTime);
    //Log::info(['Selected DateTime' => $selectedDateTime]);
    // Format the date for database comparison (matching your database format)
    $formattedDate = $selectedDateTime->format('Y-m-d H:i:s');
    //Log::info(['Formatted Date' => $formattedDate]);
    // Extract the day of the week and hour
    $selectedDayOfWeek = $selectedDateTime->dayOfWeek;
    $selectedHour = $selectedDateTime->format('H:i');
    //Log::info(['Selected Hour' => $selectedHour]);

    // Query BuffetTimings for the selected day of the week
    $buffetTimings = BuffetTiming::where('day_of_week', $selectedDayOfWeek)->get();
    //Log::info(['Buffet Timings' => $buffetTimings]);
    // Check if the selected time falls within any BuffetTimings
    $isAvailable = false;

    foreach ($buffetTimings as $timing) {
        $startTime = Carbon::parse($timing->start_time)->format('H:i');
        $endTime = Carbon::parse($timing->end_time)->format('H:i');

        if ($selectedHour >= $startTime && $selectedHour <= $endTime) {
            $isAvailable = true;
            //Log::info(['Available' => $isAvailable]);
            break; // Exit the loop if the time is available
        }
    }

    return response()->json(['available' => $isAvailable]);
}




    public function stepTwo(Request $request)
{
    $reservation = $request->session()->get('reservation');
    $min_date = Carbon::today();
    $max_date = Carbon::now()->addWeek();

    $res_table_ids = Reservation::whereDate('res_date', $reservation->res_date)
        ->orderBy('res_date')
        ->pluck('table_id');

    $tables = Category::where('guest_number', '>=', $reservation->guest_number)
        ->whereNotIn('id', $res_table_ids)
        ->get();

    return view('reservations.step-two', compact('reservation', 'tables', 'min_date', 'max_date'));
}


    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate([
            'table_id' => ['required'],
            'res_date' => ['required', 'date', new DateBetween, new TimeBetween]
        ]);
        $reservation = $request->session()->get('reservation');
        $reservation->fill($validated);
        $reservation->save();
        $request->session()->forget('reservation');

        return to_route('thankyou');
    }
    public function getEmailForm()
    {
        return view('reservations.check-email');
    }

    public function verify(Request $request)
{
    $email = $request->input('email');
    $cpf = $request->input('cpf');

    $reservations = Reservation::where('email', $email)
        ->where('cpf', $cpf)
        ->get();
    if ($reservations->isEmpty()) {
        return view('reservations.check-email')->with('warning', 'Nenhuma reserva foi encontrada!');;
    }

    return view('reservations.check', compact('reservations'));
}

    public function getReservationsByEmail($email)
{
    $reservations = Reservation::where('email', $email)->get();

    return view('reservations.check', compact('reservations'));
}

public function edit($id)
{
    $reservation = Reservation::findOrFail($id);
    $tables = Category::where('guest_number', '>=', $reservation->guest_number)
        ->get();

    return view('reservations.guest-edit', compact('reservation', 'tables'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'tel_number' => ['required', 'string', 'max:20'],
        'res_date' => ['required', 'date'],
        'table_id' => ['required', 'exists:categories,id'],
        'guest_number' => ['required', 'integer', 'min:1'],
        'cpf' => ['required', 'string'],
        'idade' => ['required', 'integer'],
    ]);

    $reservation = Reservation::findOrFail($id);
    $reservation->update([
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'email' => $validated['email'],
        'tel_number' => $validated['tel_number'],
        'res_date' => $validated['res_date'],
        'table_id' => $validated['table_id'],
        'guest_number' => $validated['guest_number'],
        'cpf' => $validated['cpf'],
        'idade' => $validated['idade'],
    ]);

    return redirect()->route('dashboard')->with('success', 'Reserva atualizada com sucesso!');
}

public function destroy($id)
{
    $reservation = Reservation::findOrFail($id);
    $reservation->delete();

        return view('reservations.deleted')->with('warning', 'Reserva deletada com sucesso!');
    }

public function deleted()
{

        return view('reservations.deleted');
    }

}
