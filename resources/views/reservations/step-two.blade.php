<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="flex items-center min-h-screen bg-gray-50">
            <div class="flex-1 h-full max-w-4xl mx-auto bg-white rounded-lg shadow-xl">
                <div class="flex flex-col md:flex-row">
                    <div class="h-32 md:h-auto md:w-1/2">
                        <img class="object-cover w-full h-full"
                            src="https://cdn.pixabay.com/photo/2021/01/15/17/01/green-5919790__340.jpg" alt="img" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                        <div class="w-full">
                            <h3 class="mb-4 text-xl font-bold text-blue-600">Solicitar reserva</h3>

                            <div class="w-full bg-gray-200 rounded-full">
                                <div
                                    class="w-100 p-1 text-xs font-medium leading-none text-center text-blue-100 bg-blue-600 rounded-full">
                                    Segundo passo</div>
                            </div>

                            <form method="POST" action="{{ route('reservations.store.step.two') }}">
                                @csrf



                                <div class="sm:col-span-6 pt-5">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Pacotes de
                                        comida</label>
                                    <div class="mt-1">
                                        <select id="table_id" name="table_id"
                                            class="form-multiselect block w-full mt-1">
                                            <option value="" selected disabled>Escolha o seu pacote de comidas
                                            </option>
                                            @foreach ($tables as $table)
                                                <option value="{{ $table->id }}" data-price="{{ $table->price }}"
                                                    {{ $table->id == $reservation->table_id ? 'selected' : '' }}>
                                                    {{ $table->name }} (Comporta
                                                    {{ $table->guest_number }} convidados)
                                                </option>
                                            @endforeach
                                        </select>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const tableSelect = document.getElementById('table_id');
                                                const selectedPrice = document.getElementById('selectedPrice');
                                                tableSelect.addEventListener('change', function() {
                                                    const selectedOption = tableSelect.options[tableSelect.selectedIndex];
                                                    const selectedPriceValue = selectedOption.getAttribute('data-price');
                                                    selectedPrice.textContent = `O preço do pacote selecionada é: R$${selectedPriceValue}`;
                                                });
                                            });
                                        </script>
                                    </div>
                                    @error('table_id')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="sm:col-span-6">
                                    <label for="res_date" class="block text-sm font-medium text-gray-700">Data da
                                        reserva</label>
                                    <div class="mt-1">
                                        <input type="datetime-local" id="res_date" name="res_date"
                                            value="{{ $reservation && $reservation->res_date ? $reservation->res_date->format('Y-m-d\TH:i:s') : '' }}"
                                            class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    <div id="availability-msg" class="text-sm text-red-400 availability-msg"></div>
                                    <span class="text-xs"><a href="{{ route('reservations.timings') }}">Confira o nosso
                                            horário de disponibilidade.
                                            Clique
                                            aqui.</a></span>
                                    <div id="availability-msg" class="text-sm text-red-400 availability-msg"></div>
                                    @error('res_date')
                                        <div class="text-sm text-red-400">{{ $message }}</div>
                                    @enderror
                                    <h4 id="selectedPrice">
                                        @if (!is_null($reservation->table_id))
                                            Preço da reserva: R${{ $selectedTablePrice }}
                                        @else
                                            Nenhuma mesa selecionada
                                        @endif
                                    </h4>
                                </div>


                                <div class="mt-6 p-4 flex justify-between">
                                    <a href="{{ route('reservations.step.one') }}"
                                        class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Anterior</a>
                                    <button type="submit"
                                        class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white"
                                        id="reservation-btn" disabled="true">Solicitar
                                        reserva</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-guest-layout>
