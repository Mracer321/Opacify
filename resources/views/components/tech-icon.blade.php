@props([
    'tech',
    'class' => 'h-6 w-6',
    'box' => 'h-10 w-10',
    'boxed' => true,
])

@php
    $logo = \App\Support\TechLogo::logoFor($tech);
    $boxClasses = $boxed
        ? 'tech-logo-box inline-flex shrink-0 items-center justify-center rounded-lg bg-white p-1.5 ring-1 ring-slate-200/80 shadow-sm ' . $box
        : 'inline-flex shrink-0 items-center justify-center ';
@endphp

<span {{ $attributes->merge(['class' => $boxClasses]) }} title="{{ $tech }}">
    @if ($logo)
        <svg
            class="tech-logo {{ $class }}"
            viewBox="{{ $logo['viewBox'] }}"
            xmlns="http://www.w3.org/2000/svg"
            role="img"
            aria-label="{{ $tech }} logo"
        >{!! $logo['svg'] !!}</svg>
    @else
        <span class="flex {{ $class }} items-center justify-center rounded bg-slate-100 text-[10px] font-bold uppercase text-slate-500" aria-hidden="true">
            {{ strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $tech), 0, 2)) }}
        </span>
    @endif
</span>
