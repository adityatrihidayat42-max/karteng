<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nia')->unique()->nullable(); // Nomor Induk Anggota
            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique()->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->foreignId('banom_id')->nullable()->constrained('banoms')->nullOnDelete();
            $table->string('jabatan')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif', 'menunggu_verifikasi'])->default('menunggu_verifikasi');
            $table->date('tanggal_bergabung')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('tampil_publik')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['status', 'banom_id']);
            $table->index('nama_lengkap');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
