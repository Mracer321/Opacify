@props([
    'count' => 1,
    'label' => 'Carousel',
])

<div
    {{ $attributes->merge(['class' => 'mobile-carousel lg:hidden']) }}
    x-data="mobileCarousel({{ (int) $count }})"
    @touchstart.passive="onTouchStart($event)"
    @touchend.passive="onTouchEnd($event)"
    role="region"
    aria-roledescription="carousel"
    aria-label="{{ $label }}"
>
    <div class="mobile-carousel-viewport overflow-hidden">
        <div
            class="mobile-carousel-track flex transition-transform duration-300 ease-out will-change-transform"
            :style="`transform: translateX(-${active * 100}%)`"
        >
            {{ $slot }}
        </div>
    </div>
    @if($count > 1)
        <div class="mt-4 flex items-center justify-center gap-2" role="tablist" aria-label="Slide navigation">
            @for($i = 0; $i < $count; $i++)
                <button
                    type="button"
                    class="mobile-carousel-dot"
                    :class="{ 'is-active': active === {{ $i }} }"
                    @click="goTo({{ $i }})"
                    :aria-selected="active === {{ $i }} ? 'true' : 'false'"
                    aria-label="Go to slide {{ $i + 1 }}"
                ></button>
            @endfor
        </div>
    @endif
</div>
