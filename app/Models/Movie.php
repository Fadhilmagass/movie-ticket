<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'synopsis',
        'duration',
        'genre',
        'rating',
        'poster',
        'trailer_url',
        'release_date',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($movie) {
            $movie->slug = self::createUniqueSlug($movie->title);
        });

        static::updating(function ($movie) {
            if ($movie->isDirty('title')) {
                $movie->slug = self::createUniqueSlug($movie->title, $movie->id);
            }
        });
    }

    private static function createUniqueSlug($title, $id = 0)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        $count = 1;
        while (Movie::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
