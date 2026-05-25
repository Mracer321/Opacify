@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'center',
    'light' => false,
])

@php
$alignClass = $align === 'left' ? 'text-left' : 'text-center mx-auto';
$titleColor = $light ? 'text-white' : 'text-navy-950';
$descColor = $light ? 'text-slate-300' : 'text-slate-600';
@endphp

<div class="{{ $alignClass }} max-w-3xl {{ $attributes->get('class') }}">
    @if($eyebrow)
        <p class="mb-3 text-sm font-semibold uppercase tracking-wider {{ $light ? 'text-accent-400' : 'text-brand-700' }}">{{ $eyebrow }}</p>
    @endif
    <h2 class="heading-section {{ $titleColor }} text-balance">{{ $title }}</h2>
    @if($description)
        <p class="mt-4 text-lead {{ $descColor }}">{{ $description }}</p>
    @endif
    {{ $slot }}
</div>
