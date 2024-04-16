@props([
    'images' => [],
])

<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        @foreach ($images as $image)
            <div class="swiper-slide">
                <a href="{{ $image->url }}" target="_blank" class="w-full h-auto">
                    <img src="{{ $image->url }}" alt="" srcset="">
                </a>
            </div>
        @endforeach

        {{-- <div class="swiper-slide">Slide 2</div>
        <div class="swiper-slide">Slide 3</div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
        <div class="swiper-slide">Slide 6</div>
        <div class="swiper-slide">Slide 7</div>
        <div class="swiper-slide">Slide 8</div>
        <div class="swiper-slide">Slide 9</div> --}}
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>




@push('js')
    <script>
        var swiper = new Swiper(".mySwiper", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
@endpush
