@props(['tech'])

<section class="gradient-hero section-padding pb-16">
    <div class="container-narrow">
        <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
            <a href="/" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-300">{{ $tech['name'] }} Developers</span>
        </nav>
        <div class="mt-6 grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <h1 class="font-display text-4xl font-semibold tracking-tight text-white sm:text-5xl text-balance">{{ $tech['headline'] }}</h1>
                <p class="mt-6 text-lg leading-relaxed text-slate-300">{{ $tech['description'] }}</p>
                <p class="mt-6 inline-flex rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm text-white">
                    Typical rates: <span class="ml-2 font-semibold text-accent-400">{{ $tech['rate'] }}</span>
                </p>
                <dl class="mt-8 flex flex-wrap gap-6 border-t border-white/10 pt-6">
                    @foreach([['48hr', 'Profile delivery'], ['NDA', 'Day-one signing'], ['94%', 'Client retention']] as [$val, $label])
                        <div>
                            <dd class="font-display text-lg font-semibold text-white">{{ $val }}</dd>
                            <dt class="text-xs text-slate-400">{{ $label }}</dt>
                        </div>
                    @endforeach
                </dl>
            </div>
            <div class="form-card-premium rounded-2xl bg-white p-5 shadow-elevated sm:p-6">
                <h2 class="font-display text-lg font-semibold text-navy-950">Hire {{ $tech['name'] }} talent</h2>
                <p class="mt-1 text-sm text-slate-500">Senior engineers matched to your stack and timezone.</p>
                <div class="mt-5">
                    <x-lead-form :id="'tech-' . $tech['slug']" :slim="true" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <x-section-header eyebrow="Capabilities" :title="'What our ' . $tech['name'] . ' developers deliver'" />
        <div class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($tech['skills'] as $skill)
                <div class="flex items-center gap-3 rounded-xl border border-slate-200/80 bg-white px-4 py-3 shadow-soft">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <span class="text-sm font-medium text-navy-950">{{ $skill }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <div class="grid gap-12 lg:grid-cols-3">
            @foreach($tech['benefits'] as [$title, $text])
                <article class="card-premium p-8">
                    <h3 class="font-display text-lg font-semibold text-navy-950">{{ $title }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div>
                <x-section-header align="left" eyebrow="Delivery workflow" title="How {{ $tech['name'] }} engagements run" description="Structured onboarding so your developer contributes from the first sprint—not after weeks of ramp-up." />
                <ol class="mt-8 space-y-4">
                    @foreach([
                        ['Technical brief', 'Stack versions, repos, ceremonies, and definition of done.'],
                        ['Profile shortlist', 'Vetted engineers with relevant production experience.'],
                        ['Interview & trial', 'You meet finalists; optional paid trial sprint.'],
                        ['Embedded delivery', 'Daily standups, PR reviews, and shared documentation.'],
                    ] as $i => [$title, $desc])
                        <li class="flex gap-4">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-700 text-xs font-bold text-white">{{ $i + 1 }}</span>
                            <div>
                                <h3 class="text-sm font-semibold text-navy-950">{{ $title }}</h3>
                                <p class="mt-1 text-sm text-slate-600">{{ $desc }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
            <x-project-preview :title="$tech['name'] . ' project workspace'" subtitle="Sprint board & code review flow" variant="dashboard" />
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <x-section-header eyebrow="Engagement models" title="Flexible ways to work with {{ $tech['name'] }} developers" />
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach([
                ['Hourly', 'Senior expertise for audits, spikes, or advisory without long commitments.'],
                ['Dedicated', 'Full-time engineer in your timezone with monthly retainer billing.'],
                ['Project squad', 'Blended team with tech lead, developers, and QA on fixed scope.'],
            ] as [$title, $desc])
                <article class="card-premium p-6">
                    <h3 class="font-display text-base font-semibold text-navy-950">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <x-section-header eyebrow="Deployment & communication" title="Built for distributed product teams" />
        <div class="mt-10 grid gap-8 md:grid-cols-2">
            <div class="card-premium p-6">
                <h3 class="font-semibold text-navy-950">Deployment approach</h3>
                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                    <li class="flex gap-2"><span class="text-brand-600">—</span> CI/CD aligned to your branching strategy</li>
                    <li class="flex gap-2"><span class="text-brand-600">—</span> Staging environments before production releases</li>
                    <li class="flex gap-2"><span class="text-brand-600">—</span> Docker and cloud deploy experience (AWS, VPS)</li>
                    <li class="flex gap-2"><span class="text-brand-600">—</span> Rollback plans and post-release monitoring</li>
                </ul>
            </div>
            <div class="card-premium p-6">
                <h3 class="font-semibold text-navy-950">Communication rhythm</h3>
                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                    <li class="flex gap-2"><span class="text-brand-600">—</span> Slack, Teams, or email—your preference</li>
                    <li class="flex gap-2"><span class="text-brand-600">—</span> Weekly written status with risks and blockers</li>
                    <li class="flex gap-2"><span class="text-brand-600">—</span> Shared documentation in Notion or Confluence</li>
                    <li class="flex gap-2"><span class="text-brand-600">—</span> Account manager for escalation and billing</li>
                </ul>
            </div>
        </div>
        <div class="mt-10 flex flex-wrap gap-2">
            @foreach(['Fintech', 'Healthcare', 'Logistics', 'SaaS', 'Retail', 'Manufacturing'] as $ind)
                <span class="badge-metric">{{ $ind }}</span>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow max-w-3xl">
        <h2 class="heading-section">Why teams hire {{ $tech['name'] }} developers through us</h2>
        <p class="mt-4 leading-relaxed text-slate-600">{{ $tech['longform'] ?? 'Every engineer in our pool has contributed to production codebases—not tutorial projects. We share profiles within 48 hours, you interview finalists directly, and onboarding happens within days under NDA.' }}</p>
        <h3 class="mt-10 text-xl font-semibold text-navy-950">Related technologies</h3>
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="/hire-laravel-developers" class="badge-tech hover:bg-brand-100">Laravel</a>
            <a href="/hire-react-developers" class="badge-tech hover:bg-brand-100">React</a>
            <a href="/hire-nodejs-developers" class="badge-tech hover:bg-brand-100">Node.js</a>
            <a href="/hire-flutter-developers" class="badge-tech hover:bg-brand-100">Flutter</a>
        </div>
    </div>
</section>

<x-cta-banner :title="'Start your ' . $tech['name'] . ' team this week'" />
