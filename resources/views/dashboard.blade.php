<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto" style="text-align: center; padding-top: 30px">
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Suas reservas
                    </label>
                    <p class="text-red-500 text-xs italic">Verifique a situação das suas reservas.</p>
                    <div class="flex items-center" style="justify-content: center;">
                        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            style="background-color: rgb(59 130 246);"
                            onmouseover="this.style.backgroundColor='#1976D2'"
                            href="{{ route('profile.reservations') }}">
                            Clique aqui
                        </a>
                    </div>

                </div>

            </form>

        </div>
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Festas em que você foi convidado
                    </label>
                    <p class="text-red-500 text-xs italic">Verifique as festas que você preencheu o formulário para ser
                        convidado.</p>
                    <div class="flex items-center" style="justify-content: center;">
                        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            style="background-color: rgb(59 130 246);"
                            onmouseover="this.style.backgroundColor='#1976D2'" href="{{ route('profile.guest-at') }}">
                            Clique aqui
                        </a>
                    </div>

                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
