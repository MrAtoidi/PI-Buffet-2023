<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto" style="text-align: center; padding-top: 30px">
        <h1 style="margin-bottom: 10px">Reserva cancelada com sucesso.</h1>
        <a href="{{ route('reservations.step.one') }}"
            class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white" style="margin-bottom: 5px">Nova
            reserva</a>
    </div>
</x-guest-layout>
