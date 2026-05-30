@props([
    'name',
    'class' => 'h-5 w-5',
])

@php
$icons = [
    'mail' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/><path d="M3 7l9 6l9-6"/>',
    'phone' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 005 5L15 13l5 2v4a2 2 0 01-2 2A16 16 0 015 6z"/>',
    'map-pin' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 106 0a3 3 0 00-6 0z"/><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>',
];
@endphp

<svg {{ $attributes->merge(['class' => $class]) }} fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $icons[$name] ?? $icons['mail'] !!}
</svg>
