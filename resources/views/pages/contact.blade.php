@extends('layouts.app')

@section('title', 'Contact Us — Get a Free Quote | OpacifyWeb')
@section('meta_description', 'Contact OpacifyWeb for a free quote. Hire Laravel, React, Node.js, and Flutter developers. Response within one business day.')
@section('canonical', 'https://opacify.in/contact')

@section('content')
    <section class="section-padding bg-surface-soft border-b border-slate-100">
        <div class="container-narrow reveal-on-scroll">
            <x-section-header
                eyebrow="Contact"
                title="Tell us about your project"
                description="Complete the form and our solutions team will reach out with developer profiles, timelines, and pricing options."
            />
        </div>
    </section>

    <section class="section-padding pt-0">
        <div class="container-narrow">
            <div class="grid gap-12 lg:grid-cols-5">
                <div class="lg:col-span-3 reveal-on-scroll">
                    <div class="card-premium p-6 sm:p-10">
                        <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-6">
                            <x-icon-box icon="chat" variant="soft" />
                            <div>
                                <h2 class="font-display text-lg font-semibold text-navy">Project inquiry</h2>
                                <p class="text-sm text-slate-500">All fields help us match the right engineers faster.</p>
                            </div>
                        </div>
                        <x-lead-form id="contact-lead-form" submitLabel="Submit & Get Free Quote" />
                    </div>
                </div>
                <aside class="lg:col-span-2 space-y-6">
                    <div class="card-premium p-6 reveal-on-scroll" data-reveal-delay="80">
                        <h2 class="font-display text-lg font-semibold text-navy">Direct contact</h2>
                        <ul class="mt-4 space-y-4 text-sm">
                            <li class="flex gap-3">
                                <x-icon-box icon="mail" variant="soft" class="!h-9 !w-9 shrink-0" />
                                <div>
                                    <span class="font-medium text-slate-500">Email</span>
                                    <a href="mailto:opacifyweb@gmail.com" class="mt-1 block text-brand-700 hover:text-brand-800">opacifyweb@gmail.com</a>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <x-icon-box icon="phone" variant="soft" class="!h-9 !w-9 shrink-0" />
                                <div>
                                    <span class="font-medium text-slate-500">Phone</span>
                                    <a href="tel:+918802032023" class="mt-1 block text-brand-700 hover:text-brand-800">+91 88020 32023</a>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <x-icon-box icon="clock" variant="soft" class="!h-9 !w-9 shrink-0" />
                                <div>
                                    <span class="font-medium text-slate-500">Office hours</span>
                                    <p class="mt-1 text-slate-600">Mon–Fri, 9:00 AM – 7:00 PM IST</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="reveal-on-scroll" data-reveal-delay="120">
                        <x-ui-mockup variant="crm" subtitle="Client workspace" class="shadow-card ring-1 ring-slate-200/80" />
                    </div>
                    <div class="rounded-2xl bg-navy p-6 text-slate-300 reveal-on-scroll" data-reveal-delay="160">
                        <div class="flex items-center gap-2">
                            <x-icon-box icon="workflow" variant="brand" class="!h-9 !w-9" />
                            <h3 class="font-semibold text-white">What happens next?</h3>
                        </div>
                        <ol class="mt-4 space-y-4 text-sm">
                            @foreach(['We review your stack and timeline', 'You receive 2–3 developer profiles', 'Optional intro calls with shortlisted talent', 'Contract and onboarding within days'] as $i => $step)
                                <li class="flex gap-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-white/10 text-xs font-bold text-white">{{ $i + 1 }}</span>
                                    <span class="pt-0.5">{{ $step }}</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
