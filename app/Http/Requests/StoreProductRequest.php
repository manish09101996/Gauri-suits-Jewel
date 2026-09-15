<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|lt:price|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'fabric' => 'nullable|string|max:100',
            'colour' => 'nullable|string|max:100',
            'pattern' => 'nullable|string|max:100',
            'work' => 'nullable|string|max:100',
            'occasion' => 'nullable|string|max:100',
            'care_instructions' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'is_best_seller' => 'boolean',
            'is_new' => 'boolean',
            'is_sale' => 'boolean',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:5120',
            'variants' => 'nullable|array',
            'variants.*.sku' => 'required_with:variants|string|max:100',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.colour' => 'nullable|string|max:50',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.sale_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
        ];
    }
}
