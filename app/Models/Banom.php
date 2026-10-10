<?php

namespace App\Models;

use App\Models\Traits\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banom extends Model
{
    use HasFactory, HasUniqueSlug;

    protected $fillable = [
        'nama',
        'slug',
        'singkatan',
        'deskripsi',
        'logo',
        'foto',
        'ketua',
        'kontak',
        'alamat',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Get the source column to generate slug from.
     */
    public function getSlugSourceColumn(): string
    {
        return 'nama';
    }

    // Relationships
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    // Accessors
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/banom-default.svg');
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/banom-default.svg');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('sort_order');
    }

    // Route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
