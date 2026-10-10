<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

#[Signature('donations:cleanup-pending')]
#[Description('Hapus donasi pending yang lebih dari 7 hari dan tidak memiliki bukti transfer')]
class CleanupPendingDonations extends Command
{
    public function handle(): int
    {
        $days = 7;
        $cutoffDate = now()->subDays($days);

        $donations = Donation::where('status', 'pending')
            ->where('created_at', '<', $cutoffDate)
            ->whereNull('proof_image')
            ->get();

        $count = $donations->count();

        if ($count === 0) {
            $this->info("Tidak ada donasi pending lama yang perlu dibersihkan.");
            return Command::SUCCESS;
        }

        $this->info("Menghapus {$count} donasi pending lebih dari {$days} hari tanpa bukti transfer...");

        foreach ($donations as $donation) {
            // Log sebelum dihapus
            Log::info("Cleaning up pending donation", [
                'transaction_code' => $donation->transaction_code,
                'donor_name' => $donation->donor_name,
                'created_at' => $donation->created_at,
            ]);

            $donation->delete();
        }

        $this->info("Berhasil menghapus {$count} donasi pending lama.");
        return Command::SUCCESS;
    }
}
