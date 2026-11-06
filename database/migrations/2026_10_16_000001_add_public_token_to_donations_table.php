<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Token acak untuk alamat publik donasi (/donasi/{token}).
     * transaction_code berurutan sehingga mudah ditebak; token ini tidak.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('public_token', 64)->nullable()->after('transaction_code');
        });

        // Isi token untuk donasi yang sudah ada
        foreach (DB::table('donations')->whereNull('public_token')->pluck('id') as $id) {
            DB::table('donations')->where('id', $id)->update([
                'public_token' => bin2hex(random_bytes(20)),
            ]);
        }

        Schema::table('donations', function (Blueprint $table) {
            $table->unique('public_token');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropUnique(['public_token']);
            $table->dropColumn('public_token');
        });
    }
};
