<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banom extends Model
{
    use HasFactory;

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

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
        static::updating(function ($model) {
            if ($model->isDirty('nama') && empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
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
        return asset('images/banom-default.png');
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/banom-default.png');
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
