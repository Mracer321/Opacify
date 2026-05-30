@props([
    'variant' => 'dashboard',
    'title' => null,
    'subtitle' => 'Enterprise workspace',
])

@php
$labels = [
    'dashboard' => 'Operations dashboard',
    'erp' => 'ERP control center',
    'mobile' => 'Mobile field app',
    'analytics' => 'Analytics & reporting',
    'crm' => 'CRM workspace',
    'fintech' => 'Payments console',
];
$label = $labels[$variant] ?? $labels['dashboard'];
@endphp

<div {{ $attributes->merge(['class' => 'ui-mockup overflow-hidden']) }} data-variant="{{ $variant }}">
    <div class="ui-mockup-chrome">
        <div class="flex gap-1.5">
            <span class="ui-mockup-dot"></span>
            <span class="ui-mockup-dot"></span>
            <span class="ui-mockup-dot"></span>
        </div>
        <span class="text-[10px] font-medium uppercase tracking-wider text-slate-400">{{ $label }}</span>
    </div>

    <div class="ui-mockup-body">
        @if($variant === 'mobile')
            <div class="mx-auto max-w-[220px]">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-2 shadow-card">
                    <div class="rounded-[1.25rem] bg-slate-50 p-3">
                        <div class="flex items-center justify-between">
                            <div class="h-2 w-12 rounded bg-slate-200"></div>
                            <div class="h-6 w-6 rounded-full bg-brand-100"></div>
                        </div>
                        <div class="mt-4 space-y-2">
                            @foreach([72, 88, 64] as $w)
                                <div class="flex items-center gap-2 rounded-lg bg-white p-2 shadow-sm">
                                    <div class="h-8 w-8 rounded-md bg-brand-50"></div>
                                    <div class="flex-1 space-y-1">
                                        <div class="h-2 rounded bg-slate-200" style="width: {{ $w }}%"></div>
                                        <div class="h-1.5 w-1/2 rounded bg-slate-100"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 flex justify-around border-t border-slate-200 pt-2">
                            @foreach(range(1, 4) as $i)
                                <div class="h-1.5 w-1.5 rounded-full {{ $i === 1 ? 'bg-brand-600' : 'bg-slate-300' }}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="grid h-full min-h-[220px] grid-cols-[4.5rem_1fr] gap-0">
                <aside class="border-r border-slate-200/80 bg-slate-50/90 p-2">
                    <div class="mb-3 h-2 w-8 rounded bg-brand-200"></div>
                    @foreach(range(1, 5) as $i)
                        <div class="mb-1.5 flex items-center gap-1.5 rounded-md px-1.5 py-1.5 {{ $i === 1 ? 'bg-white shadow-sm ring-1 ring-slate-200/60' : '' }}">
                            <div class="h-1.5 w-1.5 rounded-full {{ $i === 1 ? 'bg-brand-600' : 'bg-slate-300' }}"></div>
                            <div class="h-1.5 flex-1 rounded bg-slate-200"></div>
                        </div>
                    @endforeach
                </aside>
                <div class="flex flex-col p-3 sm:p-4">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            @if($title)
                                <p class="text-xs font-semibold text-slate-700">{{ $title }}</p>
                            @endif
                            <p class="text-[10px] text-slate-400">{{ $subtitle }}</p>
                        </div>
                        <div class="flex gap-1">
                            <div class="h-7 w-16 rounded-md bg-slate-100"></div>
                            <div class="h-7 w-7 rounded-md bg-brand-600/90"></div>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        @foreach([['Active', '2,481'], ['Revenue', '$84k'], ['SLA', '99.9%']] as [$l, $v])
                            <div class="rounded-lg border border-slate-200/80 bg-white p-2 shadow-sm">
                                <p class="text-[9px] uppercase tracking-wide text-slate-400">{{ $l }}</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700">{{ $v }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 flex-1 rounded-lg border border-slate-200/80 bg-white p-2 shadow-sm">
                        <div class="flex h-20 items-end justify-between gap-1 px-1">
                            @foreach([35, 55, 42, 68, 48, 72, 58, 80, 62] as $h)
                                <div class="w-full max-w-[14px] rounded-t bg-gradient-to-t from-brand-600 to-brand-400" style="height: {{ $h }}%"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3 space-y-1.5">
                        @foreach(range(1, 3) as $row)
                            <div class="flex items-center gap-2 rounded border border-slate-100 bg-slate-50/50 px-2 py-1.5">
                                <div class="h-2 w-2 rounded-full bg-emerald-400/80"></div>
                                <div class="h-1.5 flex-1 rounded bg-slate-200"></div>
                                <div class="h-1.5 w-8 rounded bg-slate-200"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
