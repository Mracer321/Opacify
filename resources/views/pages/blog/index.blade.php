@extends('layouts.app')

@section('title', 'Blog — Hiring Developers & Software Insights | Hire Developer')
@section('meta_description', 'Practical guides on hiring remote developers, scaling engineering teams, and delivering software projects.')
@section('canonical', 'https://hiredeveloper.co.in/blog')

@php
$posts = [
    [
        'slug' => 'how-to-hire-laravel-developers',
        'title' => 'How to Hire Laravel Developers Without a Six-Month Search',
        'excerpt' => 'A practical framework for evaluating Laravel talent, structuring trials, and avoiding common outsourcing pitfalls.',
        'category' => 'Hiring',
        'date' => 'May 12, 2026',
        'read' => '8 min read',
    ],
    [
        'slug' => 'dedicated-developer-vs-hourly',
        'title' => 'Dedicated Developer vs Hourly: Which Model Fits Your Roadmap?',
        'excerpt' => 'Compare cost predictability, velocity, and governance across engagement models before you sign.',
        'category' => 'Strategy',
        'date' => 'Apr 28, 2026',
        'read' => '6 min read',
    ],
    [
        'slug' => 'react-team-augmentation-checklist',
        'title' => 'The React Team Augmentation Checklist for Series A Startups',
        'excerpt' => 'What to prepare in design systems, repos, and ceremonies before your first frontend contractor joins.',
        'category' => 'Frontend',
        'date' => 'Apr 15, 2026',
        'read' => '7 min read',
    ],
    [
        'slug' => 'erp-migration-lessons',
        'title' => 'Five Lessons from Migrating a Legacy ERP to Laravel',
        'excerpt' => 'Data migration, user training, and phased rollouts—what actually reduced downtime.',
        'category' => 'Case insights',
        'date' => 'Mar 30, 2026',
        'read' => '10 min read',
    ],
];
@endphp

@section('content')
    <section class="gradient-hero section-padding pb-14">
        <div class="container-narrow">
            <h1 class="font-display text-4xl font-semibold text-white sm:text-5xl">Insights for hiring and building</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-300">Guides written by delivery leads—not generic content farms.</p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <div class="grid gap-8 md:grid-cols-2">
                @foreach($posts as $post)
                    <article class="card-premium group flex flex-col overflow-hidden">
                        <div class="aspect-[2/1] bg-gradient-to-br from-brand-50 to-slate-100"></div>
                        <div class="flex flex-1 flex-col p-6 sm:p-8">
                            <div class="flex items-center gap-3 text-xs font-medium text-slate-500">
                                <span class="badge-tech">{{ $post['category'] }}</span>
                                <time datetime="{{ $post['date'] }}">{{ $post['date'] }}</time>
                                <span>{{ $post['read'] }}</span>
                            </div>
                            <h2 class="mt-4 font-display text-xl font-semibold text-navy-950 group-hover:text-brand-700">
                                <a href="/blog/{{ $post['slug'] }}">{{ $post['title'] }}</a>
                            </h2>
                            <p class="mt-3 flex-1 text-sm text-slate-600">{{ $post['excerpt'] }}</p>
                            <a href="/blog/{{ $post['slug'] }}" class="mt-4 text-sm font-semibold text-brand-700 link-underline">Read article</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-banner />
@endsection
