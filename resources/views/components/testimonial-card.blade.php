@props([
    'quote',
    'author',
    'role',
    'company',
    'initials' => 'JD',
])

<article {{ $attributes->merge(['class' => 'card-premium flex h-full flex-col p-6 sm:p-8']) }}>
    <div class="flex gap-1 text-amber-400" aria-hidden="true">
        @for($i = 0; $i < 5; $i++)
            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        @endfor
    </div>
    <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-slate-600 sm:text-base">"{{ $quote }}"</blockquote>
    <footer class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-6">
        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-100 text-sm font-semibold text-brand-800">{{ $initials }}</div>
        <div>
            <cite class="not-italic text-sm font-semibold text-navy-950">{{ $author }}</cite>
            <p class="text-xs text-slate-500">{{ $role }}, {{ $company }}</p>
        </div>
    </footer>
</article>
