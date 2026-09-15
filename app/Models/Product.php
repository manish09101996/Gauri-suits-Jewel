<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'short_description',
        'price',
        'sale_price',
        'cost_price',
        'category_id',
        'fabric',
        'colour',
        'pattern',
        'work',
        'occasion',
        'care_instructions',
        'weight',
        'stock',
        'low_stock_threshold',
        'status',
        'is_featured',
        'is_best_seller',
        'is_new',
        'is_sale',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'weight' => 'decimal:2',
            'stock' => 'integer',
            'low_stock_threshold' => 'integer',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new' => 'boolean',
            'is_sale' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_product');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    // Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestSeller(Builder $query): Builder
    {
        return $query->where('is_best_seller', true);
    }

    public function scopeNewArrival(Builder $query): Builder
    {
        return $query->where('is_new', true);
    }

    public function scopeOnSale(Builder $query): Builder
    {
        return $query->where('is_sale', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereColumn('stock', '<=', 'low_stock_threshold');
    }

    // Helpers
    public function getBasePriceAttribute(): float
    {
        return (float) $this->price;
    }

    public function getCompareAtPriceAttribute(): ?float
    {
        return ($this->sale_price && $this->sale_price < $this->price) ? (float) $this->price : null;
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) ($this->sale_price && $this->sale_price > 0 && $this->sale_price < $this->price
            ? $this->sale_price
            : $this->price);
    }

    public function getDiscountPercentAttribute(): int
    {
        if ($this->sale_price && $this->price > 0 && $this->sale_price < $this->price) {
            return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->firstWhere('is_primary', true) ?? $this->images->first();
        if ($primary && $primary->image_path) {
            if (str_starts_with($primary->image_path, 'http')) {
                return $primary->image_path;
            }
            return asset('storage/' . $primary->image_path);
        }
        return asset('images/placeholder.jpg');
    }

    public function getSecondaryImageUrlAttribute(): string
    {
        $secondary = $this->images->skip(1)->first();
        if ($secondary && $secondary->image_path) {
            if (str_starts_with($secondary->image_path, 'http')) {
                return $secondary->image_path;
            }
            return asset('storage/' . $secondary->image_path);
        }
        return $this->primary_image_url;
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) round($this->approvedReviews()->avg('rating') ?: 5.0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }
}
