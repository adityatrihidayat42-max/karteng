<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->string('donor_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('donation_type', ['infaq', 'sedekah', 'donasi_kegiatan', 'donasi_umum', 'lainnya'])->default('donasi_umum');
            $table->string('payment_method')->nullable();
            $table->string('bank_name')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('proof_image')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('status');
            $table->index('transaction_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
