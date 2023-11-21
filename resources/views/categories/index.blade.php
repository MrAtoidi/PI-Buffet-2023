<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="grid lg:grid-cols-4 gap-y-6">
            @foreach ($categories as $category)
                <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg">

                    <div class="overflow-hidden shadow-md sm:rounded-lg">
                        <div class=" shadow-md sm:rounded-lg teste1">
                            <div class="carousel-{{ $category->id }} teste2">
                                <div class="carousel-item">
                                    <div class="inline-block" style="width: 100px; height: 100px;">
                                        <div class="carousel-{{ $category->id }}">
                                            <img src="{{ url("/public/categories/$category->image1") }}" alt=""
                                                class="w-12 h-12 rounded imgslider">
                                            <img src="{{ url("/public/categories/$category->image2") }}" alt=""
                                                class="w-12 h-12 rounded imgslider">
                                            <img src="{{ url("/public/categories/$category->image3") }}" alt=""
                                                class="w-12 h-12 rounded imgslider">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4">

                        <a href="{{ route('categories.show', $category->id) }}">
                            <h4
                                class="mb-3 text-xl font-semibold tracking-tight text-green-600 hover:text-green-400 uppercase">
                                {{ $category->name }}</h4>
                            <span class="text-xl text-green-600">R${{ $category->price }}</span>
                            <p class="leading-normal text-gray-700">{!! $category->description !!}</p>
                        </a>

                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.carousel-{{ $category->id }}').slick({
                            infinite: true,
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 2000
                        });
                    });
                </script>
            @endforeach

        </div>
    </div>
</x-guest-layout>
