@props(['service'])

<section class="gradient-hero section-padding pb-12">
    <div class="container-narrow">
        <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
            <a href="/" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <a href="/services" class="hover:text-white">Services</a>
            <span class="mx-2">/</span>
            <span class="text-slate-300">{{ $service['title'] }}</span>
        </nav>
        <div class="mt-6 flex items-start gap-4">
            <x-service-icon :name="$service['icon']" size="h-7 w-7" box="h-12 w-12 rounded-xl" />
            <div class="max-w-3xl">
                <h1 class="font-display text-3xl font-semibold tracking-tight text-white sm:text-4xl text-balance">{{ $service['hero_title'] }}</h1>
                <p class="mt-4 text-lg leading-relaxed text-slate-300">{{ $service['hero_text'] }}</p>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <x-section-header align="left" eyebrow="Capabilities" title="What we deliver" />
        <div class="mt-10 grid gap-4 sm:grid-cols-2">
            @foreach($service['capabilities'] as $i => [$title, $desc])
            <article class="card-premium p-6 reveal-on-scroll">
                <x-icon-box icon="check" variant="soft" class="!h-9 !w-9" />
                <h3 class="mt-3 font-semibold text-navy">{{ $title }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $desc }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-start">
            <div>
                <x-section-header align="left" eyebrow="Process" title="How engagements run" />
                <ol class="mt-8 space-y-4">
                    @foreach($service['process'] as $i => [$title, $desc])
                    <li class="flex gap-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-500 text-xs font-bold text-white">{{ $i + 1 }}</span>
                        <div>
                            <h3 class="text-sm font-semibold text-navy">{{ $title }}</h3>
                            <p class="mt-1 text-sm text-slate-600">{{ $desc }}</p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>
            <x-project-preview :title="$service['title']" subtitle="Solution preview" :variant="$service['preview'] ?? 'dashboard'" />
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow">
        <x-section-header eyebrow="Technologies" title="Stacks we work with" />
        <div class="mt-8 flex flex-wrap justify-center gap-3" data-reveal-stagger>
            @foreach($service['technologies'] as $tech)
            <span class="badge-tech-icon">
                <x-tech-icon :tech="$tech" box="h-6 w-6 rounded-md" class="h-3.5 w-3.5" :boxed="true" />
                {{ $tech }}
            </span>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-slate-50">
    <div class="container-narrow">
        <x-section-header eyebrow="Engagement" title="Delivery models" />
        <div class="mt-10 grid gap-6 md:grid-cols-3" data-reveal-stagger>
            @foreach($service['delivery'] as $i => [$title, $desc])
            @php $deliveryIcons = ['clock', 'users', 'briefcase']; @endphp
            <article class="card-premium p-6 reveal-on-scroll">
                <x-icon-box :icon="$deliveryIcons[$i] ?? 'briefcase'" variant="soft" />
                <h3 class="mt-4 font-display text-base font-semibold text-navy">{{ $title }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $desc }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow max-w-3xl">
        <x-section-header eyebrow="FAQ" :title="$service['title'] . ' — common questions'" />
        <div class="mt-8">
            @php
            $faqItems = array_map(fn ($f) => ['question' => $f['question'], 'answer' => $f['answer']], $service['faqs']);
            @endphp
            <x-faq-accordion :items="$faqItems" :id="'faq-' . $service['slug']" />
        </div>
    </div>
</section>

<section id="consultation" class="section-padding border-t border-slate-100 bg-slate-50">
    <div class="container-narrow">
        <div class="grid items-start gap-10 lg:grid-cols-2 lg:gap-14">
            <div class="reveal-on-scroll">
                <p class="text-sm font-semibold uppercase tracking-wider text-brand-700">Consultation</p>
                <h2 class="mt-2 heading-section">Discuss your {{ $service['title'] }} project</h2>
                <p class="mt-4 leading-relaxed text-slate-600">Share requirements and we will respond within one business day with scope guidance and team options.</p>
                <ul class="mt-6 space-y-3 text-sm text-slate-600">
                    @foreach([['document', 'Structured scope review'], ['users', 'Matched senior engineers'], ['clock', 'Response within one business day']] as [$icon, $text])
                    <li class="flex items-center gap-3">
                        <x-icon-box :icon="$icon" variant="soft" class="!h-8 !w-8" />
                        {{ $text }}
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="form-card-premium rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-6">
                <x-lead-form :id="'service-detail-' . $service['slug']" :slim="true" submitLabel="Request consultation" />
            </div>
        </div>
    </div>
</section>