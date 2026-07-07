<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->unique()->catchPhrase();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 100000),
            'project_label' => fake()->company(),
            'short_summary' => fake()->sentence(12),
            'industry' => fake()->randomElement(['Supply Chain', 'Healthcare', 'Fintech', 'Retail']),
            'duration' => fake()->randomElement(['3 months', '6 months', '9 months']),
            'technologies' => ['Laravel', 'Vue.js', 'MySQL'],
            'highlights' => [
                ['text' => '40% faster fulfillment'],
                ['text' => '99.9% uptime'],
            ],
            'challenge' => fake()->paragraph(),
            'solution' => fake()->paragraph(),
            'team_summary' => '2 Laravel developers, 1 QA',
            'key_results' => [
                ['value' => '40%', 'label' => 'Reduction in order fulfillment time'],
                ['value' => '99.9%', 'label' => 'Platform uptime post-launch'],
            ],
            'testimonial_quote' => null,
            'testimonial_name' => null,
            'testimonial_role' => null,
            'primary_image' => null,
            'secondary_image' => null,
            'status' => Project::STATUS_DRAFT,
            'is_featured' => false,
            'sort_order' => 0,
            'seo_title' => null,
            'meta_description' => null,
            'og_image' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['status' => Project::STATUS_PUBLISHED]);
    }

    public function featured(): static
    {
        return $this->state(fn () => [
            'status' => Project::STATUS_PUBLISHED,
            'is_featured' => true,
        ]);
    }

    public function withTestimonial(): static
    {
        return $this->state(fn () => [
            'testimonial_quote' => 'They felt like an extension of our team.',
            'testimonial_name' => 'Marcus Lindqvist',
            'testimonial_role' => 'COO, LogiStack',
        ]);
    }
}
