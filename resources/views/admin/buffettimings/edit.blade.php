{{-- <form action="{{ route('admin.buffettimings.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="day_of_week">Dia da Semana:</label>
        <select id="day_of_week" name="day_of_week" class="form-multiselect block w-full mt-1">
            <option value="0">Domingo</option>
            <option value="1">Segunda-feira</option>
            <option value="2">Terça-feira</option>
            <option value="3">Quarta-feira</option>
            <option value="4">Quinta-feira</option>
            <option value="5">Sexta-feira</option>
            <option value="6">Sábado</option>
        </select>
    </div>

    <div class="form-group">
        <label for="start_time">Horário de Início:</label>
        <input type="time" id="start_time" name="start_time" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="end_time">Horário de Término:</label>
        <input type="time" id="end_time" name="end_time" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form> --}}

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-2">
                <a href="{{ route('admin.buffettimings.index') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Reservation Index</a>
            </div>
            <div class="m-2 p-2 bg-slate-100 rounded">
                <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                    <form method="POST"
                        action="{{ route('admin.buffettimings.update', ['id' => $buffet_timing->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="sm:col-span-6">
                            <label for="day_of_week" class="block text-sm font-medium text-gray-700"> Horário de
                            </label>
                            <div class="mt-1">
                                <select id="day_of_week" name="day_of_week" class="form-multiselect block w-full mt-1"
                                    value="{{ $buffet_timing->day_of_week }}">
                                    <option value="0">Domingo</option>
                                    <option value="1">Segunda-feira</option>
                                    <option value="2">Terça-feira</option>
                                    <option value="3">Quarta-feira</option>
                                    <option value="4">Quinta-feira</option>
                                    <option value="5">Sexta-feira</option>
                                    <option value="6">Sábado</option>
                                </select>
                            </div>
                            @error('day_of_week')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="start_time" class="block text-sm font-medium text-gray-700"> Horário de abertura
                            </label>
                            <div class="mt-1">
                                <input type="time" id="start_time" name="start_time"
                                    value="{{ \Carbon\Carbon::parse($buffet_timing->start_time)->format('H:i:s') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('start_time')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="end_time" class="block text-sm font-medium text-gray-700"> Horário de
                                encerramento </label>
                            <div class="mt-1">
                                <input type="time" id="end_time" name="end_time"
                                    value="{{ \Carbon\Carbon::parse($buffet_timing->end_time)->format('H:i:s') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('end_time')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mt-6 p-4">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Salvar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
