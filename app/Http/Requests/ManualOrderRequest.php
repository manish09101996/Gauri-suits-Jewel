<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManualOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'nullable|string|max:100',
            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|in:pending,paid',
            'status' => 'required|in:pending,confirmed,processing,packed,shipped,delivered',
            'discount_amount' => 'nullable|numeric|min:0',
            'shipping_amount' => 'nullable|numeric|min:0',
            'shipping_carrier' => 'nullable|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.name' => 'required|string|max:255',
            'items.*.sku' => 'nullable|string|max:100',
            'items.*.variant_title' => 'nullable|string|max:100',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
