@props(['stats' => []])

<dl {{ $attributes->merge(['class' => 'grid gap-6 sm:grid-cols-2 lg:grid-cols-4']) }}>
    @foreach($stats as $stat)
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 text-center shadow-soft sm:text-left">
            <dt class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</dt>
            <dd class="mt-2 font-display text-3xl font-semibold tracking-tight text-navy-950">{{ $stat['value'] }}</dd>
            @if(!empty($stat['note']))
                <p class="mt-1 text-xs text-slate-500">{{ $stat['note'] }}</p>
            @endif
        </div>
    @endforeach
</dl>
