<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_is_accessible_to_guests(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('Admin login');
    }

    public function test_invalid_credentials_do_not_authenticate(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('correct-password'),
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_valid_existing_user_can_authenticate_through_admin_login(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('secret-password'),
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'secret-password',
        ])->assertRedirect('/admin/enquiries');

        $this->assertAuthenticatedAs($user);
    }

    public function test_guest_cannot_access_admin_enquiries(): void
    {
        $this->get('/admin/enquiries')->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_access_admin_enquiries(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/enquiries')
            ->assertOk()
            ->assertSee('Enquiries');
    }

    public function test_logout_ends_the_authenticated_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/admin/logout')
            ->assertRedirect('/admin/login');

        $this->assertGuest();
    }
}
