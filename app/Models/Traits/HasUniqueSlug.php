<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait HasUniqueSlug
{
    /**
     * Generate a unique slug for the model.
     */
    protected static function generateUniqueSlug(string $source, string $slugColumn = 'slug', array $extraConditions = []): string
    {
        $baseSlug = Str::slug($source);
        
        if (empty($baseSlug)) {
            $baseSlug = 'item';
        }

        return DB::transaction(function () use ($baseSlug, $slugColumn, $extraConditions) {
            $model = new static();
            $table = $model->getTable();
            
            // Lock the table to prevent race conditions
            $latest = DB::table($table)
                ->where($slugColumn, 'like', $baseSlug . '%')
                ->where(function ($query) use ($extraConditions) {
                    foreach ($extraConditions as $col => $val) {
                        $query->where($col, $val);
                    }
                })
                ->lockForUpdate()
                ->orderByDesc('id')
                ->first([$slugColumn]);

            $slug = $baseSlug;
            $counter = 1;

            if ($latest) {
                // Check if the latest slug matches our base pattern
                if (preg_match('/^' . preg_quote($baseSlug, '/') . '-(\d+)$/', $latest->{$slugColumn}, $matches)) {
                    $counter = intval($matches[1]) + 1;
                } elseif ($latest->{$slugColumn} === $baseSlug) {
                    $counter = 2;
                }
            }

            // Find next available slug
            while (true) {
                $testSlug = $counter === 1 ? $baseSlug : $baseSlug . '-' . $counter;
                
                $exists = DB::table($table)
                    ->where($slugColumn, $testSlug)
                    ->where(function ($query) use ($extraConditions) {
                        foreach ($extraConditions as $col => $val) {
                            $query->where($col, $val);
                        }
                    })
                    ->exists();

                if (!$exists) {
                    $slug = $testSlug;
                    break;
                }
                $counter++;
            }

            return $slug;
        });
    }

    /**
     * Boot the trait - automatically generate unique slug on creating.
     */
    protected static function bootHasUniqueSlug()
    {
        static::creating(function ($model) {
            $slugColumn = $model->getSlugColumn();
            $sourceColumn = $model->getSlugSourceColumn();
            
            if (empty($model->{$slugColumn}) && !empty($model->{$sourceColumn})) {
                $extraConditions = $model->getSlugExtraConditions() ?? [];
                $model->{$slugColumn} = static::generateUniqueSlug(
                    $model->{$sourceColumn}, 
                    $slugColumn, 
                    $extraConditions
                );
            }
        });

        static::updating(function ($model) {
            $slugColumn = $model->getSlugColumn();
            $sourceColumn = $model->getSlugSourceColumn();
            
            if ($model->isDirty($sourceColumn) && empty($model->{$slugColumn})) {
                $extraConditions = $model->getSlugExtraConditions() ?? [];
                $model->{$slugColumn} = static::generateUniqueSlug(
                    $model->{$sourceColumn}, 
                    $slugColumn, 
                    $extraConditions
                );
            }
        });
    }

    /**
     * Get the column name used for slug.
     * Override in model if different.
     */
    public function getSlugColumn(): string
    {
        return 'slug';
    }

    /**
     * Get the source column to generate slug from.
     * Override in model if different.
     */
    public function getSlugSourceColumn(): string
    {
        return 'title';
    }

    /**
     * Get extra conditions for slug uniqueness check.
     * Useful for scoped uniqueness (e.g., per category).
     * Override in model if needed.
     *
     * @return array<string, mixed>
     */
    public function getSlugExtraConditions(): array
    {
        return [];
    }
}