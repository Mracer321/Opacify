@props(['blocks' => []])

{{--
    Renders typed content blocks into safe HTML. Text runs through
    App\Support\BlogContent::inline() (escape-first + tiny whitelist); code and
    commands are output via {{ }} (auto-escaped). No raw author HTML is ever
    executed. Copy buttons use inline Alpine — no extra JS bundle needed.
--}}
@use('App\Support\BlogContent')

<div class="blog-content">
    @foreach(($blocks ?? []) as $block)
        @switch($block['type'] ?? '')
            @case('paragraph')
                <p class="mt-5 leading-relaxed text-slate-600">{!! BlogContent::inline($block['text'] ?? '') !!}</p>
                @break

            @case('heading')
                @php $level = (int) ($block['level'] ?? 2); @endphp
                @if($level === 3)
                    <h3 class="mt-8 font-display text-xl font-semibold text-navy">{{ $block['text'] ?? '' }}</h3>
                @else
                    <h2 class="mt-10 font-display text-2xl font-semibold text-navy">{{ $block['text'] ?? '' }}</h2>
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
        @endswitch
    @endforeach
</div>
