<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Database\Seeders\BlogPostSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPublicTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(BlogPostSeeder::class);
    }

    public function test_blog_index_lists_published_posts(): void
    {
        $response = $this->get('/blog')->assertOk();

        $response
            ->assertSee('How to Hire Laravel Developers Without a Six-Month Search')
            ->assertSee('Dedicated Developer vs Hourly: Which Model Fits Your Roadmap?')
            ->assertSee('The React Team Augmentation Checklist for Series A Startups')
            ->assertSee('Five Lessons from Migrating a Legacy ERP to Laravel');
    }

    public function test_known_blog_post_has_unique_title_and_h1(): void
    {
        $response = $this->get('/blog/dedicated-developer-vs-hourly')->assertOk();

        $response
            ->assertSee('<title>Dedicated Developer vs Hourly: Which Model Fits Your Roadmap? — OpacifyWeb Blog</title>', false)
            ->assertSee('<h1 class="mt-4 font-display text-3xl font-semibold text-white sm:text-4xl text-balance">Dedicated Developer vs Hourly: Which Model Fits Your Roadmap?</h1>', false);
    }

    public function test_blog_posts_have_unique_titles(): void
    {
        $this->get('/blog/dedicated-developer-vs-hourly')
            ->assertOk()
            ->assertSee('<title>Dedicated Developer vs Hourly: Which Model Fits Your Roadmap? — OpacifyWeb Blog</title>', false)
            ->assertDontSee('<title>How to Hire Laravel Developers Without a Six-Month Search — OpacifyWeb Blog</title>', false);

        $this->get('/blog/react-team-augmentation-checklist')
            ->assertOk()
            ->assertSee('<title>The React Team Augmentation Checklist for Series A Startups — OpacifyWeb Blog</title>', false);
    }

    public function test_unknown_blog_slug_returns_404(): void
    {
        $this->get('/blog/not-a-real-post')->assertNotFound();
    }

    public function test_pagination_limits_posts_per_page_and_preserves_search(): void
    {
        BlogPost::factory()->count(15)->published()->create();

        // 4 seeded + 15 = 19 posts, 9 per page → page 2 exists.
        $this->get('/blog')->assertOk()->assertSee('?page=2', false);

        // Search term is carried onto pagination links.
        BlogPost::factory()->count(12)->published()->create([
            'excerpt' => 'kubernetes migration notes',
        ]);

        $response = $this->get('/blog?q=kubernetes')->assertOk();
        $response->assertSee('q=kubernetes', false);
    }

    public function test_search_matches_title_and_handles_zero_results(): void
    {
        BlogPost::factory()->published()->create([
            'title' => 'Scaling GraphQL Gateways',
            'slug' => 'scaling-graphql-gateways',
            'excerpt' => 'A guide to federation.',
        ]);

        $this->get('/blog?q=GraphQL')
            ->assertOk()
            ->assertSee('Scaling GraphQL Gateways')
            ->assertDontSee('Five Lessons from Migrating a Legacy ERP to Laravel');

        $this->get('/blog?q=zzzznotfoundzzz')
            ->assertOk()
            ->assertSee('No articles found');
    }

    public function test_draft_post_is_not_publicly_visible(): void
    {
        $draft = BlogPost::factory()->draft()->create([
            'title' => 'Secret Draft Post',
            'slug' => 'secret-draft-post',
        ]);

        $this->get('/blog/secret-draft-post')->assertNotFound();
        $this->get('/blog')->assertOk()->assertDontSee('Secret Draft Post');
    }

    public function test_scheduled_future_post_is_not_publicly_visible(): void
    {
        BlogPost::factory()->scheduled()->create([
            'title' => 'Future Scheduled Post',
            'slug' => 'future-scheduled-post',
        ]);

        $this->get('/blog/future-scheduled-post')->assertNotFound();
        $this->get('/blog')->assertOk()->assertDontSee('Future Scheduled Post');
    }

    public function test_scheduled_post_becomes_visible_once_publish_time_passes(): void
    {
        $post = BlogPost::factory()->create([
            'title' => 'Now Live Post',
            'slug' => 'now-live-post',
            'status' => BlogPost::STATUS_SCHEDULED,
            'published_at' => now()->subMinute(),
        ]);

        $this->get('/blog/now-live-post')->assertOk()->assertSee('Now Live Post');
        $this->get('/blog')->assertOk()->assertSee('Now Live Post');
    }

    public function test_published_post_renders_blog_posting_schema_with_real_data(): void
    {
        $response = $this->get('/blog/how-to-hire-laravel-developers')->assertOk();

        $response
            ->assertSee('"@type":"BlogPosting"', false)
            ->assertSee('"headline":"How to Hire Laravel Developers Without a Six-Month Search"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('property="og:type" content="article"', false);
    }

    public function test_search_results_page_is_noindexed(): void
    {
        $this->get('/blog?q=laravel')
            ->assertOk()
            ->assertSee('name="robots" content="noindex, follow"', false);

        $this->get('/blog')
            ->assertOk()
            ->assertSee('name="robots" content="index, follow"', false);
    }
}
