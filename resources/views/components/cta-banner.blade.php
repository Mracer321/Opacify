@props([
    'title' => 'Ready to hire developers who deliver?',
    'description' => 'Tell us about your project. We will match you with vetted engineers and send a tailored proposal within 24 hours.',
    'primaryLabel' => 'Get Free Quote',
    'primaryHref' => '/contact',
])

<section {{ $attributes->merge(['class' => 'section-padding']) }}>
    <div class="container-narrow">
        <div class="relative overflow-hidden rounded-3xl gradient-hero px-6 py-14 sm:px-12 sm:py-16 lg:px-16">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-brand-500/20 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-brand-500/10 blur-3xl"></div>
            <div class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div class="max-w-2xl">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-brand-300">
                        <x-icon name="sparkles" class="h-3.5 w-3.5 text-brand-400" />
                        Enterprise delivery · Vetted talent
                    </div>
                    <h2 class="font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">{{ $title }}</h2>
                    <p class="mt-4 text-lg leading-relaxed text-slate-300">{{ $description }}</p>
                    <ul class="mt-6 flex flex-wrap gap-4 text-sm text-slate-300">
                        <li class="flex items-center gap-2"><x-icon name="shield" class="h-4 w-4 text-brand-400" /> NDA included</li>
                        <li class="flex items-center gap-2"><x-icon name="clock" class="h-4 w-4 text-brand-400" /> 48hr matching</li>
                    </ul>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <x-button href="{{ $primaryHref }}" variant="primary" size="lg">{{ $primaryLabel }}</x-button>
                        <x-button href="tel:+919876543210" variant="outline-light" size="lg">Call +91 98765 43210</x-button>
                    </div>
                </div>
                <div class="hidden w-full max-w-xs lg:block">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                        <x-ui-mockup variant="analytics" subtitle="Delivery metrics" class="border-white/10 shadow-none ring-1 ring-white/10" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
