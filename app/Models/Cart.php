<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'coupon_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    public function getDiscountAttribute(): float
    {
        if ($this->coupon && $this->coupon->isValidForAmount($this->subtotal)) {
            return $this->coupon->calculateDiscount($this->subtotal);
        }
        return 0.0;
    }

    public function getTotalItemsAttribute(): int
    {
        return (int) $this->items->sum('quantity');
    }
}
