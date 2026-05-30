@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'center',
    'light' => false,
])

@php
$alignClass = $align === 'left' ? 'text-left' : 'text-center mx-auto';
$titleColor = $light ? 'text-white' : 'text-navy';
$descColor = $light ? 'text-slate-300' : 'text-slate-500';
$eyebrowRowClass = $align === 'left' ? 'flex items-center gap-3' : 'flex items-center justify-center gap-3';
@endphp

<div class="{{ $alignClass }} max-w-3xl {{ $attributes->get('class') }}">
    @if($eyebrow)
        <div class="{{ $eyebrowRowClass }} mb-3">
            <span class="eyebrow-line" aria-hidden="true"></span>
            <p class="{{ $light ? 'eyebrow-accent-light' : 'eyebrow-accent' }}">{{ $eyebrow }}</p>
            @if($align !== 'left')
                <span class="eyebrow-line" aria-hidden="true"></span>
            @endif
        </div>
    @endif
    <h2 class="heading-section {{ $titleColor }} text-balance">{{ $title }}</h2>
    @if($description)
        <p class="mt-4 text-lead {{ $descColor }}">{{ $description }}</p>
    @endif
    {{ $slot }}
</div>
