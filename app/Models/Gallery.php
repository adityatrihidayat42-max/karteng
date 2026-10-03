<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image',
        'event_date',
        'created_by',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    // Relationships
    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        // Use first image as cover if available
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return asset('storage/' . $firstImage->image);
        }
        return asset('images/gallery-default.jpg');
    }

    public function getImagesCountAttribute(): int
    {
        return $this->images()->count();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderByDesc('event_date');
    }

    // Route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
