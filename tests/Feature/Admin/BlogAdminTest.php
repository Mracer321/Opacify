<?php

namespace Tests\Feature\Admin;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogAdminTest extends TestCase
{
    use RefreshDatabase;

    // --- Access ---------------------------------------------------------

    public function test_guest_cannot_access_blog_admin(): void
    {
        $this->get('/admin/blog')->assertRedirect('/admin/login');
        $this->get('/admin/blog/create')->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_access_blog_index_and_create(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/blog')->assertOk()->assertSee('Blog posts');
        $this->actingAs($user)->get('/admin/blog/create')->assertOk()->assertSee('Add post');
    }

    // --- CRUD -----------------------------------------------------------

    public function test_admin_can_create_a_draft_post(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/blog', $this->validPayload(['status' => 'draft']))
            ->assertRedirect();

        $post = BlogPost::firstWhere('slug', 'my-first-post');
        $this->assertNotNull($post);
        $this->assertSame('draft', $post->status);
        $this->assertSame('paragraph', $post->content_blocks[0]['type']);
    }

    public function test_admin_can_publish_and_post_becomes_visible(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/blog', $this->validPayload([
                'status' => 'published',
                'published_at' => now()->subHour()->format('Y-m-d\TH:i'),
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('blog_posts', ['slug' => 'my-first-post', 'status' => 'published']);
        $this->get('/blog/my-first-post')->assertOk()->assertSee('My First Post');
    }

    public function test_publishing_without_a_date_defaults_to_now(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/blog', $this->validPayload(['status' => 'published', 'published_at' => '']))
            ->assertRedirect();

        $this->assertNotNull(BlogPost::firstWhere('slug', 'my-first-post')->published_at);
    }

    public function test_post_can_be_updated_and_deleted(): void
    {
        $post = BlogPost::factory()->create(['slug' => 'keep-slug']);

        $this->actingAs(User::factory()->create())
            ->put("/admin/blog/{$post->id}", $this->validPayload(['slug' => 'keep-slug', 'title' => 'Updated Title']))
            ->assertRedirect();

        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'title' => 'Updated Title']);

        $this->actingAs(User::factory()->create())
            ->delete("/admin/blog/{$post->id}")
            ->assertRedirect('/admin/blog');

        $this->assertModelMissing($post);
    }

    public function test_toggle_publishes_and_unpublishes(): void
    {
        $draft = BlogPost::factory()->draft()->create();

        $this->actingAs(User::factory()->create())
            ->post("/admin/blog/{$draft->id}/toggle")
            ->assertRedirect();

        $this->assertSame('published', $draft->fresh()->status);
        $this->assertNotNull($draft->fresh()->published_at);

        $this->actingAs(User::factory()->create())
            ->post("/admin/blog/{$draft->id}/toggle")
            ->assertRedirect();

        $this->assertSame('draft', $draft->fresh()->status);
    }

    // --- Validation -----------------------------------------------------

    public function test_duplicate_slug_is_rejected(): void
    {
        BlogPost::factory()->create(['slug' => 'my-first-post']);

        $this->actingAs(User::factory()->create())
            ->post('/admin/blog', $this->validPayload(['slug' => 'my-first-post']))
            ->assertSessionHasErrors('slug');
    }

    public function test_update_can_retain_its_own_slug(): void
    {
        $post = BlogPost::factory()->create(['slug' => 'keep-this']);

        $this->actingAs(User::factory()->create())
            ->put("/admin/blog/{$post->id}", $this->validPayload(['slug' => 'keep-this']))
            ->assertRedirect()
            ->assertSessionHasNoErrors();
    }

    public function test_invalid_status_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/blog', $this->validPayload(['status' => 'archived']))
            ->assertSessionHasErrors('status');
    }

    // --- Preview authorization -----------------------------------------

    public function test_guest_cannot_preview_draft(): void
    {
        $draft = BlogPost::factory()->draft()->create();

        $this->get("/admin/blog/{$draft->id}/preview")->assertRedirect('/admin/login');
    }

    public function test_admin_can_preview_draft_and_it_is_noindex(): void
    {
        $draft = BlogPost::factory()->draft()->create([
            'title' => 'Preview Only Post',
            'slug' => 'preview-only-post',
        ]);

        $this->actingAs(User::factory()->create())
            ->get("/admin/blog/{$draft->id}/preview")
            ->assertOk()
            ->assertSee('Preview Only Post')
            ->assertSee('Admin preview')
            ->assertSee('name="robots" content="noindex, nofollow"', false);

        // But the public route still hides the draft.
        $this->get('/blog/preview-only-post')->assertNotFound();
    }

    // --- Image upload + metadata defaults ------------------------------

    public function test_image_upload_returns_path_and_metadata_defaults(): void
    {
        Storage::fake('public');

        // Use a GD-free fake file (fake()->image() needs the GD extension). The
        // ImageOptimizer falls back to storing the original when GD is absent.
        $response = $this->actingAs(User::factory()->create())
            ->post('/admin/blog/image', [
                'image' => UploadedFile::fake()->create('photo.jpg', 200, 'image/jpeg'),
                'topic' => 'Hiring Laravel Developers',
            ])
            ->assertOk()
            ->assertJsonStructure(['path', 'url', 'defaults' => ['slug', 'title', 'alt', 'caption', 'description']]);

        $this->assertSame('hiring-laravel-developers', $response->json('defaults.slug'));
        $this->assertSame('Hiring Laravel Developers', $response->json('defaults.alt'));
        Storage::disk('public')->assertExists($response->json('path'));
    }

    // --- SEO fallbacks --------------------------------------------------

    public function test_seo_metadata_falls_back_to_post_fields(): void
    {
        BlogPost::factory()->published()->create([
            'slug' => 'fallback-post',
            'title' => 'Fallback Post Title',
            'excerpt' => 'A concise fallback excerpt for meta.',
            'seo_title' => null,
            'meta_description' => null,
            'og_title' => null,
        ]);

        $this->get('/blog/fallback-post')
            ->assertOk()
            ->assertSee('<title>Fallback Post Title — OpacifyWeb Blog</title>', false)
            ->assertSee('name="description" content="A concise fallback excerpt for meta."', false)
            ->assertSee('property="og:image" content="https://opacify.in/images/og-default.png"', false);
    }

    public function test_explicit_seo_fields_win_over_fallbacks(): void
    {
        BlogPost::factory()->published()->create([
            'slug' => 'explicit-seo',
            'title' => 'Plain Title',
            'seo_title' => 'Custom SEO Title',
            'meta_description' => 'Custom meta description.',
        ]);

        $this->get('/blog/explicit-seo')
            ->assertOk()
            ->assertSee('<title>Custom SEO Title — OpacifyWeb Blog</title>', false)
            ->assertSee('name="description" content="Custom meta description."', false);
    }

    /**
     * @return array<string, mixed>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'My First Post',
            'slug' => 'my-first-post',
            'excerpt' => 'A short summary of the post.',
            'category' => 'Hiring',
            'tags' => 'laravel, hiring',
            'author' => 'Neha Kapoor',
            'author_role' => 'Head of Delivery',
            'status' => 'draft',
            'content_blocks' => [
                ['type' => 'paragraph', 'text' => 'The opening paragraph of the article.'],
                ['type' => 'heading', 'level' => '2', 'text' => 'A section heading'],
            ],
        ], $overrides);
    }
}
