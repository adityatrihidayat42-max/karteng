<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NuSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_pages_are_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/profil')->assertStatus(200);
        $this->get('/anggota')->assertStatus(200);
        $this->get('/banom')->assertStatus(200);
        $this->get('/berita')->assertStatus(200);
        $this->get('/agenda')->assertStatus(200);
        $this->get('/galeri')->assertStatus(200);
        $this->get('/donasi')->assertStatus(200);
        $this->get('/daftar-anggota')->assertStatus(200);
    }

    public function test_admin_requires_authentication(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::where('email', 'admin@nu.or.id')->first();
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_member_registration_can_be_submitted(): void
    {
        $response = $this->post('/daftar-anggota', [
            'nama_lengkap' => 'Kader Penguji Baru',
            'nik' => '3302111212990099',
            'jenis_kelamin' => 'L',
            'nomor_hp' => '081233445566',
            'alamat' => 'Jl. Santri No. 1',
            'persetujuan' => '1',
        ]);

        $response->assertRedirect('/daftar-anggota');
        $this->assertDatabaseHas('members', [
            'nama_lengkap' => 'Kader Penguji Baru',
            'status' => 'menunggu_verifikasi',
        ]);
    }

    public function test_kta_is_protected_and_only_admin_can_access(): void
    {
        // Public / unauthenticated user cannot access KTA print
        $response = $this->get('/admin/kta');
        $response->assertRedirect('/login');

        // Public /kta route is not available publicly
        $publicResponse = $this->get('/kta');
        $publicResponse->assertStatus(404);
    }

    public function test_admin_can_preview_and_download_kta_by_nis(): void
    {
        $admin = User::where('email', 'admin@nu.or.id')->first();
        $member = Member::where('status', 'aktif')->whereNotNull('nis')->first();
        $this->assertNotNull($member);

        // Admin preview KTA by NIS on KTA index
        $previewResponse = $this->actingAs($admin)->get("/admin/kta?nis={$member->nis}");
        $previewResponse->assertStatus(200);
        $previewResponse->assertSee($member->nama_lengkap);
        $previewResponse->assertSee($member->nis);

        // Admin download KTA PDF by NIS
        $downloadResponse = $this->actingAs($admin)->get("/admin/kta/{$member->nis}/download");
        $downloadResponse->assertStatus(200);
        $downloadResponse->assertHeader('content-type', 'application/pdf');
    }

    public function test_nis_must_be_unique(): void
    {
        $admin = User::where('email', 'admin@nu.or.id')->first();
        $existing = Member::where('status', 'aktif')->whereNotNull('nis')->first();

        $response = $this->actingAs($admin)->post('/admin/members', [
            'nama_lengkap' => 'Duplikat NIS Test',
            'nis' => $existing->nis,
            'jenis_kelamin' => 'L',
            'status' => 'aktif',
        ]);

        $response->assertSessionHasErrors('nis');
    }
}

