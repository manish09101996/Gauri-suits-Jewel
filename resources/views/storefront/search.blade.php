@extends('layouts.app')

@section('title', "Search results for '{$q}' | Gauri Suits & Jewel")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Header -->
    <div class="border-b border-stone-200 pb-6 text-center">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Search Catalog</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-1">
            @if($q)
                Results for "{{ $q }}"
            @else
                Search Collections
            @endif
        </h1>

        <!-- Search Bar -->
        <form action="{{ route('search') }}" method="GET" class="max-w-xl mx-auto mt-6 flex gap-2">
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ $q }}" placeholder="Search by suit name, fabric (silk, velvet), jewellery..." class="w-full bg-stone-50 border border-stone-300 rounded px-4 py-3 text-xs sm:text-sm text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
            </div>
            <button type="submit" class="px-6 py-3 bg-brand-maroon hover:bg-[#400c13] text-white font-bold text-xs uppercase tracking-wider rounded transition">
                Search
            </button>
        </form>
    </div>

    @if($products->isNotEmpty())
        <div class="space-y-4">
            <div class="text-xs text-stone-500 font-medium">
                Found <span class="font-bold text-brand-charcoal">{{ $products->total() }}</span> {{ Str::plural('piece', $products->total()) }}
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 sm:gap-7">
                @foreach($products as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="pt-6 border-t">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    @else
        <!-- No Results Empty State -->
        <div class="bg-white border border-stone-200 rounded-3xl p-12 text-center max-w-2xl mx-auto space-y-6">
            <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center mx-auto text-stone-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <div class="space-y-2">
                <h2 class="font-serif text-2xl font-bold text-brand-charcoal">No Matching Pieces Found</h2>
                <p class="text-xs sm:text-sm text-stone-500 font-light max-w-md mx-auto">
                    We couldn't find exact matches for "{{ $q }}". Try searching for "Patiala", "Anarkali", "Chanderi", "Kundan", or explore our featured royal collections below.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-2 pt-2">
                @foreach($featuredCategories as $cat)
                    <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="px-4 py-2 bg-stone-100 hover:bg-brand-gold text-stone-700 hover:text-brand-charcoal rounded text-xs font-semibold transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Recommended Pieces -->
        @if($recommendedProducts->isNotEmpty())
        <div class="pt-12 border-t space-y-6">
            <div class="text-center">
                <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Heirloom Curation</span>
                <h2 class="font-serif text-2xl font-bold text-brand-charcoal mt-1">Recommended for You</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 sm:gap-7">
                @foreach($recommendedProducts as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
