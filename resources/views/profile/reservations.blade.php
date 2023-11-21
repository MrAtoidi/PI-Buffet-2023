<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" style="
    padding-right: 250px;
">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end m-2 p-2">
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Voltar</a>
            </div>
            <div class="flex flex-col">
                <div class="sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
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
                                            Confirmados/Convidados
                                        </th>
                                        <th scope="col" class="relative py-3 px-6">
                                            <span class="sr-only">Editar</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $reservation)
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
                                                <a href="{{ route('reservations.confirmed-guests', ['reservation' => $reservation->id]) }}"
                                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">{{ $reservation->confirmed_guests_count }}/{{ $reservation->guest_number }}</a>

                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                <!-- Reserva sem nenhuma alteração do usuário -->
                                                @if ($reservation->status == 0)
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('reservations.guest-edit', $reservation->id) }}"
                                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">Editar</a>
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="{{ route('reservations.cancel', $reservation->id) }}"
                                                            onsubmit="return confirm('Você tem certeza?');">
                                                            @csrf
                                                            <button type="submit">Cancelar</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <!-- Reserva confirmada -->
                                                @if ($reservation->status == 1)
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('reservations.guest-edit', $reservation->id) }}"
                                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">Editar</a>
                                                        <a href="{{ route('confirmation.form', $reservation->id) }}"
                                                            class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-white">Convite</a>
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="{{ route('reservations.cancel', $reservation->id) }}"
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
                                                            class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="{{ route('reservations.pending', $reservation->id) }}"
                                                            onsubmit="return confirm('Você tem certeza?');">
                                                            @csrf
                                                            <button type="submit">Solicitar novamente</button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <!-- Reserva iniciada -->
                                                @if ($reservation->status == 3)
                                                    <div class="flex space-x-2">
                                                    </div>
                                                @endif
                                                <!-- Reserva finalizada -->
                                                @if ($reservation->status == 4)
                                                    <a href="{{ route('reviews.create', $reservation->id) }}"
                                                        class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded-lg text-white">Avaliar</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
