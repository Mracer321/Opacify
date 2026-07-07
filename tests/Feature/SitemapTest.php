<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'https://opacify.in']);
    }

    public function test_sitemap_returns_valid_xml_with_correct_content_type(): void
    {
        $response = $this->get('/sitemap.xml');

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $content = $response->getContent();

        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertNotFalse(simplexml_load_string($content));
    }

    public function test_sitemap_includes_canonical_public_pages(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();

        foreach ([
            'https://opacify.in',
            'https://opacify.in/services',
            'https://opacify.in/services/web-development',
            'https://opacify.in/hire-laravel-developers',
            'https://opacify.in/technologies/angular',
            'https://opacify.in/blog',
            'https://opacify.in/blog/how-to-hire-laravel-developers',
            'https://opacify.in/case-studies',
        ] as $url) {
            $response->assertSee('<loc>'.$url.'</loc>', false);
        }
    }

    public function test_sitemap_includes_published_projects_and_excludes_drafts(): void
    {
        $published = Project::factory()->published()->create(['slug' => 'published-study']);
        Project::factory()->create(['slug' => 'draft-study']);

        $response = $this->get('/sitemap.xml')->assertOk();

        $response->assertSee('<loc>https://opacify.in/case-studies/published-study</loc>', false);
        $response->assertDontSee('<loc>https://opacify.in/case-studies/draft-study</loc>', false);
        $response->assertSee('<lastmod>'.$published->updated_at->toDateString().'</lastmod>', false);
    }

    public function test_sitemap_excludes_admin_and_duplicate_redirect_urls(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();

        foreach ([
            'https://opacify.in/admin',
            'https://opacify.in/admin/login',
            'https://opacify.in/enquiries',
            'https://opacify.in/technologies/laravel',
            'https://opacify.in/technologies/react',
            'https://opacify.in/technologies/nodejs',
            'https://opacify.in/technologies/flutter',
        ] as $url) {
            $response->assertDontSee('<loc>'.$url.'</loc>', false);
        }
    }
}
