@extends('layouts.app')

@section('title', 'Hire Developer — Hire Top Remote Developers For Your Projects')
@section('meta_description', 'Hire experienced Laravel, React, Node.js, Flutter, and full-stack developers for hourly, dedicated, or project-based work. Starting from $15/hour.')
@section('canonical', 'https://hiredeveloper.co.in')

@section('content')
<section class="gradient-hero relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-60"></div>
    <div class="section-padding relative pb-20 pt-12 lg:pt-16">
        <div class="container-narrow">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-10 xl:gap-16">
                <div class="reveal-on-scroll relative z-10">
                    <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-sm text-slate-300 backdrop-blur-sm">
                        <span class="h-2 w-2 rounded-full bg-brand-500 ring-2 ring-brand-500/30"></span>
                        Vetted developers · NDA-backed engagements
                    </p>
                    <h1 class="mt-6 font-display text-4xl font-semibold leading-tight tracking-tight text-white sm:text-5xl lg:text-[3.25rem] text-balance">
                        Hire Top Remote Developers For Your Projects
                    </h1>
                    <p class="mt-6 text-lg leading-relaxed text-slate-300 sm:text-xl">
                        Hire experienced Laravel, React, Node.js, Flutter, and full-stack developers for hourly, dedicated, or project-based work.
                    </p>
                    <div class="mt-8 flex flex-wrap items-center gap-6">
                        <div class="rounded-xl border border-white/10 bg-white/5 px-5 py-3 backdrop-blur-sm">
                            <p class="text-xs font-medium uppercase tracking-wider text-brand-400">Transparent pricing</p>
                            <p class="mt-1 font-display text-2xl font-semibold text-white">Starting from <span class="text-brand-400">$15/hour</span></p>
                        </div>
                        <ul class="space-y-2 text-sm text-slate-300">
                            <li class="flex items-center gap-2"><x-icon name="check" class="h-5 w-5 text-brand-400" /> Match within 48 hours</li>
                            <li class="flex items-center gap-2"><x-icon name="check" class="h-5 w-5 text-brand-400" /> No upfront recruitment fees</li>
                        </ul>
                    </div>
                </div>

                <div class="reveal-on-scroll relative z-10 lg:pl-4" data-reveal-delay="120">
                    <x-hero-visual class="!hidden xl:block absolute inset-y-0 -left-[55%] right-0 -z-10" />
                    <div class="relative z-10 rounded-2xl border border-white/10 bg-white/95 shadow-elevated backdrop-blur-sm ring-1 ring-white/20">
                        <div class="border-b border-slate-100 px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-icon-box icon="chat" variant="soft" class="!h-9 !w-9" />
                                <div>
                                    <h2 class="font-display text-lg font-semibold text-navy">Get a free developer match</h2>
                                    <p class="text-sm text-slate-500">We respond within one business day.</p>
                                </div>
                            </div>
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

<section class="border-b border-slate-100 bg-slate-50 py-12 reveal-on-scroll">
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
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Technologies" title="Hire developers across your entire stack" description="From backend APIs to mobile apps—we place engineers who have shipped production systems in the technologies you rely on." />
        </div>
        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
            @foreach([
            ['Laravel', 'PHP backends, APIs, and admin panels', '/hire-laravel-developers'],
            ['React', 'SPAs, dashboards, and design systems', '/hire-react-developers'],
            ['Node.js', 'Real-time apps and microservices', '/hire-nodejs-developers'],
            ['Flutter', 'Cross-platform iOS and Android', '/hire-flutter-developers'],
            ] as [$name, $desc, $href])
            <a href="{{ $href }}" class="card-premium card-equal group block p-6 reveal-on-scroll">
                <x-tech-icon :tech="$name" box="h-12 w-12" class="h-7 w-7" />
                <h3 class="mt-4 font-display text-lg font-semibold text-navy group-hover:text-brand-700">Hire {{ $name }} Developers</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-700">Explore <x-icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" /></span>
            </a>
            @endforeach
        </div>
        @php
        $techChips = ['React', 'Next.js', 'Laravel', 'PHP', 'Node.js', 'Vue.js', 'Angular', 'Flutter', 'Docker', 'AWS', 'TypeScript', 'PostgreSQL', 'MySQL', 'Python'];
        @endphp
        {{-- Mobile & tablet: horizontal swipe slider --}}
        <div class="mobile-snap-row mt-8 reveal-on-scroll lg:hidden" data-reveal-delay="200">
            <div class="mobile-tech-track scrollbar-hide gap-2.5" data-tech-marquee>
                @foreach($techChips as $badge)
                <a href="/technologies/{{ strtolower(str_replace([' ', '.'], ['-', ''], $badge)) }}" class="badge-tech-icon mobile-snap-chip">
                    <x-tech-icon :tech="$badge" class="h-4 w-4" box="h-7 w-7 rounded-md" />
                    {{ $badge }}
                </a>
                @endforeach
            </div>
        </div>
        {{-- Desktop: unchanged wrap layout --}}
        <div class="mt-8 hidden flex-wrap justify-center gap-2 reveal-on-scroll lg:flex" data-reveal-delay="200">
            @foreach(['Vue.js', 'Angular', 'Python', 'MySQL', 'Docker', 'AWS', 'TypeScript', 'PostgreSQL'] as $badge)
            <a href="/technologies/{{ strtolower(str_replace([' ', '.'], ['-', ''], $badge)) }}" class="badge-tech-icon">
                <x-tech-icon :tech="$badge" class="h-4 w-4" box="h-7 w-7 rounded-md" />
                {{ $badge }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Services" title="End-to-end software delivery" description="Whether you need a single senior engineer or a full product squad, we align talent to your roadmap and delivery model." />
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3" data-reveal-stagger>
            @foreach([
            ['Web Development', 'Custom portals, SaaS platforms, and internal tools built for scale.', '/services/web-development', 'web'],
            ['Mobile App Development', 'Native and cross-platform apps with polished UX and reliable releases.', '/services/mobile-app-development', 'mobile'],
            ['ERP Solutions', 'Inventory, finance, and operations modules tailored to your workflows.', '/services/erp-solutions', 'erp'],
            ['Software Development', 'Greenfield products and legacy modernization with clear milestones.', '/services/software-development', 'software'],
            ['Digital Marketing', 'SEO, paid media, and conversion optimization for growth teams.', '/services/digital-marketing', 'marketing'],
            ['AI & Automation', 'Workflow automation, integrations, and data-driven decision tools.', '/services/ai-automation', 'ai'],
            ] as [$title, $desc, $href, $icon])
            <a href="{{ $href }}" class="card-premium card-equal block p-6 reveal-on-scroll">
                <x-service-icon :name="$icon" size="h-7 w-7" box="h-14 w-14 rounded-xl" />
                <h3 class="mt-4 font-display text-lg font-semibold text-navy">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $desc }}</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-700 link-underline">Learn more</span>
            </a>
            @endforeach
        </div>
        <div class="mt-10 text-center reveal-on-scroll">
            <x-button href="/services" variant="secondary">View all services</x-button>
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="reveal-on-scroll">
                <x-section-header align="left" eyebrow="Why Hire Developer" title="Built for teams that cannot afford hiring mistakes" description="We combine agency-grade delivery with the flexibility of staff augmentation—so you get speed without sacrificing quality." />
                <ul class="mt-8 space-y-4">
                    @foreach([
                    ['shield', 'Rigorous vetting', 'Technical interviews, live coding, and reference checks on every developer.'],
                    ['users', 'Dedicated account management', 'A single point of contact for staffing, billing, and escalation.'],
                    ['clock', 'Timezone overlap', 'Engineers available for US, UK, EU, and APAC collaboration windows.'],
                    ['lock', 'IP protection', 'NDAs, secure repositories, and role-based access from day one.'],
                    ] as [$icon, $title, $text])
                    <li class="flex gap-4 card-premium p-5">
                        <x-icon-box :icon="$icon" />
                        <div>
                            <h3 class="font-semibold text-navy">{{ $title }}</h3>
                            <p class="mt-1 text-sm text-slate-600">{{ $text }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="reveal-on-scroll" data-reveal-delay="150">
                <x-stat-grid :stats="[
                        ['label' => 'Developers placed', 'value' => '320+', 'note' => 'Across 18 countries', 'icon' => 'users'],
                        ['label' => 'Client retention', 'value' => '94%', 'note' => '12-month average', 'icon' => 'chart'],
                        ['label' => 'Avg. time to match', 'value' => '3 days', 'note' => 'For senior roles', 'icon' => 'clock'],
                        ['label' => 'Projects delivered', 'value' => '180+', 'note' => 'Since 2018', 'icon' => 'briefcase'],
                    ]" />
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Engagement models" title="Flexible hiring that fits your budget" />
        </div>
        @php
        $pricingPlans = [
        ['currency', 'Hourly Basis', 'Best for advisory, audits, or short bursts of senior expertise.', '$15–$45/hr', 'Scale up or down weekly'],
        ['briefcase', 'Dedicated Developer', 'A full-time engineer embedded in your sprint rituals and tools.', 'Monthly retainer', '40 hrs/week commitment'],
        ['document', 'Full Project', 'Fixed scope with milestones, QA, and handover documentation.', 'Custom quote', 'Discovery workshop included'],
        ];
        @endphp
        {{-- Mobile & tablet: peek carousel with arrows & dots --}}
        <x-mobile-carousel :count="count($pricingPlans)" label="Pricing plans" :peek="true" class="mt-12">
            @foreach($pricingPlans as [$icon, $title, $desc, $price, $note])
            <div class="mobile-carousel-slide is-peek">
                <x-pricing-card :icon="$icon" :title="$title" :description="$desc" :price="$price" :note="$note" />
            </div>
            @endforeach
        </x-mobile-carousel>
        {{-- Desktop: unchanged grid --}}
        <div class="mt-12 hidden gap-6 lg:grid lg:grid-cols-3" data-reveal-stagger>
            @foreach($pricingPlans as [$icon, $title, $desc, $price, $note])
            <x-pricing-card :icon="$icon" :title="$title" :description="$desc" :price="$price" :note="$note" class="reveal-on-scroll p-8" />
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding border-y border-slate-100 bg-white">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Expertise" title="Senior talent across product and platform" description="Our network includes staff-level engineers who have led migrations, built payment flows, and owned on-call for high-traffic systems." />
        </div>
        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
            @foreach([
            ['layers', 'Full-Stack', 'Laravel + React, Node + Vue'],
            ['server', 'Backend & APIs', 'REST, GraphQL, microservices'],
            ['component', 'Frontend & UI', 'Design systems, accessibility'],
            ['smartphone', 'Mobile', 'Flutter, React Native, native'],
            ['cloud', 'DevOps', 'CI/CD, Docker, cloud deploy'],
            ['check', 'QA & Testing', 'Automation, regression suites'],
            ['chart', 'Data & BI', 'ETL, Power BI, analytics'],
            ['cpu', 'AI & ML', 'Integrations, workflow bots'],
            ] as [$icon, $role, $skills])
            <div class="card-premium p-5 reveal-on-scroll">
                <x-icon-box :icon="$icon" variant="soft" class="!h-9 !w-9" />
                <h3 class="mt-3 font-semibold text-navy">{{ $role }}</h3>
                <p class="mt-1 text-sm text-slate-600">{{ $skills }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="How it works" title="From brief to onboarded developer in days" />
        </div>
        <ol class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4" data-reveal-stagger>
            @foreach([
            ['chat', '01', 'Share requirements', 'Tell us your stack, timeline, and team structure via our form or a call.'],
            ['users', '02', 'Receive shortlist', 'We send profiles with portfolios, availability, and rate cards.'],
            ['workflow', '03', 'Interview & select', 'Meet candidates live. Swap or extend with no long-term lock-in.'],
            ['code', '04', 'Start delivery', 'Developer joins your tools. We handle contracts and invoicing.'],
            ] as [$icon, $step, $title, $desc])
            <li class="card-premium p-6 reveal-on-scroll">
                <div class="flex items-center justify-between">
                    <span class="process-step-icon"><x-icon :name="$icon" class="h-5 w-5" /></span>
                    <span class="font-display text-2xl font-bold text-brand-100">{{ $step }}</span>
                </div>
                <h3 class="mt-4 font-display text-lg font-semibold text-navy">{{ $title }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
            </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="section-padding">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Client stories" title="Teams that scaled with Hire Developer" />
        </div>
        @php
        $testimonials = [
        ['quote' => 'We needed a Laravel lead within a week for a fintech MVP. Hire Developer sent three strong profiles; we onboarded one in four days. Code quality and communication were consistently excellent.', 'author' => 'Priya Mehta', 'role' => 'CTO', 'company' => 'FinEdge Payments', 'initials' => 'PM'],
        ['quote' => 'Our React dashboard was six weeks behind. A dedicated frontend engineer from HD joined our standups, refactored our component library, and helped us ship before our investor demo.', 'author' => 'James Whitfield', 'role' => 'VP Engineering', 'company' => 'RetailOS', 'initials' => 'JW'],
        ['quote' => 'We run a dedicated Flutter team through HD for two apps. They understand our release process, handle store submissions, and have never missed a sprint commitment in fourteen months.', 'author' => 'Anita Korhonen', 'role' => 'Product Director', 'company' => 'HealthBridge', 'initials' => 'AK'],
        ];
        @endphp
        {{-- Mobile & tablet: swipe carousel with dots --}}
        <x-mobile-carousel :count="count($testimonials)" label="Client testimonials" class="mt-12">
            @foreach($testimonials as $t)
            <div class="mobile-carousel-slide">
                <x-testimonial-card
                    class="h-auto"
                    :quote="$t['quote']"
                    :author="$t['author']"
                    :role="$t['role']"
                    :company="$t['company']"
                    :initials="$t['initials']" />
            </div>
            @endforeach
        </x-mobile-carousel>
        {{-- Desktop: unchanged grid --}}
        <div class="mt-12 hidden gap-6 lg:grid lg:grid-cols-3" data-reveal-stagger>
            @foreach($testimonials as $t)
            <x-testimonial-card
                class="card-equal reveal-on-scroll"
                :quote="$t['quote']"
                :author="$t['author']"
                :role="$t['role']"
                :company="$t['company']"
                :initials="$t['initials']" />
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end reveal-on-scroll">
            <x-section-header align="left" eyebrow="Case studies" title="Recent work across industries" class="max-w-xl" />
            <x-button href="/case-studies" variant="secondary">View all case studies</x-button>
        </div>
        <div class="mt-12 grid gap-8 lg:grid-cols-2" data-reveal-stagger>
            @foreach([
            ['Logistics ERP Modernization', 'Replaced legacy desktop software with a Laravel + Vue platform serving 40 warehouses.', ['Laravel', 'Vue.js', 'MySQL'], '40% faster fulfillment', '/case-studies/logistics-erp-modernization', 'erp'],
            ['Healthcare Patient Portal', 'HIPAA-aware React portal with appointment booking and secure messaging.', ['React', 'Node.js', 'AWS'], '2.1M sessions / year', '/case-studies/healthcare-patient-portal', 'dashboard'],
            ] as [$title, $desc, $techs, $metric, $href, $variant])
            <a href="{{ $href }}" class="card-premium group overflow-hidden reveal-on-scroll">
                <x-ui-mockup :variant="$variant" :title="$title" subtitle="Client deliverable preview" class="rounded-none border-0 border-b border-slate-200/80 shadow-none" />
                <div class="p-6 sm:p-8">
                    <div class="flex flex-wrap gap-2">
                        @foreach($techs as $t)<span class="badge-tech">{{ $t }}</span>@endforeach
                    </div>
                    <h3 class="mt-4 font-display text-xl font-semibold text-navy group-hover:text-brand-700">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
                    <p class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600"><x-icon name="chart" class="h-4 w-4" /> {{ $metric }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding reveal-on-scroll" id="faqs">
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

<x-cta-banner class="reveal-on-scroll" />
@endsection