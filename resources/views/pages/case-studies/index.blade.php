@extends('layouts.app')

@section('title', 'Case Studies: Enterprise Software Projects | OpacifyWeb')
@section('meta_description', 'Explore case studies in logistics, healthcare, fintech, and SaaS. See how OpacifyWeb delivers measurable outcomes.')
@section('canonical', 'https://opacify.in/case-studies')

@section('content')
    <section class="gradient-hero section-padding pb-14">
        <div class="container-narrow">
            <h1 class="font-display text-4xl font-semibold text-white sm:text-5xl">Case studies</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-300">
                Real outcomes from ERP modernizations, patient portals, and product rebuilds, documented with the metrics stakeholders care about.
            </p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow space-y-12">
            @forelse($projects as $project)
                <article class="card-premium overflow-hidden lg:flex reveal-on-scroll">
                    <div class="lg:w-[42%] shrink-0 min-h-[220px] lg:min-h-0">
                        @if($project->primary_image)
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($project->primary_image) }}"
                                alt="{{ $project->title }}"
                                class="h-full min-h-[220px] w-full border-b border-slate-200/80 object-cover lg:border-b-0 lg:border-r"
                                loading="lazy"
                            >
                        @else
                            <x-ui-mockup
                                variant="dashboard"
                                :title="$project->title"
                                :subtitle="$project->industry"
                                class="h-full rounded-none border-0 border-r border-slate-200/80 shadow-none"
                            />
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-6 sm:p-10">
                        <p class="text-sm font-medium text-brand-700">{{ $project->project_label }}</p>
                        <h2 class="mt-2 font-display text-2xl font-semibold text-navy">
                            <a href="{{ route('case-studies.show', $project->slug) }}" class="hover:text-brand-700">{{ $project->title }}</a>
                        </h2>
                        <p class="mt-3 text-slate-600">{{ $project->short_summary }}</p>
                        @if(!empty($project->technologies))
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($project->technologies as $tech)
                                    <span class="badge-tech">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if(!empty($project->highlights))
                            <ul class="mt-6 flex flex-wrap gap-4">
                                @foreach($project->highlights as $highlight)
                                    <li class="badge-metric">{{ $highlight['text'] ?? '' }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('case-studies.show', $project->slug) }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-brand-700">
                            View case study
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </article>
            @empty
                <div class="card-premium reveal-on-scroll p-10 text-center sm:p-14">
                    <h2 class="font-display text-2xl font-semibold text-navy">Case studies coming soon</h2>
                    <p class="mx-auto mt-3 max-w-xl text-slate-600">
                        We're preparing detailed write-ups of recent client work. In the meantime, tell us about your project and we'll share relevant examples directly.
                    </p>
                    <a href="/contact" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-brand-700">
                        Start a conversation
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>
            @endforelse
        </div>
    </section>

    <x-cta-banner />
@endsection
