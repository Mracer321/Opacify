<div {{ $attributes->merge(['class' => 'relative hidden xl:block']) }} aria-hidden="true">
    <div class="absolute -right-8 top-8 h-64 w-64 rounded-full bg-brand-500/10 blur-3xl"></div>

    <div class="floating-ui-slow relative z-0 -mr-6 mt-4 w-[min(100%,420px)]">
        <x-ui-mockup variant="dashboard" subtitle="Sprint delivery overview" class="shadow-elevated ring-1 ring-white/10" />
    </div>

    <div class="floating-ui-delayed absolute -left-6 bottom-8 z-10 w-44 rounded-xl border border-white/15 bg-white/10 p-3 backdrop-blur-md shadow-elevated">
        <div class="flex items-center gap-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-brand-300">
                <x-icon name="chart" class="h-4 w-4" />
            </span>
            <div>
                <p class="text-[10px] uppercase tracking-wide text-slate-400">Deployments</p>
                <p class="text-sm font-semibold text-white">+24% QoQ</p>
            </div>
        </div>
    </div>

    <div class="floating-ui absolute -right-2 top-0 z-10 w-40 rounded-xl border border-white/15 bg-white/10 p-3 backdrop-blur-md shadow-elevated">
        <div class="flex items-center gap-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10 text-brand-300">
                <x-icon name="code" class="h-4 w-4" />
            </span>
            <div>
                <p class="text-[10px] uppercase tracking-wide text-slate-400">Code review</p>
                <p class="text-sm font-semibold text-white">12 PRs merged</p>
            </div>
        </div>
    </div>
</div>
