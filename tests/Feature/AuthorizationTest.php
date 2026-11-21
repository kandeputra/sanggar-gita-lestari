<?php

namespace Tests\Feature;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_manage_content_but_not_users_or_settings(): void
    {
        $admin = User::factory()->create();

        $this->assertTrue($admin->can('create', Artwork::class));
        $this->assertFalse($admin->can('viewAny', User::class));
        $this->assertFalse($admin->can('manage-settings'));

        $this->actingAs($admin)->get('/admin/artworks')->assertOk();
        $this->actingAs($admin)->get('/admin/profil-sanggar')->assertOk();
        $this->actingAs($admin)->get('/admin/users')->assertForbidden();
        $this->actingAs($admin)->get('/admin/pengaturan')->assertForbidden();
    }

    public function test_super_admin_can_manage_users_and_settings(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $this->actingAs($superAdmin)->get('/admin/users')->assertOk();
        $this->actingAs($superAdmin)->get('/admin/pengaturan')->assertOk();
    }

    public function test_super_admin_cannot_delete_own_account(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();
        $other = User::factory()->create();

        $this->assertFalse($superAdmin->can('delete', $superAdmin));
        $this->assertTrue($superAdmin->can('delete', $other));
    }

    public function test_inactive_user_cannot_access_panel(): void
    {
        $user = User::factory()->inactive()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();
        $this->assertFalse($user->can('create', Artwork::class));
    }
}
