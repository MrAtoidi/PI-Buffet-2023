<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end m-2 p-2">
                <a href="{{ route('admin.reservations.index') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white mr-2">Voltar</a>
                <a href="{{ route('admin.confirmation.form', ['reservation_id' => $reservation->id]) }} }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Novo convidado</a>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-md sm:rounded-lg">
                            <table class="min-w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Nome
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            CPF
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Idade
                                        </th>
                                        @if ($reservation->status == 3)
                                            <th scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                Chegou?
                                            </th>
                                        @endif
                                        <th scope="col" class="relative py-3 px-6">
                                            <span class="sr-only">Editar</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($confirmedGuests as $guest)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $guest->first_name }} {{ $guest->last_name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $guest->cpf }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $guest->age }}
                                            </td>
                                            @if ($reservation->status == 3)
                                                <td
                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    @if ($guest->arrived == 1)
                                                        SIM
                                                    @else
                                                        NÃO
                                                    @endif
                                                </td>
                                            @endif
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                @if ($reservation->status == 3)
                                                    @if (!$guest->arrived)
                                                        <form action="{{ route('confirm-presence', $guest->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Você tem certeza?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg text-white">
                                                                Confirmar Presença
                                                            </button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <div class="flex space-x-2">
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="{{ route('guests.remove', ['guest' => $guest->id]) }}"
                                                            onsubmit="return confirm('Você tem certeza?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit">Remover convidado</button>
                                                        </form>
                                                    </div>
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


</x-admin-layout>
