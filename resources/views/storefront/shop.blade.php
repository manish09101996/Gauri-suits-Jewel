@extends('layouts.app')

@section('title', "{$pageTitle} | Gauri Suits & Jewel")
@section('meta_description', $pageDescription)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ mobileFilterOpen: false }">

    <!-- Breadcrumb & Header -->
    <div class="border-b border-stone-200 pb-8 text-center sm:text-left">
        <nav class="flex items-center justify-center sm:justify-start gap-2 text-xs text-stone-400 mb-3 uppercase tracking-wider">
            <a href="{{ route('home') }}" class="hover:text-brand-maroon transition">Home</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-brand-maroon transition">Shop</a>
            @if($currentCategory)
                <span>/</span>
                <span class="text-brand-charcoal font-semibold">{{ $currentCategory->name }}</span>
            @endif
        </nav>

        <h1 class="font-serif text-3xl sm:text-5xl font-bold text-brand-charcoal tracking-tight">
            {{ $pageTitle }}
        </h1>
        <p class="text-sm sm:text-base text-stone-600 mt-2 max-w-3xl font-light leading-relaxed">
            {{ $pageDescription }}
        </p>
    </div>

    <!-- Top Bar: Result count, Mobile Filter toggle, Sort -->
    <div class="flex items-center justify-between gap-4 pb-4 border-b border-stone-100">
        <div class="text-xs text-stone-500 font-medium">
            Showing <span class="font-bold text-brand-charcoal">{{ $products->total() }}</span> {{ Str::plural('piece', $products->total()) }}
        </div>

        <div class="flex items-center gap-3">
            <!-- Mobile Filter Button -->
            <button type="button" @click="mobileFilterOpen = true" class="lg:hidden inline-flex items-center gap-2 px-4 py-2 border border-stone-300 rounded-sm text-xs font-bold uppercase tracking-wider text-brand-charcoal hover:bg-stone-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filters
            </button>

            <!-- Sort Form -->
            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                @foreach(request()->except(['sort', 'page']) as $k => $v)
                    @if(is_array($v))
                        @foreach($v as $subV)
                            <input type="hidden" name="{{ $k }}[]" value="{{ $subV }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endif
                @endforeach
                <label for="sort" class="text-xs text-stone-500 hidden sm:inline-block">Sort by:</label>
                <select id="sort" name="sort" onchange="this.form.submit()" class="text-xs font-semibold bg-white border border-stone-300 text-brand-charcoal rounded-sm px-3 py-2 outline-none focus:border-brand-maroon">
                    <option value="featured" {{ request('sort', 'featured') === 'featured' ? 'selected' : '' }}>Curated (Featured)</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>New Arrivals</option>
                    <option value="best_selling" {{ request('sort') === 'best_selling' ? 'selected' : '' }}>Most Loved</option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <!-- Desktop Filter Sidebar (1 Col) -->
        <aside class="hidden lg:block space-y-6 bg-white p-6 rounded-xl border border-stone-200/80 shadow-sm sticky top-24">
            <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                <span class="font-serif text-base font-bold text-brand-charcoal tracking-wide">Refine Search</span>
                @if(request()->hasAny(['category', 'collection', 'fabric', 'colour', 'occasion', 'min_price', 'max_price', 'in_stock']))
                    <a href="{{ route('shop.index') }}" class="text-[11px] text-brand-gold hover:text-brand-maroon font-semibold underline">
                        Clear All
                    </a>
                @endif
            </div>

            <form method="GET" action="{{ url()->current() }}" class="space-y-6">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <!-- Categories -->
                <div>
                    <h3 class="text-xs uppercase tracking-wider font-bold text-brand-charcoal mb-3">Category</h3>
                    <div class="space-y-2 text-xs">
                        @foreach($allCategories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-stone-600 hover:text-brand-maroon">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="text-brand-maroon focus:ring-0">
                                <span class="{{ request('category') === $cat->slug ? 'font-bold text-brand-maroon' : '' }}">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-brand-charcoal mb-3">Price Range ({{ $currencySymbol ?? '$' }})</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min {{ $currencySymbol ?? '$' }}" class="bg-stone-50 border border-stone-300 rounded px-2.5 py-1.5 text-xs">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max {{ $currencySymbol ?? '$' }}" class="bg-stone-50 border border-stone-300 rounded px-2.5 py-1.5 text-xs">
                    </div>
                    <button type="submit" class="mt-2 w-full py-1.5 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/40 text-[#F7EED9] text-xs font-bold uppercase tracking-wider rounded-xs transition shadow-xs">
                        Apply Price
                    </button>
                </div>

                <!-- Fabric Filter -->
                @if($fabrics->isNotEmpty())
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-brand-charcoal mb-3">Fabric</h3>
                    <div class="space-y-1.5 max-h-48 overflow-y-auto text-xs text-stone-600">
                        @foreach($fabrics as $fab)
                            <label class="flex items-center gap-2 cursor-pointer hover:text-brand-maroon">
                                <input type="checkbox" name="fabric[]" value="{{ $fab }}" {{ in_array($fab, (array)request('fabric', [])) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded text-brand-maroon focus:ring-0">
                                <span>{{ $fab }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Colour Filter -->
                @if($colours->isNotEmpty())
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-brand-charcoal mb-3">Colour</h3>
                    <div class="space-y-1.5 max-h-48 overflow-y-auto text-xs text-stone-600">
                        @foreach($colours as $col)
                            <label class="flex items-center gap-2 cursor-pointer hover:text-brand-maroon">
                                <input type="checkbox" name="colour[]" value="{{ $col }}" {{ in_array($col, (array)request('colour', [])) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded text-brand-maroon focus:ring-0">
                                <span>{{ $col }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Occasion Filter -->
                @if($occasions->isNotEmpty())
                <div class="pt-4 border-t border-stone-100">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-brand-charcoal mb-3">Occasion</h3>
                    <div class="space-y-1.5 text-xs text-stone-600">
                        @foreach($occasions as $occ)
                            <label class="flex items-center gap-2 cursor-pointer hover:text-brand-maroon">
                                <input type="checkbox" name="occasion[]" value="{{ $occ }}" {{ in_array($occ, (array)request('occasion', [])) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded text-brand-maroon focus:ring-0">
                                <span>{{ $occ }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- In Stock Toggle -->
                <div class="pt-4 border-t border-stone-100">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700 font-semibold">
                        <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') == '1' ? 'checked' : '' }} onchange="this.form.submit()" class="rounded text-brand-maroon focus:ring-0">
                        <span>In Stock Only</span>
                    </label>
                </div>
            </form>
        </aside>

        <!-- Product Grid (3 Cols) -->
        <main class="lg:col-span-3 space-y-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-5 sm:gap-7">
                @forelse($products as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-stone-200 space-y-4">
                        <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center mx-auto text-stone-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-brand-charcoal">No designs matched your criteria</h3>
                        <p class="text-sm text-stone-500 max-w-md mx-auto">
                            Try broadening your filters or explore our newest Punjabi couture and bridal jewellery.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('shop.index') }}" class="inline-flex px-6 py-2.5 bg-brand-maroon hover:bg-brand-gold text-white hover:text-brand-charcoal text-xs font-bold uppercase tracking-wider rounded-sm transition">
                                View Full Catalog
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="pt-6 border-t border-stone-200">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>

    <!-- Mobile Filter Drawer -->
    <div x-show="mobileFilterOpen" class="fixed inset-0 z-50 flex lg:hidden" style="display: none;">
        <div @click="mobileFilterOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative ml-auto w-full max-w-xs bg-white h-full shadow-2xl p-6 overflow-y-auto space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-stone-200">
                <h3 class="font-serif text-lg font-bold text-brand-charcoal">Filter Ensembles</h3>
                <button type="button" @click="mobileFilterOpen = false" class="text-stone-400 hover:text-stone-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="space-y-6">
                <!-- Mobile Categories -->
                <div>
                    <h4 class="text-xs uppercase tracking-wider font-bold text-brand-charcoal mb-3">Categories</h4>
                    <div class="space-y-2 text-xs">
                        @foreach($allCategories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-stone-600">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} class="text-brand-maroon focus:ring-0">
                                <span>{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-stone-200 flex gap-2">
                    <button type="submit" class="flex-1 py-3 bg-brand-maroon text-white font-bold text-xs uppercase tracking-wider rounded-sm">
                        Apply Filters
                    </button>
                    <a href="{{ route('shop.index') }}" class="px-4 py-3 bg-stone-100 text-stone-700 font-semibold text-xs rounded-sm text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
