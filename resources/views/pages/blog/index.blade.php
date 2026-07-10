@extends('layouts.app')

@section('title', 'Blog — Hiring Developers & Software Insights | OpacifyWeb')
@section('meta_description', 'Practical guides on hiring remote developers, scaling engineering teams, and delivering software projects.')
@section('canonical', 'https://opacify.in/blog')
{{-- Search result pages are low-value for the index; keep them out of the index
     while still crawlable. The un-searched listing indexes normally. --}}
@section('robots', $search !== '' ? 'noindex, follow' : 'index, follow')

@section('content')
    <section class="gradient-hero section-padding pb-14">
        <div class="container-narrow reveal-on-scroll">
            <div class="flex items-center gap-3">
                <x-icon-box icon="document" variant="soft" class="!h-10 !w-10 bg-white/10 text-white ring-white/20" />
                <p class="text-sm font-semibold uppercase tracking-wider text-brand-400">Insights</p>
            </div>
            <h1 class="mt-4 font-display text-4xl font-semibold text-white sm:text-5xl">Insights for hiring and building</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-300">Guides written by delivery leads—not generic content farms.</p>

            <form method="get" action="{{ route('blog.index') }}" role="search" class="mt-8 flex max-w-md gap-2">
                <label for="blog-search" class="sr-only">Search articles</label>
                <input id="blog-search" type="search" name="q" value="{{ $search }}" placeholder="Search articles"
                       class="input-field flex-1 border-white/10 bg-white/10 text-white placeholder:text-slate-400 focus:border-brand-400 focus:ring-brand-400/20">
                <button type="submit" class="rounded-lg bg-brand-500 px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-brand-600">Search</button>
            </form>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            @if($search !== '')
                <p class="mb-8 text-sm text-slate-500">
                    {{ $posts->total() }} {{ Str::plural('result', $posts->total()) }} for “<span class="font-medium text-navy">{{ $search }}</span>”.
                    <a href="{{ route('blog.index') }}" class="font-semibold text-brand-700 hover:text-brand-800">Clear</a>
                </p>
            @endif

            @if($posts->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-soft">
                    <p class="font-display text-lg font-semibold text-navy">No articles found</p>
                    <p class="mt-2 text-sm text-slate-500">
                        @if($search !== '')
                            Nothing matched “{{ $search }}”. Try a different keyword or <a href="{{ route('blog.index') }}" class="font-semibold text-brand-700 hover:text-brand-800">browse all articles</a>.
                        @else
                            New articles are on the way. Check back soon.
                        @endif
                    </p>
                </div>
            @else
                <div class="grid gap-8 md:grid-cols-2" data-reveal-stagger>
                    @foreach($posts as $post)
                        <article class="card-premium group flex flex-col overflow-hidden reveal-on-scroll">
                            <div class="border-b border-slate-100 p-3">
                                @if($post->featuredImageUrl())
                                    <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->featuredImageAlt() }}" class="aspect-[16/9] w-full rounded-lg object-cover" loading="lazy">
                                @else
                                    <x-ui-mockup variant="dashboard" :subtitle="$post->category ?? 'Article'" class="!shadow-none !ring-0" />
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-6 sm:p-8">
                                <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                                    @if($post->category)
                                        <span class="inline-flex items-center gap-1.5 badge-tech">
                                            <x-icon name="document" class="h-3.5 w-3.5 text-brand-600" />
                                            {{ $post->category }}
                                        </span>
                                    @endif
                                    @if($post->published_at)
                                        <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('M j, Y') }}</time>
                                    @endif
                                    <span class="inline-flex items-center gap-1">
                                        <x-icon name="clock" class="h-3.5 w-3.5" />
                                        {{ $post->readLabel() }}
                                    </span>
                                </div>
                                <h2 class="mt-4 font-display text-xl font-semibold text-navy group-hover:text-brand-700">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                @if($post->excerpt)
                                    <p class="mt-3 flex-1 text-sm text-slate-600">{{ $post->excerpt }}</p>
                                @endif
                                <a href="{{ route('blog.show', $post->slug) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 link-underline">
                                    Read article
                                    <x-icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" />
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>

    <x-cta-banner />
@endsection
