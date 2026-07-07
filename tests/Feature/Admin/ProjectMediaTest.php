<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_primary_image_uploads(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload([
                'primary_image' => UploadedFile::fake()->create('hero.jpg', 500, 'image/jpeg'),
            ]))
            ->assertRedirect('/admin/projects');

        $project = Project::firstWhere('slug', 'logistics-erp-modernization');
        $this->assertNotNull($project->primary_image);
        $this->assertStringStartsWith('projects/', $project->primary_image);
        Storage::disk('public')->assertExists($project->primary_image);
    }

    public function test_invalid_image_is_rejected(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create())
            ->post('/admin/projects', $this->validPayload([
                'primary_image' => UploadedFile::fake()->create('brochure.pdf', 200, 'application/pdf'),
            ]))
            ->assertSessionHasErrors('primary_image');

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_existing_image_is_preserved_when_edit_has_no_replacement(): void
    {
        Storage::fake('public');

        $existing = UploadedFile::fake()->create('existing.jpg', 500, 'image/jpeg')->store('projects', 'public');
        $project = Project::factory()->create([
            'slug' => 'has-image',
            'primary_image' => $existing,
        ]);

        $this->actingAs(User::factory()->create())
            ->put("/admin/projects/{$project->id}", $this->validPayload([
                'slug' => 'has-image',
                'title' => 'Renamed But Same Image',
            ]))
            ->assertRedirect('/admin/projects');

        $this->assertSame($existing, $project->fresh()->primary_image);
        Storage::disk('public')->assertExists($existing);
    }

    public function test_replaced_managed_image_is_deleted(): void
    {
        Storage::fake('public');

        $old = UploadedFile::fake()->create('old.jpg', 500, 'image/jpeg')->store('projects', 'public');
        $project = Project::factory()->create([
            'slug' => 'replace-image',
            'primary_image' => $old,
        ]);

        $this->actingAs(User::factory()->create())
            ->put("/admin/projects/{$project->id}", $this->validPayload([
                'slug' => 'replace-image',
                'primary_image' => UploadedFile::fake()->create('new.jpg', 500, 'image/jpeg'),
            ]))
            ->assertRedirect('/admin/projects');

        $new = $project->fresh()->primary_image;
        $this->assertNotSame($old, $new);
        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($new);
    }

    public function test_project_deletion_removes_managed_project_media(): void
    {
        Storage::fake('public');

        $primary = UploadedFile::fake()->create('p.jpg', 500, 'image/jpeg')->store('projects', 'public');
        $secondary = UploadedFile::fake()->create('s.jpg', 500, 'image/jpeg')->store('projects', 'public');
        $project = Project::factory()->create([
            'primary_image' => $primary,
            'secondary_image' => $secondary,
        ]);

        $this->actingAs(User::factory()->create())
            ->delete("/admin/projects/{$project->id}")
            ->assertRedirect('/admin/projects');

        Storage::disk('public')->assertMissing($primary);
        Storage::disk('public')->assertMissing($secondary);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Logistics ERP Modernization',
            'slug' => 'logistics-erp-modernization',
            'project_label' => 'LogiStack',
            'short_summary' => 'Replaced a decade-old desktop ERP with a cloud Laravel platform.',
            'industry' => 'Supply Chain',
            'duration' => '6 months',
            'technologies' => ['Laravel', 'Vue.js'],
            'highlights' => ['40% faster fulfillment'],
            'challenge' => 'A monolithic desktop ERP that could not scale.',
            'solution' => 'A modular Laravel + Vue platform with real-time sync.',
            'team_summary' => '2 Laravel developers, 1 QA',
            'key_results' => [
                ['value' => '40%', 'label' => 'Reduction in order fulfillment time'],
            ],
            'status' => 'draft',
            'is_featured' => '0',
            'sort_order' => 0,
        ], $overrides);
    }
}
