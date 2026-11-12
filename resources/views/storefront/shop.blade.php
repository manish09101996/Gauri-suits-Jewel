@extends('layouts.app')

@section('title', "{$pageTitle} | Gauri Suits & Jewel")
@section('meta_description', $pageDescription)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ mobileFilterOpen: false }">

    <!-- Royal Editorial Header -->
    <div class="bg-gradient-to-b from-[#FAF7F2] to-[#F5EFEB] border border-[#D4AF37]/35 rounded-sm p-6 sm:p-10 text-center relative overflow-hidden shadow-xs">
        <div class="max-w-3xl mx-auto space-y-2">
            <nav class="flex items-center justify-center gap-2 text-[10px] sm:text-xs text-[#8C713B] uppercase tracking-[0.2em] font-medium mb-2">
                <a href="{{ route('home') }}" class="hover:text-[#58111A] transition">Home</a>
                <span class="text-[#D4AF37]">&bull;</span>
                <a href="{{ route('shop.index') }}" class="hover:text-[#58111A] transition">Shop</a>
                @if($currentCategory)
                    <span class="text-[#D4AF37]">&bull;</span>
                    <span class="text-[#3B0A11] font-bold">{{ $currentCategory->name }}</span>
                @endif
            </nav>

            <span class="text-[9.5px] sm:text-[10.5px] uppercase tracking-[0.35em] text-[#8C713B] font-bold block">
                ✦ ROYAL ATELIER ARCHIVE ✦
            </span>

            <h1 class="font-serif text-3xl sm:text-5xl font-normal text-[#3B0A11] tracking-wide">
                {{ $pageTitle }}
            </h1>

            <p class="text-xs sm:text-sm text-[#6B5E55] font-serif italic max-w-2xl mx-auto leading-relaxed pt-1">
                {{ $pageDescription }}
            </p>
        </div>
    </div>

    <!-- Top Bar: Result count, Mobile Filter toggle, Sort -->
    <div class="flex items-center justify-between gap-4 pb-4 border-b border-[#E8DFD5]">
        <div class="text-xs text-[#6B5E55] font-medium">
            Presenting <span class="font-bold text-[#3B0A11]">{{ $products->total() }}</span> {{ Str::plural('ensemble', $products->total()) }}
        </div>

        <div class="flex items-center gap-3">
            <!-- Mobile Filter Button -->
            <button type="button" @click="mobileFilterOpen = true" class="lg:hidden inline-flex items-center gap-2 px-3.5 py-2 border border-[#D4AF37]/45 rounded-xs text-xs font-bold uppercase tracking-wider text-[#3B0A11] hover:bg-[#FAF7F2] transition shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-[#8C713B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Refine
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
                <label for="sort" class="text-xs text-[#6B5E55] hidden sm:inline-block font-sans">Sort by:</label>
                <select id="sort" name="sort" onchange="this.form.submit()" class="text-xs font-semibold bg-[#FAF7F2] border border-[#D4AF37]/40 text-[#3B0A11] rounded-xs px-3 py-2 outline-none focus:border-[#58111A] shadow-xs cursor-pointer">
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
        <aside class="hidden lg:block space-y-6 bg-[#FAF7F2] p-6 rounded-sm border border-[#D4AF37]/35 shadow-xs sticky top-24">
            <div class="flex items-center justify-between pb-4 border-b border-[#E8DFD5]">
                <span class="font-serif text-sm uppercase tracking-[0.2em] font-bold text-[#3B0A11]">Refine Royal Search</span>
                @if(request()->hasAny(['category', 'collection', 'fabric', 'colour', 'occasion', 'min_price', 'max_price', 'in_stock']))
                    <a href="{{ route('shop.index') }}" class="text-[11px] text-[#8C713B] hover:text-[#58111A] font-semibold underline">
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
                    <h3 class="text-xs uppercase tracking-wider font-bold text-[#3B0A11] mb-3">Category</h3>
                    <div class="space-y-2 text-xs">
                        @foreach($allCategories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-[#4A3E38] hover:text-[#58111A]">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#58111A] focus:ring-0">
                                <span class="{{ request('category') === $cat->slug ? 'font-bold text-[#58111A]' : '' }}">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range (AUD) -->
                <div class="pt-4 border-t border-[#E8DFD5]">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-[#3B0A11] mb-3">Price Range ({{ $currencySymbol ?? '$' }} AUD)</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min {{ $currencySymbol ?? '$' }}" class="bg-white border border-[#D5CBC0] rounded-xs px-2.5 py-1.5 text-xs text-[#2A1810]">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max {{ $currencySymbol ?? '$' }}" class="bg-white border border-[#D5CBC0] rounded-xs px-2.5 py-1.5 text-xs text-[#2A1810]">
                    </div>
                    <button type="submit" class="mt-2.5 w-full py-2 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/40 text-[#F7EED9] text-xs font-bold uppercase tracking-wider rounded-xs transition shadow-xs cursor-pointer">
                        Filter Price
                    </button>
                </div>

                <!-- Fabric Filter -->
                @if($fabrics->isNotEmpty())
                <div class="pt-4 border-t border-[#E8DFD5]">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-[#3B0A11] mb-3">Fabric</h3>
                    <div class="space-y-1.5 max-h-48 overflow-y-auto text-xs text-[#4A3E38]">
                        @foreach($fabrics as $fab)
                            <label class="flex items-center gap-2 cursor-pointer hover:text-[#58111A]">
                                <input type="checkbox" name="fabric[]" value="{{ $fab }}" {{ in_array($fab, (array)request('fabric', [])) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-xs text-[#58111A] focus:ring-0">
                                <span>{{ $fab }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Colour Filter -->
                @if($colours->isNotEmpty())
                <div class="pt-4 border-t border-[#E8DFD5]">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-[#3B0A11] mb-3">Colour</h3>
                    <div class="space-y-1.5 max-h-48 overflow-y-auto text-xs text-[#4A3E38]">
                        @foreach($colours as $col)
                            <label class="flex items-center gap-2 cursor-pointer hover:text-[#58111A]">
                                <input type="checkbox" name="colour[]" value="{{ $col }}" {{ in_array($col, (array)request('colour', [])) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-xs text-[#58111A] focus:ring-0">
                                <span>{{ $col }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Occasion Filter -->
                @if($occasions->isNotEmpty())
                <div class="pt-4 border-t border-[#E8DFD5]">
                    <h3 class="text-xs uppercase tracking-wider font-bold text-[#3B0A11] mb-3">Occasion</h3>
                    <div class="space-y-1.5 text-xs text-[#4A3E38]">
                        @foreach($occasions as $occ)
                            <label class="flex items-center gap-2 cursor-pointer hover:text-[#58111A]">
                                <input type="checkbox" name="occasion[]" value="{{ $occ }}" {{ in_array($occ, (array)request('occasion', [])) ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-xs text-[#58111A] focus:ring-0">
                                <span>{{ $occ }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- In Stock Toggle -->
                <div class="pt-4 border-t border-[#E8DFD5]">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-[#2A1810] font-semibold">
                        <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') == '1' ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-xs text-[#58111A] focus:ring-0">
                        <span>In Stock Ready to Ship</span>
                    </label>
                </div>
            </form>
        </aside>

        <!-- Product Grid (3 Cols) -->
        <div class="lg:col-span-3 space-y-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5 sm:gap-6">
                @forelse($products as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full bg-white rounded-sm p-12 text-center border border-[#D4AF37]/35 space-y-4">
                        <div class="w-16 h-16 rounded-full bg-[#FAF7F2] border border-[#D4AF37]/50 flex items-center justify-center mx-auto text-[#8C713B]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="font-serif text-xl font-normal text-[#3B0A11]">No designs matched your criteria</h3>
                        <p class="text-xs sm:text-sm text-[#6B5E55] max-w-md mx-auto font-serif italic">
                            Try broadening your filters or explore our newest Punjabi couture and bridal jewellery.
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('shop.index') }}" class="inline-flex px-6 py-2.5 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] text-xs font-bold uppercase tracking-wider rounded-xs transition shadow-xs">
                                View Full Royal Archive
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="pt-6 border-t border-[#E8DFD5]">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Mobile Filter Drawer -->
    <div x-show="mobileFilterOpen" class="fixed inset-0 z-50 flex lg:hidden" style="display: none;">
        <div @click="mobileFilterOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative ml-auto w-full max-w-xs bg-[#FAF7F2] h-full shadow-2xl p-6 overflow-y-auto space-y-6 border-l border-[#D4AF37]/40">
            <div class="flex items-center justify-between pb-4 border-b border-[#E8DFD5]">
                <h3 class="font-serif text-base uppercase tracking-wider font-bold text-[#3B0A11]">Filter Ensembles</h3>
                <button type="button" @click="mobileFilterOpen = false" class="text-stone-400 hover:text-stone-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="space-y-6">
                <!-- Mobile Categories -->
                <div>
                    <h4 class="text-xs uppercase tracking-wider font-bold text-[#3B0A11] mb-3">Categories</h4>
                    <div class="space-y-2 text-xs">
                        @foreach($allCategories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer text-[#4A3E38]">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} class="text-[#58111A] focus:ring-0">
                                <span>{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-[#E8DFD5] flex gap-2">
                    <button type="submit" class="flex-1 py-3 bg-[#58111A] text-[#F7EED9] font-bold text-xs uppercase tracking-wider rounded-xs border border-[#D4AF37]/40">
                        Apply Filters
                    </button>
                    <a href="{{ route('shop.index') }}" class="px-4 py-3 bg-white border border-[#D5CBC0] text-[#3B0A11] font-semibold text-xs rounded-xs text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
