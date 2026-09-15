<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Setting;
use Exception;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService,
        protected ShippingService $shippingService
    ) {}

    public function calculateCheckoutTotals(Cart $cart, string $state, string $paymentMethod = 'online'): array
    {
        if ($cart->items->isEmpty()) {
            throw new Exception('Your cart is empty.');
        }

        $subtotal = $cart->subtotal;
        $discount = $cart->discount;
        $taxableAmount = max(0, $subtotal - $discount);

        $shippingData = $this->shippingService->calculateShipping($state, $taxableAmount, $paymentMethod);
        $shippingAmount = $shippingData['total_shipping'];

        // Tax calculation from Settings
        $taxRate = (float) Setting::get('tax_rate_percent', 0); // e.g. 12% GST on apparel if enabled
        $taxInclusive = filter_var(Setting::get('tax_inclusive', true), FILTER_VALIDATE_BOOLEAN);

        $taxAmount = 0.0;
        if ($taxRate > 0) {
            if ($taxInclusive) {
                // Included in product price: Tax = Amount - (Amount / (1 + Rate))
                $taxAmount = round($taxableAmount - ($taxableAmount / (1 + ($taxRate / 100))), 2);
                $totalAmount = round($taxableAmount + $shippingAmount, 2);
            } else {
                // Added on top
                $taxAmount = round(($taxableAmount * $taxRate) / 100, 2);
                $totalAmount = round($taxableAmount + $taxAmount + $shippingAmount, 2);
            }
        } else {
            $totalAmount = round($taxableAmount + $shippingAmount, 2);
        }

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'coupon_code' => $cart->coupon?->code,
            'shipping' => $shippingAmount,
            'shipping_fee' => $shippingAmount,
            'shipping_data' => $shippingData,
            'tax' => $taxAmount,
            'tax_inclusive' => $taxInclusive,
            'tax_rate' => $taxRate,
            'total' => $totalAmount,
            'grand_total' => $totalAmount,
            'currency' => Setting::get('currency_code', 'INR'),
            'currency_symbol' => Setting::get('currency_symbol', '₹'),
        ];
    }
}
