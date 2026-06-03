@props(['name', 'size' => 'h-6 w-6', 'box' => 'h-11 w-11'])

@php
$iconMap = [
    'web' => 'computer-desktop',
    'mobile' => 'smartphone',
    'erp' => 'building-office',
    'software' => 'command-line',
    'marketing' => 'megaphone',
    'ai' => 'sparkles',
];
$iconName = $iconMap[$name] ?? 'command-line';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100 ' . $box]) }} aria-hidden="true">
    <x-icon :name="$iconName" :class="$size" />
</span>
