<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Video;
use App\Models\Reel;
use App\Models\Review;
use App\Models\HomepageSection;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Hero Banners
        $heroBanners = Banner::where('type', 'hero')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // 2. Featured Category cards ("Adorn Every Part of You")
        $featuredCategories = Category::active()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        if ($featuredCategories->isEmpty()) {
            $featuredCategories = Category::active()
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->limit(8)
                ->get();
        }

        // 3. Featured Products ("Crafted for Every Celebration")
        $featuredProducts = Product::published()
            ->featured()
            ->with(['images', 'variants', 'category'])
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::published()
                ->with(['images', 'variants', 'category'])
                ->orderBy('id', 'desc')
                ->limit(8)
                ->get();
        }

        // 4. Best Sellers ("Most Loved by You") - calculated dynamically from order_items
        $topProductIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as qty'))
            ->groupBy('product_id')
            ->orderByDesc('qty')
            ->limit(8)
            ->pluck('product_id');

        if ($topProductIds->isNotEmpty()) {
            $bestSellers = Product::published()
                ->whereIn('id', $topProductIds)
                ->with(['images', 'variants', 'category'])
                ->get()
                ->sortBy(function ($product) use ($topProductIds) {
                    return array_search($product->id, $topProductIds->toArray());
                })
                ->values();
        } else {
            // Fallback to products marked as is_best_seller or newest
            $bestSellers = Product::published()
                ->where('is_best_seller', true)
                ->with(['images', 'variants', 'category'])
                ->limit(8)
                ->get();

            if ($bestSellers->isEmpty()) {
                $bestSellers = Product::published()
                    ->with(['images', 'variants', 'category'])
                    ->latest()
                    ->limit(8)
                    ->get();
            }
        }

        // 5. Jewellery Category Showcase
        $jewelleryCategory = Category::where('slug', 'jewellery')
            ->orWhere('name', 'like', '%jewel%')
            ->first();

        $jewelleryProducts = collect();
        if ($jewelleryCategory) {
            $categoryIds = Category::where('parent_id', $jewelleryCategory->id)
                ->pluck('id')
                ->push($jewelleryCategory->id);

            $jewelleryProducts = Product::published()
                ->whereIn('category_id', $categoryIds)
                ->with(['images', 'variants', 'category'])
                ->limit(8)
                ->get();
        }

        // 6. Cinematic Video Section
        $featuredVideo = Video::where('is_active', true)->orderBy('sort_order')->first();

        // 7. Reels / Instagram Visuals
        $reels = Reel::where('is_active', true)
            ->with('product')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        // 8. Approved Customer Reviews
        $reviews = Review::approved()
            ->with(['product.images'])
            ->latest('approved_at')
            ->limit(6)
            ->get();

        // 9. Sections config from CMS
        $sections = HomepageSection::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('key');

        return view('storefront.home', compact(
            'heroBanners',
            'featuredCategories',
            'featuredProducts',
            'bestSellers',
            'jewelleryProducts',
            'featuredVideo',
            'reels',
            'reviews',
            'sections'
        ));
    }
}
