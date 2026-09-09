<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_admin(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_open_admin_pages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get('/admin')->assertOk();
        $this->get('/admin/projects')->assertOk();
        $this->get('/admin/projects/create')->assertOk();
        $this->get('/admin/skills')->assertOk();
        $this->get('/admin/clients')->assertOk();
        $this->get('/admin/clients/create')->assertOk();
        $this->get('/admin/contact-messages')->assertOk();
        $this->get('/admin/manage-site-settings')->assertOk();
    }
}
