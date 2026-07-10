@php
    $isEdit = $post->exists;
    $action = $isEdit ? route('admin.blog.update', $post) : route('admin.blog.store');

    $tags = old('tags', $post->tags ?? []);
    $tagsValue = is_array($tags) ? implode(', ', $tags) : $tags;

    $blocks = old('content_blocks', $post->content_blocks ?? []);

    $sectionClass = 'rounded-2xl border border-slate-200 bg-white p-6 shadow-soft';
    $headingClass = 'font-display text-lg font-semibold text-navy';
    $addBtnClass = 'inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50';
    $removeBtnClass = 'shrink-0 rounded-lg border border-slate-200 px-3 text-slate-400 hover:border-red-200 hover:bg-red-50 hover:text-red-600';
@endphp

@if(session('quality_warnings') && count(session('quality_warnings')))
    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
        <p class="font-semibold">Saved with suggestions:</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach(session('quality_warnings') as $warning)
                <li>{{ $warning }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($errors->any())
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">Please fix the following:</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    {{-- BASIC INFORMATION --}}
    <section class="{{ $sectionClass }}">
        <h2 class="{{ $headingClass }}">Basic information</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
                <label for="title" class="label-field">Title <span class="text-red-500">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" required class="input-field @error('title') border-red-300 @enderror">
                @error('title')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="slug" class="label-field">Slug <span class="text-red-500">*</span></label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $post->slug) }}" required placeholder="how-to-hire-laravel-developers" class="input-field @error('slug') border-red-300 @enderror">
                <p class="mt-1 text-xs text-slate-400">Lowercase letters, numbers, and hyphens. Public URL: /blog/&lt;slug&gt;</p>
                @error('slug')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="category" class="label-field">Category</label>
                <input id="category" type="text" name="category" value="{{ old('category', $post->category) }}" placeholder="Hiring" class="input-field @error('category') border-red-300 @enderror">
                @error('category')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="tags" class="label-field">Tags</label>
                <input id="tags" type="text" name="tags" value="{{ $tagsValue }}" placeholder="laravel, hiring" class="input-field @error('tags') border-red-300 @enderror">
                <p class="mt-1 text-xs text-slate-400">Comma-separated. Used for search and related posts.</p>
            </div>
            <div>
                <label for="author" class="label-field">Author <span class="text-red-500">*</span></label>
                <input id="author" type="text" name="author" value="{{ old('author', $post->author ?? 'Neha Kapoor') }}" required class="input-field @error('author') border-red-300 @enderror">
                @error('author')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="author_role" class="label-field">Author role</label>
                <input id="author_role" type="text" name="author_role" value="{{ old('author_role', $post->author_role ?? 'Head of Delivery') }}" placeholder="Head of Delivery" class="input-field">
            </div>
            <div>
                <label for="read_minutes" class="label-field">Read time (minutes)</label>
                <input id="read_minutes" type="number" name="read_minutes" value="{{ old('read_minutes', $post->read_minutes) }}" min="1" max="120" class="input-field w-32">
                <p class="mt-1 text-xs text-slate-400">Leave blank to estimate from content.</p>
            </div>
            <div class="sm:col-span-2">
                <label for="excerpt" class="label-field">Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="2" class="input-field resize-y @error('excerpt') border-red-300 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                <p class="mt-1 text-xs text-slate-400">Shown on listing cards and used as the meta description fallback.</p>
                @error('excerpt')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    {{-- CONTENT BLOCKS --}}
    @include('admin.blog._blocks', ['blocks' => $blocks])

    {{-- FEATURED IMAGE --}}
    <section class="{{ $sectionClass }}">
        <h2 class="{{ $headingClass }}">Featured image</h2>
        <p class="mt-1 text-xs text-slate-400">JPG, PNG, or WebP up to 8&nbsp;MB. Oversized images are downscaled and optimized automatically. Leaving this empty keeps the current image.</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2">
            <div>
                @if($post->featuredImageUrl())
                    <img src="{{ $post->featuredImageUrl() }}" alt="Current featured image" class="mb-2 h-32 w-full rounded-lg border border-slate-200 object-cover">
                @endif
                <input id="featured_image" type="file" name="featured_image" accept="image/png,image/jpeg,image/webp" class="block w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                @error('featured_image')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="featured_image_alt" class="label-field">Featured image alt text</label>
                <input id="featured_image_alt" type="text" name="featured_image_alt" value="{{ old('featured_image_alt', $post->featured_image_alt) }}" class="input-field">
                <p class="mt-1 text-xs text-slate-400">Falls back to the post title when empty.</p>
            </div>
        </div>
    </section>

    {{-- PUBLISHING + SEO --}}
    <div class="grid gap-6 lg:grid-cols-2">
        <section class="{{ $sectionClass }}">
            <h2 class="{{ $headingClass }}">Publishing</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="status" class="label-field">Status <span class="text-red-500">*</span></label>
                    <select id="status" name="status" required class="input-field @error('status') border-red-300 @enderror">
                        @foreach(['draft' => 'Draft', 'scheduled' => 'Scheduled', 'published' => 'Published'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $post->status ?? 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Drafts and future-dated scheduled posts are never public. Scheduled posts go live automatically at the publish time.</p>
                    @error('status')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="published_at" class="label-field">Publish date &amp; time</label>
                    <input id="published_at" type="datetime-local" name="published_at"
                           value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}"
                           class="input-field @error('published_at') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-slate-400">Set a future time with status “Scheduled” to auto-publish later.</p>
                    @error('published_at')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="{{ $sectionClass }}">
            <h2 class="{{ $headingClass }}">SEO</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="seo_title" class="label-field">SEO title</label>
                    <input id="seo_title" type="text" name="seo_title" value="{{ old('seo_title', $post->seo_title) }}" class="input-field @error('seo_title') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-slate-400">Falls back to the post title. ~60 characters recommended.</p>
                    @error('seo_title')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="meta_description" class="label-field">Meta description</label>
                    <textarea id="meta_description" name="meta_description" rows="2" class="input-field resize-y @error('meta_description') border-red-300 @enderror">{{ old('meta_description', $post->meta_description) }}</textarea>
                    <p class="mt-1 text-xs text-slate-400">Falls back to the excerpt. ~160 characters recommended.</p>
                    @error('meta_description')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="canonical_url" class="label-field">Canonical URL override</label>
                    <input id="canonical_url" type="url" name="canonical_url" value="{{ old('canonical_url', $post->canonical_url) }}" placeholder="https://opacify.in/blog/{{ $post->slug ?? 'slug' }}" class="input-field @error('canonical_url') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-slate-400">Leave empty to self-canonicalize to the post URL.</p>
                    @error('canonical_url')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="og_title" class="label-field">Open Graph title</label>
                        <input id="og_title" type="text" name="og_title" value="{{ old('og_title', $post->og_title) }}" class="input-field">
                        <p class="mt-1 text-xs text-slate-400">Falls back to the SEO title.</p>
                    </div>
                    <div>
                        <label for="og_description" class="label-field">Open Graph description</label>
                        <input id="og_description" type="text" name="og_description" value="{{ old('og_description', $post->og_description) }}" class="input-field">
                        <p class="mt-1 text-xs text-slate-400">Falls back to the meta description.</p>
                    </div>
                </div>
                <div>
                    <label for="og_image" class="label-field">Open Graph image</label>
                    @if($post->og_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->og_image) }}" alt="Current OG image" class="mb-2 h-24 w-full rounded-lg border border-slate-200 object-cover">
                    @endif
                    <input id="og_image" type="file" name="og_image" accept="image/png,image/jpeg,image/webp" class="block w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                    <p class="mt-1 text-xs text-slate-400">Falls back to the featured image, then the site default OG image.</p>
                    @error('og_image')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-3">
                        <input type="hidden" name="robots_noindex" value="0">
                        <input type="checkbox" name="robots_noindex" value="1" @checked(old('robots_noindex', $post->robots_noindex)) class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span class="text-sm font-medium text-slate-700">noindex</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="hidden" name="robots_nofollow" value="0">
                        <input type="checkbox" name="robots_nofollow" value="1" @checked(old('robots_nofollow', $post->robots_nofollow)) class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span class="text-sm font-medium text-slate-700">nofollow</span>
                    </label>
                </div>
            </div>
        </section>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.blog.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancel</a>
        <button type="submit" class="rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">
            {{ $isEdit ? 'Save changes' : 'Create post' }}
        </button>
    </div>
</form>
