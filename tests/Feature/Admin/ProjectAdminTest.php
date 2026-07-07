<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectAdminTest extends TestCase
{
    use RefreshDatabase;

    // --- Admin access ---------------------------------------------------

    public function test_guest_cannot_access_project_index(): void
    {
        $this->get('/admin/projects')->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_access_project_create(): void
    {
        $this->get('/admin/projects/create')->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_access_project_index(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/projects')
            ->assertOk()
            ->assertSee('Projects');
    }

    public function test_authenticated_user_can_access_project_create(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin/projects/create')
            ->assertOk()
            ->assertSee('Add project');
    }

    // --- CRUD -----------------------------------------------------------

    public function test_authenticated_user_can_create_a_draft_project(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload(['status' => 'draft']))
            ->assertRedirect('/admin/projects');

        $project = Project::firstWhere('slug', 'logistics-erp-modernization');
        $this->assertNotNull($project);
        $this->assertSame('draft', $project->status);
        $this->assertSame(['Laravel', 'Vue.js', 'MySQL'], $project->technologies);
        $this->assertSame([['text' => '40% faster fulfillment'], ['text' => '99.9% uptime']], $project->highlights);
        $this->assertSame([
            ['value' => '40%', 'label' => 'Reduction in order fulfillment time'],
            ['value' => '99.9%', 'label' => 'Platform uptime post-launch'],
        ], $project->key_results);
    }

    public function test_authenticated_user_can_create_a_published_project(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload(['status' => 'published']))
            ->assertRedirect('/admin/projects');

        $this->assertDatabaseHas('projects', [
            'slug' => 'logistics-erp-modernization',
            'status' => 'published',
        ]);
    }

    public function test_project_can_be_updated(): void
    {
        $project = Project::factory()->create(['slug' => 'original-slug']);

        $this->actingAs(User::factory()->create())
            ->put("/admin/projects/{$project->id}", $this->validPayload([
                'slug' => 'original-slug',
                'title' => 'Updated Title',
            ]))
            ->assertRedirect('/admin/projects');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'slug' => 'original-slug',
            'title' => 'Updated Title',
        ]);
    }

    public function test_project_can_be_deleted(): void
    {
        $project = Project::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete("/admin/projects/{$project->id}")
            ->assertRedirect('/admin/projects');

        $this->assertModelMissing($project);
    }

    // --- Validation -----------------------------------------------------

    public function test_duplicate_slug_is_rejected(): void
    {
        Project::factory()->create(['slug' => 'logistics-erp-modernization']);

        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload(['slug' => 'logistics-erp-modernization']))
            ->assertSessionHasErrors('slug');

        $this->assertSame(1, Project::where('slug', 'logistics-erp-modernization')->count());
    }

    public function test_update_can_retain_its_own_slug(): void
    {
        $project = Project::factory()->create(['slug' => 'keep-this-slug']);

        $this->actingAs(User::factory()->create())
            ->put("/admin/projects/{$project->id}", $this->validPayload(['slug' => 'keep-this-slug']))
            ->assertRedirect('/admin/projects')
            ->assertSessionHasNoErrors();
    }

    public function test_invalid_status_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload(['status' => 'archived']))
            ->assertSessionHasErrors('status');

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_empty_structured_rows_are_removed_before_persistence(): void
    {
        $payload = $this->validPayload([
            'technologies' => ['Laravel', '', '   '],
            'highlights' => ['40% faster fulfillment', ''],
            'key_results' => [
                ['value' => '40%', 'label' => 'Reduction in fulfillment time'],
                ['value' => '', 'label' => ''],
            ],
        ]);

        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $payload)
            ->assertRedirect('/admin/projects');

        $project = Project::firstWhere('slug', 'logistics-erp-modernization');
        $this->assertSame(['Laravel'], $project->technologies);
        $this->assertSame([['text' => '40% faster fulfillment']], $project->highlights);
        $this->assertSame([['value' => '40%', 'label' => 'Reduction in fulfillment time']], $project->key_results);
    }

    // --- Featured rule --------------------------------------------------

    public function test_published_featured_project_can_be_featured(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload([
                'status' => 'published',
                'is_featured' => '1',
            ]));

        $this->assertTrue(Project::firstWhere('slug', 'logistics-erp-modernization')->is_featured);
    }

    public function test_featuring_a_second_published_project_unfeatures_the_first(): void
    {
        $first = Project::factory()->featured()->create(['slug' => 'first-project']);

        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload([
                'slug' => 'second-project',
                'status' => 'published',
                'is_featured' => '1',
            ]));

        $this->assertFalse($first->fresh()->is_featured);
        $this->assertTrue(Project::firstWhere('slug', 'second-project')->is_featured);
        $this->assertSame(1, Project::where('is_featured', true)->count());
    }

    public function test_draft_project_cannot_become_the_public_featured_project(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload([
                'status' => 'draft',
                'is_featured' => '1',
            ]));

        // The flag may be stored, but the public homepage query never selects a draft.
        $publicFeatured = Project::query()->published()->where('is_featured', true)->first();
        $this->assertNull($publicFeatured);
    }

    public function test_changing_featured_project_to_draft_removes_it_from_homepage_selection(): void
    {
        $project = Project::factory()->featured()->create(['slug' => 'featured-one']);

        $this->actingAs(User::factory()->create())
            ->put("/admin/projects/{$project->id}", $this->validPayload([
                'slug' => 'featured-one',
                'status' => 'draft',
                'is_featured' => '1',
            ]));

        $publicFeatured = Project::query()->published()->where('is_featured', true)->first();
        $this->assertNull($publicFeatured);
    }

    /**
     * A valid project form payload (repeatable fields shaped like the form submits).
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Logistics ERP Modernization',
            'slug' => 'logistics-erp-modernization',
            'project_label' => 'LogiStack',
            'short_summary' => 'Replaced a decade-old desktop ERP with a cloud Laravel platform serving 40 warehouses.',
            'industry' => 'Supply Chain',
            'duration' => '6 months',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL'],
            'highlights' => ['40% faster fulfillment', '99.9% uptime'],
            'challenge' => 'LogiStack relied on a monolithic desktop ERP that could not scale with new warehouses.',
            'solution' => 'We designed a modular Laravel + Vue platform with real-time inventory sync.',
            'team_summary' => '2 Laravel developers, 1 Vue developer, 1 QA',
            'key_results' => [
                ['value' => '40%', 'label' => 'Reduction in order fulfillment time'],
                ['value' => '99.9%', 'label' => 'Platform uptime post-launch'],
            ],
            'status' => 'draft',
            'is_featured' => '0',
            'sort_order' => 0,
        ], $overrides);
    }
}
