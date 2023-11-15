<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto" style="text-align: center; padding-top: 30px">
        <h1>Obrigado!</h1>
        <p style="margin-bottom: 10px">A sua reserva foi efetuada com sucesso!</p>
        <a href="{{ route('reservations.check.form') }}"
            class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white" style="margin-bottom: 5px">Verificar
            situação</a>
    </div>
</x-guest-layout>
