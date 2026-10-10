<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nomor_hp',
        'email',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'banom_id',
        'jabatan',
        'status',
        'tanggal_bergabung',
        'foto',
        'tampil_publik',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lahir'    => 'date',
        'tanggal_bergabung' => 'date',
        'tampil_publik'    => 'boolean',
    ];

    // Relationships
    public function banom()
    {
        return $this->belongsTo(Banom::class);
    }

    // Generate NIS (Nomor Induk Santri) - Thread-safe with DB lock
    public static function generateNis(): string
    {
        return DB::transaction(function () {
            // Lock the table for this transaction to prevent race conditions
            $year = date('Y');
            $prefix = 'NIS-' . $year . '-';
            
            // Get the last NIS for this year with lock
            $last = static::where('nis', 'like', $prefix . '%')
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;
            if ($last && preg_match('/NIS-\d{4}-(\d+)/', $last->nis, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $maxId = static::max('id') ?? 0;
                $nextNumber = $maxId + 1;
            }

            $nis = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            
            // Double-check uniqueness within transaction
            while (static::where('nis', $nis)->exists()) {
                $nextNumber++;
                $nis = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }

            return $nis;
        });
    }

    // Alias for compatibility
    public static function generateNia(): string
    {
        return static::generateNis();
    }

    // Accessors
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        $gender = $this->jenis_kelamin === 'P' ? 'women' : 'men';
        return "https://ui-avatars.com/api/?name=" . urlencode($this->nama_lengkap) . "&background=00704A&color=fff";
    }

    public function getAlamatLengkapAttribute(): string
    {
        $parts = array_filter([
            $this->alamat,
            $this->rt ? 'RT ' . $this->rt : null,
            $this->rw ? 'RW ' . $this->rw : null,
            $this->desa_kelurahan,
            $this->kecamatan,
            $this->kabupaten_kota,
            $this->provinsi,
        ]);
        return implode(', ', $parts);
    }

    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif'               => 'Aktif',
            'tidak_aktif'         => 'Tidak Aktif',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            default               => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'aktif'               => 'green',
            'tidak_aktif'         => 'red',
            'menunggu_verifikasi' => 'yellow',
            default               => 'gray',
        };
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu_verifikasi');
    }

    public function scopePublik($query)
    {
        return $query->where('tampil_publik', true)->where('status', 'aktif');
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_lengkap', 'like', "%{$keyword}%")
              ->orWhere('nis', 'like', "%{$keyword}%")
              ->orWhere('jabatan', 'like', "%{$keyword}%");
        });
    }
}
