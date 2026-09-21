@extends('layouts.admin')

@section('title', 'Add New Product')
@section('header_title', 'Create New Product')
@section('header_subtitle', 'Add royal suit, lehenga, or heritage jewellery to the store catalog')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8"
      x-data="{
          variants: [
              { sku: '', size: 'M', colour: 'Maroon', price: '', sale_price: '', stock: 10 }
          ],
          addVariant() {
              this.variants.push({ sku: '', size: 'L', colour: 'Gold', price: '', sale_price: '', stock: 5 });
          },
          removeVariant(index) {
              this.variants.splice(index, 1);
          }
      }">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column (2 Cols): Basic Info, Descriptions, Variants -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card: General Details -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Product Information</h2>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Product Title *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Royal Embroidered Patiala Salwar Suit"
                           class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm text-[#2A1810] focus:ring-1 focus:ring-[#C5A869]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">SKU (Stock Keeping Unit) *</label>
                        <input type="text" name="sku" value="{{ old('sku', 'GSJ-' . strtoupper(Str::random(6))) }}" required
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded font-mono text-sm uppercase">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">URL Slug (Optional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generated-if-empty"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm text-[#2A1810]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Short Overview</label>
                    <textarea name="short_description" rows="2" placeholder="Brief summary displayed on quick views and search snippets..."
                              class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-xs text-[#2A1810]">{{ old('short_description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Full Editorial Description</label>
                    <textarea name="description" rows="5" placeholder="Detailed craftsmanship story, embroidery details, silhouette notes..."
                              class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-xs text-[#2A1810]">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Card: Pricing & Base Inventory -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Pricing &amp; Inventory</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Regular MRP ({{ $currencySymbol ?? '$' }}) *</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="499.00"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Sale Price ({{ $currencySymbol ?? '$' }})</label>
                        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="399.00"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm font-bold text-[#58111A]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Cost Price ({{ $currencySymbol ?? '$' }})</label>
                        <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price') }}" placeholder="210.00"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm text-gray-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Total Aggregate Stock *</label>
                        <input type="number" name="stock" value="{{ old('stock', 15) }}" required
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Low Stock Alert Threshold</label>
                        <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', 5) }}"
                               class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm">
                    </div>
                </div>
            </div>

            <!-- Card: Heritage Specifications -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Fabric &amp; Artisan Specifications</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Fabric</label>
                        <input type="text" name="fabric" value="{{ old('fabric', 'Pure Chanderi Silk') }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Colour</label>
                        <input type="text" name="colour" value="{{ old('colour', 'Crimson Maroon') }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Pattern</label>
                        <input type="text" name="pattern" value="{{ old('pattern', 'Floral Handblock & Foil') }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Work / Embroidery</label>
                        <input type="text" name="work" value="{{ old('work', 'Zardozi & Gota Patti') }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Occasion</label>
                        <input type="text" name="occasion" value="{{ old('occasion', 'Wedding & Festivities') }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Weight (g/kg)</label>
                        <input type="number" step="0.01" name="weight" value="{{ old('weight', 0.85) }}"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Care Instructions</label>
                    <input type="text" name="care_instructions" value="{{ old('care_instructions', 'Dry Clean Only. Preserve in muslin wrap.') }}"
                           class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                </div>
            </div>

            <!-- Card: Product Variants Matrix -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <div class="flex items-center justify-between border-b border-[#EFE9DE] pb-3">
                    <div>
                        <h2 class="font-serif text-base font-bold text-[#2A1810]">Product Variants (Sizes &amp; Colours)</h2>
                        <p class="text-xs text-[#8C713B]">Manage individual SKU stock and pricing overrides per variant</p>
                    </div>
                    <button @click="addVariant()" type="button" class="px-3 py-1.5 bg-[#F7F4EE] hover:bg-[#58111A] hover:text-white text-xs font-bold rounded text-[#58111A] transition-colors">
                        + Add Variant
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="grid grid-cols-6 gap-2 items-center p-3 bg-[#FCFBF8] border border-[#EFE9DE] rounded text-xs">
                            <div>
                                <label class="block text-[10px] text-gray-500">Size</label>
                                <input type="text" :name="'variants[' + index + '][size]'" x-model="variant.size" placeholder="e.g. M" class="w-full p-1.5 border rounded">
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500">Colour</label>
                                <input type="text" :name="'variants[' + index + '][colour]'" x-model="variant.colour" placeholder="e.g. Maroon" class="w-full p-1.5 border rounded">
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500">Variant SKU</label>
                                <input type="text" :name="'variants[' + index + '][sku]'" x-model="variant.sku" :placeholder="'SKU-' + (index+1)" class="w-full p-1.5 border rounded uppercase font-mono">
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-500">Price (Override)</label>
                                <input type="number" step="0.01" :name="'variants[' + index + '][price]'" x-model="variant.price" placeholder="Base" class="w-full p-1.5 border rounded">
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

            <!-- Card: Media Uploads -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Product Media Gallery</h2>
                <div>
                    <label class="block text-xs text-gray-600 mb-2">Upload multiple high-resolution editorial photos (PNG, JPG, WebP):</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-sm file:border-0 file:text-xs file:font-semibold file:bg-[#58111A] file:text-[#F7EED9] hover:file:bg-[#430D14]">
                </div>
            </div>
        </div>

        <!-- Right Column (1 Col): Taxonomy, Badges, Publishing, SEO -->
        <div class="space-y-6">

            <!-- Card: Publishing Status -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Publishing</h2>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Visibility Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                        <option value="published">Published (Visible on Store)</option>
                        <option value="draft">Draft (Hidden)</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 bg-[#58111A] hover:bg-[#430D14] text-[#F7EED9] font-bold text-xs uppercase tracking-widest rounded-sm shadow transition-colors">
                        Save &amp; Publish Product
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
                                <option value="{{ $parent->id }}">{{ $parent->name }} (Main)</option>
                                @foreach($parent->children as $child)
                                    <option value="{{ $child->id }}">&mdash; {{ $child->name }}</option>
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
                                <input type="checkbox" name="collections[]" value="{{ $col->id }}" class="rounded text-[#58111A] focus:ring-0">
                                <span>{{ $col->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Card: Badges & Display Flags -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-3">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Badges &amp; Highlights</h2>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">Featured on Homepage</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">Highlight as Best Seller</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_new" value="1" checked class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">New Arrival Badge</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs">
                    <input type="checkbox" name="is_sale" value="1" {{ old('is_sale') ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                    <span class="font-semibold text-[#2A1810]">Special Sale Event</span>
                </label>
            </div>

            <!-- Card: Search Engine Optimization (SEO) -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-3">
                <h2 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Search Engine Optimization</h2>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">SEO Title</label>
                    <input type="text" name="seo_title" value="{{ old('seo_title') }}" placeholder="Custom meta title..."
                           class="w-full px-3 py-1.5 border border-[#EFE9DE] rounded text-xs">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-700 mb-1">SEO Description</label>
                    <textarea name="seo_description" rows="2" placeholder="Custom meta snippet for Google search..."
                              class="w-full px-3 py-1.5 border border-[#EFE9DE] rounded text-xs">{{ old('seo_description') }}</textarea>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection
