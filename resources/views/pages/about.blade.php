@extends('layouts.app')

@section('title', 'About Us — Hire Developer | Premium Software Agency')
@section('meta_description', 'Learn about Hire Developer—an enterprise software agency helping companies hire remote developers and deliver complex digital products since 2018.')
@section('canonical', 'https://hiredeveloper.co.in/about')

@section('content')
    <section class="gradient-hero section-padding pb-16">
        <div class="container-narrow">
            <h1 class="max-w-3xl font-display text-4xl font-semibold tracking-tight text-white sm:text-5xl">
                We help ambitious teams build software—and hire the people who ship it
            </h1>
            <p class="mt-6 max-w-2xl text-lg text-slate-300">
                Hire Developer is a remote-first software agency based in India, partnering with startups and enterprises across North America, Europe, and APAC since 2018.
            </p>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <x-section-header align="left" eyebrow="Our story" title="Agency discipline. Staff augmentation speed." description="We started because founders kept telling us the same story: great developers exist, but vetting, contracts, and timezone alignment take too long. We built a process that respects your roadmap and your standards." />
                </div>
                <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-brand-100 to-slate-100 flex items-center justify-center border border-slate-200">
                    <p class="px-8 text-center font-display text-lg font-medium text-slate-500">Team collaboration · Remote delivery · Client workshops</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-slate-50">
        <div class="container-narrow">
            <x-section-header eyebrow="Values" title="How we work with every client" />
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach([
                    ['Transparency', 'Clear rates, weekly status, and no surprise scope changes without written approval.'],
                    ['Ownership', 'Developers are accountable to outcomes—not ticket counts.'],
                    ['Partnership', 'We recommend when to hire, when to outsource a project, and when to pause.'],
                ] as [$title, $desc])
                    <div class="card-premium p-8">
                        <h3 class="font-display text-lg font-semibold text-navy-950">{{ $title }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <x-stat-grid :stats="[
                ['label' => 'Team members', 'value' => '85+', 'note' => 'Engineers, QA, PMs'],
                ['label' => 'Countries served', 'value' => '22', 'note' => 'Remote delivery'],
                ['label' => 'Years in business', 'value' => '7+', 'note' => 'Since 2018'],
                ['label' => 'Avg. client tenure', 'value' => '14 mo', 'note' => 'Dedicated teams'],
            ]" />
        </div>
    </section>

    <section class="section-padding bg-slate-50">
        <div class="container-narrow max-w-3xl text-center">
            <h2 class="heading-section">Leadership</h2>
            <p class="mt-4 text-slate-600">Our leadership team combines product engineering backgrounds with client services experience—so conversations stay technical and practical.</p>
            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                @foreach([
                    ['Rahul Sharma', 'CEO & Co-founder', 'RS'],
                    ['Neha Kapoor', 'Head of Delivery', 'NK'],
                    ['David Chen', 'Director, Client Success', 'DC'],
                ] as [$name, $role, $init])
                    <div class="card-premium p-6">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-700 text-lg font-bold text-white">{{ $init }}</div>
                        <h3 class="mt-4 font-semibold text-navy-950">{{ $name }}</h3>
                        <p class="text-sm text-slate-500">{{ $role }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta-banner />
@endsection
