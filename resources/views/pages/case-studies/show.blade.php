@extends('layouts.app')

@php
$study = $study ?? [
    'title' => 'Logistics ERP Modernization',
    'slug' => 'logistics-erp-modernization',
    'client' => 'LogiStack',
    'industry' => 'Supply Chain',
    'duration' => '6 months',
    'team' => '2 Laravel developers, 1 Vue developer, 1 QA',
    'challenge' => 'LogiStack relied on a monolithic desktop ERP that could not scale with new warehouses. Reporting took days, and mobile access was nonexistent.',
    'solution' => 'We designed a modular Laravel + Vue platform with warehouse-specific workflows, real-time inventory sync, and executive dashboards.',
    'results' => [
        ['40%', 'Reduction in order fulfillment time'],
        ['99.9%', 'Platform uptime post-launch'],
        ['12', 'Legacy modules migrated'],
    ],
    'tech' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'AWS'],
    'quote' => 'Hire Developer felt like an extension of our internal IT team. They challenged our assumptions and still hit the go-live date.',
    'author' => 'Marcus Lindqvist',
    'role' => 'COO, LogiStack',
];
@endphp

@section('title', $study['title'] . ' Case Study — Hire Developer')
@section('canonical', 'https://hiredeveloper.co.in/case-studies/' . $study['slug'])

@section('content')
    <header class="gradient-hero section-padding pb-12">
        <div class="container-narrow">
            <nav class="text-sm text-slate-400">
                <a href="/case-studies" class="hover:text-white">Case Studies</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $study['client'] }}</span>
            </nav>
            <p class="mt-6 text-sm font-medium text-accent-400">{{ $study['industry'] }} · {{ $study['duration'] }}</p>
            <h1 class="mt-4 max-w-3xl font-display text-4xl font-semibold text-white sm:text-5xl">{{ $study['title'] }}</h1>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($study['tech'] as $t)
                    <span class="rounded-md bg-white/10 px-3 py-1 text-sm text-white ring-1 ring-white/20">{{ $t }}</span>
                @endforeach
            </div>
        </div>
    </header>

    <section class="section-padding">
        <div class="container-narrow">
            <div class="grid gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-10">
                    <div>
                        <h2 class="heading-section">Challenge</h2>
                        <p class="mt-4 leading-relaxed text-slate-600">{{ $study['challenge'] }}</p>
                    </div>
                    <div>
                        <h2 class="heading-section">Solution</h2>
                        <p class="mt-4 leading-relaxed text-slate-600">{{ $study['solution'] }}</p>
                    </div>
                    <x-project-preview :title="$study['title']" subtitle="Production interface preview" variant="erp" class="lg:col-span-1" />
                </div>
                <aside class="space-y-6">
                    <div class="card-premium p-6">
                        <h3 class="font-semibold text-navy-950">Project snapshot</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div><dt class="text-slate-500">Client</dt><dd class="font-medium text-navy-950">{{ $study['client'] }}</dd></div>
                            <div><dt class="text-slate-500">Duration</dt><dd class="font-medium text-navy-950">{{ $study['duration'] }}</dd></div>
                            <div><dt class="text-slate-500">Team</dt><dd class="font-medium text-navy-950">{{ $study['team'] }}</dd></div>
                        </dl>
                    </div>
                    <div class="rounded-2xl bg-brand-50 p-6 ring-1 ring-brand-100">
                        <h3 class="font-semibold text-navy-950">Key results</h3>
                        <ul class="mt-4 space-y-4">
                            @foreach($study['results'] as [$value, $label])
                                <li>
                                    <p class="font-display text-2xl font-semibold text-brand-700">{{ $value }}</p>
                                    <p class="text-sm text-slate-600">{{ $label }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @php
        $initials = implode('', array_map(fn ($w) => $w[0] ?? '', explode(' ', $study['author'])));
    @endphp
    <section class="section-padding bg-slate-50">
        <div class="container-narrow max-w-3xl">
            <x-testimonial-card
                :quote="$study['quote']"
                :author="$study['author']"
                :role="$study['role']"
                :company="$study['client']"
                :initials="$initials"
            />
        </div>
    </section>

    <x-cta-banner title="Planning a similar transformation?" />
@endsection
