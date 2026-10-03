<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'donor_name',
        'phone',
        'email',
        'amount',
        'donation_type',
        'payment_method',
        'bank_name',
        'transfer_date',
        'proof_image',
        'notes',
        'status',
        'confirmed_at',
        'confirmed_by',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'transfer_date' => 'date',
        'confirmed_at' => 'datetime',
    ];

    // Relationships
    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    // Generate transaction code
    public static function generateTransactionCode(): string
    {
        $prefix = 'INF';
        $date = date('Ymd');
        $last = static::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    // Accessors
    public function getAmountFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getDonationTypeLabelAttribute(): string
    {
        return match ($this->donation_type) {
            'infaq'           => 'Infaq',
            'sedekah'         => 'Sedekah',
            'donasi_kegiatan' => 'Donasi Kegiatan',
            'donasi_umum'     => 'Donasi Umum',
            'lainnya'         => 'Lainnya',
            default           => $this->donation_type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'rejected'  => 'Ditolak',
            default     => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'yellow',
            'confirmed' => 'green',
            'rejected'  => 'red',
            default     => 'gray',
        };
    }

    public function getProofImageUrlAttribute(): ?string
    {
        return $this->proof_image ? asset('storage/' . $this->proof_image) : null;
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }
}
