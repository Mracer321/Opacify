@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;

    $technologies = $project->technologies ?? [];
    $keyResults = $project->key_results ?? [];

    $primaryImageUrl = $project->primary_image ? Storage::disk('public')->url($project->primary_image) : null;
    $secondaryImageUrl = $project->secondary_image ? Storage::disk('public')->url($project->secondary_image) : null;
    // Main content visual: prefer the secondary image, gracefully fall back to primary.
    $mainVisualUrl = $secondaryImageUrl ?? $primaryImageUrl;

    $metaDescription = $project->meta_description ?: $project->short_summary;
@endphp

@section('title', $project->seo_title ?: $project->title . ' Case Study — OpacifyWeb')
@section('meta_description', $metaDescription)
@section('canonical', 'https://opacify.in/case-studies/' . $project->slug)

@section('content')
    <header class="gradient-hero section-padding pb-12">
        <div class="container-narrow">
            <nav class="text-sm text-slate-400 reveal-on-scroll">
                <a href="/case-studies" class="hover:text-white">Case Studies</a>
                <span class="mx-2">/</span>
                <span class="text-slate-300">{{ $project->project_label }}</span>
            </nav>
            <div class="mt-6 grid gap-10 lg:grid-cols-2 lg:items-end">
                <div class="reveal-on-scroll">
                    <p class="inline-flex items-center gap-2 text-sm font-medium text-brand-400">
                        <x-icon name="briefcase" class="h-4 w-4" />
                        {{ $project->industry }} · {{ $project->duration }}
                    </p>
                    <h1 class="mt-4 max-w-3xl font-display text-4xl font-semibold text-white sm:text-5xl">{{ $project->title }}</h1>
                    @if(!empty($technologies))
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($technologies as $tech)
                                <span class="rounded-md bg-white/10 px-3 py-1 text-sm text-white ring-1 ring-white/20">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="reveal-on-scroll hidden lg:block" data-reveal-delay="100">
                    @if($primaryImageUrl)
                        <img src="{{ $primaryImageUrl }}" alt="{{ $project->title }}" class="aspect-[16/10] w-full rounded-xl object-cover shadow-elevated ring-1 ring-white/10">
                    @else
                        <x-ui-mockup variant="dashboard" :title="$project->project_label" subtitle="Production interface" class="shadow-elevated ring-1 ring-white/10" />
                    @endif
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
                        <p class="mt-4 whitespace-pre-line leading-relaxed text-slate-600">{{ $project->challenge }}</p>
                    </div>
                    <div class="reveal-on-scroll">
                        <div class="flex items-center gap-2">
                            <x-icon-box icon="workflow" variant="soft" class="!h-8 !w-8" />
                            <h2 class="heading-section">Solution</h2>
                        </div>
                        <p class="mt-4 whitespace-pre-line leading-relaxed text-slate-600">{{ $project->solution }}</p>
                    </div>
                    <div class="reveal-on-scroll">
                        @if($mainVisualUrl)
                            <img src="{{ $mainVisualUrl }}" alt="{{ $project->title }} interface" class="w-full rounded-2xl border border-slate-200/80 object-cover shadow-card">
                        @else
                            <x-project-preview :title="$project->title" subtitle="Production interface preview" variant="dashboard" />
                        @endif
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
                                <div><dt class="text-slate-500">Client</dt><dd class="font-medium text-navy">{{ $project->project_label }}</dd></div>
                            </div>
                            <div class="flex gap-3">
                                <x-icon name="clock" class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" />
                                <div><dt class="text-slate-500">Duration</dt><dd class="font-medium text-navy">{{ $project->duration }}</dd></div>
                            </div>
                            <div class="flex gap-3">
                                <x-icon name="users" class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" />
                                <div><dt class="text-slate-500">Team</dt><dd class="font-medium text-navy">{{ $project->team_summary }}</dd></div>
                            </div>
                        </dl>
                    </div>
                    @if(!empty($keyResults))
                        <div class="rounded-2xl bg-brand-50 p-6 ring-1 ring-brand-100 reveal-on-scroll" data-reveal-delay="80">
                            <div class="flex items-center gap-2">
                                <x-icon-box icon="chart" variant="brand" class="!h-8 !w-8" />
                                <h3 class="font-semibold text-navy">Key results</h3>
                            </div>
                            <ul class="mt-4 space-y-4">
                                @foreach($keyResults as $result)
                                    <li>
                                        <p class="font-display text-2xl font-semibold text-brand-600">{{ $result['value'] ?? '' }}</p>
                                        <p class="text-sm text-slate-600">{{ $result['label'] ?? '' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    @if($project->hasTestimonial())
        @php
            $initials = collect(explode(' ', $project->testimonial_name))
                ->map(fn ($word) => mb_substr($word, 0, 1))
                ->implode('');
        @endphp
        <section class="section-padding bg-surface-soft">
            <div class="container-narrow max-w-3xl reveal-on-scroll">
                <x-testimonial-card
                    :quote="$project->testimonial_quote"
                    :author="$project->testimonial_name"
                    :role="$project->testimonial_role"
                    :company="$project->project_label"
                    :initials="$initials"
                />
            </div>
        </section>
    @endif

    <x-cta-banner title="Planning a similar transformation?" />
@endsection
