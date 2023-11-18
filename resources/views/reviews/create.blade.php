<x-guest-layout>
    <form action="{{ route('reviews.store', ['reservation' => $reservation->id]) }}" method="POST" id="reviewForm">
        @csrf

        <div class="flex flex-col items-center">
            <div class="space-y-2">
                <h4>Qual é a nota que você acha que encaixa melhor?</h4>
                <input type="radio" id="html" name="rating" value="1">
                <label for="html">1</label><br>
                <input type="radio" id="css" name="rating" value="2">
                <label for="css">2</label><br>
                <input type="radio" id="javascript" name="rating" value="3">
                <label for="javascript">3</label>
                <input type="radio" id="javascript2" name="rating" value="4">
                <label for="javascript2">4</label>
                <input type="radio" id="javascript3" name="rating" value="4">
                <label for="javascript3">5</label>
            </div>

            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <label for="review" class="text-gray-600">Escreva sobre a sua experiência:</label>
            <textarea name="review" id="review" class="border border-gray-300 rounded-md p-2"></textarea>
            <script type="text/javascript" src='https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js'></script>
            <script>
                tinymce.init({
                    selector: "#review"
                });
            </script>

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                style="background-color: rgb(59 130 246);" onmouseover="this.style.backgroundColor='#1976D2'"
                onmouseout="this.style.backgroundColor='rgb(59 130 246)'">
                Enviar avaliação
            </button>
        </div>
    </form>
</x-guest-layout>

{{-- <form action="{{ route('reviews.store', ['reservation' => $reservation->id]) }}" method="POST">
    @csrf
    <label for="rating">Rating:</label>
    <input type="number" name="rating" min="1" max="5">
    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

    <label for="review">Comment:</label>
    <textarea name="review"></textarea>

    <button type="submit">Submit Review</button>
</form> --}}
