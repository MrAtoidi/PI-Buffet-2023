@if ($reservation->status == 0 || $reservation->status == 2)
    <x-guest-layout>
        <div class="container w-full px-5 py-6 mx-auto" style="text-align: center; padding-top: 30px">
            <h1>Esta reserva está pendente!</h1>
            <p style="margin-bottom: 10px">Volte quando a reserva for aprovada!</p>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-lg  text-white"
                style="margin-bottom: 5px">Seu perfil</a>
        </div>
    </x-guest-layout>
@else
    <x-guest-layout>
        <div class="flex justify-end m-2 p-2">
            <a href="{{ route('dashboard') }}"
                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Voltar</a>
        </div>
        <div class="flex justify-center" style="margin-top: 20px; margin-bottom: 20px;">
            <form class="w-full max-w-lg"
                action="{{ route('confirmation.save', ['reservation_id' => $reservation->id]) }}" method="post"
                method="post">
                @csrf
                <div id="guests-container">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-first-name">
                                Primeiro nome
                            </label>
                            <input name="guests[0][first_name]"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-first-name" type="text" placeholder="Jane" required>

                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-last-name">
                                Último nome
                            </label>
                            <input name="guests[0][last_name]"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-last-name" type="text" placeholder="Doe" required>
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-cpf">
                                CPF
                            </label>
                            <input name="guests[0][cpf]"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-cpf" type="text" placeholder="123.456.789-00" required>
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-age">
                                Idade
                            </label>
                            <input name="guests[0][age]"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-age" type="text" placeholder="25" required>
                        </div>
                        <input type="hidden" name="guests[0][user_id]" value="{{ auth()->id() }}">
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}"
                            value="{{ $reservation->id }}">

                    </div>
                </div>

                <button
                    class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mr-2"
                    type="button" id="add-guest">Adicionar outro convidado</button>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit"
                    style="background-color: rgb(59 130 246);" onmouseover="this.style.backgroundColor='#1976D2'"
                    onmouseout="this.style.backgroundColor='rgb(59 130 246)'">Confirmar presença</button>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                let guestIndex = 1;

                $('#add-guest').click(function() {
                    $('#guests-container').append(
                        '<hr class="my-8" style="margin-top: 15px; margin-bottom: 15px;">' +
                        '<div class="flex flex-wrap -mx-3 mb-6">' +
                        '<div class="w-full md:w-1/2 px-3">' +
                        '<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"' +
                        'for="grid-first-name' + guestIndex + '" required>' +
                        'First Name' +
                        '</label>' +
                        '<input name="guests[' + guestIndex +
                        '][first_name]" class="appearance-none block w-full bg-gray-200 text-gray-700 border ' +
                        'border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none ' +
                        'focus:bg-white" id="grid-first-name' + guestIndex + '" type="text" ' +
                        'placeholder="Jane" required>' +
                        '</div>' +
                        '<div class="w-full md:w-1/2 px-3">' +
                        '<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" ' +
                        'for="grid-last-name' + guestIndex + '">' +
                        'Last Name' +
                        '</label>' +
                        '<input name="guests[' + guestIndex +
                        '][last_name]" class="appearance-none block w-full bg-gray-200 text-gray-700 border ' +
                        'border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none ' +
                        'focus:bg-white focus:border-gray-500" id="grid-last-name' + guestIndex + '" ' +
                        'type="text" placeholder="Doe" required>' +
                        '</div>' +
                        '<div class="w-full md:w-1/2 px-3">' +
                        '<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" ' +
                        'for="grid-cpf' + guestIndex + '">' +
                        'CPF' +
                        '</label>' +
                        '<input name="guests[' + guestIndex +
                        '][cpf]" class="appearance-none block w-full bg-gray-200 text-gray-700 border ' +
                        'border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none ' +
                        'focus:bg-white focus:border-gray-500" id="grid-cpf' + guestIndex + '" ' +
                        'type="text" placeholder="123.456.789-00" required>' +
                        '</div>' +
                        '<div class="w-full md:w-1/2 px-3">' +
                        '<label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" ' +
                        'for="grid-age' + guestIndex + '">' +
                        'Age' +
                        '</label>' +
                        '<input name="guests[' + guestIndex +
                        '][age]" class="appearance-none block w-full bg-gray-200 text-gray-700 border ' +
                        'border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none ' +
                        'focus:bg-white focus:border-gray-500" id="grid-age' + guestIndex + '" ' +
                        'type="text" placeholder="25" required>' +
                        '</div>' +
                        '<input type="hidden" name="guests[' + guestIndex +
                        '][user_id]" value="{{ auth()->id() }}">' +
                        '<input type="hidden" name="guests[' + guestIndex +
                        '][reservation_id]" value="{{ $reservation->id }}">' +
                        '</div>'
                    );
                    guestIndex++;
                    $('#guests-container').append('<hr class="my-8">');
                });
            });
        </script>
    </x-guest-layout>
@endif
