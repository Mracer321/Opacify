<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 100000),
            'excerpt' => fake()->sentence(14),
            'category' => fake()->randomElement(['Hiring', 'Strategy', 'Frontend', 'Case insights']),
            'tags' => fake()->randomElements(['laravel', 'react', 'hiring', 'teams', 'devops'], 2),
            'author' => fake()->name(),
            'author_role' => 'Head of Delivery',
            'read_minutes' => fake()->numberBetween(4, 10),
            'content_blocks' => [
                ['type' => 'paragraph', 'text' => fake()->paragraph()],
                ['type' => 'heading', 'level' => 2, 'text' => rtrim(fake()->sentence(4), '.')],
                ['type' => 'paragraph', 'text' => fake()->paragraph()],
            ],
            'featured_image' => null,
            'featured_image_alt' => null,
            'status' => BlogPost::STATUS_DRAFT,
            'published_at' => null,
            'seo_title' => null,
            'meta_description' => null,
            'canonical_url' => null,
            'og_title' => null,
            'og_description' => null,
            'og_image' => null,
            'robots_noindex' => false,
            'robots_nofollow' => false,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => BlogPost::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => BlogPost::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }

    /**
     * Scheduled for the future — should NOT be publicly visible yet.
     */
    public function scheduled(): static
    {
        return $this->state(fn () => [
            'status' => BlogPost::STATUS_SCHEDULED,
            'published_at' => now()->addWeek(),
        ]);
    }
}
