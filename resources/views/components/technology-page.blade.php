@props(['tech'])

<section class="gradient-hero section-padding pb-16">
    <div class="container-narrow">
        <nav class="text-sm text-slate-400 reveal-on-scroll" aria-label="Breadcrumb">
            <a href="/" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-300">{{ $tech['name'] }} Developers</span>
        </nav>
        <div class="mt-6 grid gap-12 lg:grid-cols-2 lg:items-center">
            <div class="reveal-on-scroll">
                <div class="flex items-center gap-3">
                    <x-tech-icon :tech="$tech['name']" box="h-12 w-12 rounded-xl" class="h-6 w-6" />
                    <span class="text-sm font-medium text-brand-400">{{ $tech['name'] }} specialists</span>
                </div>
                <h1 class="mt-4 font-display text-4xl font-semibold tracking-tight text-white sm:text-5xl text-balance">{{ $tech['headline'] }}</h1>
                <p class="mt-6 text-lg leading-relaxed text-slate-300">{{ $tech['description'] }}</p>
                <p class="mt-6 inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm text-white">
                    <x-icon name="currency" class="h-4 w-4 text-brand-400" />
                    Typical rates: <span class="font-semibold text-brand-400">{{ $tech['rate'] }}</span>
                </p>
                <dl class="mt-8 flex flex-wrap gap-6 border-t border-white/10 pt-6">
                    @foreach([['48hr', 'Profile delivery', 'clock'], ['NDA', 'Day-one signing', 'lock'], ['94%', 'Client retention', 'chart']] as [$val, $label, $icon])
                        <div class="flex items-center gap-3">
                            <x-icon-box :icon="$icon" variant="soft" class="!h-9 !w-9 bg-white/10 text-white ring-white/10" />
                            <div>
                                <dd class="font-display text-lg font-semibold text-white">{{ $val }}</dd>
                                <dt class="text-xs text-slate-400">{{ $label }}</dt>
                            </div>
                        </div>
                    @endforeach
                </dl>
            </div>
            <div class="reveal-on-scroll relative" data-reveal-delay="120">
                <x-hero-visual class="!hidden xl:block absolute inset-y-0 -left-[45%] right-0 -z-10 opacity-90" />
                <div class="relative z-10 form-card-premium rounded-2xl bg-white p-5 shadow-elevated sm:p-6">
                    <div class="flex items-center gap-2 border-b border-slate-100 pb-4">
                        <x-icon-box icon="users" variant="soft" class="!h-9 !w-9" />
                        <div>
                            <h2 class="font-display text-lg font-semibold text-navy">Hire {{ $tech['name'] }} talent</h2>
                            <p class="text-sm text-slate-500">Senior engineers matched to your stack and timezone.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <x-lead-form :id="'tech-' . $tech['slug']" :slim="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Capabilities" :title="'What our ' . $tech['name'] . ' developers deliver'" />
        </div>
        <div class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-3" data-reveal-stagger>
            @foreach($tech['skills'] as $skill)
                <div class="card-premium flex items-center gap-3 px-4 py-3">
                    <x-icon-box icon="check" variant="soft" class="!h-8 !w-8" />
                    <span class="text-sm font-medium text-navy">{{ $skill }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <div class="grid gap-6 md:grid-cols-3" data-reveal-stagger>
            @foreach($tech['benefits'] as $i => [$title, $text])
                @php
                    $benefitIcons = ['shield', 'chart', 'workflow'];
                @endphp
                <article class="card-premium p-8 reveal-on-scroll">
                    <x-icon-box :icon="$benefitIcons[$i] ?? 'check'" variant="soft" />
                    <h3 class="mt-4 font-display text-lg font-semibold text-navy">{{ $title }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div class="reveal-on-scroll">
                <x-section-header align="left" eyebrow="Delivery workflow" title="How {{ $tech['name'] }} engagements run" description="Structured onboarding so your developer contributes from the first sprint—not after weeks of ramp-up." />
                <ol class="mt-8 space-y-4">
                    @foreach([
                        ['Technical brief', 'Stack versions, repos, ceremonies, and definition of done.', 'document'],
                        ['Profile shortlist', 'Vetted engineers with relevant production experience.', 'users'],
                        ['Interview & trial', 'You meet finalists; optional paid trial sprint.', 'chat'],
                        ['Embedded delivery', 'Daily standups, PR reviews, and shared documentation.', 'workflow'],
                    ] as $i => [$title, $desc, $icon])
                        <li class="flex gap-4">
                            <x-icon-box :icon="$icon" variant="brand" class="!h-9 !w-9 shrink-0" />
                            <div>
                                <h3 class="text-sm font-semibold text-navy">{{ $title }}</h3>
                                <p class="mt-1 text-sm text-slate-600">{{ $desc }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="reveal-on-scroll" data-reveal-delay="100">
                <x-project-preview :title="$tech['name'] . ' project workspace'" subtitle="Sprint board & code review flow" variant="dashboard" />
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Engagement models" title="Flexible ways to work with {{ $tech['name'] }} developers" />
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-3" data-reveal-stagger>
            @foreach([
                ['Hourly', 'Senior expertise for audits, spikes, or advisory without long commitments.', 'clock'],
                ['Dedicated', 'Full-time engineer in your timezone with monthly retainer billing.', 'users'],
                ['Project squad', 'Blended team with tech lead, developers, and QA on fixed scope.', 'briefcase'],
            ] as [$title, $desc, $icon])
                <article class="card-premium p-6">
                    <x-icon-box :icon="$icon" variant="soft" />
                    <h3 class="mt-4 font-display text-base font-semibold text-navy">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <div class="reveal-on-scroll">
            <x-section-header eyebrow="Deployment & communication" title="Built for distributed product teams" />
        </div>
        <div class="mt-10 grid gap-8 md:grid-cols-2" data-reveal-stagger>
            <div class="card-premium p-6">
                <div class="flex items-center gap-3">
                    <x-icon-box icon="server" variant="soft" />
                    <h3 class="font-semibold text-navy">Deployment approach</h3>
                </div>
                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                    @foreach(['CI/CD aligned to your branching strategy', 'Staging environments before production releases', 'Docker and cloud deploy experience (AWS, VPS)', 'Rollback plans and post-release monitoring'] as $item)
                        <li class="flex gap-2"><x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" />{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="card-premium p-6">
                <div class="flex items-center gap-3">
                    <x-icon-box icon="chat" variant="soft" />
                    <h3 class="font-semibold text-navy">Communication rhythm</h3>
                </div>
                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                    @foreach(['Slack, Teams, or email—your preference', 'Weekly written status with risks and blockers', 'Shared documentation in Notion or Confluence', 'Account manager for escalation and billing'] as $item)
                        <li class="flex gap-2"><x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" />{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="mt-10 flex flex-wrap gap-2 reveal-on-scroll">
            @foreach(['Fintech', 'Healthcare', 'Logistics', 'SaaS', 'Retail', 'Manufacturing'] as $ind)
                <span class="badge-metric">{{ $ind }}</span>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow max-w-3xl reveal-on-scroll">
        <h2 class="heading-section">Why teams hire {{ $tech['name'] }} developers through us</h2>
        <p class="mt-4 leading-relaxed text-slate-600">{{ $tech['longform'] ?? 'Every engineer in our pool has contributed to production codebases—not tutorial projects. We share profiles within 48 hours, you interview finalists directly, and onboarding happens within days under NDA.' }}</p>
        <h3 class="mt-10 text-xl font-semibold text-navy">Related technologies</h3>
        <div class="mt-4 flex flex-wrap gap-3">
            @foreach(['Laravel' => '/hire-laravel-developers', 'React' => '/hire-react-developers', 'Node.js' => '/hire-nodejs-developers', 'Flutter' => '/hire-flutter-developers'] as $name => $href)
                <a href="{{ $href }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-navy shadow-soft transition-colors hover:border-brand-200 hover:bg-brand-50">
                    <x-tech-icon :tech="$name" box="h-7 w-7 rounded-md" class="h-3.5 w-3.5" />
                    {{ $name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<x-cta-banner :title="'Start your ' . $tech['name'] . ' team this week'" />
