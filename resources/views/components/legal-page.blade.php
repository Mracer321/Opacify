@props([
    'heading',
    'updated',
    'intro' => null,
])

<section class="gradient-hero section-padding pb-14">
    <div class="container-narrow reveal-on-scroll">
        <h1 class="max-w-3xl font-display text-4xl font-semibold tracking-tight text-white sm:text-5xl">{{ $heading }}</h1>
        @if($intro)
            <p class="mt-6 max-w-2xl text-lg text-slate-300">{{ $intro }}</p>
        @endif
        <p class="mt-6 text-sm text-slate-400">Last updated: {{ $updated }}</p>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-narrow max-w-3xl">
        <div class="legal-prose">
            {{ $slot }}
        </div>
    </div>
</section>
