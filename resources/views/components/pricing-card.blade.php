@props([
    'icon',
    'title',
    'description',
    'price',
    'note',
])

<article {{ $attributes->merge(['class' => 'card-premium card-equal flex min-h-full flex-col p-6 sm:p-8']) }}>
    <x-icon-box :icon="$icon" variant="soft" class="!h-11 !w-11" />
    <h3 class="mt-4 font-display text-xl font-semibold text-navy">{{ $title }}</h3>
    <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ $description }}</p>
    <p class="mt-6 font-display text-2xl font-semibold text-brand-600">{{ $price }}</p>
    <p class="mt-1 text-xs text-slate-500">{{ $note }}</p>
    <x-button href="/contact" variant="secondary" class="btn-touch mt-6 w-full">Discuss this model</x-button>
</article>
