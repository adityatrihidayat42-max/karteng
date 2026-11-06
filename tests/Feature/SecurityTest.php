<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    private function admin(): User
    {
        return User::where('email', 'admin@nu.or.id')->firstOrFail();
    }

    private function pengurus(): User
    {
        return User::where('email', 'pengurus@nu.or.id')->firstOrFail();
    }

    public function test_pengurus_can_access_dashboard(): void
    {
        $this->actingAs($this->pengurus())->get('/admin/dashboard')->assertStatus(200);
    }

    public function test_pengurus_cannot_open_user_management(): void
    {
        $this->actingAs($this->pengurus())->get('/admin/users')->assertStatus(403);
        $this->actingAs($this->pengurus())->get('/admin/users/create')->assertStatus(403);
    }

    public function test_pengurus_cannot_create_an_admin_account(): void
    {
        $response = $this->actingAs($this->pengurus())->post('/admin/users', [
            'name' => 'Admin Palsu',
            'email' => 'palsu@example.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => 'palsu@example.com']);
    }

    public function test_pengurus_cannot_edit_organization_profile(): void
    {
        $this->actingAs($this->pengurus())->get('/admin/organization')->assertStatus(403);
        $this->actingAs($this->pengurus())
            ->put('/admin/organization', ['nama_organisasi' => 'Diubah Pengurus'])
            ->assertStatus(403);
    }

    public function test_admin_can_open_user_management_and_organization(): void
    {
        $this->actingAs($this->admin())->get('/admin/users')->assertStatus(200);
        $this->actingAs($this->admin())->get('/admin/organization')->assertStatus(200);
    }

    public function test_sidebar_hides_admin_only_menus_from_pengurus(): void
    {
        $this->actingAs($this->pengurus())->get('/admin/dashboard')
            ->assertDontSee(route('admin.users.index'), false)
            ->assertDontSee(route('admin.organization.edit'), false);

        $this->actingAs($this->admin())->get('/admin/dashboard')
            ->assertSee(route('admin.users.index'), false)
            ->assertSee(route('admin.organization.edit'), false);
    }

    public function test_admin_email_without_a_role_gets_no_access(): void
    {
        $admin = $this->admin();
        $admin->syncRoles([]);

        $this->actingAs($admin->fresh())->get('/admin/dashboard')->assertStatus(403);
    }

    public function test_user_without_role_cannot_enter_admin_area(): void
    {
        $user = User::create([
            'name' => 'Warga Biasa',
            'email' => 'warga@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/admin/dashboard')->assertStatus(403);
    }

    public function test_login_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'admin@nu.or.id', 'password' => 'salah'])
                ->assertStatus(302);
        }

        $this->post('/login', ['email' => 'admin@nu.or.id', 'password' => 'salah'])
            ->assertStatus(429);
    }

    public function test_member_registration_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/daftar-anggota', [])->assertStatus(302);
        }

        $this->post('/daftar-anggota', [])->assertStatus(429);
    }

    public function test_donation_submission_is_rate_limited(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->post('/donasi', [])->assertStatus(302);
        }

        $this->post('/donasi', [])->assertStatus(429);
    }

    public function test_proof_upload_is_rate_limited(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->post('/donasi/INF-TIDAK-ADA/upload-bukti', [])->assertStatus(404);
        }

        $this->post('/donasi/INF-TIDAK-ADA/upload-bukti', [])->assertStatus(429);
    }
}
