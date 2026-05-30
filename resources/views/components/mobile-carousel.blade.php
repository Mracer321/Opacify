@props([
    'count' => 1,
    'label' => 'Carousel',
    'peek' => false,
    'hint' => true,
])

<div
    {{ $attributes->merge(['class' => 'mobile-carousel lg:hidden']) }}
    x-data="mobileCarousel({ count: {{ (int) $count }}, peek: {{ $peek ? 'true' : 'false' }} })"
    x-init="init()"
    @touchstart.passive="onTouchStart($event)"
    @touchend.passive="onTouchEnd($event)"
    role="region"
    aria-roledescription="carousel"
    aria-label="{{ $label }}"
>
    @if($hint && $count > 1)
        <p class="carousel-swipe-hint" aria-hidden="true">
            <x-icon name="arrow-right" class="h-3.5 w-3.5 rotate-180 opacity-60" />
            <span>Swipe to explore</span>
            <x-icon name="arrow-right" class="h-3.5 w-3.5 opacity-60" />
        </p>
    @endif

    <div class="mobile-carousel-shell">
        @if($count > 1)
            <button
                type="button"
                class="carousel-nav carousel-nav-prev"
                @click="prev()"
                :disabled="active === 0"
                aria-label="Previous slide"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        @endif

        <div class="mobile-carousel-viewport" x-ref="viewport" :class="{ 'is-peek': peek }">
            <div
                class="mobile-carousel-track"
                :class="{ 'is-peek': peek }"
                x-ref="track"
                :style="trackStyle"
            >
                {{ $slot }}
            </div>
        </div>

        @if($count > 1)
            <button
                type="button"
                class="carousel-nav carousel-nav-next"
                @click="next()"
                :disabled="active >= total - 1"
                aria-label="Next slide"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        @endif
    </div>

    @if($count > 1)
        <div class="carousel-dots" role="tablist" aria-label="Slide navigation">
            @for($i = 0; $i < $count; $i++)
                <button
                    type="button"
                    class="mobile-carousel-dot"
                    :class="{ 'is-active': active === {{ $i }} }"
                    @click="goTo({{ $i }})"
                    :aria-selected="active === {{ $i }} ? 'true' : 'false'"
                    role="tab"
                    aria-label="Go to slide {{ $i + 1 }}"
                ></button>
            @endfor
        </div>
    @endif
</div>
