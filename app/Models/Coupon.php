<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'usage_limit' => 'integer',
            'usage_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValidForAmount(float $amount): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        if ($this->usage_limit !== null && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_order_amount > 0 && $amount < (float) $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if (!$this->isValidForAmount($subtotal)) {
            return 0.0;
        }

        $discount = 0.0;
        if ($this->type === 'percentage') {
            $discount = ($subtotal * (float) $this->value) / 100.0;
            if ($this->max_discount_amount && $discount > (float) $this->max_discount_amount) {
                $discount = (float) $this->max_discount_amount;
            }
        } else {
            $discount = min((float) $this->value, $subtotal);
        }

        return round($discount, 2);
    }
}
