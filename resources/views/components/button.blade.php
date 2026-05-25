@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
$base = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

$variants = [
    'primary' => 'bg-brand-700 text-white shadow-sm hover:bg-brand-800 hover:shadow-md focus:ring-brand-500',
    'secondary' => 'border border-slate-200 bg-white text-navy-950 shadow-sm hover:border-slate-300 hover:bg-slate-50 focus:ring-slate-300',
    'outline-light' => 'border border-white/30 bg-white/10 text-white backdrop-blur hover:bg-white/20 focus:ring-white/50',
    'accent' => 'bg-accent-600 text-white hover:bg-accent-500 focus:ring-accent-500',
];

$sizes = [
    'sm' => 'px-3.5 py-2 text-sm',
    'md' => 'px-5 py-2.5 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
