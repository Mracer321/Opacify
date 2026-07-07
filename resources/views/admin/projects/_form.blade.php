@php
    $isEdit = $project->exists;
    $action = $isEdit ? route('admin.projects.update', $project) : route('admin.projects.store');

    // Seed repeatable rows from old() (validation failure) then the model, so
    // submitted values survive a failed validation and edits load existing data.
    $technologies = old('technologies', $project->technologies ?? []);
    $highlights = old('highlights', collect($project->highlights ?? [])->pluck('text')->filter()->values()->all());
    $keyResults = old('key_results', $project->key_results ?? []);

    if (empty($technologies)) {
        $technologies = [''];
    }
    if (empty($highlights)) {
        $highlights = [''];
    }
    // Key results are optional — start with no rows so nothing empty is forced.
    $keyResults = array_values($keyResults);

    $sectionClass = 'rounded-2xl border border-slate-200 bg-white p-6 shadow-soft';
    $headingClass = 'font-display text-lg font-semibold text-navy';
    $addBtnClass = 'inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50';
    $removeBtnClass = 'shrink-0 rounded-lg border border-slate-200 px-3 text-slate-400 hover:border-red-200 hover:bg-red-50 hover:text-red-600';
@endphp

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
                <input id="title" type="text" name="title" value="{{ old('title', $project->title) }}" required class="input-field @error('title') border-red-300 @enderror">
                @error('title')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="slug" class="label-field">Slug <span class="text-red-500">*</span></label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $project->slug) }}" required placeholder="logistics-erp-modernization" class="input-field @error('slug') border-red-300 @enderror">
                <p class="mt-1 text-xs text-slate-400">Lowercase letters, numbers, and hyphens. Public URL: /case-studies/&lt;slug&gt;</p>
                @error('slug')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="project_label" class="label-field">Project / Client Label <span class="text-red-500">*</span></label>
                <input id="project_label" type="text" name="project_label" value="{{ old('project_label', $project->project_label) }}" required class="input-field @error('project_label') border-red-300 @enderror">
                @error('project_label')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="industry" class="label-field">Industry <span class="text-red-500">*</span></label>
                <input id="industry" type="text" name="industry" value="{{ old('industry', $project->industry) }}" required class="input-field @error('industry') border-red-300 @enderror">
                @error('industry')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="duration" class="label-field">Duration <span class="text-red-500">*</span></label>
                <input id="duration" type="text" name="duration" value="{{ old('duration', $project->duration) }}" required placeholder="6 months" class="input-field @error('duration') border-red-300 @enderror">
                @error('duration')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="short_summary" class="label-field">Short Summary <span class="text-red-500">*</span></label>
                <textarea id="short_summary" name="short_summary" rows="2" required class="input-field resize-y @error('short_summary') border-red-300 @enderror">{{ old('short_summary', $project->short_summary) }}</textarea>
                @error('short_summary')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    {{-- TECHNOLOGIES --}}
    <section class="{{ $sectionClass }}" x-data="{ items: @js(array_values($technologies)) }">
        <div class="flex items-center justify-between">
            <h2 class="{{ $headingClass }}">Technologies <span class="text-red-500">*</span></h2>
            <button type="button" class="{{ $addBtnClass }}" @click="items.push('')"><x-icon name="plus" class="h-4 w-4" /> Add</button>
        </div>
        @error('technologies')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
        <div class="mt-4 space-y-2">
            <template x-for="(item, i) in items" :key="i">
                <div class="flex items-center gap-2">
                    <input type="text" :name="`technologies[${i}]`" x-model="items[i]" placeholder="Laravel" class="input-field flex-1">
                    <button type="button" class="{{ $removeBtnClass }}" @click="items.splice(i, 1)" x-show="items.length > 1" aria-label="Remove technology">&times;</button>
                </div>
            </template>
        </div>
    </section>

    {{-- HOMEPAGE / LISTING HIGHLIGHTS --}}
    <section class="{{ $sectionClass }}" x-data="{ items: @js(array_values($highlights)) }">
        <div class="flex items-center justify-between">
            <h2 class="{{ $headingClass }}">Highlights</h2>
            <button type="button" class="{{ $addBtnClass }}" @click="items.push('')"><x-icon name="plus" class="h-4 w-4" /> Add</button>
        </div>
        <p class="mt-1 text-xs text-slate-400">Result pills shown on the listing and homepage cards.</p>
        @error('highlights')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
        <div class="mt-4 space-y-2">
            <template x-for="(item, i) in items" :key="i">
                <div class="flex items-center gap-2">
                    <input type="text" :name="`highlights[${i}]`" x-model="items[i]" placeholder="40% faster fulfillment" class="input-field flex-1">
                    <button type="button" class="{{ $removeBtnClass }}" @click="items.splice(i, 1)" x-show="items.length > 1" aria-label="Remove highlight">&times;</button>
                </div>
            </template>
        </div>
    </section>

    {{-- CASE STUDY CONTENT --}}
    <section class="{{ $sectionClass }}">
        <h2 class="{{ $headingClass }}">Case study content</h2>
        <div class="mt-4 space-y-4">
            <div>
                <label for="challenge" class="label-field">Challenge <span class="text-red-500">*</span></label>
                <textarea id="challenge" name="challenge" rows="4" required class="input-field resize-y @error('challenge') border-red-300 @enderror">{{ old('challenge', $project->challenge) }}</textarea>
                @error('challenge')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="solution" class="label-field">Solution <span class="text-red-500">*</span></label>
                <textarea id="solution" name="solution" rows="4" required class="input-field resize-y @error('solution') border-red-300 @enderror">{{ old('solution', $project->solution) }}</textarea>
                @error('solution')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="team_summary" class="label-field">Team Summary <span class="text-red-500">*</span></label>
                <input id="team_summary" type="text" name="team_summary" value="{{ old('team_summary', $project->team_summary) }}" required placeholder="2 Laravel developers, 1 Vue developer, 1 QA" class="input-field @error('team_summary') border-red-300 @enderror">
                @error('team_summary')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </section>

    {{-- KEY RESULTS --}}
    <section class="{{ $sectionClass }}" x-data="{ items: @js(array_values($keyResults)) }">
        <div class="flex items-center justify-between">
            <h2 class="{{ $headingClass }}">Key results <span class="text-sm font-normal text-slate-400">(optional)</span></h2>
            <button type="button" class="{{ $addBtnClass }}" @click="items.push({ value: '', label: '' })"><x-icon name="plus" class="h-4 w-4" /> Add</button>
        </div>
        <p class="mt-1 text-xs text-slate-400">Value + label pairs shown on the case-study detail. Leave empty to hide the block.</p>
        @error('key_results')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
        <div class="mt-4 space-y-2">
            <template x-for="(item, i) in items" :key="i">
                <div class="flex items-center gap-2">
                    <input type="text" :name="`key_results[${i}][value]`" x-model="items[i].value" placeholder="40%" class="input-field w-28">
                    <input type="text" :name="`key_results[${i}][label]`" x-model="items[i].label" placeholder="Reduction in order fulfillment time" class="input-field flex-1">
                    <button type="button" class="{{ $removeBtnClass }}" @click="items.splice(i, 1)" aria-label="Remove result">&times;</button>
                </div>
            </template>
            <p class="text-xs text-slate-400" x-show="items.length === 0">No key results added.</p>
        </div>
    </section>

    {{-- TESTIMONIAL --}}
    <section class="{{ $sectionClass }}">
        <h2 class="{{ $headingClass }}">Testimonial <span class="text-sm font-normal text-slate-400">(optional)</span></h2>
        <div class="mt-4 space-y-4">
            <div>
                <label for="testimonial_quote" class="label-field">Quote</label>
                <textarea id="testimonial_quote" name="testimonial_quote" rows="3" class="input-field resize-y @error('testimonial_quote') border-red-300 @enderror">{{ old('testimonial_quote', $project->testimonial_quote) }}</textarea>
                @error('testimonial_quote')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="testimonial_name" class="label-field">Person Name</label>
                    <input id="testimonial_name" type="text" name="testimonial_name" value="{{ old('testimonial_name', $project->testimonial_name) }}" class="input-field @error('testimonial_name') border-red-300 @enderror">
                    @error('testimonial_name')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="testimonial_role" class="label-field">Role / Company</label>
                    <input id="testimonial_role" type="text" name="testimonial_role" value="{{ old('testimonial_role', $project->testimonial_role) }}" placeholder="COO, LogiStack" class="input-field @error('testimonial_role') border-red-300 @enderror">
                    @error('testimonial_role')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <p class="text-xs text-slate-400">The testimonial only appears publicly when both a quote and a name are present.</p>
        </div>
    </section>

    {{-- MEDIA --}}
    <section class="{{ $sectionClass }}">
        <h2 class="{{ $headingClass }}">Media</h2>
        <p class="mt-1 text-xs text-slate-400">JPG, PNG, or WebP up to 4&nbsp;MB. Leaving a field empty keeps the current image.</p>
        <div class="mt-4 grid gap-6 sm:grid-cols-3">
            @foreach([
                ['primary_image', 'Primary Project Image'],
                ['secondary_image', 'Secondary Project Image'],
                ['og_image', 'OG Image'],
            ] as [$field, $label])
                <div>
                    <label for="{{ $field }}" class="label-field">{{ $label }}</label>
                    @if($project->{$field})
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($project->{$field}) }}" alt="Current {{ $label }}" class="mb-2 h-24 w-full rounded-lg border border-slate-200 object-cover">
                    @endif
                    <input id="{{ $field }}" type="file" name="{{ $field }}" accept="image/png,image/jpeg,image/webp" class="block w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                    @error($field)<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
            @endforeach
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
                        @foreach(['draft' => 'Draft', 'published' => 'Published'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $project->status ?? 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-center gap-3">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured)) class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    <span class="text-sm font-medium text-slate-700">Feature on homepage <span class="text-slate-400">(only one project can be featured)</span></span>
                </label>
                <div>
                    <label for="sort_order" class="label-field">Sort Order</label>
                    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0" class="input-field w-32 @error('sort_order') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-slate-400">Lower numbers appear first on the listing.</p>
                    @error('sort_order')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="{{ $sectionClass }}">
            <h2 class="{{ $headingClass }}">SEO</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <label for="seo_title" class="label-field">SEO Title</label>
                    <input id="seo_title" type="text" name="seo_title" value="{{ old('seo_title', $project->seo_title) }}" class="input-field @error('seo_title') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-slate-400">Falls back to the project title when empty.</p>
                    @error('seo_title')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="meta_description" class="label-field">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="input-field resize-y @error('meta_description') border-red-300 @enderror">{{ old('meta_description', $project->meta_description) }}</textarea>
                    <p class="mt-1 text-xs text-slate-400">Falls back to the short summary when empty.</p>
                    @error('meta_description')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.projects.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancel</a>
        <button type="submit" class="rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">
            {{ $isEdit ? 'Save changes' : 'Create project' }}
        </button>
    </div>
</form>
