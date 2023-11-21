<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar reserva') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-2">
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Voltar</a>
            </div>
            <div class="m-2 p-2 bg-slate-100 rounded">
                <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                    @if ($reservation->status > 0)
                        <form method="POST" action="{{ route('reservations.update', ['id' => $reservation->id]) }}"
                            onsubmit="return confirm('Você tem certeza? A sua reserva está confirmada, se você alterar algum dado, o status será definido como PENDENTE.');">
                        @else
                            <form method="POST"
                                action="{{ route('reservations.update', ['id' => $reservation->id]) }}">
                    @endif

                    @csrf
                    @method('PUT')
                    <div class="sm:col-span-6">
                        <label for="first_name" class="block text-sm font-medium text-gray-700"> Primeiro nome
                        </label>
                        <div class="mt-1">
                            <input type="text" id="first_name" name="first_name"
                                value="{{ old('first_name', $reservation->first_name) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('first_name')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="last_name" class="block text-sm font-medium text-gray-700"> Último nome </label>
                        <div class="mt-1">
                            <input type="text" id="last_name" name="last_name"
                                value="{{ old('last_name', $reservation->last_name) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('last_name')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="email" class="block text-sm font-medium text-gray-700"> E-mail </label>
                        <div class="mt-1">
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $reservation->email) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('email')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="tel_number" class="block text-sm font-medium text-gray-700"> Telefone
                        </label>
                        <div class="mt-1">
                            <input type="text" id="tel_number" name="tel_number"
                                value="{{ old('tel_number', $reservation->tel_number) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('tel_number')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="res_date" class="block text-sm font-medium text-gray-700"> Data da reserva
                        </label>
                        <div class="mt-1">
                            <input type="datetime-local" id="res_date" name="res_date"
                                value="{{ old('res_date', $reservation->res_date->format('Y-m-d\TH:i:s')) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('res_date')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6 pt-5">
                        <label for="status" class="block text-sm font-medium text-gray-700">Pacotes de Comida</label>
                        <div class="mt-1">
                            <select id="table_id" name="table_id" class="form-multiselect block w-full mt-1">
                                @foreach ($tables as $table)
                                    <option value="{{ $table->id }}" data-price="{{ $table->price }}"
                                        {{ $table->id == $reservation->table_id ? 'selected' : '' }}>
                                        {{ $table->name }}
                                        ({{ $table->guest_number }} Guests)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('table_id')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const tableSelect = document.getElementById('table_id');
                            const priceDifference = document.getElementById('price_difference');

                            let selectedPrice = parseFloat({{ $reservation->table->price }});

                            tableSelect.addEventListener('change', function() {
                                const selectedOption = tableSelect.options[tableSelect.selectedIndex];
                                const newPrice = parseFloat(selectedOption.getAttribute('data-price'));

                                const difference = newPrice - selectedPrice;

                                let formattedDifference = '';
                                if (difference > 0) {
                                    formattedDifference = `A pagar: R$${Math.abs(difference).toFixed(2)}`;
                                } else if (difference < 0) {
                                    formattedDifference = `Estorno: R$${Math.abs(difference).toFixed(2)}`;
                                } else {
                                    formattedDifference = 'Não há diferença de preço';
                                }

                                priceDifference.value = formattedDifference;
                            });
                        });
                    </script>

                    <div class="sm:col-span-6">
                        <label for="guest_number" class="block text-sm font-medium text-gray-700"> Qtd de Convidados
                        </label>
                        <div class="mt-1">
                            <input type="number" id="guest_number" name="guest_number"
                                value="{{ old('guest_number', $reservation->guest_number) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('guest_number')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="cpf" class="block text-sm font-medium text-gray-700"> CPF </label>
                        <div class="mt-1">
                            <input type="text" id="cpf" name="cpf"
                                value="{{ old('cpf', $reservation->cpf) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        @error('cpf')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sm:col-span-6">
                        <label for="idade" class="block text-sm font-medium text-gray-700"> Idade </label>
                        <div class="mt-1">
                            <input type="number" id="idade" name="idade"
                                value="{{ old('idade', $reservation->idade) }}"
                                class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <label class="block text-sm font-medium text-gray-700">Diferença de Preço</label>
                            <div class="mt-1">
                                <input
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                    type="text" id="price_difference" name="price_difference" readonly>
                            </div>
                        </div>
                        <div class="mt-6 p-4">

                            <button type="submit"
                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Atualizar</button>
                        </div>
                        @error('idade')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-guest-layout>
