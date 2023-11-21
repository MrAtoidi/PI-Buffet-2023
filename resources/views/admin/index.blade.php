<x-admin-layout>
    <div class="py-12" style="
    padding-right: 250px;
">
        @if ($countHappeningReservations > 0)

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="sm:-mx-6 lg:-mx-8">
                        <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white"
                                style="color: black;">
                                Festas acontecendo agora:</h1>
                            <div class="overflow-hidden shadow-md sm:rounded-lg">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Nome
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                E-mail
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Idade
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                CPF
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Data da reserva
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Pacote de comida
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Chegaram/Confirmados
                                            </th>
                                            @if (Auth::user()->is_admin == 1)
                                                <th scope="col" class="relative py-3 px-6">
                                                    <span class="sr-only">Editar</span>
                                                </th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $reservation)
                                            @if ($reservation->status == 3)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                                    <td
                                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        @if ($reservation->status == 0)
                                                            🟠
                                                        @endif
                                                        @if ($reservation->status == 1)
                                                            🟢
                                                        @endif
                                                        @if ($reservation->status == 2)
                                                            🔴
                                                        @endif
                                                        @if ($reservation->status == 3)
                                                            🎉
                                                        @endif
                                                        @if ($reservation->status == 4)
                                                            ✅
                                                        @endif
                                                    </td>

                                                    <td
                                                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $reservation->first_name }} {{ $reservation->last_name }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        {{ $reservation->email }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        {{ $reservation->idade }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        {{ $reservation->cpf }}
                                                    </td>


                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        {{ $reservation->res_date }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        {{ $reservation->table->name }}
                                                    </td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                        <a href="{{ route('admin.reservations.confirmed-guests', ['reservation' => $reservation->id]) }}"
                                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">{{ $reservation->confirmed_guests_count }}/{{ $reservation->confirmed_presence_count }}</a>
                                                    </td>
                                                    @if (Auth::user()->is_admin == 1)
                                                        <td
                                                            class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                            <!-- Reserva sem nenhuma alteração do usuário -->
                                                            @if ($reservation->status == 0)
                                                                <div class="flex space-x-2">
                                                                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">Editar</a>
                                                                    <form
                                                                        class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                        method="POST"
                                                                        action="{{ route('admin.reservations.confirm', $reservation->id) }}"
                                                                        onsubmit="return confirm('Você tem certeza?');">
                                                                        @csrf
                                                                        <button type="submit">Confirmar</button>
                                                                    </form>
                                                                    <form
                                                                        class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                                        method="POST"
                                                                        action="{{ route('admin.reservations.cancel', $reservation->id) }}"
                                                                        onsubmit="return confirm('Você tem certeza?');">
                                                                        @csrf
                                                                        <button type="submit">Recusar</button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                            <!-- Reserva confirmada -->
                                                            @if ($reservation->status == 1)
                                                                <div class="flex space-x-2">
                                                                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">Editar</a>
                                                                    <form
                                                                        class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                        method="POST"
                                                                        action="{{ route('admin.reservations.start', $reservation->id) }}"
                                                                        onsubmit="return confirm('Você tem certeza?');">
                                                                        @csrf
                                                                        <button type="submit">Marcar início</button>
                                                                    </form>
                                                                    <form
                                                                        class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                                        method="POST"
                                                                        action="{{ route('admin.reservations.cancel', $reservation->id) }}"
                                                                        onsubmit="return confirm('Você tem certeza?');">
                                                                        @csrf
                                                                        <button type="submit">Cancelar</button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                            <!-- Reserva cancelada -->
                                                            @if ($reservation->status == 2)
                                                                <div class="flex space-x-2">
                                                                    <form
                                                                        class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                        method="POST"
                                                                        action="{{ route('admin.reservations.confirm', $reservation->id) }}"
                                                                        onsubmit="return confirm('Você tem certeza?');">
                                                                        @csrf
                                                                        <button type="submit">Confirmar
                                                                            reserva</button>
                                                                    </form>
                                                                    <form
                                                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white"
                                                                        method="POST"
                                                                        action="{{ route('admin.reservations.pending', $reservation->id) }}"
                                                                        onsubmit="return confirm('Você tem certeza?');">
                                                                        @csrf
                                                                        <button type="submit">Reabrir reserva</button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                            <!-- Reserva iniciada -->
                                                            @if ($reservation->status == 3)
                                                                <div class="flex space-x-2">
                                                                    <form
                                                                        class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                        action="{{ route('admin.reservations.confirmed-guests', $reservation->id) }}">
                                                                        @csrf
                                                                        <button type="submit">
                                                                            Verificar
                                                                            convidados</button>
                                                                    </form>
                                                                    <form
                                                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white"
                                                                        method="POST"
                                                                        action="{{ route('admin.reservations.finish', $reservation->id) }}"
                                                                        onsubmit="return confirm('Você tem certeza?');">
                                                                        @csrf
                                                                        <button type="submit">Finalizar festa</button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                            <!-- Reserva finalizada -->
                                                            @if ($reservation->status == 4)
                                                                <form
                                                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white"
                                                                    method="POST"
                                                                    action="{{ route('admin.reservations.finish', $reservation->id) }}"
                                                                    onsubmit="return confirm('Você tem certeza?');">
                                                                    @csrf
                                                                    <button type="submit">Avaliação</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="sm:-mx-6 lg:-mx-8">
                        <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white"
                                style="color: black;">
                                Festas acontecendo agora:</h1>
                            <p
                                class="mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                                Não há nenhuma festa acontecendo agora.</p>

                        </div>
                    </div>
                </div>
            </div>
        @endif





        @if ($nearestReservation != null)

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="sm:-mx-6 lg:-mx-8">
                        <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white"
                                style="color: black;">
                                Próxima(s) festa(s):</h1>
                            <div class="overflow-hidden shadow-md sm:rounded-lg">

                                <table class="min-w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Nome
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                E-mail
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Idade
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                CPF
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Data da reserva
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Pacote de comida
                                            </th>
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Qtd de convidados
                                            </th>
                                            @if (Auth::user()->is_admin == 1)
                                                <th scope="col" class="relative py-3 px-6">
                                                    <span class="sr-only">Editar</span>
                                                </th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                🟢
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $nearestReservation->first_name }}
                                                {{ $nearestReservation->last_name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $nearestReservation->email }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $nearestReservation->idade }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $nearestReservation->cpf }}
                                            </td>


                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $nearestReservation->res_date }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $nearestReservation->table->name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                {{ $nearestReservation->guest_number }}
                                            </td>
                                            @if (Auth::user()->is_admin == 1)
                                                <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                    <!-- Reserva sem nenhuma alteração do usuário -->
                                                    @if ($nearestReservation->status == 0)
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('admin.reservations.edit', $nearestReservation->id) }}"
                                                                class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">Editar</a>
                                                            <form
                                                                class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.confirm', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Confirmar</button>
                                                            </form>
                                                            <form
                                                                class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.cancel', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Recusar</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    <!-- Reserva confirmada -->
                                                    @if ($nearestReservation->status == 1)
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('admin.reservations.edit', $nearestReservation->id) }}"
                                                                class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">Editar</a>
                                                            <form
                                                                class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.start', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Marcar início</button>
                                                            </form>
                                                            <form
                                                                class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.cancel', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Cancelar</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    <!-- Reserva cancelada -->
                                                    @if ($nearestReservation->status == 2)
                                                        <div class="flex space-x-2">
                                                            <form
                                                                class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.confirm', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Confirmar reserva</button>
                                                            </form>
                                                            <form
                                                                class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.pending', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Reabrir reserva</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    <!-- Reserva iniciada -->
                                                    @if ($nearestReservation->status == 3)
                                                        <div class="flex space-x-2">
                                                            <form
                                                                class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.confirm', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Verificar convidados</button>
                                                            </form>
                                                            <form
                                                                class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white"
                                                                method="POST"
                                                                action="{{ route('admin.reservations.finish', $nearestReservation->id) }}"
                                                                onsubmit="return confirm('Você tem certeza?');">
                                                                @csrf
                                                                <button type="submit">Finalizar festa</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                    <!-- Reserva finalizada -->
                                                    @if ($nearestReservation->status == 4)
                                                        <form
                                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="{{ route('admin.reservations.finish', $nearestReservation->id) }}"
                                                            onsubmit="return confirm('Você tem certeza?');">
                                                            @csrf
                                                            <button type="submit">Avaliação</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="sm:-mx-6 lg:-mx-8">
                        <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white"
                                style="color: black;">
                                Próxima festa:</h1>
                            <p
                                class="mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                                Não há nenhuma festa confirmada para mostrar.</p>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
