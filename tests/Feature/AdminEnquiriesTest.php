<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEnquiriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_newest_enquiries_appear_first(): void
    {
        $user = User::factory()->create();
        $older = Enquiry::create($this->enquiryData(['name' => 'Older Lead', 'email' => 'older@example.com']));
        $older->forceFill(['created_at' => now()->subDay(), 'updated_at' => now()->subDay()])->save();
        $newer = Enquiry::create($this->enquiryData(['name' => 'Newer Lead', 'email' => 'newer@example.com']));
        $newer->forceFill(['created_at' => now(), 'updated_at' => now()])->save();

        $response = $this->actingAs($user)->get('/admin/enquiries');

        $response->assertOk();
        $this->assertLessThan(
            strpos($response->getContent(), 'Older Lead'),
            strpos($response->getContent(), 'Newer Lead')
        );
    }

    public function test_enquiry_detail_is_protected(): void
    {
        $enquiry = Enquiry::create($this->enquiryData());

        $this->get("/admin/enquiries/{$enquiry->id}")
            ->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_view_full_enquiry_details(): void
    {
        $user = User::factory()->create();
        $enquiry = Enquiry::create($this->enquiryData([
            'project_description' => 'Full project description for the admin detail page.',
        ]));

        $this->actingAs($user)
            ->get("/admin/enquiries/{$enquiry->id}")
            ->assertOk()
            ->assertSee('Full project description for the admin detail page.')
            ->assertSee('Laravel / PHP')
            ->assertSee('+91 9802032023');
    }

    private function enquiryData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Aarav Mehta',
            'email' => 'aarav@example.com',
            'country_code' => '+91',
            'phone' => '9802032023',
            'company' => 'Acme Labs',
            'technology' => 'Laravel / PHP',
            'budget_type' => 'Full Project',
            'project_description' => 'We need help building a Laravel portal.',
            'source' => '/contact',
        ], $overrides);
    }
}
