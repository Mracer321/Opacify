@extends('layouts.app')

@php
$servicesCatalog = require resource_path('data/services.php');
$services = array_values($servicesCatalog);
@endphp

@section('title', 'Software Development Services | OpacifyWeb')
@section('meta_description', 'Enterprise software services: web development, mobile apps, ERP, custom software, digital marketing, and AI automation.')
@section('canonical', 'https://opacify.in/services')

@section('content')
<section class="gradient-hero section-padding pb-14">
    <div class="container-narrow">
        <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
            <a href="/" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-300">Services</span>
        </nav>
        <h1 class="mt-6 max-w-3xl font-display text-4xl font-semibold tracking-tight text-white sm:text-5xl text-balance">
            Enterprise software services
        </h1>
        <p class="mt-6 max-w-2xl text-lg text-slate-300">
            We work across six practice areas with one delivery standard. Find the capability that matches your roadmap, then open its overview for process, technology, and engagement detail.
        </p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <x-section-header
            eyebrow="Our practices"
            title="Choose a service to learn more"
            description="Select a practice below for capabilities, delivery models, and FAQs, without scrolling through one long page." />
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($services as $service)
            <x-service-card :service="$service" />
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-surface-soft">
    <div class="container-narrow">
        <x-section-header eyebrow="Delivery methodology" title="How we deliver across every practice" description="We follow the same delivery process for a single hire or a full project." />
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
            @foreach([
            ['workflow', 'Discover', 'Workshops, scope definition, and risk identification before build.'],
            ['layers', 'Architect', 'Stack decisions, security baseline, and integration mapping.'],
            ['code', 'Deliver', 'Sprint demos, code review, QA gates, and staging releases.'],
            ['server', 'Operate', 'Handover runbooks, monitoring, and optional retainers.'],
            ] as [$icon, $title, $desc])
            <article class="card-premium p-6 reveal-on-scroll">
                <x-icon-box :icon="$icon" variant="soft" />
                <h3 class="mt-4 font-display text-base font-semibold text-navy">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $desc }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <x-section-header eyebrow="Industries" title="Sectors we serve regularly" />
        <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-4">
            @foreach(['Fintech', 'Healthcare', 'Logistics', 'Retail', 'Manufacturing', 'SaaS', 'Education', 'Real Estate'] as $industry)
            <div class="rounded-xl border border-slate-200/80 bg-surface-soft px-4 py-5 text-center">
                <span class="text-sm font-semibold text-slate-700">{{ $industry }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-surface-soft">
    <div class="container-narrow">
        <x-section-header eyebrow="Process" title="Our delivery process, step by step" />
        <ol class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
            @foreach([
            ['01', 'Consultation', 'Share goals, constraints, and timeline. We respond within one business day.'],
            ['02', 'Proposal', 'Team structure, milestones, and transparent commercial options.'],
            ['03', 'Onboarding', 'NDA, tool access, and sprint cadence aligned to your org.'],
            ['04', 'Delivery', 'Releases, documentation, and measurable outcomes.'],
            ] as [$step, $title, $desc])
            <li>
                <span class="font-display text-4xl font-bold text-brand-100">{{ $step }}</span>
                <h3 class="mt-2 font-semibold text-navy">{{ $title }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
            </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <x-section-header align="left" eyebrow="Why OpacifyWeb" title="Built for teams that need agency quality without agency friction" description="Experienced engineers, documented delivery, and account management that stays technical." />
            <ul class="space-y-4">
                @foreach([
                ['Rigorous vetting', 'Live technical interviews and production reference checks.'],
                ['Transparent delivery', 'Weekly status, shared backlogs, and no surprise scope.'],
                ['Flexible engagement', 'Hourly, dedicated, or fixed-scope, with the same quality bar.'],
                ['IP & security', 'NDAs, access controls, and audit-friendly practices.'],
                ] as [$title, $text])
                <li class="flex gap-4 card-premium p-5">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-navy">{{ $title }}</h3>
                        <p class="mt-1 text-sm text-slate-600">{{ $text }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<x-cta-banner
    title="Not sure which service fits?"
    description="Tell us about your project on the contact page and we will route you to the right practice lead."
    primaryHref="/contact" />
@endsection