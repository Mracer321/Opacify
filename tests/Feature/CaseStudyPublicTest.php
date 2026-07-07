<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseStudyPublicTest extends TestCase
{
    use RefreshDatabase;

    // --- Public listing -------------------------------------------------

    public function test_published_project_appears_on_listing(): void
    {
        Project::factory()->published()->create(['title' => 'Published Case Study']);

        $this->get('/case-studies')
            ->assertOk()
            ->assertSee('Published Case Study');
    }

    public function test_draft_project_does_not_appear_on_listing(): void
    {
        Project::factory()->create(['title' => 'Hidden Draft Study']);

        $this->get('/case-studies')
            ->assertOk()
            ->assertDontSee('Hidden Draft Study');
    }

    public function test_projects_respect_sort_order(): void
    {
        Project::factory()->published()->create(['title' => 'Second Card', 'slug' => 'second', 'sort_order' => 2]);
        Project::factory()->published()->create(['title' => 'First Card', 'slug' => 'first', 'sort_order' => 1]);

        $content = $this->get('/case-studies')->assertOk()->getContent();

        $this->assertLessThan(
            strpos($content, 'Second Card'),
            strpos($content, 'First Card')
        );
    }

    public function test_empty_project_database_renders_successfully(): void
    {
        $this->get('/case-studies')
            ->assertOk()
            ->assertSee('Case studies');
    }

    // --- Public detail --------------------------------------------------

    public function test_published_project_detail_returns_200(): void
    {
        $project = Project::factory()->published()->create(['slug' => 'live-study']);

        $this->get("/case-studies/{$project->slug}")->assertOk();
    }

    public function test_draft_project_detail_returns_404(): void
    {
        $project = Project::factory()->create(['slug' => 'draft-study']);

        $this->get("/case-studies/{$project->slug}")->assertNotFound();
    }

    public function test_unknown_slug_returns_404(): void
    {
        $this->get('/case-studies/does-not-exist')->assertNotFound();
    }

    public function test_detail_renders_stored_project_content(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'content-study',
            'title' => 'Content Rich Study',
            'challenge' => 'The unique challenge statement here.',
            'solution' => 'The unique solution statement here.',
            'technologies' => ['Laravel', 'Vue.js'],
            'key_results' => [
                ['value' => '42%', 'label' => 'Unique result label'],
            ],
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('Content Rich Study')
            ->assertSee('The unique challenge statement here.')
            ->assertSee('The unique solution statement here.')
            ->assertSee('Laravel')
            ->assertSee('42%')
            ->assertSee('Unique result label');
    }

    public function test_testimonial_is_shown_when_present(): void
    {
        $project = Project::factory()->published()->withTestimonial()->create([
            'slug' => 'has-testimonial',
            'testimonial_quote' => 'A truly meaningful testimonial quote.',
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('A truly meaningful testimonial quote.');
    }

    public function test_optional_testimonial_is_hidden_when_incomplete(): void
    {
        // Quote present but no name => not a meaningful testimonial.
        $project = Project::factory()->published()->create([
            'slug' => 'no-testimonial',
            'testimonial_quote' => 'Orphan quote without attribution.',
            'testimonial_name' => null,
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertDontSee('Orphan quote without attribution.');
    }

    // --- Media rendering ------------------------------------------------

    public function test_uploaded_primary_image_is_rendered_instead_of_mockup_on_detail(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'has-primary',
            'primary_image' => 'projects/hero.jpg',
        ]);

        // "Production interface" is the subtitle of the hero/main mockup fallback
        // (the CTA banner mockup uses a different subtitle), so its absence proves
        // the uploaded image replaced the project's fallback visual.
        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('projects/hero.jpg', false)
            ->assertDontSee('Production interface');
    }

    public function test_uploaded_primary_image_is_rendered_on_listing_card(): void
    {
        Project::factory()->published()->create([
            'slug' => 'listing-image',
            'primary_image' => 'projects/listing.jpg',
        ]);

        $this->get('/case-studies')
            ->assertOk()
            ->assertSee('projects/listing.jpg', false);
    }

    public function test_uploaded_primary_image_is_rendered_on_homepage_featured_card(): void
    {
        Project::factory()->featured()->create([
            'slug' => 'home-image',
            'primary_image' => 'projects/home.jpg',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('projects/home.jpg', false);
    }

    public function test_uploaded_secondary_image_is_rendered_in_detail_content(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'has-secondary',
            'primary_image' => 'projects/primary.jpg',
            'secondary_image' => 'projects/secondary.jpg',
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('projects/primary.jpg', false)   // hero
            ->assertSee('projects/secondary.jpg', false); // content/media section
    }

    public function test_generic_mockup_is_used_as_fallback_when_no_image(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'no-image',
            'primary_image' => null,
            'secondary_image' => null,
        ]);

        // With no uploaded images, the hero/main visual falls back to the mockup,
        // whose distinctive "Production interface" subtitle is present.
        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertDontSee('projects/', false)
            ->assertSee('Production interface');
    }

    public function test_detail_hides_key_results_block_when_none_exist(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'no-results',
            'key_results' => [],
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertDontSee('Key results');
    }

    public function test_og_image_meta_is_emitted_and_falls_back_to_primary_image(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'og-fallback',
            'og_image' => null,
            'primary_image' => 'projects/hero.jpg',
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('property="og:image"', false)
            ->assertSee('projects/hero.jpg', false);
    }

    // --- SEO ------------------------------------------------------------

    public function test_project_seo_title_is_used_when_present(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'seo-study',
            'seo_title' => 'Custom SEO Title For Study',
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('Custom SEO Title For Study');
    }

    public function test_project_title_fallback_is_used_when_seo_title_missing(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'fallback-study',
            'title' => 'Fallback Title Study',
            'seo_title' => null,
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('Fallback Title Study Case Study — OpacifyWeb');
    }

    public function test_meta_description_falls_back_to_short_summary(): void
    {
        $project = Project::factory()->published()->create([
            'slug' => 'meta-study',
            'short_summary' => 'The summary used as the meta description fallback.',
            'meta_description' => null,
        ]);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('The summary used as the meta description fallback.', false);
    }

    public function test_canonical_uses_exact_project_slug(): void
    {
        $project = Project::factory()->published()->create(['slug' => 'canonical-study']);

        $this->get("/case-studies/{$project->slug}")
            ->assertOk()
            ->assertSee('https://opacify.in/case-studies/canonical-study', false);
    }

    // --- Homepage featured ---------------------------------------------

    public function test_featured_published_project_content_renders_on_homepage(): void
    {
        Project::factory()->featured()->create([
            'title' => 'Homepage Featured Study',
            'short_summary' => 'Featured summary shown on the homepage card.',
            'slug' => 'home-featured',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Homepage Featured Study')
            ->assertSee('Featured summary shown on the homepage card.');
    }

    public function test_draft_featured_data_does_not_render_on_homepage(): void
    {
        Project::factory()->create([
            'title' => 'Draft Featured Study',
            'is_featured' => true,
            'status' => 'draft',
            'slug' => 'draft-featured',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Draft Featured Study');
    }

    public function test_homepage_returns_200_when_no_featured_project_exists(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_homepage_displays_a_maximum_of_four_featured_projects(): void
    {
        foreach (range(1, 5) as $i) {
            Project::factory()->featured()->create([
                'title' => "Featured Card {$i}",
                'slug' => "featured-card-{$i}",
                'sort_order' => $i,
            ]);
        }

        $response = $this->get('/')->assertOk();

        foreach (range(1, 4) as $i) {
            $response->assertSee("Featured Card {$i}");
        }
        // The 5th (highest sort_order) is beyond the 4-card limit.
        $response->assertDontSee('Featured Card 5');
    }

    public function test_homepage_respects_sort_order_ascending(): void
    {
        Project::factory()->featured()->create(['title' => 'Beta Card', 'slug' => 'beta', 'sort_order' => 2]);
        Project::factory()->featured()->create(['title' => 'Alpha Card', 'slug' => 'alpha', 'sort_order' => 1]);

        $content = $this->get('/')->assertOk()->getContent();

        $this->assertLessThan(
            strpos($content, 'Beta Card'),
            strpos($content, 'Alpha Card')
        );
    }

    public function test_unpublished_featured_projects_do_not_appear_on_homepage(): void
    {
        Project::factory()->create([
            'title' => 'Unpublished Featured Study',
            'slug' => 'unpublished-featured',
            'is_featured' => true,
            'status' => 'draft',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Unpublished Featured Study');
    }
}
