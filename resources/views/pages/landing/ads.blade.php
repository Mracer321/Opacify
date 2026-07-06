@extends('layouts.landing')

@section('title', 'Hire Remote Developers — Free Quote in 24 Hours | OpacifyWeb')
@section('meta_description', 'Hire vetted Laravel, React, Node.js, and Flutter developers. Starting $15/hour. Get matched within 48 hours. Free quote.')
@section('canonical', 'https://opacify.in/lp/hire-developers')

@section('content')
    {{-- Minimal header for conversion --}}
    <header class="border-b border-slate-200 bg-white">
        <div class="container-narrow flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="/" class="flex items-center">
                <x-brand-logo variant="default" class="h-8 w-auto max-w-[10rem]" />
            </a>
            <a href="tel:+918802032023" class="text-sm font-semibold text-brand-600 hover:text-brand-700">+91 88020 32023</a>
        </div>
    </header>

    <section class="gradient-hero section-padding relative overflow-hidden">
        <div class="container-narrow">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div class="reveal-on-scroll relative z-10">
                    <p class="text-sm font-semibold uppercase tracking-wider text-brand-400">Limited onboarding slots this month</p>
                    <h1 class="mt-4 font-display text-4xl font-semibold text-white sm:text-5xl text-balance">
                        Hire senior developers in 48 hours—not 48 days
                    </h1>
                    <p class="mt-6 text-lg text-slate-300">
                        Laravel, React, Node.js, and Flutter engineers. Hourly from <strong class="text-white">$15/hour</strong>. NDA included. No recruitment fees.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        @foreach([['shield', 'ISO-aligned process'], ['chart', '94% client retention'], ['users', '320+ developers placed']] as [$icon, $badge])
                            <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-slate-200">
                                <x-icon :name="$icon" class="h-4 w-4 text-brand-400" />
                                {{ $badge }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="reveal-on-scroll relative z-10" data-reveal-delay="100">
                    <x-hero-visual class="!hidden xl:block absolute inset-y-0 -left-[50%] right-0 -z-10" />
                    <div class="relative rounded-2xl bg-white p-6 shadow-elevated sm:p-8" id="quote-form">
                    <h2 class="font-display text-xl font-semibold text-navy">Get your free quote</h2>
                    <p class="mt-1 text-sm text-slate-500">We respond within one business day.</p>
                    <div class="mt-6">
                        <x-lead-form id="landing-lead-form" :compact="true" submitLabel="Get My Free Quote" />
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-100 py-10">
        <div class="container-narrow flex flex-wrap items-center justify-center gap-8 opacity-60">
            @foreach(['FinEdge', 'RetailOS', 'HealthBridge', 'LogiStack'] as $b)
                <span class="font-display font-semibold text-slate-400">{{ $b }}</span>
            @endforeach
        </div>
    </section>

    <section class="section-padding bg-slate-50">
        <div class="container-narrow max-w-3xl">
            <x-section-header title="Why founders choose us over job boards" />
            <div class="mt-10 grid gap-6 sm:grid-cols-3" data-reveal-stagger>
                @foreach([
                    ['Vetted in 5 stages', 'Live coding, architecture discussion, and reference checks.', 'shield'],
                    ['Start within days', 'Profiles in 48 hours. Onboarding in under a week.', 'clock'],
                    ['Swap if not a fit', 'Replacement support during the trial period.', 'users'],
                ] as [$t, $d, $icon])
                    <div class="card-premium p-6 text-center sm:text-left reveal-on-scroll">
                        <x-icon-box :icon="$icon" variant="soft" class="mx-auto sm:mx-0" />
                        <h3 class="mt-4 font-semibold text-navy">{{ $t }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $d }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <div class="grid gap-6 md:grid-cols-2">
                <x-testimonial-card
                    quote="We hired a Laravel lead through HD and shipped our MVP before our funding deadline. Transparent rates and no surprises."
                    author="Priya Mehta"
                    role="CTO"
                    company="FinEdge Payments"
                    initials="PM"
                />
                <x-testimonial-card
                    quote="The dedicated React engineer joined our sprint rituals on day one. Best augmentation decision we made last year."
                    author="James Whitfield"
                    role="VP Engineering"
                    company="RetailOS"
                    initials="JW"
                />
            </div>
        </div>
    </section>

    <section class="section-padding bg-slate-50">
        <div class="container-narrow max-w-2xl">
            <x-section-header title="Quick answers" />
            <div class="mt-8">
                <x-faq-accordion :items="[
                    ['question' => 'How fast can I start?', 'answer' => 'Most clients receive developer profiles within 48 hours and start within 5–7 business days after selection.'],
                    ['question' => 'What are your rates?', 'answer' => 'Hourly engagements start at $15/hour depending on stack and seniority. Dedicated and project pricing is quoted after your brief.'],
                    ['question' => 'Is there a long-term contract?', 'answer' => 'Dedicated developers use monthly retainers with 30-day notice. Hourly work has no long-term lock-in.'],
                ]" id="landing-faq" />
            </div>
        </div>
    </section>

    <section class="section-padding gradient-hero">
        <div class="container-narrow text-center">
            <h2 class="font-display text-2xl font-semibold text-white sm:text-3xl">Ready to meet your next developer?</h2>
            <p class="mt-4 text-slate-300">Submit the form above or call us now.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <x-button href="#quote-form" variant="accent" size="lg">Get Free Quote</x-button>
                <x-button href="tel:+918802032023" variant="outline-light" size="lg">Call Now</x-button>
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} OpacifyWeb · <a href="/" class="text-brand-700">opacify.in</a></p>
    </footer>
@endsection
