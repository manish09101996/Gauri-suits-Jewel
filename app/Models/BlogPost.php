<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    protected $fillable = [
        'admin_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'tags',
        'author_name',
        'status',
        'published_at',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            if (str_starts_with($this->featured_image, 'http')) {
                return $this->featured_image;
            }
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/blog-placeholder.jpg');
    }
}
