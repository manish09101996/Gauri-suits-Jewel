<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'states',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'states' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function rates(): HasMany
    {
        return $this->hasMany(ShippingRate::class, 'zone_id')->where('is_active', true);
    }
}
