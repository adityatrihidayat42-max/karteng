<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_organisasi',
        'nama_singkat',
        'tingkat',
        'wilayah',
        'sejarah',
        'visi',
        'misi',
        'tentang',
        'logo',
        'logo_nu',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'facebook',
        'instagram',
        'youtube',
        'whatsapp',
        'periode',
        'tagline',
        'rekening_bank',
        'nama_rekening',
        'nomor_rekening',
        'qris_image',
    ];

    // Singleton: always get or create the first record
    public static function getInstance(): static
    {
        return static::firstOrCreate([], [
            'nama_organisasi' => 'NU Ranting',
            'tagline'         => 'Menegakkan Ajaran Islam Ahlussunah Wal Jamaah',
        ]);
    }

    // Accessors
    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/logo-nu.svg');
    }

    public function getQrisImageUrlAttribute(): ?string
    {
        return $this->qris_image ? asset('storage/' . $this->qris_image) : null;
    }

    public function getAlamatLengkapAttribute(): string
    {
        $parts = array_filter([
            $this->alamat,
            $this->kelurahan,
            $this->kecamatan,
            $this->kabupaten,
            $this->provinsi,
            $this->kode_pos,
        ]);
        return implode(', ', $parts);
    }
}
