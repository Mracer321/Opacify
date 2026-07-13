@php
    // Normalize existing blocks for the editor; ensure a predictable shape.
    $editorBlocks = collect($blocks ?? [])->map(function ($b) {
        return [
            'type' => $b['type'] ?? 'paragraph',
            'text' => $b['text'] ?? '',
            'level' => (int) ($b['level'] ?? 2),
            'style' => $b['style'] ?? 'bulleted',
            'items' => $b['items'] ?? [],
            'language' => $b['language'] ?? '',
            'code' => $b['code'] ?? '',
            'path' => $b['path'] ?? '',
            'url' => $b['url'] ?? '',
            'alt' => $b['alt'] ?? '',
            'title' => $b['title'] ?? '',
            'caption' => $b['caption'] ?? '',
            'variant' => $b['variant'] ?? 'info',
            'header' => $b['header'] ?? true,
            'align' => $b['align'] ?? 'left',
            'rows' => $b['rows'] ?? [],
            'buttonText' => $b['buttonText'] ?? '',
            'newTab' => $b['newTab'] ?? false,
        ];
    })->values()->all();
@endphp

<section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-soft"
         x-data="blogEditor({
            blocks: @js($editorBlocks),
            uploadUrl: '{{ route('admin.blog.image') }}',
            csrf: '{{ csrf_token() }}',
         })">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-display text-lg font-semibold text-navy">Content</h2>
            <p class="mt-1 text-xs text-slate-400">Build the article from content blocks. Text supports <code>**bold**</code> and <code>[label](url)</code> links only — no raw HTML.</p>
        </div>
    </div>

    @error('content_blocks')<p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>@enderror

    <div class="mt-5 space-y-4">
        <template x-for="(block, i) in blocks" :key="i">
            <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-4">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <span x-text="blockLabel(block.type)"></span>
                    </span>
                    <div class="flex items-center gap-1">
                        <button type="button" class="rounded px-2 py-1 text-slate-400 hover:bg-white hover:text-slate-600" @click="move(i, -1)" :disabled="i === 0" aria-label="Move up">&uarr;</button>
                        <button type="button" class="rounded px-2 py-1 text-slate-400 hover:bg-white hover:text-slate-600" @click="move(i, 1)" :disabled="i === blocks.length - 1" aria-label="Move down">&darr;</button>
                        <button type="button" class="rounded px-2 py-1 text-slate-400 hover:bg-red-50 hover:text-red-600" @click="remove(i)" aria-label="Remove block">&times;</button>
                    </div>
                </div>

                {{-- hidden type field --}}
                <input type="hidden" :name="`content_blocks[${i}][type]`" :value="block.type">

                {{-- paragraph / quote --}}
                <template x-if="block.type === 'paragraph' || block.type === 'quote'">
                    <textarea :name="`content_blocks[${i}][text]`" x-model="block.text" rows="3" class="input-field mt-3 resize-y" placeholder="Write text…"></textarea>
                </template>

                {{-- heading --}}
                <template x-if="block.type === 'heading'">
                    <div class="mt-3 flex gap-2">
                        <select :name="`content_blocks[${i}][level]`" x-model.number="block.level" class="input-field w-28">
                            <option value="2">H2</option>
                            <option value="3">H3</option>
                        </select>
                        <input type="text" :name="`content_blocks[${i}][text]`" x-model="block.text" class="input-field flex-1" placeholder="Heading text">
                    </div>
                </template>

                {{-- list --}}
                <template x-if="block.type === 'list'">
                    <div class="mt-3">
                        <select :name="`content_blocks[${i}][style]`" x-model="block.style" class="input-field w-40">
                            <option value="bulleted">Bulleted</option>
                            <option value="numbered">Numbered</option>
                        </select>
                        <div class="mt-2 space-y-2">
                            <template x-for="(item, j) in block.items" :key="j">
                                <div class="flex items-center gap-2">
                                    <input type="text" :name="`content_blocks[${i}][items][${j}]`" x-model="block.items[j]" class="input-field flex-1" placeholder="List item">
                                    <button type="button" class="shrink-0 rounded-lg border border-slate-200 px-3 text-slate-400 hover:border-red-200 hover:bg-red-50 hover:text-red-600" @click="block.items.splice(j, 1)">&times;</button>
                                </div>
                            </template>
                        </div>
                        <button type="button" class="mt-2 inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-white" @click="block.items.push('')">+ Add item</button>
                    </div>
                </template>

                {{-- code / command --}}
                <template x-if="block.type === 'code' || block.type === 'command'">
                    <div class="mt-3 space-y-2">
                        <template x-if="block.type === 'code'">
                            <input type="text" :name="`content_blocks[${i}][language]`" x-model="block.language" class="input-field w-48" placeholder="Language (e.g. php)">
                        </template>
                        <textarea :name="`content_blocks[${i}][code]`" x-model="block.code" rows="4" class="input-field resize-y font-mono text-sm" placeholder="Paste code or a command…"></textarea>
                    </div>
                </template>

                {{-- image --}}
                <template x-if="block.type === 'image'">
                    <div class="mt-3 space-y-3">
                        <input type="hidden" :name="`content_blocks[${i}][path]`" :value="block.path">
                        <template x-if="block.path || block.url">
                            <img :src="block.url || block.path" alt="" class="h-32 w-full rounded-lg border border-slate-200 object-cover">
                        </template>
                        <div class="flex items-center gap-3">
                            <input type="file" accept="image/png,image/jpeg,image/webp" @change="uploadImage($event, block)" class="block w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                            <span x-show="block._uploading" class="text-xs text-slate-400">Uploading…</span>
                        </div>
                        <p class="text-xs text-slate-400">Alt text, title, and caption are auto-filled from the post title if left blank. You can edit them.</p>
                        <div class="grid gap-2 sm:grid-cols-3">
                            <input type="text" :name="`content_blocks[${i}][alt]`" x-model="block.alt" class="input-field" placeholder="Alt text">
                            <input type="text" :name="`content_blocks[${i}][title]`" x-model="block.title" class="input-field" placeholder="Title">
                            <input type="text" :name="`content_blocks[${i}][caption]`" x-model="block.caption" class="input-field" placeholder="Caption (optional)">
                        </div>
                    </div>
                </template>

                {{-- table of contents (auto-generated from headings) --}}
                <template x-if="block.type === 'toc'">
                    <p class="mt-3 text-xs text-slate-500">A contents list is generated automatically from the H2 and H3 headings in this article. It is hidden when there are fewer than two headings.</p>
                </template>

                {{-- divider --}}
                <template x-if="block.type === 'divider'">
                    <p class="mt-3 text-xs text-slate-500">A horizontal divider will be shown here.</p>
                </template>

                {{-- table --}}
                <template x-if="block.type === 'table'">
                    <div class="mt-3 space-y-3">
                        <div class="flex flex-wrap items-center gap-4">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" :name="`content_blocks[${i}][header]`" x-model="block.header" value="1"> Header row
                            </label>
                            <select :name="`content_blocks[${i}][align]`" x-model="block.align" class="input-field w-40">
                                <option value="left">Align left</option>
                                <option value="center">Align center</option>
                                <option value="right">Align right</option>
                            </select>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="border-collapse">
                                <tbody>
                                    <template x-for="(row, r) in block.rows" :key="r">
                                        <tr>
                                            <template x-for="(cell, c) in row" :key="c">
                                                <td class="p-1 align-top">
                                                    <input type="text" :name="`content_blocks[${i}][rows][${r}][${c}]`" x-model="block.rows[r][c]" class="input-field min-w-[9rem]" :placeholder="block.header && r === 0 ? 'Header' : 'Cell'">
                                                </td>
                                            </template>
                                            <td class="p-1 align-middle">
                                                <button type="button" class="rounded-lg border border-slate-200 px-2 py-1 text-slate-400 hover:border-red-200 hover:bg-red-50 hover:text-red-600" @click="tableRemoveRow(block, r)" aria-label="Remove row">&times;</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-white" @click="tableAddRow(block)">+ Row</button>
                            <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-white" @click="tableAddCol(block)">+ Column</button>
                            <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-white" @click="tableRemoveCol(block, (block.rows[0] || []).length - 1)">&minus; Column</button>
                        </div>
                    </div>
                </template>

                {{-- faq --}}
                <template x-if="block.type === 'faq'">
                    <div class="mt-3 space-y-3">
                        <template x-for="(item, j) in block.items" :key="j">
                            <div class="rounded-lg border border-slate-200 bg-white p-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-medium text-slate-500">Q<span x-text="j + 1"></span></span>
                                    <div class="flex items-center gap-1">
                                        <button type="button" class="rounded px-2 py-1 text-slate-400 hover:bg-slate-50" @click="faqMove(block, j, -1)" :disabled="j === 0" aria-label="Move up">&uarr;</button>
                                        <button type="button" class="rounded px-2 py-1 text-slate-400 hover:bg-slate-50" @click="faqMove(block, j, 1)" :disabled="j === block.items.length - 1" aria-label="Move down">&darr;</button>
                                        <button type="button" class="rounded px-2 py-1 text-slate-400 hover:bg-red-50 hover:text-red-600" @click="faqRemove(block, j)" aria-label="Remove question">&times;</button>
                                    </div>
                                </div>
                                <input type="text" :name="`content_blocks[${i}][items][${j}][q]`" x-model="item.q" class="input-field mt-2" placeholder="Question">
                                <textarea :name="`content_blocks[${i}][items][${j}][a]`" x-model="item.a" rows="2" class="input-field mt-2 resize-y" placeholder="Answer"></textarea>
                            </div>
                        </template>
                        <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-white" @click="faqAdd(block)">+ Add question</button>
                    </div>
                </template>

                {{-- callout --}}
                <template x-if="block.type === 'callout'">
                    <div class="mt-3 space-y-2">
                        <select :name="`content_blocks[${i}][variant]`" x-model="block.variant" class="input-field w-40">
                            <option value="info">Info</option>
                            <option value="tip">Tip</option>
                            <option value="warning">Warning</option>
                            <option value="success">Success</option>
                        </select>
                        <input type="text" :name="`content_blocks[${i}][title]`" x-model="block.title" class="input-field" placeholder="Title (optional)">
                        <textarea :name="`content_blocks[${i}][text]`" x-model="block.text" rows="3" class="input-field resize-y" placeholder="Callout text…"></textarea>
                    </div>
                </template>

                {{-- cta button --}}
                <template x-if="block.type === 'cta'">
                    <div class="mt-3 space-y-2">
                        <input type="text" :name="`content_blocks[${i}][title]`" x-model="block.title" class="input-field" placeholder="Heading (optional)">
                        <textarea :name="`content_blocks[${i}][text]`" x-model="block.text" rows="2" class="input-field resize-y" placeholder="Description (optional)"></textarea>
                        <div class="grid gap-2 sm:grid-cols-2">
                            <input type="text" :name="`content_blocks[${i}][buttonText]`" x-model="block.buttonText" class="input-field" placeholder="Button text">
                            <input type="text" :name="`content_blocks[${i}][url]`" x-model="block.url" class="input-field" placeholder="Button URL (/contact or https://…)">
                        </div>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" :name="`content_blocks[${i}][newTab]`" x-model="block.newTab" value="1"> Open in new tab
                        </label>
                    </div>
                </template>
            </div>
        </template>

        <p class="text-xs text-slate-400" x-show="blocks.length === 0">No content yet. Add a block below.</p>
    </div>

    <div class="mt-5 flex flex-wrap gap-2 border-t border-slate-100 pt-4">
        <template x-for="opt in blockTypes" :key="opt.type">
            <button type="button" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50" @click="add(opt.type)">
                <span>+</span> <span x-text="opt.label"></span>
            </button>
        </template>
    </div>
</section>
