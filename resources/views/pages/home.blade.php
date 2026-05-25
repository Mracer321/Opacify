@extends('layouts.app')

@section('title', 'Hire Developer — Hire Top Remote Developers For Your Projects')
@section('meta_description', 'Hire experienced Laravel, React, Node.js, Flutter, and full-stack developers for hourly, dedicated, or project-based work. Starting from $15/hour.')
@section('canonical', 'https://hiredeveloper.co.in')

@section('content')
    <section class="gradient-hero relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-60"></div>
        <div class="section-padding relative pb-20 pt-12 lg:pt-16">
            <div class="container-narrow">
                <div class="grid items-start gap-12 lg:grid-cols-2 lg:gap-16">
                    <div class="animate-fade-in">
                        <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-sm text-slate-300 backdrop-blur">
                            <span class="h-2 w-2 rounded-full bg-accent-400"></span>
                            Vetted developers · NDA-backed engagements
                        </p>
                        <h1 class="mt-6 font-display text-4xl font-semibold leading-tight tracking-tight text-white sm:text-5xl lg:text-[3.25rem] text-balance">
                            Hire Top Remote Developers For Your Projects
                        </h1>
                        <p class="mt-6 text-lg leading-relaxed text-slate-300 sm:text-xl">
                            Hire experienced Laravel, React, Node.js, Flutter, and full-stack developers for hourly, dedicated, or project-based work.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center gap-6">
                            <div class="rounded-xl border border-white/10 bg-white/5 px-5 py-3 backdrop-blur">
                                <p class="text-xs font-medium uppercase tracking-wider text-accent-400">Transparent pricing</p>
                                <p class="mt-1 font-display text-2xl font-semibold text-white">Starting from <span class="text-accent-400">$15/hour</span></p>
                            </div>
                            <ul class="space-y-2 text-sm text-slate-300">
                                <li class="flex items-center gap-2"><svg class="h-5 w-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Match within 48 hours</li>
                                <li class="flex items-center gap-2"><svg class="h-5 w-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> No upfront recruitment fees</li>
                            </ul>
                        </div>
                    </div>
                    <div class="animate-slide-up lg:sticky lg:top-24">
                        <div class="rounded-2xl border border-white/10 bg-white shadow-elevated">
                            <div class="border-b border-slate-100 px-6 py-4">
                                <h2 class="font-display text-lg font-semibold text-navy-950">Get a free developer match</h2>
                                <p class="text-sm text-slate-500">Share your requirements—we respond within one business day.</p>
                            </div>
                            <div class="p-6">
                                <x-lead-form id="hero-lead-form" :compact="true" :showCompany="false" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-100 bg-slate-50 py-12">
        <div class="container-narrow px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-medium uppercase tracking-wider text-slate-500">Trusted by product teams and agencies</p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-6 opacity-70 grayscale">
                @foreach(['FinEdge', 'RetailOS', 'HealthBridge', 'LogiStack', 'EduNova', 'PropTech Co'] as $brand)
                    <span class="font-display text-lg font-semibold tracking-tight text-slate-400">{{ $brand }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding gradient-subtle">
        <div class="container-narrow">
            <x-section-header eyebrow="Technologies" title="Hire developers across your entire stack" description="From backend APIs to mobile apps—we place engineers who have shipped production systems in the technologies you rely on." />
            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['Laravel', 'PHP backends, APIs, and admin panels', '/hire-laravel-developers', 'LV'],
                    ['React', 'SPAs, dashboards, and design systems', '/hire-react-developers', 'RE'],
                    ['Node.js', 'Real-time apps and microservices', '/hire-nodejs-developers', 'ND'],
                    ['Flutter', 'Cross-platform iOS and Android', '/hire-flutter-developers', 'FL'],
                ] as [$name, $desc, $href, $abbr])
                    <a href="{{ $href }}" class="card-premium group block p-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-700 text-sm font-bold text-white transition-transform duration-300 group-hover:scale-105">{{ $abbr }}</div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-navy-950 group-hover:text-brand-700">Hire {{ $name }} Developers</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
                        <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-700">Explore <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></span>
                    </a>
                @endforeach
            </div>
            <div class="mt-8 flex flex-wrap justify-center gap-2">
                @foreach(['Vue.js', 'Angular', 'Python', 'MySQL', 'Docker', 'AWS', 'TypeScript', 'PostgreSQL'] as $badge)
                    <a href="/technologies/{{ strtolower(str_replace([' ', '.'], ['-', ''], $badge)) }}" class="badge-tech transition-colors hover:bg-brand-100">{{ $badge }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <x-section-header eyebrow="Services" title="End-to-end software delivery" description="Whether you need a single senior engineer or a full product squad, we align talent to your roadmap and delivery model." />
            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    ['Web Development', 'Custom portals, SaaS platforms, and internal tools built for scale.', '/services/web-development'],
                    ['Mobile App Development', 'Native and cross-platform apps with polished UX and reliable releases.', '/services/mobile-app-development'],
                    ['ERP Solutions', 'Inventory, finance, and operations modules tailored to your workflows.', '/services/erp-solutions'],
                    ['Software Development', 'Greenfield products and legacy modernization with clear milestones.', '/services/software-development'],
                    ['Digital Marketing', 'SEO, paid media, and conversion optimization for growth teams.', '/services/digital-marketing'],
                    ['AI & Automation', 'Workflow automation, integrations, and data-driven decision tools.', '/services/ai-automation'],
                ] as [$title, $desc, $href])
                    <a href="{{ $href }}" class="card-premium block p-6">
                        <h3 class="font-display text-lg font-semibold text-navy-950">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $desc }}</p>
                        <span class="mt-4 inline-block text-sm font-semibold text-brand-700 link-underline">Learn more</span>
                    </a>
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <x-button href="/services" variant="secondary">View all services</x-button>
            </div>
        </div>
    </section>

    <section class="section-padding bg-slate-50">
        <div class="container-narrow">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <x-section-header align="left" eyebrow="Why Hire Developer" title="Built for teams that cannot afford hiring mistakes" description="We combine agency-grade delivery with the flexibility of staff augmentation—so you get speed without sacrificing quality." />
                    <ul class="mt-8 space-y-4">
                        @foreach([
                            ['Rigorous vetting', 'Technical interviews, live coding, and reference checks on every developer.'],
                            ['Dedicated account management', 'A single point of contact for staffing, billing, and escalation.'],
                            ['Timezone overlap', 'Engineers available for US, UK, EU, and APAC collaboration windows.'],
                            ['IP protection', 'NDAs, secure repositories, and role-based access from day one.'],
                        ] as [$title, $text])
                            <li class="flex gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-700 text-white">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <h3 class="font-semibold text-navy-950">{{ $title }}</h3>
                                    <p class="mt-1 text-sm text-slate-600">{{ $text }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <x-stat-grid :stats="[
                    ['label' => 'Developers placed', 'value' => '320+', 'note' => 'Across 18 countries'],
                    ['label' => 'Client retention', 'value' => '94%', 'note' => '12-month average'],
                    ['label' => 'Avg. time to match', 'value' => '3 days', 'note' => 'For senior roles'],
                    ['label' => 'Projects delivered', 'value' => '180+', 'note' => 'Since 2018'],
                ]" />
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <x-section-header eyebrow="Engagement models" title="Flexible hiring that fits your budget" />
            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach([
                    ['Hourly Basis', 'Best for advisory, audits, or short bursts of senior expertise.', '$15–$45/hr', 'Scale up or down weekly'],
                    ['Dedicated Developer', 'A full-time engineer embedded in your sprint rituals and tools.', 'Monthly retainer', '40 hrs/week commitment'],
                    ['Full Project', 'Fixed scope with milestones, QA, and handover documentation.', 'Custom quote', 'Discovery workshop included'],
                ] as [$title, $desc, $price, $note])
                    <article class="card-premium flex flex-col p-8">
                        <h3 class="font-display text-xl font-semibold text-navy-950">{{ $title }}</h3>
                        <p class="mt-3 flex-1 text-sm text-slate-600">{{ $desc }}</p>
                        <p class="mt-6 font-display text-2xl font-semibold text-brand-700">{{ $price }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $note }}</p>
                        <x-button href="/contact" variant="secondary" class="mt-6 w-full">Discuss this model</x-button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding border-y border-slate-100 bg-white">
        <div class="container-narrow">
            <x-section-header eyebrow="Expertise" title="Senior talent across product and platform" description="Our network includes staff-level engineers who have led migrations, built payment flows, and owned on-call for high-traffic systems." />
            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['Full-Stack', 'Laravel + React, Node + Vue'],
                    ['Backend & APIs', 'REST, GraphQL, microservices'],
                    ['Frontend & UI', 'Design systems, accessibility'],
                    ['Mobile', 'Flutter, React Native, native'],
                    ['DevOps', 'CI/CD, Docker, cloud deploy'],
                    ['QA & Testing', 'Automation, regression suites'],
                    ['Data & BI', 'ETL, Power BI, analytics'],
                    ['AI & ML', 'Integrations, workflow bots'],
                ] as [$role, $skills])
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/50 p-5 transition-colors hover:border-brand-200 hover:bg-brand-50/30">
                        <h3 class="font-semibold text-navy-950">{{ $role }}</h3>
                        <p class="mt-1 text-sm text-slate-600">{{ $skills }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding bg-slate-50">
        <div class="container-narrow">
            <x-section-header eyebrow="How it works" title="From brief to onboarded developer in days" />
            <ol class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['01', 'Share requirements', 'Tell us your stack, timeline, and team structure via our form or a call.'],
                    ['02', 'Receive shortlist', 'We send profiles with portfolios, availability, and rate cards.'],
                    ['03', 'Interview & select', 'Meet candidates live. Swap or extend with no long-term lock-in.'],
                    ['04', 'Start delivery', 'Developer joins your tools. We handle contracts and invoicing.'],
                ] as [$step, $title, $desc])
                    <li class="relative">
                        <span class="font-display text-4xl font-bold text-brand-100">{{ $step }}</span>
                        <h3 class="mt-2 font-display text-lg font-semibold text-navy-950">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="section-padding">
        <div class="container-narrow">
            <x-section-header eyebrow="Client stories" title="Teams that scaled with Hire Developer" />
            <div class="mt-12 grid gap-6 md:grid-cols-3">
                <x-testimonial-card quote="We needed a Laravel lead within a week for a fintech MVP. Hire Developer sent three strong profiles; we onboarded one in four days. Code quality and communication were consistently excellent." author="Priya Mehta" role="CTO" company="FinEdge Payments" initials="PM" />
                <x-testimonial-card quote="Our React dashboard was six weeks behind. A dedicated frontend engineer from HD joined our standups, refactored our component library, and helped us ship before our investor demo." author="James Whitfield" role="VP Engineering" company="RetailOS" initials="JW" />
                <x-testimonial-card quote="We run a dedicated Flutter team through HD for two apps. They understand our release process, handle store submissions, and have never missed a sprint commitment in fourteen months." author="Anita Korhonen" role="Product Director" company="HealthBridge" initials="AK" />
            </div>
        </div>
    </section>

    <section class="section-padding bg-slate-50">
        <div class="container-narrow">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <x-section-header align="left" eyebrow="Case studies" title="Recent work across industries" class="max-w-xl" />
                <x-button href="/case-studies" variant="secondary">View all case studies</x-button>
            </div>
            <div class="mt-12 grid gap-8 lg:grid-cols-2">
                @foreach([
                    ['Logistics ERP Modernization', 'Replaced legacy desktop software with a Laravel + Vue platform serving 40 warehouses.', ['Laravel', 'Vue.js', 'MySQL'], '40% faster fulfillment', '/case-studies/logistics-erp-modernization'],
                    ['Healthcare Patient Portal', 'HIPAA-aware React portal with appointment booking and secure messaging.', ['React', 'Node.js', 'AWS'], '2.1M sessions / year', '/case-studies/healthcare-patient-portal'],
                ] as [$title, $desc, $techs, $metric, $href])
                    <a href="{{ $href }}" class="card-premium group overflow-hidden">
                        <div class="aspect-[16/9] bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                            <div class="text-center px-6">
                                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Project preview</span>
                                <p class="mt-2 font-display text-lg font-semibold text-slate-500">{{ $title }}</p>
                            </div>
                        </div>
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-wrap gap-2">
                                @foreach($techs as $t)<span class="badge-tech">{{ $t }}</span>@endforeach
                            </div>
                            <h3 class="mt-4 font-display text-xl font-semibold text-navy-950 group-hover:text-brand-700">{{ $title }}</h3>
                            <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
                            <p class="mt-4 text-sm font-semibold text-accent-600">{{ $metric }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-padding" id="faqs">
        <div class="container-narrow max-w-3xl">
            <x-section-header eyebrow="FAQs" title="Common questions about hiring developers" />
            <div class="mt-10">
                <x-faq-accordion :items="[
                    ['question' => 'How quickly can you provide developers?', 'answer' => 'For common stacks like Laravel, React, and Node.js, we typically share profiles within 48 hours. Niche or principal-level roles may take 3–5 business days.'],
                    ['question' => 'What is your minimum engagement?', 'answer' => 'Hourly engagements start at 20 hours per month. Dedicated developers work on a monthly retainer with a 30-day notice period for changes.'],
                    ['question' => 'Do developers work in our timezone?', 'answer' => 'Yes. We align overlap with your core hours—commonly 4–6 hours with US Eastern and full UK business hours for European clients.'],
                    ['question' => 'How do you ensure code quality?', 'answer' => 'Developers follow your branching strategy, participate in reviews, and can include QA engineers. We also offer technical leads for architecture oversight.'],
                    ['question' => 'Can we hire a full project team?', 'answer' => 'Absolutely. We staff blended squads with a tech lead, developers, QA, and DevOps based on a fixed statement of work after a discovery workshop.'],
                ]" />
            </div>
        </div>
    </section>

    <x-cta-banner />
@endsection
