@extends('layouts.app')

@section('title', 'Case Studies — Enterprise Software Projects | Hire Developer')
@section('meta_description', 'Explore case studies in logistics, healthcare, fintech, and SaaS. See how Hire Developer delivers measurable outcomes.')
@section('canonical', 'https://hiredeveloper.co.in/case-studies')

@php
$studies = [
    [
        'slug' => 'logistics-erp-modernization',
        'title' => 'Logistics ERP Modernization',
        'client' => 'LogiStack',
        'industry' => 'Supply Chain',
        'summary' => 'Replaced a decade-old desktop ERP with a cloud Laravel platform serving 40 warehouses across three countries.',
        'metrics' => ['40% faster fulfillment', '99.9% uptime', '6-month rollout'],
        'tech' => ['Laravel', 'Vue.js', 'MySQL', 'AWS'],
    ],
    [
        'slug' => 'healthcare-patient-portal',
        'title' => 'Healthcare Patient Portal',
        'client' => 'HealthBridge',
        'industry' => 'Healthcare',
        'summary' => 'HIPAA-aware patient portal with scheduling, records access, and secure messaging for a regional care network.',
        'metrics' => ['2.1M annual sessions', '4.8 app store rating', '12-week MVP'],
        'tech' => ['React', 'Node.js', 'PostgreSQL', 'AWS'],
    ],
    [
        'slug' => 'fintech-payment-dashboard',
        'title' => 'Fintech Payment Dashboard',
        'client' => 'FinEdge Payments',
        'industry' => 'Fintech',
        'summary' => 'Real-time reconciliation dashboard for merchants with role-based access and audit trails.',
        'metrics' => ['$2B+ processed annually', '<200ms API p95', 'SOC2-aligned controls'],
        'tech' => ['Laravel', 'React', 'Redis', 'Docker'],
    ],
    [
        'slug' => 'retail-inventory-mobile',
        'title' => 'Retail Inventory Mobile Suite',
        'client' => 'RetailOS',
        'industry' => 'Retail',
        'summary' => 'Flutter field app for stock counts, barcode scanning, and offline sync to central ERP.',
        'metrics' => ['3,200 store users', 'Offline-first sync', '8-week pilot'],
        'tech' => ['Flutter', 'Firebase', 'REST APIs'],
    ],
];
@endphp

@section('content')
    <section class="gradient-hero section-padding pb-14">
        <div class="container-narrow">
            <h1 class="font-display text-4xl font-semibold text-white sm:text-5xl">Case studies</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-300">
                Real outcomes from ERP modernizations, patient portals, and product rebuilds—documented with the metrics stakeholders care about.
            </p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow space-y-12">
            @foreach($studies as $study)
                <article class="card-premium overflow-hidden lg:flex">
                    <div class="lg:w-2/5 aspect-[16/10] lg:aspect-auto bg-gradient-to-br from-slate-100 to-brand-50 flex items-center justify-center min-h-[200px]">
                        <span class="text-sm font-semibold uppercase tracking-wider text-slate-400">{{ $study['industry'] }}</span>
                    </div>
                    <div class="flex flex-1 flex-col p-6 sm:p-10">
                        <p class="text-sm font-medium text-brand-700">{{ $study['client'] }}</p>
                        <h2 class="mt-2 font-display text-2xl font-semibold text-navy-950">
                            <a href="/case-studies/{{ $study['slug'] }}" class="hover:text-brand-700">{{ $study['title'] }}</a>
                        </h2>
                        <p class="mt-3 text-slate-600">{{ $study['summary'] }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($study['tech'] as $t)
                                <span class="badge-tech">{{ $t }}</span>
                            @endforeach
                        </div>
                        <ul class="mt-6 flex flex-wrap gap-4">
                            @foreach($study['metrics'] as $metric)
                                <li class="badge-metric">{{ $metric }}</li>
                            @endforeach
                        </ul>
                        <a href="/case-studies/{{ $study['slug'] }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-brand-700">
                            View case study
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <x-cta-banner />
@endsection
