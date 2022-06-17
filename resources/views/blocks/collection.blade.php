<div>
    <div class="swiper slider slider_main">
        <div class="swiper-wrapper slider__wrapper">
            @forelse($collection as $item)
                <div class="swiper-slide slider__item">
                    @include('blocks.card', ['item' => $item])
                </div>
            @empty
            @endforelse
        </div>
        <div class="swiper-button-prev arrow arrow_left"></div>
        <div class="swiper-button-next arrow arrow_right"></div>
        <div class="collections-pagination"></div>
    </div>
</div>
