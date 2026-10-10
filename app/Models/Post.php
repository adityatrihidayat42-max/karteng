<?php

namespace App\Models;

use App\Models\Traits\HasUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasUniqueSlug;

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'views',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views'        => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if ($model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
        });
        static::updating(function ($model) {
            if ($model->status === 'published' && empty($model->published_at)) {
                $model->published_at = now();
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Accessors
    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/post-default.svg');
    }

    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, (int) ceil($wordCount / 200));
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now())
                     ->orderByDesc('published_at');
    }

    public function scopePopular($query)
    {
        return $query->where('status', 'published')->orderByDesc('views');
    }

    // Route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Increment views
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
