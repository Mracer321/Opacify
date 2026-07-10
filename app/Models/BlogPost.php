<?php

namespace App\Models;

use Database\Factories\BlogPostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    /** @use HasFactory<BlogPostFactory> */
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_SCHEDULED = 'scheduled';

    public const STATUS_PUBLISHED = 'published';

    /**
     * Default share image used when a post has no featured/OG image.
     */
    public const DEFAULT_OG_IMAGE = 'https://opacify.in/images/og-default.png';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'category',
        'tags',
        'author',
        'author_role',
        'read_minutes',
        'content_blocks',
        'featured_image',
        'featured_image_alt',
        'status',
        'published_at',
        'seo_title',
        'meta_description',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'robots_noindex',
        'robots_nofollow',
    ];

    protected $casts = [
        'tags' => 'array',
        'content_blocks' => 'array',
        'read_minutes' => 'integer',
        'published_at' => 'datetime',
        'robots_noindex' => 'boolean',
        'robots_nofollow' => 'boolean',
    ];

    /**
     * Publicly visible posts: not a draft, with a publish time that has arrived.
     * This is query/state-based so scheduled posts appear automatically once
     * published_at passes — no background job required.
     */
    public function scopePublishable(Builder $query): Builder
    {
        return $query
            ->where('status', '!=', self::STATUS_DRAFT)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPubliclyVisible(): bool
    {
        return $this->status !== self::STATUS_DRAFT
            && $this->published_at !== null
            && $this->published_at->lte(now());
    }

    public function isScheduled(): bool
    {
        return $this->status === self::STATUS_SCHEDULED
            && $this->published_at !== null
            && $this->published_at->isFuture();
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Estimated reading time in minutes: explicit override, else derived from
     * the text content at ~200 words/minute (minimum 1).
     */
    public function readMinutes(): int
    {
        if ($this->read_minutes) {
            return $this->read_minutes;
        }

        $words = 0;
        foreach ($this->content_blocks ?? [] as $block) {
            $text = match ($block['type'] ?? null) {
                'paragraph', 'heading', 'quote' => $block['text'] ?? '',
                'list' => implode(' ', $block['items'] ?? []),
                'code', 'command' => $block['code'] ?? '',
                default => '',
            };
            $words += str_word_count(strip_tags((string) $text));
        }

        return max(1, (int) ceil($words / 200));
    }

    public function readLabel(): string
    {
        return $this->readMinutes().' min read';
    }

    // --- Media -----------------------------------------------------------

    public function featuredImageUrl(): ?string
    {
        return $this->diskUrl($this->featured_image);
    }

    public function featuredImageAlt(): string
    {
        return $this->featured_image_alt ?: $this->title;
    }

    // --- SEO fallbacks (single source of truth for render + schema) -------

    public function effectiveSeoTitle(): string
    {
        return $this->seo_title ?: $this->title;
    }

    public function effectiveMetaDescription(): ?string
    {
        return $this->meta_description
            ?: $this->excerpt
            ?: Str::limit(strip_tags($this->title), 150);
    }

    public function effectiveCanonical(): string
    {
        return $this->canonical_url ?: url('/blog/'.$this->slug);
    }

    public function effectiveOgTitle(): string
    {
        return $this->og_title ?: $this->effectiveSeoTitle();
    }

    public function effectiveOgDescription(): ?string
    {
        return $this->og_description ?: $this->effectiveMetaDescription();
    }

    /**
     * Absolute OG image URL: explicit OG image, else featured image, else the
     * site default. Always absolute so social crawlers can fetch it.
     */
    public function effectiveOgImageUrl(): string
    {
        $path = $this->og_image ?: $this->featured_image;

        if ($path) {
            return url($this->diskUrl($path));
        }

        return self::DEFAULT_OG_IMAGE;
    }

    public function robotsContent(): string
    {
        return implode(', ', [
            $this->robots_noindex ? 'noindex' : 'index',
            $this->robots_nofollow ? 'nofollow' : 'follow',
        ]);
    }

    public function publishedAtIso(): ?string
    {
        return $this->published_at?->toIso8601String();
    }

    private function diskUrl(?string $path): ?string
    {
        if (! is_string($path) || $path === '') {
            return null;
        }

        // Already an absolute URL (e.g. legacy/imported) — return as-is.
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    protected static function newFactory(): BlogPostFactory
    {
        return BlogPostFactory::new();
    }
}
