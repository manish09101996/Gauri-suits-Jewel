<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Collection;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images', 'variants'])->latest();

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('sku', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('stock_status')) {
            if ($request->input('stock_status') === 'low') {
                $query->whereColumn('stock', '<=', 'low_stock_threshold');
            } elseif ($request->input('stock_status') === 'out') {
                $query->where('stock', '<=', 0);
            }
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->whereNull('parent_id')->with('children')->get();
        $collections = Collection::active()->get();

        return view('admin.products.create', compact('categories', 'collections'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . strtolower(Str::random(4));
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_best_seller'] = $request->boolean('is_best_seller');
        $data['is_new'] = $request->boolean('is_new');
        $data['is_sale'] = $request->boolean('is_sale') || (!empty($data['sale_price']) && $data['sale_price'] < $data['price']);

        $product = DB::transaction(function () use ($data, $request) {
            $product = Product::create($data);

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $index,
                        'is_primary' => ($index === 0),
                    ]);
                }
            }

            // Handle variants
            if (!empty($data['variants'])) {
                foreach ($data['variants'] as $variantData) {
                    if (!empty($variantData['sku'])) {
                        $product->variants()->create([
                            'sku' => $variantData['sku'],
                            'size' => $variantData['size'] ?? null,
                            'colour' => $variantData['colour'] ?? null,
                            'price' => $variantData['price'] ?? $product->price,
                            'sale_price' => $variantData['sale_price'] ?? null,
                            'stock' => $variantData['stock'] ?? 0,
                            'status' => true,
                        ]);
                    }
                }
            }

            // Sync collections
            if ($request->has('collections')) {
                $product->collections()->sync($request->input('collections'));
            }

            return $product;
        });

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' created successfully.");
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'variants', 'collections']);
        $categories = Category::active()->whereNull('parent_id')->with('children')->get();
        $collections = Collection::active()->get();

        return view('admin.products.edit', compact('product', 'categories', 'collections'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_best_seller'] = $request->boolean('is_best_seller');
        $data['is_new'] = $request->boolean('is_new');
        $data['is_sale'] = $request->boolean('is_sale') || (!empty($data['sale_price']) && $data['sale_price'] < $data['price']);

        DB::transaction(function () use ($product, $data, $request) {
            $product->update($data);

            // Handle new uploaded images
            if ($request->hasFile('images')) {
                $currentMaxOrder = $product->images()->max('sort_order') ?? -1;
                $hasPrimary = $product->images()->where('is_primary', true)->exists();

                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $currentMaxOrder + 1 + $index,
                        'is_primary' => (!$hasPrimary && $index === 0),
                    ]);
                }
            }

            // Update variants
            if ($request->has('variants')) {
                $submittedVariantIds = [];
                foreach ($request->input('variants') as $vData) {
                    if (!empty($vData['sku'])) {
                        if (!empty($vData['id'])) {
                            $variant = ProductVariant::where('product_id', $product->id)->find($vData['id']);
                            if ($variant) {
                                $variant->update([
                                    'sku' => $vData['sku'],
                                    'size' => $vData['size'] ?? null,
                                    'colour' => $vData['colour'] ?? null,
                                    'price' => $vData['price'] ?? $product->price,
                                    'sale_price' => $vData['sale_price'] ?? null,
                                    'stock' => $vData['stock'] ?? 0,
                                ]);
                                $submittedVariantIds[] = $variant->id;
                            }
                        } else {
                            $newVariant = $product->variants()->create([
                                'sku' => $vData['sku'],
                                'size' => $vData['size'] ?? null,
                                'colour' => $vData['colour'] ?? null,
                                'price' => $vData['price'] ?? $product->price,
                                'sale_price' => $vData['sale_price'] ?? null,
                                'stock' => $vData['stock'] ?? 0,
                                'status' => true,
                            ]);
                            $submittedVariantIds[] = $newVariant->id;
                        }
                    }
                }

                // Delete variants removed by admin
                if (!empty($submittedVariantIds)) {
                    $product->variants()->whereNotIn('id', $submittedVariantIds)->delete();
                }
            }

            // Sync collections
            if ($request->has('collections')) {
                $product->collections()->sync($request->input('collections'));
            } else {
                $product->collections()->detach();
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' updated successfully.");
    }

    public function duplicate(Product $product)
    {
        $newProduct = DB::transaction(function () use ($product) {
            $clone = $product->replicate(['slug', 'sku']);
            $clone->name = $product->name . ' (Copy)';
            $clone->slug = Str::slug($clone->name) . '-' . strtolower(Str::random(4));
            $clone->sku = $product->sku . '-COPY';
            $clone->status = 'draft';
            $clone->save();

            // Clone images
            foreach ($product->images as $image) {
                ProductImage::create([
                    'product_id' => $clone->id,
                    'image_path' => $image->image_path,
                    'alt_text' => $image->alt_text,
                    'sort_order' => $image->sort_order,
                    'is_primary' => $image->is_primary,
                ]);
            }

            // Clone variants
            foreach ($product->variants as $variant) {
                ProductVariant::create([
                    'product_id' => $clone->id,
                    'sku' => $variant->sku . '-COPY',
                    'size' => $variant->size,
                    'colour' => $variant->colour,
                    'price' => $variant->price,
                    'sale_price' => $variant->sale_price,
                    'stock' => $variant->stock,
                    'status' => $variant->status,
                ]);
            }

            return $clone;
        });

        return redirect()->route('admin.products.edit', $newProduct->id)
            ->with('success', 'Product duplicated as draft.');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$name}' deleted.");
    }

    public function deleteImage(int $imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        if (!str_starts_with($image->image_path, 'http')) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function setPrimaryImage(int $imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return response()->json(['success' => true]);
    }
}
