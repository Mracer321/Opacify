@props([
    'title' => 'Project interface',
    'subtitle' => 'Dashboard & workflow preview',
    'variant' => 'dashboard',
])

@php
$variants = [
    'dashboard' => ['from' => 'from-slate-100', 'to' => 'to-brand-50/40', 'label' => 'Admin dashboard'],
    'erp' => ['from' => 'from-slate-100', 'to' => 'to-slate-200', 'label' => 'ERP module view'],
    'mobile' => ['from' => 'from-brand-50', 'to' => 'to-slate-100', 'label' => 'Mobile application'],
    'analytics' => ['from' => 'from-slate-50', 'to' => 'to-brand-100/50', 'label' => 'Analytics panel'],
];
$style = $variants[$variant] ?? $variants['dashboard'];
@endphp

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft']) }}>
    <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-4 py-3">
        <div class="flex gap-1.5">
            <span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
            <span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
            <span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
        </div>
        <span class="text-[10px] font-medium uppercase tracking-wider text-slate-400">{{ $style['label'] }}</span>
    </div>
    <div class="aspect-[16/10] bg-gradient-to-br {{ $style['from'] }} {{ $style['to'] }} p-6 sm:p-8">
        <div class="flex h-full flex-col justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $subtitle }}</p>
                <p class="mt-2 font-display text-lg font-semibold text-slate-600">{{ $title }}</p>
            </div>
            <div class="grid grid-cols-3 gap-2 sm:gap-3">
                @foreach(['Metric', 'Status', 'Queue'] as $block)
                    <div class="rounded-lg border border-white/60 bg-white/70 px-3 py-4 shadow-sm backdrop-blur-sm">
                        <div class="h-2 w-8 rounded bg-slate-200"></div>
                        <div class="mt-3 h-6 w-full rounded bg-slate-100"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
