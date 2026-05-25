@props([
    'title' => 'Ready to hire developers who deliver?',
    'description' => 'Tell us about your project. We will match you with vetted engineers and send a tailored proposal within 24 hours.',
    'primaryLabel' => 'Get Free Quote',
    'primaryHref' => '/contact',
])

<section class="section-padding">
    <div class="container-narrow">
        <div class="relative overflow-hidden rounded-3xl gradient-hero px-6 py-14 sm:px-12 sm:py-16 lg:px-16">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-brand-600/20 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-accent-500/10 blur-3xl"></div>
            <div class="relative max-w-2xl">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-white sm:text-3xl">{{ $title }}</h2>
                <p class="mt-4 text-lg leading-relaxed text-slate-300">{{ $description }}</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <x-button href="{{ $primaryHref }}" variant="accent" size="lg">{{ $primaryLabel }}</x-button>
                    <x-button href="tel:+919876543210" variant="outline-light" size="lg">Call +91 98765 43210</x-button>
                </div>
            </div>
        </div>
    </div>
</section>
