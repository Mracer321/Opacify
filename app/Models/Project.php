<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'title',
        'slug',
        'project_label',
        'short_summary',
        'industry',
        'duration',
        'technologies',
        'highlights',
        'challenge',
        'solution',
        'team_summary',
        'key_results',
        'testimonial_quote',
        'testimonial_name',
        'testimonial_role',
        'primary_image',
        'secondary_image',
        'status',
        'is_featured',
        'sort_order',
        'seo_title',
        'meta_description',
        'og_image',
    ];

    protected $casts = [
        'technologies' => 'array',
        'highlights' => 'array',
        'key_results' => 'array',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Only published projects are visible on the public site.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    /**
     * Whether a meaningful testimonial exists (quote + attribution name).
     */
    public function hasTestimonial(): bool
    {
        return filled($this->testimonial_quote) && filled($this->testimonial_name);
    }
}
