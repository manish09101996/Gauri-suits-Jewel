@extends('layouts.admin')

@section('title', 'Products Management')
@section('header_title', 'Products Management')
@section('header_subtitle', 'Manage catalog, inventory, pricing, variants, and badges')

@section('content')
<div class="space-y-6">

    <!-- Action Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-sm shadow-xs border border-[#EFE9DE] flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Search & Filter Form -->
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto text-xs">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or SKU..."
                   class="px-3.5 py-2 border border-[#EFE9DE] rounded w-60 text-xs focus:ring-1 focus:ring-[#C5A869]">

            <select name="category_id" class="px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="status" class="px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>

            <select name="stock_status" class="px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                <option value="">All Stock</option>
                <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (≤ Threshold)</option>
                <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock (0)</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-[#58111A] text-white rounded font-bold hover:bg-[#430D14] transition-colors">
                Apply Filter
            </button>
            @if(request()->hasAny(['search', 'category_id', 'status', 'stock_status']))
                <a href="{{ route('admin.products.index') }}" class="text-xs text-rose-700 underline font-semibold">Reset</a>
            @endif
        </form>

        <!-- Add Product CTA -->
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-[#C5A869] hover:bg-[#A88B4D] text-white font-bold text-xs uppercase tracking-wider rounded-sm transition-colors flex items-center gap-2 shadow shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Add New Product</span>
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-sm shadow-xs border border-[#EFE9DE] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F7F4EE] uppercase tracking-wider text-[#8C713B] font-bold border-b border-[#EFE9DE]">
                    <tr>
                        <th class="px-5 py-3.5">Product</th>
                        <th class="px-5 py-3.5">SKU</th>
                        <th class="px-5 py-3.5">Category</th>
                        <th class="px-5 py-3.5">Price (₹)</th>
                        <th class="px-5 py-3.5">Stock</th>
                        <th class="px-5 py-3.5">Badges</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EFE9DE]">
                    @forelse($products as $product)
                        <tr class="hover:bg-[#FCFBF8] transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-12 h-14 object-cover rounded bg-[#EFE9DE] shrink-0">
                                    <div>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="font-bold text-[#2A1810] hover:text-[#58111A]">
                                            {{ $product->name }}
                                        </a>
                                        <div class="text-[11px] text-gray-400">Created: {{ $product->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 font-mono font-bold text-gray-700">
                                {{ $product->sku }}
                            </td>
                            <td class="px-5 py-3 text-gray-600">
                                {{ $product->category->name }}
                            </td>
                            <td class="px-5 py-3 font-bold text-[#2A1810]">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="text-[#58111A]">{{ $currencySymbol ?? '$' }}{{ number_format($product->sale_price, 2) }}</span>
                                    <span class="text-gray-400 line-through text-[11px] block">{{ $currencySymbol ?? '$' }}{{ number_format($product->price, 2) }}</span>
                                @else
                                    {{ $currencySymbol ?? '$' }}{{ number_format($product->price, 2) }}
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded font-bold text-xs {{ $product->stock <= $product->low_stock_threshold ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                    {{ $product->stock }} in stock
                                </span>
                                @if($product->variants->count() > 0)
                                    <div class="text-[10px] text-gray-500 mt-0.5">{{ $product->variants->count() }} Variants</div>
                                @endif
                            </td>
                            <td class="px-5 py-3 space-y-1">
                                <div class="flex flex-wrap gap-1">
                                    @if($product->is_featured)
                                        <span class="px-1.5 py-0.5 bg-[#C5A869]/20 text-[#8C713B] rounded text-[10px] font-bold">Featured</span>
                                    @endif
                                    @if($product->is_best_seller)
                                        <span class="px-1.5 py-0.5 bg-blue-50 text-blue-800 rounded text-[10px] font-bold">Bestseller</span>
                                    @endif
                                    @if($product->is_new)
                                        <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-800 rounded text-[10px] font-bold">New</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded font-bold text-[10px] uppercase {{ $product->status === 'published' ? 'bg-emerald-100 text-emerald-800' : ($product->status === 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="p-1.5 text-gray-500 hover:text-[#58111A]" title="View Storefront">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.products.duplicate', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-gray-500 hover:text-blue-700" title="Duplicate">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="p-1.5 text-gray-500 hover:text-[#58111A]" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete product {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-700" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                                No products found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-5 border-t border-[#EFE9DE] bg-[#F7F4EE]">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
