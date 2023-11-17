<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuffetTiming;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BuffetTimingController extends Controller
{
    // ...

    public function index()
    {
        $weekdays = [
        0 => 'Domingo',
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
    ];

        $buffetTimings = BuffetTiming::orderBy('day_of_week')->get();
        return view('admin.buffettimings.index', compact('buffetTimings', 'weekdays'));
    }

    public function indexGuest()
    {
        $weekdays = [
        0 => 'Domingo',
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
    ];

        $buffetTimings = BuffetTiming::orderBy('day_of_week')->get();
        return view('reservations.timings', compact('buffetTimings', 'weekdays'));
    }

    public function create()
    {
        return view('admin.buffettimings.create');
    }

function formatarInputTime($inputTime) {
    // Obtém a data atual
    $dataAtual = date('Y-m-d');

    // Combina a data atual com o valor do input time
    $dataHoraFormatada = $dataAtual . ' ' . $inputTime;

    // Retorna a data e hora formatada
    return $dataHoraFormatada;
}

// Exemplo de uso:


public function store(Request $request)
{
    $date_start_1 = Carbon::today();
    $date_start_2 = Carbon::today();

    $start_time = Carbon::createFromTimeString($request->start_time);
    $end_time = Carbon::createFromTimeString($request->end_time);

    $date_start = $date_start_1->setTime($start_time->hour, $start_time->minute, $start_time->second);
    $date_end = $date_start_2->setTime($end_time->hour, $end_time->minute, $end_time->second);

    try {
        $validatedData = $request->validate([
            'day_of_week' => 'required|integer',
        ]);

        Log::info('Dados validados:', $validatedData);

        $validatedData['start_time'] = $date_start->format('Y-m-d H:i:s');
        $validatedData['end_time'] = $date_end->format('Y-m-d H:i:s');

        BuffetTiming::create($validatedData);

        return redirect()->route('admin.buffettimings.index')->with('success', 'Buffet timing criado com sucesso!');
    } catch (\Exception $e) {
        Log::error('Erro ao criar BuffetTiming: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Erro ao criar BuffetTiming. Verifique os registros para mais detalhes.');
    }
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
    public function edit(BuffetTiming $buffet_timing, $id)
{
    $buffet_timing = BuffetTiming::findOrFail($id);
    return view('admin.buffettimings.edit', compact('buffet_timing'));
}

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuffetTiming $buffet_timing, $id)
{
    $buffet_timing = BuffetTiming::findOrFail($id);
    $date_start_1 = Carbon::today();
    $date_start_2 = Carbon::today();

    $start_time = Carbon::createFromTimeString($request->start_time);
    $end_time = Carbon::createFromTimeString($request->end_time);

    $date_start = $date_start_1->setTime($start_time->hour, $start_time->minute, $start_time->second);
    $date_end = $date_start_2->setTime($end_time->hour, $end_time->minute, $end_time->second);

    try {
        $validatedData = $request->validate([
            'day_of_week' => 'required|integer',
        ]);


        Log::info('Dados validados:', $validatedData);

        $validatedData['start_time'] = $date_start->format('Y-m-d H:i:s');
        $validatedData['end_time'] = $date_end->format('Y-m-d H:i:s');

    $buffet_timing->update($validatedData);

    return redirect()->route('admin.buffettimings.index')->with('success', 'Buffet timing atualizado com sucesso!');

    } catch (\Exception $e) {
        Log::error('Erro ao criar BuffetTiming: ' . $e->getMessage());
        return back()->withInput()->with('error', 'Erro ao criar BuffetTiming. Verifique os registros para mais detalhes.');
    }
}

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuffetTiming $buffet_timing)
{
    try {
        $buffet_timing->delete();

        return redirect()->route('admin.buffettimings.index')->with('success', 'Buffet timing deleted successfully!');
    } catch (\Exception $e) {
        Log::error('Error deleting BuffetTiming: ' . $e->getMessage());
        return back()->with('error', 'Error deleting BuffetTiming. Please check the logs for more details.');
    }
}
}
