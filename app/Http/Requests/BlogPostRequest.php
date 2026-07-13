<?php

namespace App\Http\Requests;

use App\Models\BlogPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogPostRequest extends FormRequest
{
    /**
     * Routes are already protected by the `auth` middleware group.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize content blocks + tags before validation. Empty rows are dropped
     * so nothing hollow is persisted.
     */
    protected function prepareForValidation(): void
    {
        $tags = collect(Arr::wrap($this->input('tags', [])))
            ->flatMap(fn ($t) => is_string($t) ? explode(',', $t) : [])
            ->map(fn ($t) => Str::of($t)->trim()->lower()->value())
            ->filter()
            ->unique()
            ->values()
            ->all();

        $blocks = collect(Arr::wrap($this->input('content_blocks', [])))
            ->map(fn ($block) => $this->normalizeBlock($block))
            ->filter()
            ->values()
            ->all();

        $this->merge([
            'tags' => $tags,
            'content_blocks' => $blocks,
            'robots_noindex' => $this->boolean('robots_noindex'),
            'robots_nofollow' => $this->boolean('robots_nofollow'),
        ]);
    }

    /**
     * @param  mixed  $block
     * @return array<string, mixed>|null
     */
    private function normalizeBlock($block): ?array
    {
        if (! is_array($block)) {
            return null;
        }

        $type = $block['type'] ?? null;

        return match ($type) {
            'paragraph', 'quote' => filled($block['text'] ?? null)
                ? ['type' => $type, 'text' => trim((string) $block['text'])]
                : null,
            'heading' => filled($block['text'] ?? null)
                ? ['type' => 'heading', 'level' => (int) ($block['level'] ?? 2) === 3 ? 3 : 2, 'text' => trim((string) $block['text'])]
                : null,
            'list' => ($items = $this->cleanList($block['items'] ?? [])) !== []
                ? ['type' => 'list', 'style' => ($block['style'] ?? 'bulleted') === 'numbered' ? 'numbered' : 'bulleted', 'items' => $items]
                : null,
            'code', 'command' => filled($block['code'] ?? null)
                ? array_filter([
                    'type' => $type,
                    'language' => $type === 'code' ? (trim((string) ($block['language'] ?? '')) ?: 'code') : null,
                    'code' => (string) $block['code'],
                ], fn ($v) => $v !== null)
                : null,
            'image' => filled($block['path'] ?? null) || filled($block['url'] ?? null)
                ? array_filter([
                    'type' => 'image',
                    'path' => $block['path'] ?? null,
                    'url' => $block['url'] ?? null,
                    'alt' => trim((string) ($block['alt'] ?? '')),
                    'title' => trim((string) ($block['title'] ?? '')),
                    'caption' => trim((string) ($block['caption'] ?? '')),
                ], fn ($v) => $v !== null && $v !== '')
                : null,
            'toc', 'divider' => ['type' => $type],
            'table' => ($rows = $this->cleanTable($block['rows'] ?? [])) !== []
                ? [
                    'type' => 'table',
                    'header' => (bool) ($block['header'] ?? false),
                    'align' => in_array($block['align'] ?? 'left', ['left', 'center', 'right'], true) ? $block['align'] : 'left',
                    'rows' => $rows,
                ]
                : null,
            'faq' => ($items = $this->cleanFaq($block['items'] ?? [])) !== []
                ? ['type' => 'faq', 'items' => $items]
                : null,
            'callout' => (filled($block['title'] ?? null) || filled($block['text'] ?? null))
                ? array_filter([
                    'type' => 'callout',
                    'variant' => in_array($block['variant'] ?? 'info', ['info', 'tip', 'warning', 'success'], true) ? $block['variant'] : 'info',
                    'title' => trim((string) ($block['title'] ?? '')),
                    'text' => trim((string) ($block['text'] ?? '')),
                ], fn ($v) => $v !== '')
                : null,
            'cta' => (filled($block['url'] ?? null) && filled($block['buttonText'] ?? null))
                ? [
                    'type' => 'cta',
                    'title' => trim((string) ($block['title'] ?? '')),
                    'text' => trim((string) ($block['text'] ?? '')),
                    'buttonText' => trim((string) ($block['buttonText'] ?? '')),
                    'url' => trim((string) ($block['url'] ?? '')),
                    'newTab' => (bool) ($block['newTab'] ?? false),
                ]
                : null,
            default => null,
        };
    }

    /**
     * Normalize a table's 2D cell grid to a re-indexed array of string rows.
     * Returns [] when every cell is empty so hollow tables are dropped.
     *
     * @param  mixed  $rows
     * @return array<int, array<int, string>>
     */
    private function cleanTable($rows): array
    {
        $rows = collect(Arr::wrap($rows))
            ->map(fn ($row) => collect(Arr::wrap($row))
                ->map(fn ($c) => is_string($c) ? trim($c) : '')
                ->values()
                ->all())
            ->filter(fn ($row) => count($row) > 0)
            ->values()
            ->all();

        $hasContent = collect($rows)->flatten()->contains(fn ($c) => $c !== '');

        return $hasContent ? $rows : [];
    }

    /**
     * Keep only FAQ items that have both a question and an answer.
     *
     * @param  mixed  $items
     * @return array<int, array{q: string, a: string}>
     */
    private function cleanFaq($items): array
    {
        return collect(Arr::wrap($items))
            ->map(fn ($it) => is_array($it)
                ? ['q' => trim((string) ($it['q'] ?? '')), 'a' => trim((string) ($it['a'] ?? ''))]
                : null)
            ->filter(fn ($it) => $it !== null && $it['q'] !== '' && $it['a'] !== '')
            ->values()
            ->all();
    }

    /**
     * @param  mixed  $items
     * @return array<int, string>
     */
    private function cleanList($items): array
    {
        return collect(Arr::wrap($items))
            ->map(fn ($i) => is_string($i) ? trim($i) : '')
            ->filter()
            ->values()
            ->all();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'required',
                'string',
                'max:200',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('blog_posts', 'slug')->ignore($this->route('blogPost')),
            ],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'category' => ['nullable', 'string', 'max:120'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:60'],

            'author' => ['required', 'string', 'max:120'],
            'author_role' => ['nullable', 'string', 'max:160'],
            'read_minutes' => ['nullable', 'integer', 'min:1', 'max:120'],

            'content_blocks' => ['nullable', 'array'],
            'content_blocks.*.type' => ['required', Rule::in(['paragraph', 'heading', 'list', 'quote', 'code', 'command', 'image', 'toc', 'table', 'faq', 'divider', 'callout', 'cta'])],

            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'featured_image_alt' => ['nullable', 'string', 'max:300'],

            'status' => ['required', Rule::in([
                BlogPost::STATUS_DRAFT,
                BlogPost::STATUS_SCHEDULED,
                BlogPost::STATUS_PUBLISHED,
            ])],
            'published_at' => ['nullable', 'date'],

            'seo_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'canonical_url' => ['nullable', 'url', 'max:300'],
            'og_title' => ['nullable', 'string', 'max:200'],
            'og_description' => ['nullable', 'string', 'max:300'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'robots_noindex' => ['boolean'],
            'robots_nofollow' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
        ];
    }

    /**
     * Restore the fully-normalized content blocks in the validated payload.
     *
     * Laravel's excludeUnvalidatedArrayKeys (on by default) strips every array
     * key that lacks an explicit rule. Blocks carry type-specific fields, so
     * only `content_blocks.*.type` is ruled and the parent array would be
     * reduced to bare `['type' => ...]` entries — silently discarding text,
     * rows, items, links and every other field. The blocks are already
     * sanitized and whitelisted per type in prepareForValidation(), so we hand
     * back that complete structure here.
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();
        $validated['content_blocks'] = $this->input('content_blocks', []);

        return data_get($validated, $key, $default);
    }

    /**
     * Non-blocking SEO/content quality warnings surfaced to the admin. These
     * guide without rejecting otherwise-valid content.
     *
     * @return array<int, string>
     */
    public function qualityWarnings(): array
    {
        $warnings = [];
        $data = $this->validated();

        if (blank($data['excerpt'] ?? null) && blank($data['meta_description'] ?? null)) {
            $warnings[] = 'No excerpt or meta description set — search snippets will fall back to the title.';
        }

        if (($this->hasFile('featured_image') || filled($this->route('blogPost')?->featured_image))
            && blank($data['featured_image_alt'] ?? null)) {
            $warnings[] = 'Featured image has no alt text — add one for accessibility and SEO.';
        }

        $seoTitle = $data['seo_title'] ?? $data['title'] ?? '';
        if (Str::length($seoTitle) > 60) {
            $warnings[] = 'SEO title is longer than 60 characters and may be truncated in search results.';
        }

        $metaDescription = $data['meta_description'] ?? $data['excerpt'] ?? '';
        if (Str::length($metaDescription) > 160) {
            $warnings[] = 'Meta description is longer than 160 characters and may be truncated in search results.';
        }

        if (empty($data['content_blocks'] ?? [])) {
            $warnings[] = 'This post has no content blocks yet.';
        }

        return $warnings;
    }
}
