<x-admin-layout>
    <div class="container">
        <h1>Avaliação da reserva #{{ $reservation->id }}</h1>

        @if ($reviews->isEmpty())
            <p>Essa reserva não foi avaliada.</p>
        @else
            @foreach ($reviews as $review)
                <p><strong>Usuário:</strong> {{ optional($review->user)->name }}</p>
                <p><strong>Nota (0 a 5):</strong> {{ $review->rating }}</p>
                <p><strong>Comentário:</strong> </p>
                <p>{!! $review->review !!}</p>
                <!-- Outros detalhes da avaliação -->
            @endforeach
        @endif
    </div>
</x-admin-layout>
