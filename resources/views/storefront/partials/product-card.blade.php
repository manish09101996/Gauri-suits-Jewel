@php
    $primaryImg = $product->images->first()?->image_path;
    $secondaryImg = $product->images->count() > 1 ? $product->images->get(1)->image_path : null;

    $price = $product->sale_price ?? $product->base_price;
    $comparePrice = $product->compare_at_price;
    $discountPercent = ($comparePrice && $comparePrice > $price) ? round((($comparePrice - $price) / $comparePrice) * 100) : 0;
@endphp

<div class="group relative flex flex-col transition-all duration-500" x-data>
    <!-- Image Container (3:4 Portrait Ratio matching screenshot) -->
    <div class="relative aspect-[3/4] bg-[#EFE9DE]/50 overflow-hidden rounded-sm">
        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
            <img src="{{ $primaryImg ? (str_starts_with($primaryImg, 'http') ? $primaryImg : asset('storage/' . $primaryImg)) : 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop' }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover object-top transition-transform duration-700 ease-out {{ $secondaryImg ? 'group-hover:opacity-0' : 'group-hover:scale-105' }}">

            @if($secondaryImg)
                <img src="{{ str_starts_with($secondaryImg, 'http') ? $secondaryImg : asset('storage/' . $secondaryImg) }}"
                     alt="{{ $product->name }}"
                     class="absolute inset-0 w-full h-full object-cover object-top opacity-0 group-hover:opacity-100 group-hover:scale-105 transition duration-700 ease-out">
            @endif
        </a>

        <!-- Badges (NEW = Emerald Green, SALE = Maroon) -->
        <div class="absolute top-2 right-2 flex flex-col gap-1 z-10 pointer-events-none">
            @if($discountPercent > 0)
                <span class="px-2 py-0.5 bg-[#58111A] text-[#F7EED9] border border-[#D4AF37]/40 font-bold text-[9px] tracking-wider uppercase rounded-xs shadow-xs">
                    SALE
                </span>
            @elseif($product->is_new)
                <span class="px-2 py-0.5 bg-[#0A3828] text-[#E6CA65] border border-[#D4AF37]/50 font-bold text-[9px] tracking-wider uppercase rounded-xs shadow-xs">
                    NEW
                </span>
            @endif
        </div>

        <!-- Wishlist Toggle Button (Top Left) -->
        <button type="button"
                @click.prevent="toggleWishlist({{ $product->id }}, $el)"
                class="absolute top-2 left-2 w-7 h-7 rounded-full bg-white/80 hover:bg-[#0A3828] hover:text-[#E6CA65] text-[#2A1810] flex items-center justify-center transition-all duration-200 z-10 shadow-xs opacity-0 group-hover:opacity-100 border border-[#D4AF37]/30 cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>

        <!-- Quick View / Select Bar Slide Up on Desktop -->
        <div class="absolute bottom-0 inset-x-0 p-2.5 bg-gradient-to-t from-black/60 via-black/30 to-transparent translate-y-full group-hover:translate-y-0 transition duration-300 hidden sm:flex gap-2">
            @if($product->variants->isNotEmpty())
                <a href="{{ route('product.show', $product->slug) }}" class="w-full py-1.5 bg-[#FAF6EE] hover:bg-[#0A3828] text-[#2A1810] hover:text-[#F7EED9] hover:border-[#D4AF37]/40 border border-transparent font-semibold text-[10px] uppercase tracking-widest text-center rounded-xs transition shadow-sm">
                    Select Options
                </a>
            @else
                <button type="button"
                        @click.prevent="$dispatch('open-quick-view', { id: {{ $product->id }} })"
                        class="w-full py-1.5 bg-[#FAF6EE] hover:bg-[#58111A] text-[#2A1810] hover:text-[#F7EED9] hover:border-[#D4AF37]/40 border border-transparent font-semibold text-[10px] uppercase tracking-widest text-center rounded-xs transition shadow-sm cursor-pointer">
                    Quick View
                </button>
            @endif
        </div>
    </div>

    <!-- Product Typography (Clean editorial style) -->
    <div class="pt-3 flex-1 flex flex-col justify-between space-y-1 text-center sm:text-left">
        <div>
            @if($product->category)
                <span class="text-[9px] uppercase font-bold tracking-[0.2em] text-[#A88B4D] block">
                    {{ $product->category->name }}
                </span>
            @endif

            <h3 class="font-serif text-sm sm:text-[15px] font-medium text-[#2A1810] line-clamp-1 group-hover:text-[#58111A] transition">
                <a href="{{ route('product.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>
        </div>

        <div class="pt-0.5 flex items-baseline justify-center sm:justify-start gap-2">
            <span class="font-semibold text-xs sm:text-sm text-[#58111A]">
                {{ $currencySymbol ?? '$' }}{{ number_format($price) }}
            </span>
            @if($comparePrice && $comparePrice > $price)
                <span class="text-[11px] text-[#A88B4D]/70 line-through">
                    {{ $currencySymbol ?? '$' }}{{ number_format($comparePrice) }}
                </span>
            @endif
        </div>
    </div>
</div>
