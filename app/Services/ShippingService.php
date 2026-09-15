<?php

namespace App\Services;

use App\Models\ShippingZone;
use App\Models\ShippingRate;
use App\Models\Setting;

class ShippingService
{
    /**
     * Calculate shipping charge based on state, order subtotal, and method.
     */
    public function calculateShipping(string $state, float $subtotal, string $paymentMethod = 'online'): array
    {
        // 1. Check if free shipping threshold is met
        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 2999);
        $flatShippingRate = (float) Setting::get('flat_shipping_rate', 150);

        if ($freeShippingThreshold > 0 && $subtotal >= $freeShippingThreshold) {
            $shippingCost = 0.0;
            $rateName = 'Free Express Shipping';
            $estimatedDays = '3-5 Business Days';
        } else {
            // 2. Look up matching zone
            $zone = $this->findZoneByState($state);

            if ($zone) {
                $rate = ShippingRate::where('zone_id', $zone->id)
                    ->where('is_active', true)
                    ->where('min_order_amount', '<=', $subtotal)
                    ->where(function ($q) use ($subtotal) {
                        $q->whereNull('max_order_amount')
                            ->orWhere('max_order_amount', '>=', $subtotal);
                    })
                    ->orderBy('rate', 'asc')
                    ->first();

                if ($rate) {
                    $shippingCost = (float) $rate->rate;
                    $rateName = $rate->name;
                    $estimatedDays = $rate->estimated_days ?: '3-5 Business Days';
                } else {
                    $shippingCost = $flatShippingRate;
                    $rateName = 'Standard Shipping';
                    $estimatedDays = '4-7 Business Days';
                }
            } else {
                $shippingCost = $flatShippingRate;
                $rateName = 'Standard Shipping';
                $estimatedDays = '4-7 Business Days';
            }
        }

        // 3. COD Fee if applicable
        $codFee = 0.0;
        if (strtolower($paymentMethod) === 'cod') {
            $codFee = (float) Setting::get('cod_extra_fee', 0);
        }

        $totalShipping = round($shippingCost + $codFee, 2);

        return [
            'shipping_amount' => $shippingCost,
            'cod_fee' => $codFee,
            'total_shipping' => $totalShipping,
            'rate_name' => $rateName,
            'estimated_days' => $estimatedDays,
            'is_free' => ($shippingCost === 0.0),
        ];
    }

    public function isCodAvailable(float $subtotal): bool
    {
        $codEnabled = filter_var(Setting::get('cod_enabled', true), FILTER_VALIDATE_BOOLEAN);
        if (!$codEnabled) {
            return false;
        }

        $minAmount = (float) Setting::get('cod_min_order', 0);
        $maxAmount = (float) Setting::get('cod_max_order', 25000);

        if ($subtotal < $minAmount) {
            return false;
        }

        if ($maxAmount > 0 && $subtotal > $maxAmount) {
            return false;
        }

        return true;
    }

    protected function findZoneByState(string $state): ?ShippingZone
    {
        $state = trim(strtolower($state));
        $zones = ShippingZone::where('is_active', true)->get();

        foreach ($zones as $zone) {
            $states = $zone->states;
            if (is_array($states)) {
                $statesLower = array_map('strtolower', $states);
                if (in_array($state, $statesLower)) {
                    return $zone;
                }
            }
        }

        return null;
    }
}
