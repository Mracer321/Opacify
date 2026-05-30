@props([
    'icon',
    'variant' => 'brand',
])

@php
$variants = [
    'brand' => 'bg-brand-500 text-white shadow-sm',
    'soft' => 'bg-brand-50 text-brand-600 ring-1 ring-brand-100',
    'slate' => 'bg-slate-100 text-slate-600',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl ' . ($variants[$variant] ?? $variants['brand'])]) }}>
    <x-icon :name="$icon" class="h-5 w-5" />
</span>
