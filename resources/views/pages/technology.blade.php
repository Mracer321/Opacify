@extends('layouts.app')

@php
$tech = $technology ?? [
    'name' => 'Laravel',
    'slug' => 'hire-laravel-developers',
    'headline' => 'Hire Expert Laravel Developers',
    'description' => 'Build secure APIs, admin panels, and SaaS backends with senior Laravel engineers who understand queues, testing, and production operations.',
    'canonical' => 'https://opacify.in/hire-laravel-developers',
    'rate' => '$18–$42/hour',
    'skills' => ['Laravel 10/11', 'Eloquent & Query Builder', 'Livewire / Inertia', 'PHPUnit & Pest', 'Redis & Horizon', 'REST & Sanctum APIs'],
    'benefits' => [
        ['Faster delivery', 'Experienced developers skip ramp-up on MVC patterns, migrations, and package ecosystems.'],
        ['Production discipline', 'Logging, error tracking, and deployment practices baked in from sprint one.'],
        ['Flexible engagement', 'Hourly, dedicated monthly, or fixed-scope project teams.'],
    ],
];
@endphp

@section('title', $tech['headline'] . ' — OpacifyWeb')
@section('meta_description', $tech['description'])
@section('canonical', $tech['canonical'])

@section('content')
    <section class="gradient-hero section-padding pb-16">
        <div class="container-narrow">
            <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
                <a href="/" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $tech['name'] }} Developers</span>
            </nav>
            <div class="mt-6 grid gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <h1 class="font-display text-4xl font-semibold tracking-tight text-white sm:text-5xl text-balance">{{ $tech['headline'] }}</h1>
                    <p class="mt-6 text-lg leading-relaxed text-slate-300">{{ $tech['description'] }}</p>
                    <p class="mt-6 inline-flex rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm text-white">
                        Typical rates: <span class="ml-2 font-semibold text-brand-400">{{ $tech['rate'] }}</span>
                    </p>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-elevated sm:p-8">
                    <h2 class="font-display text-lg font-semibold text-navy">Hire {{ $tech['name'] }} talent</h2>
                    <x-lead-form id="tech-lead-form" :compact="true" />
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <x-section-header eyebrow="Capabilities" title="What our {{ $tech['name'] }} developers deliver" />
            <div class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($tech['skills'] as $skill)
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200/80 bg-white px-4 py-3 shadow-soft">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-sm font-medium text-navy">{{ $skill }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding bg-surface-soft">
        <div class="container-narrow">
            <div class="grid gap-12 lg:grid-cols-3">
                @foreach($tech['benefits'] as [$title, $text])
                    <article class="card-premium p-8">
                        <h3 class="font-display text-lg font-semibold text-navy">{{ $title }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ $text }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow max-w-3xl">
            <article class="prose prose-slate max-w-none">
                <h2 class="heading-section">Why teams hire {{ $tech['name'] }} developers through us</h2>
                <p class="mt-4 text-slate-600 leading-relaxed">
                    Finding {{ $tech['name'] }} talent on job boards takes months. Freelance marketplaces offer inconsistent quality. OpacifyWeb sits in the middle: a structured agency process with individual developer flexibility. Every engineer in our {{ $tech['name'] }} pool has contributed to production codebases—payment gateways, multi-tenant SaaS, or high-traffic APIs—not tutorial projects.
                </p>
                <p class="mt-4 text-slate-600 leading-relaxed">
                    We start with a technical brief call, then share profiles that match your version requirements, timezone, and budget type. You interview finalists directly. Once selected, your developer joins Slack, Jira, or GitHub within 48 hours with a signed NDA and clear invoicing.
                </p>
                <h3 class="mt-10 text-xl font-semibold text-navy">Related technologies</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="/hire-laravel-developers" class="badge-tech hover:bg-brand-100">Laravel</a>
                    <a href="/hire-react-developers" class="badge-tech hover:bg-brand-100">React</a>
                    <a href="/hire-nodejs-developers" class="badge-tech hover:bg-brand-100">Node.js</a>
                    <a href="/hire-flutter-developers" class="badge-tech hover:bg-brand-100">Flutter</a>
                </div>
            </article>
        </div>
    </section>

    <x-cta-banner :title="'Start your ' . $tech['name'] . ' team this week'" />
@endsection
