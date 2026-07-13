@props(['blocks' => []])

{{--
    Renders typed content blocks into safe HTML. Text runs through
    App\Support\BlogContent::inline() (escape-first + tiny whitelist); code and
    commands are output via {{ }} (auto-escaped). No raw author HTML is ever
    executed. Copy buttons use inline Alpine — no extra JS bundle needed.
--}}
@use('App\Support\BlogContent')

@php
    // Precompute stable heading anchors, reused by the heading render and the
    // auto-generated table of contents. Keyed by the block's position.
    $anchors = [];
    $tocHeadings = [];
    foreach (($blocks ?? []) as $idx => $b) {
        if (($b['type'] ?? '') !== 'heading') {
            continue;
        }
        $level = (int) ($b['level'] ?? 2) === 3 ? 3 : 2;
        $anchor = (\Illuminate\Support\Str::slug($b['text'] ?? '') ?: 'section').'-'.$idx;
        $anchors[$idx] = $anchor;
        $tocHeadings[] = ['level' => $level, 'text' => $b['text'] ?? '', 'anchor' => $anchor];
    }
    $hasToc = count($tocHeadings) >= 2;
@endphp

<div class="blog-content">
    @foreach(($blocks ?? []) as $block)
        @switch($block['type'] ?? '')
            @case('paragraph')
                <div class="blog-prose">{!! BlogContent::render($block['text'] ?? '') !!}</div>
                @break

            @case('heading')
                @php $level = (int) ($block['level'] ?? 2); $hid = $anchors[$loop->index] ?? null; @endphp
                @if($level === 3)
                    <h3 @if($hid) id="{{ $hid }}" @endif class="mt-8 scroll-mt-24 font-display text-xl font-semibold text-navy">{{ $block['text'] ?? '' }}</h3>
                @else
                    <h2 @if($hid) id="{{ $hid }}" @endif class="mt-10 scroll-mt-24 font-display text-2xl font-semibold text-navy">{{ $block['text'] ?? '' }}</h2>
                @endif
                @break

            @case('list')
                @php $ordered = ($block['style'] ?? 'bulleted') === 'numbered'; @endphp
                <{{ $ordered ? 'ol' : 'ul' }} class="mt-5 space-y-2 pl-6 text-slate-600 {{ $ordered ? 'list-decimal' : 'list-disc' }}">
                    @foreach(($block['items'] ?? []) as $item)
                        <li class="leading-relaxed">{!! BlogContent::inline($item) !!}</li>
                    @endforeach
                </{{ $ordered ? 'ol' : 'ul' }}>
                @break

            @case('quote')
                <blockquote class="mt-6 border-l-4 border-brand-600 pl-4 italic text-slate-700">{!! BlogContent::inline($block['text'] ?? '') !!}</blockquote>
                @break

            @case('image')
                @php
                    $src = $block['url'] ?? (isset($block['path']) ? \Illuminate\Support\Facades\Storage::disk('public')->url($block['path']) : null);
                @endphp
                @if($src)
                    <figure class="mt-8">
                        <img src="{{ $src }}" alt="{{ $block['alt'] ?? '' }}" @isset($block['title']) title="{{ $block['title'] }}" @endisset loading="lazy" class="w-full rounded-xl border border-slate-200/80 object-cover">
                        @if(!empty($block['caption']))
                            <figcaption class="mt-2 text-center text-sm text-slate-500">{{ $block['caption'] }}</figcaption>
                        @endif
                    </figure>
                @endif
                @break

            @case('code')
                <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-slate-900" x-data="{ copied: false }">
                    <div class="flex items-center justify-between border-b border-slate-700 px-4 py-2">
                        <span class="text-xs font-medium uppercase tracking-wider text-slate-400">{{ $block['language'] ?? 'code' }}</span>
                        <button type="button" class="text-xs font-medium text-slate-300 transition-colors hover:text-white"
                                @click="navigator.clipboard?.writeText($refs.src.textContent); copied = true; setTimeout(() => copied = false, 1500)">
                            <span x-text="copied ? 'Copied' : 'Copy'"></span>
                        </button>
                    </div>
                    <pre class="overflow-x-auto p-4 text-sm leading-relaxed text-slate-100"><code x-ref="src">{{ $block['code'] ?? '' }}</code></pre>
                </div>
                @break

            @case('command')
                <div class="mt-6 overflow-hidden rounded-xl border border-slate-800 bg-slate-950" x-data="{ copied: false }">
                    <div class="flex items-center justify-between border-b border-slate-800 px-4 py-2">
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-400">
                            <x-icon name="terminal" class="h-3.5 w-3.5" /> terminal
                        </span>
                        <button type="button" class="text-xs font-medium text-slate-300 transition-colors hover:text-white"
                                @click="navigator.clipboard?.writeText($refs.src.textContent); copied = true; setTimeout(() => copied = false, 1500)">
                            <span x-text="copied ? 'Copied' : 'Copy'"></span>
                        </button>
                    </div>
                    <pre class="overflow-x-auto p-4 text-sm leading-relaxed text-emerald-300"><code x-ref="src">{{ $block['code'] ?? '' }}</code></pre>
                </div>
                @break

            @case('toc')
                @if($hasToc)
                    <nav class="mt-8 rounded-xl border border-slate-200 bg-slate-50/70 p-5" aria-label="Table of contents">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">On this page</p>
                        <ul class="mt-3 space-y-1.5 text-sm">
                            @foreach($tocHeadings as $h)
                                <li class="{{ $h['level'] === 3 ? 'pl-4' : '' }}">
                                    <a href="#{{ $h['anchor'] }}" class="hover:text-brand-700 {{ $h['level'] === 2 ? 'font-medium text-navy' : 'text-slate-600' }}">{{ $h['text'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endif
                @break

            @case('table')
                @php
                    $align = $block['align'] ?? 'left';
                    $align = in_array($align, ['left', 'center', 'right'], true) ? $align : 'left';
                    $rows = $block['rows'] ?? [];
                    $header = ! empty($block['header']);
                @endphp
                @if(! empty($rows))
                    <div class="mt-6 overflow-x-auto">
                        <table class="w-full border-collapse text-sm text-slate-600 text-{{ $align }}">
                            @if($header && isset($rows[0]))
                                <thead>
                                    <tr class="border-b border-slate-300 bg-slate-50">
                                        @foreach((array) ($rows[0] ?? []) as $cell)
                                            <th class="px-4 py-2.5 font-semibold text-navy text-{{ $align }}">{!! BlogContent::inline((string) $cell) !!}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                                @foreach($rows as $r => $row)
                                    @continue($header && $r === 0)
                                    <tr class="border-b border-slate-200">
                                        @foreach((array) $row as $cell)
                                            <td class="px-4 py-2.5 align-top">{!! BlogContent::inline((string) $cell) !!}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @break

            @case('faq')
                @php
                    $faqItems = collect($block['items'] ?? [])
                        ->filter(fn ($it) => filled($it['q'] ?? null) && filled($it['a'] ?? null))
                        ->values();
                @endphp
                @if($faqItems->isNotEmpty())
                    <div class="mt-8 space-y-3">
                        @foreach($faqItems as $item)
                            <details class="group rounded-xl border border-slate-200 bg-white [&_summary::-webkit-details-marker]:hidden">
                                <summary class="flex cursor-pointer items-center justify-between gap-4 px-5 py-4 font-medium text-navy">
                                    <span>{{ $item['q'] ?? '' }}</span>
                                    <x-icon name="chevron-down" class="h-4 w-4 shrink-0 text-slate-400 transition-transform group-open:rotate-180" />
                                </summary>
                                <div class="px-5 pb-4 leading-relaxed text-slate-600">{!! BlogContent::inline($item['a'] ?? '') !!}</div>
                            </details>
                        @endforeach
                    </div>
                    <script type="application/ld+json">
                        {!! json_encode([
                            '@context' => 'https://schema.org',
                            '@type' => 'FAQPage',
                            'mainEntity' => $faqItems->map(fn ($it) => [
                                '@type' => 'Question',
                                'name' => $it['q'] ?? '',
                                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $it['a'] ?? ''],
                            ])->all(),
                        ], JSON_UNESCAPED_UNICODE) !!}
                    </script>
                @endif
                @break

            @case('divider')
                <hr class="my-10 border-t border-slate-200">
                @break

            @case('callout')
                @php
                    $variant = $block['variant'] ?? 'info';
                    $variant = in_array($variant, ['info', 'tip', 'warning', 'success'], true) ? $variant : 'info';
                    $style = [
                        'info' => ['box' => 'border-brand-200 bg-brand-50', 'icon' => 'text-brand-600', 'title' => 'text-brand-900', 'name' => 'info'],
                        'tip' => ['box' => 'border-amber-200 bg-amber-50', 'icon' => 'text-amber-600', 'title' => 'text-amber-900', 'name' => 'lightbulb'],
                        'warning' => ['box' => 'border-red-200 bg-red-50', 'icon' => 'text-red-600', 'title' => 'text-red-900', 'name' => 'triangle-alert'],
                        'success' => ['box' => 'border-emerald-200 bg-emerald-50', 'icon' => 'text-emerald-600', 'title' => 'text-emerald-900', 'name' => 'circle-check'],
                    ][$variant];
                @endphp
                @if(filled($block['title'] ?? null) || filled($block['text'] ?? null))
                    <div class="mt-6 flex gap-3 rounded-xl border {{ $style['box'] }} p-4">
                        <x-icon :name="$style['name']" class="mt-0.5 h-5 w-5 shrink-0 {{ $style['icon'] }}" />
                        <div>
                            @if(filled($block['title'] ?? null))
                                <p class="font-semibold {{ $style['title'] }}">{{ $block['title'] ?? '' }}</p>
                            @endif
                            @if(filled($block['text'] ?? null))
                                <div class="mt-1 leading-relaxed text-slate-700">{!! BlogContent::inline($block['text'] ?? '') !!}</div>
                            @endif
                        </div>
                    </div>
                @endif
                @break

            @case('cta')
                @php $ctaUrl = $block['url'] ?? ''; $newTab = ! empty($block['newTab']); @endphp
                @if(filled($ctaUrl) && filled($block['buttonText'] ?? null))
                    <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center sm:p-8">
                        @if(filled($block['title'] ?? null))
                            <h3 class="font-display text-xl font-semibold text-navy">{{ $block['title'] ?? '' }}</h3>
                        @endif
                        @if(filled($block['text'] ?? null))
                            <p class="mx-auto mt-2 max-w-xl leading-relaxed text-slate-600">{{ $block['text'] ?? '' }}</p>
                        @endif
                        <div class="mt-5">
                            <x-button :href="$ctaUrl" variant="primary" size="lg" :target="$newTab ? '_blank' : false" :rel="$newTab ? 'noopener noreferrer' : false">{{ $block['buttonText'] ?? '' }}</x-button>
                        </div>
                    </div>
                @endif
                @break
        @endswitch
    @endforeach
</div>
