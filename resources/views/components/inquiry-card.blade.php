@props([
    'title' => 'Discuss your project',
    'description' => 'Share a brief overview and our team will respond with scope, timeline, and team options within one business day.',
    'service' => null,
    'href' => '/contact',
    'buttonLabel' => 'Request consultation',
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200/90 bg-white p-6 shadow-soft sm:p-7']) }}>
    <div class="flex items-start gap-3">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
        </span>
        <div>
            <h3 class="font-display text-lg font-semibold text-navy-950">{{ $title }}</h3>
            <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $description }}</p>
        </div>
    </div>
    @if($service)
        <p class="mt-4 text-xs font-medium uppercase tracking-wider text-slate-400">Service focus</p>
        <p class="mt-1 text-sm font-semibold text-brand-800">{{ $service }}</p>
    @endif
    <div class="mt-5 flex flex-wrap gap-3">
        <x-button href="{{ $service ? $href . '?service=' . urlencode($service) : $href }}" variant="primary" size="md">{{ $buttonLabel }}</x-button>
        <x-button href="tel:+919876543210" variant="secondary" size="md">Call us</x-button>
    </div>
</div>
