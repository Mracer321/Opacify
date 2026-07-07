@extends('layouts.app')

@section('title', 'Blog — Hiring Developers & Software Insights | OpacifyWeb')
@section('meta_description', 'Practical guides on hiring remote developers, scaling engineering teams, and delivering software projects.')
@section('canonical', 'https://opacify.in/blog')

@section('content')
    <section class="gradient-hero section-padding pb-14">
        <div class="container-narrow reveal-on-scroll">
            <div class="flex items-center gap-3">
                <x-icon-box icon="document" variant="soft" class="!h-10 !w-10 bg-white/10 text-white ring-white/20" />
                <p class="text-sm font-semibold uppercase tracking-wider text-brand-400">Insights</p>
            </div>
            <h1 class="mt-4 font-display text-4xl font-semibold text-white sm:text-5xl">Insights for hiring and building</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-300">Guides written by delivery leads—not generic content farms.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <div class="grid gap-8 md:grid-cols-2" data-reveal-stagger>
                @foreach($posts as $post)
                    <article class="card-premium group flex flex-col overflow-hidden reveal-on-scroll">
                        <div class="border-b border-slate-100 p-3">
                            <x-ui-mockup :variant="$post['preview']" :subtitle="$post['category']" class="!shadow-none !ring-0" />
                        </div>
                        <div class="flex flex-1 flex-col p-6 sm:p-8">
                            <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                                <span class="inline-flex items-center gap-1.5 badge-tech">
                                    <x-icon name="document" class="h-3.5 w-3.5 text-brand-600" />
                                    {{ $post['category'] }}
                                </span>
                                <time datetime="{{ $post['date'] }}">{{ $post['date'] }}</time>
                                <span class="inline-flex items-center gap-1">
                                    <x-icon name="clock" class="h-3.5 w-3.5" />
                                    {{ $post['read'] }}
                                </span>
                            </div>
                            <h2 class="mt-4 font-display text-xl font-semibold text-navy group-hover:text-brand-700">
                                <a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a>
                            </h2>
                            <p class="mt-3 flex-1 text-sm text-slate-600">{{ $post['excerpt'] }}</p>
                            <a href="{{ route('blog.show', $post['slug']) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 link-underline">
                                Read article
                                <x-icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" />
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-banner />
@endsection
