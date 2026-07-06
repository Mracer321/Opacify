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
    'quote' => 'OpacifyWeb felt like an extension of our internal IT team. They challenged our assumptions and still hit the go-live date.',
    'author' => 'Marcus Lindqvist',
    'role' => 'COO, LogiStack',
    'preview' => 'erp',
];
$preview = $study['preview'] ?? 'erp';
@endphp

@section('title', $study['title'] . ' Case Study — OpacifyWeb')
@section('canonical', 'https://opacifyweb.in/case-studies/' . $study['slug'])

@section('content')
    <header class="gradient-hero section-padding pb-12">
        <div class="container-narrow">
            <nav class="text-sm text-slate-400 reveal-on-scroll">
                <a href="/case-studies" class="hover:text-white">Case Studies</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $study['client'] }}</span>
            </nav>
            <div class="mt-6 grid gap-10 lg:grid-cols-2 lg:items-end">
                <div class="reveal-on-scroll">
                    <p class="inline-flex items-center gap-2 text-sm font-medium text-brand-400">
                        <x-icon name="briefcase" class="h-4 w-4" />
                        {{ $study['industry'] }} · {{ $study['duration'] }}
                    </p>
                    <h1 class="mt-4 max-w-3xl font-display text-4xl font-semibold text-white sm:text-5xl">{{ $study['title'] }}</h1>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach($study['tech'] as $t)
                            <span class="rounded-md bg-white/10 px-3 py-1 text-sm text-white ring-1 ring-white/20">{{ $t }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="reveal-on-scroll hidden lg:block" data-reveal-delay="100">
                    <x-ui-mockup :variant="$preview" :title="$study['client']" subtitle="Production interface" class="shadow-elevated ring-1 ring-white/10" />
                </div>
            </div>
        </div>
    </header>

    <section class="section-padding">
        <div class="container-narrow">
            <div class="grid gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-10">
                    <div class="reveal-on-scroll">
                        <div class="flex items-center gap-2">
                            <x-icon-box icon="help" variant="soft" class="!h-8 !w-8" />
                            <h2 class="heading-section">Challenge</h2>
                        </div>
                        <p class="mt-4 leading-relaxed text-slate-600">{{ $study['challenge'] }}</p>
                    </div>
                    <div class="reveal-on-scroll">
                        <div class="flex items-center gap-2">
                            <x-icon-box icon="workflow" variant="soft" class="!h-8 !w-8" />
                            <h2 class="heading-section">Solution</h2>
                        </div>
                        <p class="mt-4 leading-relaxed text-slate-600">{{ $study['solution'] }}</p>
                    </div>
                    <div class="reveal-on-scroll">
                        <x-project-preview :title="$study['title']" subtitle="Production interface preview" :variant="$preview" />
                    </div>
                </div>
                <aside class="space-y-6">
                    <div class="card-premium p-6 reveal-on-scroll">
                        <div class="flex items-center gap-2">
                            <x-icon-box icon="document" variant="soft" class="!h-8 !w-8" />
                            <h3 class="font-semibold text-navy">Project snapshot</h3>
                        </div>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex gap-3">
                                <x-icon name="briefcase" class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" />
                                <div><dt class="text-slate-500">Client</dt><dd class="font-medium text-navy">{{ $study['client'] }}</dd></div>
                            </div>
                            <div class="flex gap-3">
                                <x-icon name="clock" class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" />
                                <div><dt class="text-slate-500">Duration</dt><dd class="font-medium text-navy">{{ $study['duration'] }}</dd></div>
                            </div>
                            <div class="flex gap-3">
                                <x-icon name="users" class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" />
                                <div><dt class="text-slate-500">Team</dt><dd class="font-medium text-navy">{{ $study['team'] }}</dd></div>
                            </div>
                        </dl>
                    </div>
                    <div class="rounded-2xl bg-brand-50 p-6 ring-1 ring-brand-100 reveal-on-scroll" data-reveal-delay="80">
                        <div class="flex items-center gap-2">
                            <x-icon-box icon="chart" variant="brand" class="!h-8 !w-8" />
                            <h3 class="font-semibold text-navy">Key results</h3>
                        </div>
                        <ul class="mt-4 space-y-4">
                            @foreach($study['results'] as [$value, $label])
                                <li>
                                    <p class="font-display text-2xl font-semibold text-brand-600">{{ $value }}</p>
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
        <div class="container-narrow max-w-3xl reveal-on-scroll">
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
