<?php

namespace Tests\Feature;

use Tests\TestCase;

class BlogPublicTest extends TestCase
{
    public function test_blog_index_lists_all_posts(): void
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
}
