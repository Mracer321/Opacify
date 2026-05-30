@props(['items' => [], 'id' => 'faq'])

<div class="divide-y divide-slate-200 rounded-2xl border border-slate-200/80 bg-white shadow-soft" x-data="{ active: null }" id="{{ $id }}">
    @foreach($items as $index => $item)
        <div class="px-5 sm:px-6">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 py-5 text-left transition-colors hover:bg-slate-50/50"
                @click="active = active === {{ $index }} ? null : {{ $index }}"
                :aria-expanded="active === {{ $index }}"
            >
                <span class="flex items-center gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                        <x-icon name="help" class="h-4 w-4" />
                    </span>
                    <span class="text-base font-semibold text-navy">{{ $item['question'] }}</span>
                </span>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition-all duration-200" :class="active === {{ $index }} ? 'rotate-45 bg-brand-50 text-brand-600' : ''">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </span>
            </button>
            <div x-show="active === {{ $index }}" x-transition class="pb-5 pl-11" x-cloak>
                <p class="text-sm leading-relaxed text-slate-600">{{ $item['answer'] }}</p>
            </div>
        </div>
    @endforeach
</div>
