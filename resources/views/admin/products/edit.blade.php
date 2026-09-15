@extends('layouts.admin')

@section('title', 'Edit ' . $product->name)
@section('header_title', 'Edit Product')
@section('header_subtitle', 'Update specifications, pricing, media, and inventory')

@section('content')
@php
    $variantsJson = json_encode($product->variants->map(function($v) {
        return [
            'id' => $v->id,
            'sku' => $v->sku,
            'size' => $v->size,
            'colour' => $v->colour,
            'price' => $v->price,
            'sale_price' => $v->sale_price,
            'stock' => $v->stock,
        ];
    }));
@endphp

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8"
      x-data="{
          variants: {!! $variantsJson !!},
          addVariant() {
              this.variants.push({ id: null, sku: '{{ $product->sku }}-' + (this.variants.length + 1), size: 'L', colour: '{{ $product->colour ?: "Gold" }}', price: '', sale_price: '', stock: 5 });
          },
          removeVariant(index) {
              this.variants.splice(index, 1);
          },
          async deleteImg(imgId, el) {
              if (!confirm('Permanently delete this image?')) return;
              const res = await fetch('/admin/products/images/' + imgId, {
                  method: 'DELETE',
                  headers: {
                      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                      'Accept': 'application/json'
                  }
              });
              if (res.ok) { el.remove(); }
          },
          async setPrimary(imgId) {
              const res = await fetch('/admin/products/images/' + imgId + '/primary', {
                  method: 'POST',
                  headers: {
                      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                      'Accept': 'application/json'
                  }
              });
              if (res.ok) { location.reload(); }
          }
      }">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Details, Pricing, Variants, Images -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card: General Details -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Product Information</h2>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Product Title *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm text-[#2A1810]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded font-mono text-sm uppercase">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">URL Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm text-[#2A1810]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Short Overview</label>
                    <textarea name="short_description" rows="2"
                              class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-xs text-[#2A1810]">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Full Editorial Description</label>
                    <textarea name="description" rows="5"
                              class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-xs text-[#2A1810]">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <!-- Card: Pricing & Inventory -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Pricing &amp; Inventory</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Regular MRP (₹) *</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Sale Price (₹)</label>
                        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm font-bold text-[#58111A]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Cost Price (₹)</label>
                        <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm text-gray-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Total Aggregate Stock *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Low Stock Threshold</label>
                        <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm">
                    </div>
                </div>
            </div>

            <!-- Card: Specifications -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Fabric &amp; Artisan Specifications</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Fabric</label>
                        <input type="text" name="fabric" value="{{ old('fabric', $product->fabric) }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Colour</label>
                        <input type="text" name="colour" value="{{ old('colour', $product->colour) }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Pattern</label>
                        <input type="text" name="pattern" value="{{ old('pattern', $product->pattern) }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Work / Embroidery</label>
                        <input type="text" name="work" value="{{ old('work', $product->work) }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Occasion</label>
                        <input type="text" name="occasion" value="{{ old('occasion', $product->occasion) }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Weight</label>
                        <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->weight) }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Care Instructions</label>
                    <input type="text" name="care_instructions" value="{{ old('care_instructions', $product->care_instructions) }}"
                           class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                </div>
            </div>

            <!-- Card: Existing Images & New Uploads -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Product Media Gallery</h2>

                <!-- Existing Images Rail -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($product->images as $img)
                        <div class="relative group border rounded-sm overflow-hidden bg-[#EFE9DE] p-1">
                            <img src="{{ $img->url }}" class="w-full h-32 object-cover rounded-sm">
                            @if($img->is_primary)
                                <span class="absolute top-2 left-2 bg-[#58111A] text-white text-[9px] font-bold px-1.5 py-0.5 rounded shadow">PRIMARY</span>
                            @else
                                <button @click="setPrimary({{ $img->id }})" type="button" class="absolute top-2 left-2 bg-white/90 hover:bg-[#58111A] hover:text-white text-[9px] font-semibold px-1.5 py-0.5 rounded shadow transition-colors">
                                    Set Primary
                                </button>
                            @endif
                            <button @click="deleteImg({{ $img->id }}, $el.closest('.group'))" type="button" class="absolute top-2 right-2 bg-rose-600 text-white p-1 rounded hover:bg-rose-700 shadow" title="Delete Image">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="pt-2">
                    <label class="block text-xs text-gray-600 mb-2">Upload additional editorial photos:</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-sm file:border-0 file:text-xs file:font-semibold file:bg-[#58111A] file:text-[#F7EED9]">
                </div>
            </div>

            <!-- Card: Product Variants Matrix -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <div class="flex items-center justify-between border-b border-[#EFE9DE] pb-3">
                    <div>
                        <h2 class="font-serif text-base font-bold text-[#2A1810]">Product Variants Matrix</h2>
                        <p class="text-xs text-[#8C713B]">Size &amp; colour matrix with variant-specific stock</p>
                    </div>
                    <button @click="addVariant()" type="button" class="px-3 py-1.5 bg-[#F7F4EE] hover:bg-[#58111A] hover:text-white text-xs font-bold rounded text-[#58111A] transition-colors">
                        + Add Variant
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="grid grid-cols-6 gap-2 items-center p-3 bg-[#FCFBF8] border border-[#EFE9DE] rounded text-xs">
                            <input type="hidden" :name="'variants[' + index + '][id]'" x-model="variant.id">
                            <div>
                                <label class="block text-[10px] text-gray-500">Size</label>
                                <input type="text" :name="'variants[' + index + '][size]'" x-model="variant.size" class="w-full p-1.5 border rounded">
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500">Colour</label>
                                <input type="text" :name="'variants[' + index + '][colour]'" x-model="variant.colour" class="w-full p-1.5 border rounded">
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500">Variant SKU</label>
                                <input type="text" :name="'variants[' + index + '][sku]'" x-model="variant.sku" class="w-full p-1.5 border rounded font-mono uppercase">
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500">Price Override</label>
                                <input type="number" step="0.01" :name="'variants[' + index + '][price]'" x-model="variant.price" class="w-full p-1.5 border rounded">
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500">Stock</label>
                                <input type="number" :name="'variants[' + index + '][stock]'" x-model="variant.stock" class="w-full p-1.5 border rounded font-bold text-[#58111A]">
                            </div>
                            <div class="text-right pt-3">
                                <button @click="removeVariant(index)" type="button" class="text-rose-600 hover:underline font-bold text-xs">Remove</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>

        <!-- Right Column: Taxonomy, Badges, SEO -->
        <div class="space-y-6">

            <!-- Card: Publishing Status -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Publishing</h2>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Visibility Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                        <option value="published" {{ $product->status === 'published' ? 'selected' : '' }}>Published (Visible on Store)</option>
                        <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                        <option value="archived" {{ $product->status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-[#58111A] hover:bg-[#430D14] text-[#F7EED9] font-bold text-xs uppercase tracking-widest rounded-sm shadow transition-colors">
                        Update Product
                    </button>
                </div>
            </div>

            <!-- Card: Category & Collections -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Category &amp; Taxonomy</h2>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Primary Category *</label>
                    <select name="category_id" required class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                        @foreach($categories as $parent)
                            <optgroup label="{{ $parent->name }}">
                                <option value="{{ $parent->id }}" {{ $product->category_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }} (Main)</option>
                                @foreach($parent->children as $child)
                                    <option value="{{ $child->id }}" {{ $product->category_id == $child->id ? 'selected' : '' }}>&mdash; {{ $child->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="pt-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-2">Featured Collections</label>
                    <div class="space-y-2 max-h-48 overflow-y-auto border border-[#EFE9DE] p-3 rounded text-xs">
                        @foreach($collections as $col)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="collections[]" value="{{ $col->id }}"
                                       {{ $product->collections->contains($col->id) ? 'checked' : '' }}
                                       class="rounded text-[#58111A] focus:ring-0">
                                <span>{{ $col->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Card: Badges -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-3">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Badges &amp; Highlights</h2>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">Featured on Homepage</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_best_seller" value="1" {{ $product->is_best_seller ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">Highlight as Best Seller</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_new" value="1" {{ $product->is_new ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">New Arrival Badge</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_sale" value="1" {{ $product->is_sale ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">Special Sale Event</span>
                </label>
            </div>

            <!-- Card: SEO -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-3">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Search Engine Optimization</h2>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">SEO Title</label>
                    <input type="text" name="seo_title" value="{{ old('seo_title', $product->seo_title) }}"
                           class="w-full px-3 py-1.5 border border-[#EFE9DE] rounded text-xs">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">SEO Description</label>
                    <textarea name="seo_description" rows="2"
                              class="w-full px-3 py-1.5 border border-[#EFE9DE] rounded text-xs">{{ old('seo_description', $product->seo_description) }}</textarea>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection
