<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::published()
            ->where('slug', $slug)
            ->with([
                'images',
                'variants' => function ($q) {
                    $q->where('status', true);
                },
                'category.parent',
                'approvedReviews.user'
            ])
            ->firstOrFail();

        // Track recently viewed products in session
        $recentIds = Session::get('recently_viewed', []);
        $recentIds = array_diff($recentIds, [$product->id]);
        array_unshift($recentIds, $product->id);
        $recentIds = array_slice($recentIds, 0, 8);
        Session::put('recently_viewed', $recentIds);

        // Fetch recently viewed models
        $recentlyViewed = Product::published()
            ->whereIn('id', array_slice($recentIds, 1, 4))
            ->with(['images', 'category'])
            ->get();

        // Related products in same category
        $relatedProducts = Product::published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images', 'category'])
            ->limit(4)
            ->get();

        // WhatsApp inquiry link
        $whatsappNumber = Setting::get('whatsapp_number', '+919984700018');
        $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
        $productUrl = route('product.show', $product->slug);
        $whatsappMessage = urlencode("Hello Gauri Suits & Jewel, I would like to enquire about {$product->name} (SKU: {$product->sku}) - {$productUrl}");
        $whatsappUrl = "https://wa.me/{$cleanNumber}?text={$whatsappMessage}";

        return view('storefront.product', compact(
            'product',
            'relatedProducts',
            'recentlyViewed',
            'whatsappUrl'
        ));
    }

    public function quickView(int $id)
    {
        $product = Product::published()
            ->with(['images', 'variants', 'category'])
            ->findOrFail($id);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'price' => (float) $product->price,
            'sale_price' => $product->sale_price ? (float) $product->sale_price : null,
            'effective_price' => $product->effective_price,
            'discount_percent' => $product->discount_percent,
            'stock' => $product->stock,
            'short_description' => $product->short_description ?: substr(strip_tags($product->description), 0, 160) . '...',
            'category_name' => $product->category->name,
            'primary_image' => $product->primary_image_url,
            'images' => $product->images->map(fn($img) => $img->url)->toArray(),
            'variants' => $product->variants->map(fn($v) => [
                'id' => $v->id,
                'sku' => $v->sku,
                'size' => $v->size,
                'colour' => $v->colour,
                'price' => $v->effective_price,
                'stock' => $v->stock,
            ])->toArray(),
            'url' => route('product.show', $product->slug),
        ]);
    }
}
