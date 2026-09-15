<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request, ?string $categorySlug = null, ?string $collectionSlug = null)
    {
        $query = Product::published()->with(['images', 'variants', 'category']);

        $pageTitle = 'The Royal Collection';
        $pageDescription = 'Explore handcrafted Punjabi suits, designer ensembles and heritage jewellery woven with tradition.';
        $currentCategory = null;
        $currentCollection = null;

        // Route presets based on current route path
        $path = trim($request->path(), '/');

        if ($path === 'new-arrivals') {
            $query->where('is_new', true);
            $pageTitle = 'New Arrivals';
            $pageDescription = 'Discover the latest additions to our heirloom ethnic collection.';
        } elseif ($path === 'best-sellers') {
            $pageTitle = 'Best Sellers';
            $pageDescription = 'The most admired and celebrated designs of Gauri Suits & Jewel.';
            $topProductIds = OrderItem::select('product_id', DB::raw('SUM(quantity) as qty'))
                ->groupBy('product_id')
                ->orderByDesc('qty')
                ->pluck('product_id');
            if ($topProductIds->isNotEmpty()) {
                $query->whereIn('id', $topProductIds);
            } else {
                $query->where('is_best_seller', true);
            }
        } elseif ($path === 'sale') {
            $query->where(function ($q) {
                $q->where('is_sale', true)
                    ->orWhereNotNull('sale_price');
            });
            $pageTitle = 'Exclusive Sale';
            $pageDescription = 'Limited-time celebratory pricing on select handcrafted pieces.';
        } elseif (in_array($path, ['suits', 'punjabi-suits', 'designer-suits', 'party-wear', 'wedding-collection', 'bridal-collection', 'jewellery', 'accessories'])) {
            $slugToLookup = match ($path) {
                'suits' => 'punjabi-suits',
                'wedding-collection' => 'wedding',
                'bridal-collection' => 'bridal',
                default => $path,
            };

            $matchedCategory = Category::where('slug', $slugToLookup)
                ->orWhere('slug', $path)
                ->orWhere('name', 'like', "%{$path}%")
                ->first();

            if ($matchedCategory) {
                $currentCategory = $matchedCategory;
                $catIds = Category::where('parent_id', $matchedCategory->id)
                    ->pluck('id')
                    ->push($matchedCategory->id);
                $query->whereIn('category_id', $catIds);
                $pageTitle = $matchedCategory->name;
                $pageDescription = $matchedCategory->description ?: "Curated {$matchedCategory->name} collection by Gauri Suits & Jewel.";
            } else {
                // Check in collections
                $matchedCollection = Collection::where('slug', $path)->orWhere('slug', $slugToLookup)->first();
                if ($matchedCollection) {
                    $currentCollection = $matchedCollection;
                    $query->whereHas('collections', function ($q) use ($matchedCollection) {
                        $q->where('collections.id', $matchedCollection->id);
                    });
                    $pageTitle = $matchedCollection->name;
                    $pageDescription = $matchedCollection->description ?: "Curated {$matchedCollection->name} by Gauri Suits & Jewel.";
                }
            }
        }

        // Category filter from query string
        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $category = Category::where('slug', $catSlug)->first();
            if ($category) {
                $currentCategory = $category;
                $catIds = Category::where('parent_id', $category->id)->pluck('id')->push($category->id);
                $query->whereIn('category_id', $catIds);
                $pageTitle = $category->name;
            }
        }

        // Collection filter
        if ($request->filled('collection')) {
            $colSlug = $request->input('collection');
            $collection = Collection::where('slug', $colSlug)->first();
            if ($collection) {
                $currentCollection = $collection;
                $query->whereHas('collections', function ($q) use ($collection) {
                    $q->where('collections.id', $collection->id);
                });
            }
        }

        // Price Filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        // Fabric filter
        if ($request->filled('fabric')) {
            $query->where('fabric', $request->input('fabric'));
        }

        // Colour filter
        if ($request->filled('colour')) {
            $colour = $request->input('colour');
            $query->where(function ($q) use ($colour) {
                $q->where('colour', $colour)
                    ->orWhereHas('variants', function ($vq) use ($colour) {
                        $vq->where('colour', $colour);
                    });
            });
        }

        // Size filter
        if ($request->filled('size')) {
            $size = $request->input('size');
            $query->whereHas('variants', function ($vq) use ($size) {
                $vq->where('size', $size);
            });
        }

        // Occasion filter
        if ($request->filled('occasion')) {
            $query->where('occasion', $request->input('occasion'));
        }

        // Stock availability filter
        if ($request->filled('in_stock') && $request->input('in_stock') == '1') {
            $query->where('stock', '>', 0);
        }

        // Discount filter
        if ($request->filled('discount')) {
            $minDiscount = (int) $request->input('discount');
            $query->whereRaw('ROUND(((price - sale_price) / price) * 100) >= ?', [$minDiscount]);
        }

        // Sorting
        $sort = $request->input('sort', 'featured');
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'best_selling':
                $query->orderBy('is_best_seller', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'featured':
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(16)->withQueryString();

        // Available filter options for sidebar
        $allCategories = Category::active()->whereNull('parent_id')->with('children')->get();
        $allCollections = Collection::active()->get();
        $fabrics = Product::published()->whereNotNull('fabric')->distinct()->pluck('fabric')->filter()->values();
        $colours = Product::published()->whereNotNull('colour')->distinct()->pluck('colour')->filter()->values();
        $occasions = Product::published()->whereNotNull('occasion')->distinct()->pluck('occasion')->filter()->values();
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'Custom Stitch'];

        return view('storefront.shop', compact(
            'products',
            'pageTitle',
            'pageDescription',
            'currentCategory',
            'currentCollection',
            'allCategories',
            'allCollections',
            'fabrics',
            'colours',
            'occasions',
            'sizes'
        ));
    }
}
