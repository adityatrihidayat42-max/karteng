<?php

namespace App\Jobs;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDonationConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;

    public function __construct(
        public readonly int $donationId
    ) {}

    public function handle(): void
    {
        $donation = Donation::with('confirmedBy')->find($this->donationId);

        if (!$donation) {
            Log::warning("Donation #{$this->donationId} not found for email confirmation");
            return;
        }

        if ($donation->status !== 'confirmed') {
            Log::info("Donation #{$this->donationId} not confirmed yet, skipping email");
            return;
        }

        // Kirim email ke donatur
        if ($donation->email) {
            try {
                Mail::to($donation->email)->send(new \App\Mail\DonationConfirmed($donation));
                Log::info("Donation confirmation email sent to {$donation->email} for transaction {$donation->transaction_code}");
            } catch (\Exception $e) {
                Log::error("Failed to send donation confirmation email: " . $e->getMessage());
                throw $e; // Re-throw untuk retry
            }
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("SendDonationConfirmationEmail failed for donation #{$this->donationId}: " . $exception->getMessage());
    }
}
