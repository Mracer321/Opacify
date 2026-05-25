@extends('layouts.app')

@section('title', 'Contact Us — Get a Free Quote | Hire Developer')
@section('meta_description', 'Contact Hire Developer for a free quote. Hire Laravel, React, Node.js, and Flutter developers. Response within one business day.')
@section('canonical', 'https://hiredeveloper.co.in/contact')

@section('content')
    <section class="section-padding gradient-subtle border-b border-slate-100">
        <div class="container-narrow">
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
                <div class="lg:col-span-3">
                    <div class="card-premium p-6 sm:p-10">
                        <x-lead-form id="contact-lead-form" submitLabel="Submit & Get Free Quote" />
                    </div>
                </div>
                <aside class="lg:col-span-2 space-y-6">
                    <div class="card-premium p-6">
                        <h2 class="font-display text-lg font-semibold text-navy-950">Direct contact</h2>
                        <ul class="mt-4 space-y-4 text-sm">
                            <li>
                                <span class="font-medium text-slate-500">Email</span>
                                <a href="mailto:hello@hiredeveloper.co.in" class="mt-1 block text-brand-700 hover:text-brand-800">hello@hiredeveloper.co.in</a>
                            </li>
                            <li>
                                <span class="font-medium text-slate-500">Phone</span>
                                <a href="tel:+919876543210" class="mt-1 block text-brand-700 hover:text-brand-800">+91 98765 43210</a>
                            </li>
                            <li>
                                <span class="font-medium text-slate-500">Office hours</span>
                                <p class="mt-1 text-slate-600">Mon–Fri, 9:00 AM – 7:00 PM IST</p>
                            </li>
                        </ul>
                    </div>
                    <div class="rounded-2xl bg-navy-950 p-6 text-slate-300">
                        <h3 class="font-semibold text-white">What happens next?</h3>
                        <ol class="mt-4 space-y-3 text-sm list-decimal list-inside">
                            <li>We review your stack and timeline</li>
                            <li>You receive 2–3 developer profiles</li>
                            <li>Optional intro calls with shortlisted talent</li>
                            <li>Contract and onboarding within days</li>
                        </ol>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
