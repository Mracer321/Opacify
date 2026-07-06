<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnquirySubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_enquiry_is_saved(): void
    {
        $response = $this->from('/contact')->post('/enquiries', $this->validPayload());

        $response->assertRedirect('/contact');
        $response->assertSessionHas('enquiry_success');
        $this->assertDatabaseHas('enquiries', [
            'name' => 'Aarav Mehta',
            'email' => 'aarav@example.com',
            'country_code' => '+91',
            'phone' => '9802032023',
            'company' => 'Acme Labs',
            'technology' => 'Laravel / PHP',
            'budget_type' => 'Full Project',
            'source' => '/contact',
        ]);
    }

    public function test_enquiry_without_optional_company_is_saved(): void
    {
        $payload = $this->validPayload(['company_name' => null]);

        $this->post('/enquiries', $payload)->assertSessionHas('enquiry_success');

        $this->assertDatabaseHas('enquiries', [
            'email' => 'aarav@example.com',
            'company' => null,
        ]);
    }

    public function test_india_country_code_works(): void
    {
        $this->post('/enquiries', $this->validPayload(['country_code' => '+91']))
            ->assertSessionHas('enquiry_success');

        $this->assertDatabaseHas('enquiries', ['country_code' => '+91']);
    }

    public function test_another_supported_country_code_works(): void
    {
        $this->post('/enquiries', $this->validPayload(['country_code' => '+44', 'phone' => '20 7946 0958']))
            ->assertSessionHas('enquiry_success');

        $this->assertDatabaseHas('enquiries', [
            'country_code' => '+44',
            'phone' => '2079460958',
        ]);
    }

    public function test_unsupported_country_code_is_rejected(): void
    {
        $this->post('/enquiries', $this->validPayload(['country_code' => '+999']))
            ->assertSessionHasErrors('country_code');

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_phone_formatting_is_normalized_to_digits(): void
    {
        $this->post('/enquiries', $this->validPayload(['phone' => '(980) 20-32023']))
            ->assertSessionHas('enquiry_success');

        $this->assertDatabaseHas('enquiries', ['phone' => '9802032023']);
    }

    public function test_invalid_phone_is_rejected(): void
    {
        $this->post('/enquiries', $this->validPayload(['phone' => 'abc-123']))
            ->assertSessionHasErrors('phone');

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_invalid_email_is_rejected(): void
    {
        $this->post('/enquiries', $this->validPayload(['email' => 'not-an-email']))
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_required_fields_are_enforced(): void
    {
        $this->post('/enquiries', [])
            ->assertSessionHasErrors([
                'full_name',
                'email',
                'country_code',
                'phone',
                'technology',
                'budget_type',
                'project_description',
            ]);
    }

    public function test_honeypot_blocks_spam_submission(): void
    {
        $this->post('/enquiries', $this->validPayload(['website' => 'https://spam.test']))
            ->assertSessionHasErrors('website');

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_rate_limiting_protects_the_post_endpoint(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
                ->post('/enquiries', $this->validPayload([
                    'email' => "lead{$i}@example.com",
                ]))
                ->assertSessionHas('enquiry_success');
        }

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.10'])
            ->post('/enquiries', $this->validPayload([
                'email' => 'limited@example.com',
            ]))
            ->assertStatus(429);
    }

    public function test_source_internal_path_is_stored(): void
    {
        $this->post('/enquiries', $this->validPayload(['source' => '/services/web-development']))
            ->assertSessionHas('enquiry_success');

        $this->assertDatabaseHas('enquiries', ['source' => '/services/web-development']);
    }

    public function test_external_or_invalid_source_is_normalized_safely(): void
    {
        $this->post('/enquiries', $this->validPayload(['source' => 'https://evil.test/contact']))
            ->assertSessionHas('enquiry_success');

        $this->assertDatabaseHas('enquiries', ['source' => 'unknown']);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Aarav Mehta',
            'email' => 'aarav@example.com',
            'country_code' => '+91',
            'phone' => '98020 32023',
            'company_name' => 'Acme Labs',
            'technology' => 'Laravel / PHP',
            'budget_type' => 'Full Project',
            'project_description' => 'We need help building a Laravel portal with dashboards and integrations.',
            'source' => '/contact',
        ], $overrides);
    }
}
