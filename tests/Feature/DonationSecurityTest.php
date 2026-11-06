<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DonationSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        Storage::fake('public');
    }

    private function newDonation(array $override = []): Donation
    {
        return Donation::create(array_merge([
            'transaction_code' => Donation::generateTransactionCode(),
            'donor_name' => 'Donatur Uji',
            'amount' => 150000,
            'donation_type' => 'infaq',
            'status' => 'pending',
        ], $override));
    }

    public function test_every_donation_gets_a_long_random_public_token(): void
    {
        $a = $this->newDonation();
        $b = $this->newDonation();

        $this->assertGreaterThanOrEqual(32, strlen($a->public_token));
        $this->assertNotEquals($a->public_token, $b->public_token);
        $this->assertDatabaseMissing('donations', ['public_token' => null]);
    }

    public function test_submitting_a_donation_redirects_to_the_token_url_not_the_sequential_code(): void
    {
        $response = $this->post('/donasi', [
            'donor_name' => 'Donatur Form Uji',
            'amount' => 50000,
            'donation_type' => 'infaq',
        ]);

        $donation = Donation::where('donor_name', 'Donatur Form Uji')->firstOrFail();
        $response->assertRedirect('/donasi/' . $donation->public_token);
        $this->assertStringNotContainsString($donation->transaction_code, $response->headers->get('Location'));
    }

    public function test_sequential_transaction_code_no_longer_opens_a_donation_page(): void
    {
        $donation = $this->newDonation(['donor_name' => 'Rahasia Donatur']);

        $this->get('/donasi/' . $donation->transaction_code)->assertStatus(404);
        $this->post('/donasi/' . $donation->transaction_code . '/upload-bukti', [])->assertStatus(404);
    }

    public function test_donation_page_opens_with_the_token(): void
    {
        $donation = $this->newDonation(['donor_name' => 'Donatur Token']);

        $this->get('/donasi/' . $donation->public_token)
            ->assertStatus(200)
            ->assertSee('Donatur Token');
    }

    public function test_valid_image_proof_can_be_uploaded_while_pending(): void
    {
        $donation = $this->newDonation();

        $this->post('/donasi/' . $donation->public_token . '/upload-bukti', [
            'proof_image' => UploadedFile::fake()->image('bukti.jpg', 400, 400)->size(500),
            'transfer_date' => now()->toDateString(),
        ])->assertSessionHasNoErrors();

        $donation->refresh();
        $this->assertNotNull($donation->proof_image);
        Storage::disk('public')->assertExists($donation->proof_image);
    }

    public function test_non_image_files_are_rejected_as_proof(): void
    {
        $donation = $this->newDonation();

        foreach (['shell.php', 'dokumen.pdf', 'vektor.svg'] as $name) {
            $this->post('/donasi/' . $donation->public_token . '/upload-bukti', [
                'proof_image' => UploadedFile::fake()->createWithContent($name, '<?php echo 1;'),
                'transfer_date' => now()->toDateString(),
            ])->assertSessionHasErrors('proof_image');
        }

        $this->assertNull($donation->fresh()->proof_image);
    }

    public function test_oversized_proof_is_rejected(): void
    {
        $donation = $this->newDonation();

        $this->post('/donasi/' . $donation->public_token . '/upload-bukti', [
            'proof_image' => UploadedFile::fake()->image('besar.jpg')->size(4000),
            'transfer_date' => now()->toDateString(),
        ])->assertSessionHasErrors('proof_image');
    }

    public function test_proof_cannot_be_replaced_after_donation_is_processed(): void
    {
        foreach (['confirmed', 'rejected'] as $status) {
            $donation = $this->newDonation(['status' => $status, 'proof_image' => 'donations/asli.jpg']);

            $this->post('/donasi/' . $donation->public_token . '/upload-bukti', [
                'proof_image' => UploadedFile::fake()->image('pengganti.jpg'),
                'transfer_date' => now()->toDateString(),
            ])->assertSessionHas('error');

            $this->assertSame('donations/asli.jpg', $donation->fresh()->proof_image);
        }
    }

    public function test_seeder_does_not_use_the_default_password_outside_local(): void
    {
        User::whereIn('email', ['admin@nu.or.id', 'pengurus@nu.or.id'])->delete();
        $this->app['env'] = 'production';

        $this->artisan('db:seed', ['--class' => DatabaseSeeder::class, '--force' => true])->assertExitCode(0);

        foreach (['admin@nu.or.id', 'pengurus@nu.or.id'] as $email) {
            $user = User::where('email', $email)->firstOrFail();
            $this->assertFalse(Hash::check('password', $user->password), "$email masih memakai password bawaan");
        }
    }

    public function test_seeder_keeps_the_simple_password_in_local_environment(): void
    {
        $admin = User::where('email', 'admin@nu.or.id')->firstOrFail();

        $this->assertTrue(Hash::check('password', $admin->password));
    }
}
