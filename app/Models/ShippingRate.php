<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingRate extends Model
{
    protected $fillable = [
        'zone_id',
        'name',
        'min_order_amount',
        'max_order_amount',
        'rate',
        'estimated_days',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'min_order_amount' => 'decimal:2',
            'max_order_amount' => 'decimal:2',
            'rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class, 'zone_id');
    }
}
