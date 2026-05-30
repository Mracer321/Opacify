@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
$base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

$variants = [
    'primary' => 'bg-brand-500 text-white shadow-sm hover:bg-brand-600 focus:ring-brand-500',
    'secondary' => 'bg-navy text-white shadow-sm hover:bg-navy-800 focus:ring-navy',
    'outline' => 'border border-slate-200 bg-white text-navy shadow-sm hover:border-brand-200 hover:bg-brand-50 focus:ring-brand-500',
    'outline-light' => 'border border-white/30 bg-white/10 text-white backdrop-blur hover:border-brand-400/50 hover:bg-white/15 focus:ring-brand-400',
    'accent' => 'bg-brand-500 text-white shadow-sm hover:bg-brand-600 focus:ring-brand-500',
];

$sizes = [
    'sm' => 'min-h-[2.75rem] px-3.5 py-2 text-sm lg:min-h-0',
    'md' => 'min-h-[3rem] px-5 py-3 text-sm lg:min-h-0 lg:py-2.5',
    'lg' => 'min-h-[3rem] px-6 py-3 text-base lg:min-h-0',
];

$classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
