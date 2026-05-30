@props(['stats' => []])

{{-- Mobile & tablet: 2×2 equal grid --}}
<dl {{ $attributes->merge(['class' => 'stat-grid-mobile lg:hidden']) }}>
    @foreach($stats as $stat)
        <div class="stat-cell">
            @if(!empty($stat['icon']))
                <x-icon-box :icon="$stat['icon']" variant="soft" class="!h-10 !w-10 shrink-0" />
            @endif
            <dt class="mt-3 font-medium text-slate-500">{{ $stat['label'] }}</dt>
            <dd class="font-display text-2xl font-semibold tracking-tight text-brand-600 sm:text-3xl">{{ $stat['value'] }}</dd>
            @if(!empty($stat['note']))
                <p class="stat-note mt-1 text-slate-500">{{ $stat['note'] }}</p>
            @endif
        </div>
    @endforeach
</dl>

{{-- Desktop: unchanged layout --}}
<dl class="hidden gap-6 lg:grid lg:grid-cols-2">
    @foreach($stats as $stat)
        <div class="card-premium flex gap-4 p-6">
            @if(!empty($stat['icon']))
                <x-icon-box :icon="$stat['icon']" variant="soft" class="!h-10 !w-10 shrink-0" />
            @endif
            <div>
                <dt class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</dt>
                <dd class="mt-1 font-display text-3xl font-semibold tracking-tight text-brand-600">{{ $stat['value'] }}</dd>
                @if(!empty($stat['note']))
                    <p class="mt-1 text-xs text-slate-500">{{ $stat['note'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</dl>
