<?php

namespace App\Models;

use App\Models\Traits\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory, HasUniqueSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'start_at',
        'end_at',
        'image',
        'organizer',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];

    // Accessors
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/agenda-default.svg');
    }

    public function getIsPastAttribute(): bool
    {
        return $this->start_at->isPast();
    }

    public function getDurationAttribute(): string
    {
        if ($this->end_at) {
            return $this->start_at->format('d M Y') . ' - ' . $this->end_at->format('d M Y');
        }
        return $this->start_at->format('d M Y');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_at', '>=', now())
                     ->where('status', '!=', 'cancelled')
                     ->orderBy('start_at');
    }

    public function scopePast($query)
    {
        return $query->where('start_at', '<', now())->orderByDesc('start_at');
    }

    // Route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
