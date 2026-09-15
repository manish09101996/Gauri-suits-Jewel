<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));
        $products = collect();
        $recommendedProducts = collect();

        if ($q !== '') {
            $products = Product::published()
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('sku', 'like', "%{$q}%")
                        ->orWhere('fabric', 'like', "%{$q}%")
                        ->orWhere('work', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhereHas('category', function ($cq) use ($q) {
                            $cq->where('name', 'like', "%{$q}%");
                        });
                })
                ->with(['images', 'variants', 'category'])
                ->paginate(16)
                ->withQueryString();
        }

        // If no results, show recommended items
        if ($products->isEmpty()) {
            $recommendedProducts = Product::published()
                ->featured()
                ->with(['images', 'category'])
                ->limit(4)
                ->get();
        }

        $featuredCategories = Category::active()->whereNull('parent_id')->limit(4)->get();

        return view('storefront.search', compact('products', 'q', 'recommendedProducts', 'featuredCategories'));
    }

    public function suggestions(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json(['products' => [], 'categories' => []]);
        }

        $products = Product::published()
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('fabric', 'like', "%{$q}%")
                    ->orWhere('work', 'like', "%{$q}%");
            })
            ->with(['images', 'category'])
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->effective_price,
                    'image' => $product->primary_image_url,
                    'category' => $product->category->name,
                    'url' => route('product.show', $product->slug),
                ];
            });

        $categories = Category::active()
            ->where('name', 'like', "%{$q}%")
            ->limit(3)
            ->get()
            ->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'url' => route('shop.category', $cat->slug),
                ];
            });

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
