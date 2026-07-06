@props([
    'variant' => 'default',
    'class' => '',
])

@php
$variants = [
    'default' => ['src' => '/images/brand/opacify-logo.svg', 'alt' => 'OpacifyWeb'],
    'dark' => ['src' => '/images/brand/opacify-logo.svg', 'alt' => 'OpacifyWeb'],
    'icon' => ['src' => '/images/favicon.png', 'alt' => 'OpacifyWeb'],
];
$config = $variants[$variant] ?? $variants['default'];
@endphp

<img
    src="{{ $config['src'] }}"
    alt="{{ $config['alt'] }}"
    {{ $attributes->merge(['class' => trim($class)]) }}
    width="{{ $variant === 'icon' ? '36' : '185' }}"
    height="{{ $variant === 'icon' ? '36' : '40' }}"
    loading="eager"
    decoding="async"
/>
