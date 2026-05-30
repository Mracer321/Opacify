@props([
    'variant' => 'default',
    'class' => '',
])

@php
$variants = [
    'default' => ['src' => '/images/logo.png', 'alt' => 'Hire Developer'],
    'dark' => ['src' => '/images/logo-dark.png', 'alt' => 'Hire Developer'],
    'icon' => ['src' => '/images/favicon.png', 'alt' => 'Hire Developer'],
];
$config = $variants[$variant] ?? $variants['default'];
@endphp

<img
    src="{{ $config['src'] }}"
    alt="{{ $config['alt'] }}"
    {{ $attributes->merge(['class' => trim($class)]) }}
    width="{{ $variant === 'icon' ? '36' : '180' }}"
    height="{{ $variant === 'icon' ? '36' : '40' }}"
    loading="eager"
    decoding="async"
/>
