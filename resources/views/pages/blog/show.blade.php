@extends('layouts.app')

@php $isPreview = $isPreview ?? false; @endphp

@section('title', $post->effectiveSeoTitle() . ' | OpacifyWeb Blog')
@section('meta_description', $post->effectiveMetaDescription())
@section('canonical', $post->effectiveCanonical())
@section('og_type', 'article')
@section('og_title', $post->effectiveOgTitle())
@section('og_description', $post->effectiveOgDescription())
@section('og_image', $post->effectiveOgImageUrl())
{{-- Previews (draft/scheduled) must never be indexed. --}}
@section('robots', $isPreview ? 'noindex, nofollow' : $post->robotsContent())

@section('content')
    <x-schema.blog-posting :post="$post" />
    <x-schema.breadcrumbs :items="[
        ['name' => 'Home', 'url' => 'https://opacify.in'],
        ['name' => 'Blog', 'url' => 'https://opacify.in/blog'],
        ['name' => $post->title],
    ]" />

    @if($isPreview)
        <div class="bg-amber-500 px-4 py-2 text-center text-sm font-semibold text-amber-950">
            Admin preview. Status: {{ ucfirst($post->status) }}@if($post->published_at) · publish time: {{ $post->published_at->format('M j, Y g:i A') }}@endif. This page is not publicly indexable.
        </div>
    @endif

    <article>
        <header class="gradient-hero section-padding pb-12">
            <div class="container-narrow max-w-3xl">
                <nav class="text-sm text-slate-400">
                    <a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a>
                    @if($post->category)
                        <span class="mx-2">/</span>
                        <span class="text-slate-300">{{ $post->category }}</span>
                    @endif
                </nav>
                <p class="mt-6 text-sm text-brand-400">
                    @if($post->category){{ $post->category }} · @endif
                    @if($post->published_at){{ $post->published_at->format('M j, Y') }} · @endif
                    {{ $post->readLabel() }}
                </p>
                <h1 class="mt-4 font-display text-3xl font-semibold text-white sm:text-4xl text-balance">{{ $post->title }}</h1>
                <p class="mt-4 text-slate-300">By {{ $post->author }}@if($post->author_role), {{ $post->author_role }}@endif</p>
            </div>
        </header>

        @if($post->featuredImageUrl())
            <div class="section-padding !pb-0">
                <div class="container-narrow max-w-3xl">
                    <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->featuredImageAlt() }}" class="w-full rounded-2xl border border-slate-200/80 object-cover shadow-card" loading="lazy">
                </div>
            </div>
        @endif

        <div class="section-padding">
            <div class="container-narrow max-w-3xl reveal-on-scroll">
                @if($post->excerpt)
                    <p class="text-lg leading-relaxed text-slate-600">{{ $post->excerpt }}</p>
                @endif
                <x-blog.content :blocks="$post->content_blocks" />
            </div>
        </div>
    </article>

    @if($relatedPosts->isNotEmpty())
        <section class="section-padding bg-surface-soft">
            <div class="container-narrow">
                <x-section-header align="left" eyebrow="Keep reading" title="Related articles" class="max-w-xl" />
                <div class="mt-10 grid gap-6 md:grid-cols-3" data-reveal-stagger>
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="card-premium group flex flex-col p-6 reveal-on-scroll">
                            @if($related->category)
                                <span class="inline-flex w-fit items-center gap-1.5 badge-tech text-xs font-medium text-slate-500">
                                    <x-icon name="document" class="h-3.5 w-3.5 text-brand-600" />
                                    {{ $related->category }}
                                </span>
                            @endif
                            <h3 class="mt-4 font-display text-lg font-semibold text-navy group-hover:text-brand-700">{{ $related->title }}</h3>
                            @if($related->excerpt)
                                <p class="mt-2 flex-1 text-sm text-slate-600">{{ $related->excerpt }}</p>
                            @endif
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 link-underline">Read article</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta-banner title="Need developers for your next project?" />
@endsection
