@props(['service'])

<a
    href="/services/{{ $service['slug'] }}"
    class="card-premium group flex h-full flex-col p-6 sm:p-8">
    <x-service-icon :name="$service['icon']" size="h-8 w-8" box="h-14 w-14 rounded-2xl" />
    <h3 class="mt-5 font-display text-xl font-semibold text-navy group-hover:text-brand-700">{{ $service['title'] }}</h3>
    <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600">{{ $service['summary'] }}</p>
    <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
        Learn more
        <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
        </svg>
    </span>
</a>