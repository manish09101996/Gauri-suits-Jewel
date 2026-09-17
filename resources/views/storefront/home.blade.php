@extends('layouts.app')

@section('title', 'Gauri Suits & Jewel | Luxury Punjabi Fashion & Heritage Fine Jewellery')
@section('meta_description', 'Discover handcrafted Punjabi suits, royal Patiala salwars, bespoke bridal couture, and heirloom Kundan & Polki jewellery at Gauri Suits & Jewel. Tradition Meets Elegance.')

@section('content')
<div class="bg-[#FAF7F2] text-[#2A1810]">

    <!-- ============================================================== -->
    <!-- HERO SECTION: FULL-WIDTH CINEMATIC PUNJABI BRIDAL EDITORIAL    -->
    <!-- ============================================================== -->
    <section class="relative overflow-hidden bg-[#1E080C] text-white min-h-[560px] sm:min-h-[680px] lg:min-h-[760px] flex items-center">
        <!-- Hero Background Image (Regal bride in palace haveli archway) -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=2400&auto=format&fit=crop"
                 alt="Gauri Suits & Jewel Timeless Traditions"
                 class="w-full h-full object-cover object-center sm:object-[center_35%] filter brightness-[0.88]">
            <!-- Luxury Vignette Gradients for Editorial Text Legibility -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/35 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full px-5 sm:px-8 lg:px-12 py-16 sm:py-24 flex items-center justify-between">
            <!-- Left Overlay Copy matching screenshot -->
            <div class="max-w-2xl space-y-2 sm:space-y-3">
                <span class="text-[10px] sm:text-xs tracking-[0.35em] uppercase font-sans font-semibold text-[#E6CA65] block drop-shadow">
                    TIMELESS TRADITIONS
                </span>

                <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-normal tracking-[0.06em] text-[#FAF7F2] uppercase leading-[1.05] drop-shadow-md">
                    HANDCRAFTED<br>
                    FOR TODAY
                </h1>

                <p class="font-serif italic text-lg sm:text-2xl text-[#E3CE9B] drop-shadow font-light pt-1">
                    Punjabi Suits &amp; Royal Jewels
                </p>

                <div class="pt-5 sm:pt-7">
                    <a href="{{ route('shop.new-arrivals') }}"
                       class="inline-flex items-center gap-2.5 px-6 sm:px-8 py-3 border border-[#E6CA65] text-[#FAF7F2] hover:bg-[#58111A] hover:border-[#D4AF37] text-xs font-sans uppercase tracking-[0.24em] font-semibold transition-all duration-300 shadow-lg group">
                        <span>SHOP NEW ARRIVALS</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>

                <!-- Slider Indicator: 01 — 02 — 03 -->
                <div class="pt-8 sm:pt-12 flex items-center gap-3 text-[11px] sm:text-xs font-sans tracking-[0.2em] text-[#E6CA65]/80 select-none">
                    <span class="font-bold text-[#E6CA65]">01</span>
                    <span class="w-6 h-[1px] bg-[#E6CA65]/60"></span>
                    <span class="opacity-60">02</span>
                    <span class="w-6 h-[1px] bg-[#E6CA65]/40"></span>
                    <span class="opacity-40">03</span>
                </div>
            </div>

            <!-- Right Calligraphic Watermark Accent matching screenshot -->
            <div class="hidden lg:flex flex-col items-center text-center text-[#E6CA65] select-none pr-4">
                <div class="font-serif text-3xl xl:text-4xl text-[#E6CA65] drop-shadow-md leading-tight" style="font-style: italic; font-family: 'Playfair Display', Georgia, serif;">
                    Tradition<br>
                    Meets<br>
                    Elegance
                </div>
                <!-- 4-Petal Ornamental Floret -->
                <div class="mt-3 text-[#D4AF37] text-xl drop-shadow">✦</div>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION 1: SHOP BY CATEGORY (6 HORIZONTAL LUXURY CARDS)        -->
    <!-- ============================================================== -->
    @php
        $categoryCards = [
            [
                'name' => 'PUNJABI SUITS',
                'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.suits')
            ],
            [
                'name' => 'PATIALA SALWARS',
                'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.designer-suits')
            ],
            [
                'name' => 'JEWELLERY',
                'image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.jewellery')
            ],
            [
                'name' => 'BRIDAL COUTURE',
                'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.wedding-collection')
            ],
            [
                'name' => 'NEW IN ATELIER',
                'image' => 'https://images.unsplash.com/photo-1583391733975-021c37b679b3?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.new-arrivals')
            ],
            [
                'name' => 'FESTIVE SALE',
                'image' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.sale')
            ],
        ];
    @endphp

    <section class="py-8 sm:py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 6 Equal-Width Cards in one row on desktop, swipeable on mobile -->
        <div class="flex overflow-x-auto snap-x lg:grid lg:grid-cols-6 gap-3 sm:gap-4 no-scrollbar pb-2">
            @foreach($categoryCards as $card)
                <a href="{{ $card['url'] }}"
                   class="group shrink-0 w-44 sm:w-52 lg:w-auto snap-start flex flex-col bg-white border border-[#E3DACD] hover:border-[#58111A] transition-all duration-300 shadow-2xs hover:shadow-md">
                    <!-- Category Image (3:4 Portrait Ratio matching screenshot) -->
                    <div class="relative aspect-[3/4] overflow-hidden bg-[#EFE9DE]">
                        <img src="{{ $card['image'] }}"
                             alt="{{ $card['name'] }}"
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 ease-out">
                    </div>
                    <!-- Clean White Card Label with Title and Arrow -->
                    <div class="py-2.5 px-2 text-center bg-white border-t border-[#E8DFD5] group-hover:bg-[#FAF7F2] transition-colors">
                        <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.16em] uppercase text-[#2A1810] group-hover:text-[#58111A] transition-colors inline-flex items-center justify-center gap-1.5">
                            {{ $card['name'] }} <span class="text-[#8C713B] group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION 2: FEATURED PRODUCTS (OUR COLLECTION)                  -->
    <!-- ============================================================== -->
    <section class="py-10 sm:py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Filigree Gold Flourishes & View All Link -->
        <div class="relative flex items-center justify-center mb-8 sm:mb-12">
            <div class="text-center space-y-1">
                <span class="text-[10px] sm:text-xs uppercase tracking-[0.35em] text-[#8C713B] font-bold block">OUR COLLECTION</span>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-[#3B0A11] font-normal tracking-wide flex items-center justify-center gap-3">
                    <span class="text-sm sm:text-base text-[#C5A869]">❖</span>
                    <span>Featured Products</span>
                    <span class="text-sm sm:text-base text-[#C5A869]">❖</span>
                </h2>
            </div>
            <a href="{{ route('shop.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 hidden sm:inline-flex items-center gap-1.5 text-xs font-sans uppercase font-bold tracking-[0.2em] text-[#2A1810] hover:text-[#58111A] transition-colors">
                <span>VIEW ALL</span> &rarr;
            </a>
        </div>

        @php
            // Curated showcase list matching screenshot down to names & prices
            $curatedMock = [
                ['name' => 'Royal Maroon Embroidered Suit', 'price' => 4999, 'image' => 'https://images.unsplash.com/photo-1583391733975-021c37b679b3?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Pastel Pink Palazzo Suit', 'price' => 3899, 'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Mehndi Green Designer Suit', 'price' => 4299, 'image' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Classic Red Bridal Suit', 'price' => 5999, 'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Ivory Handwork Suit', 'price' => 4499, 'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Regal Purple Suit Set', 'price' => 3999, 'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=600&auto=format&fit=crop'],
            ];

            // Use dynamic database products if available
            $displayProducts = $featuredProducts->take(6);
        @endphp

        <!-- 6-Product Grid matching screenshot -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @for($i = 0; $i < 6; $i++)
                @php
                    $prod = $displayProducts->get($i);
                    $fallback = $curatedMock[$i] ?? $curatedMock[0];

                    $prodId = $prod ? $prod->id : ($i + 1);
                    $prodName = $prod ? $prod->name : $fallback['name'];
                    $prodPrice = $prod ? ($prod->sale_price ?? $prod->price) : $fallback['price'];
                    $prodUrl = $prod ? route('product.show', $prod->slug) : route('shop.index');
                    $prodImg = $prod && $prod->images->isNotEmpty() ? $prod->primary_image : $fallback['image'];
                @endphp

                <div class="group flex flex-col bg-white border border-[#E3DACD] hover:border-[#58111A] transition-all duration-300 shadow-2xs hover:shadow-md">
                    <!-- Image with top-right wishlist heart -->
                    <div class="relative aspect-[3/4] overflow-hidden bg-[#EFE9DE]">
                        <a href="{{ $prodUrl }}" class="block w-full h-full">
                            <img src="{{ $prodImg }}"
                                 alt="{{ $prodName }}"
                                 class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 ease-out">
                        </a>

                        <!-- Wishlist Toggle Button (Top Right matching screenshot) -->
                        <button type="button"
                                @click="toggleWishlist({{ $prodId }}, $el)"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 hover:bg-[#58111A] hover:text-white text-[#2A1810] flex items-center justify-center transition-all duration-200 z-10 shadow-2xs border border-[#E3DACD]"
                                title="Add to Wishlist"
                                aria-label="Toggle Wishlist">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Product Details: Name & Price -->
                    <div class="p-3 flex-1 flex flex-col justify-between text-left space-y-1">
                        <div>
                            <h3 class="font-sans text-xs font-semibold text-[#2A1810] line-clamp-1 group-hover:text-[#58111A] transition-colors">
                                <a href="{{ $prodUrl }}">{{ $prodName }}</a>
                            </h3>
                            <div class="text-xs font-bold text-[#2A1810] mt-1">
                                ₹ {{ number_format($prodPrice) }}
                            </div>
                        </div>

                        <!-- Clean ADD TO CART button below price -->
                        <button type="button"
                                @click="addToCartDirect({{ $prodId }}, null, 1, $el)"
                                class="w-full mt-2.5 py-2 px-2 bg-[#FAF7F2] hover:bg-[#58111A] text-[#2A1810] hover:text-[#F7EED9] border border-[#D5CBC0] hover:border-[#58111A] text-[10px] sm:text-[10.5px] font-sans uppercase font-bold tracking-[0.16em] transition-all rounded-xs shadow-2xs text-center">
                            ADD TO CART
                        </button>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Mobile View All Button -->
        <div class="text-center mt-6 sm:hidden">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-1.5 text-xs font-sans uppercase font-bold tracking-[0.2em] text-[#58111A] border-b border-[#58111A] pb-1">
                <span>VIEW ALL PRODUCTS</span> &rarr;
            </a>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION 3: THE ATELIER / HERITAGE STORY (CINEMATIC BANNER)     -->
    <!-- ============================================================== -->
    <section class="relative overflow-hidden bg-[#1D090D] text-white py-14 sm:py-20 my-6">
        <!-- Atmospheric Background of Woman with Gold Bangles & Rings -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=85&w=2200&auto=format&fit=crop"
                 alt="The Atelier Heritage Craftsmanship"
                 class="w-full h-full object-cover object-center filter brightness-[0.45]">
            <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/70"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-5 sm:px-8 lg:px-12 flex flex-col lg:flex-row lg:items-center justify-between gap-10">
            <!-- Left Side: Editorial Typography & Explore Button -->
            <div class="max-w-xl space-y-2 sm:space-y-3">
                <span class="text-[10px] sm:text-xs tracking-[0.35em] uppercase font-sans font-semibold text-[#E6CA65] block">
                    THE ATELIER
                </span>
                <h2 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-normal tracking-[0.06em] text-[#FAF7F2] uppercase leading-[1.1]">
                    A LEGACY<br>
                    IN EVERY DETAIL
                </h2>
                <div class="pt-4 sm:pt-6">
                    <a href="{{ route('pages.about') }}"
                       class="inline-flex items-center gap-2 px-6 sm:px-8 py-3 border border-[#E6CA65] text-[#FAF7F2] hover:bg-[#58111A] hover:border-[#D4AF37] text-xs font-sans uppercase tracking-[0.22em] font-semibold transition-all duration-300 shadow-md">
                        <span>EXPLORE OUR STORY</span> &rarr;
                    </a>
                </div>
            </div>

            <!-- Right Side: 4 Luxury Gold Line Icon Pillars matching screenshot -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 lg:gap-8 text-center pt-4 lg:pt-0">
                <!-- Pillar 1: Authentic Craftsmanship -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center text-[#E6CA65] shadow-xs bg-black/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <span class="text-[10.5px] sm:text-[11px] font-sans font-medium tracking-[0.14em] uppercase text-[#E3CE9B] leading-tight">
                        Authentic<br>Craftsmanship
                    </span>
                </div>

                <!-- Pillar 2: Premium Fabrics -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center text-[#E6CA65] shadow-xs bg-black/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="text-[10.5px] sm:text-[11px] font-sans font-medium tracking-[0.14em] uppercase text-[#E3CE9B] leading-tight">
                        Premium<br>Fabrics
                    </span>
                </div>

                <!-- Pillar 3: Traditional Techniques -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center text-[#E6CA65] shadow-xs bg-black/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="text-[10.5px] sm:text-[11px] font-sans font-medium tracking-[0.14em] uppercase text-[#E3CE9B] leading-tight">
                        Traditional<br>Techniques
                    </span>
                </div>

                <!-- Pillar 4: Made in Punjab -->
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-12 h-12 rounded-full border border-[#D4AF37]/50 flex items-center justify-center text-[#E6CA65] shadow-xs bg-black/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="text-[10.5px] sm:text-[11px] font-sans font-medium tracking-[0.14em] uppercase text-[#E3CE9B] leading-tight">
                        Made in<br>Punjab
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION 4: SHOP BY OCCASION (5 CARDS IN A ROW)                 -->
    <!-- ============================================================== -->
    @php
        $occasions = [
            [
                'name' => 'WEDDING',
                'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.wedding-collection')
            ],
            [
                'name' => 'FESTIVE',
                'image' => 'https://images.unsplash.com/photo-1583391733975-021c37b679b3?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.suits', ['occasion' => 'festive'])
            ],
            [
                'name' => 'PARTY WEAR',
                'image' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.party-wear')
            ],
            [
                'name' => 'CASUAL ELEGANCE',
                'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.designer-suits')
            ],
            [
                'name' => 'JEWELLERY',
                'image' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=600&auto=format&fit=crop',
                'url' => route('shop.jewellery')
            ],
        ];
    @endphp

    <section class="py-10 sm:py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Centered Header with Gold ❖ Accents -->
        <div class="text-center space-y-1 mb-8 sm:mb-12">
            <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-[#3B0A11] font-normal tracking-wide flex items-center justify-center gap-3">
                <span class="text-sm sm:text-base text-[#C5A869]">❖</span>
                <span>Shop by Occasion</span>
                <span class="text-sm sm:text-base text-[#C5A869]">❖</span>
            </h2>
        </div>

        <!-- 5 Cards in one row on desktop matching screenshot -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
            @foreach($occasions as $occ)
                <a href="{{ $occ['url'] }}"
                   class="group flex flex-col bg-white border border-[#E3DACD] hover:border-[#58111A] transition-all duration-300 shadow-2xs hover:shadow-md">
                    <div class="relative aspect-[3/4] overflow-hidden bg-[#EFE9DE]">
                        <img src="{{ $occ['image'] }}"
                             alt="{{ $occ['name'] }}"
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700 ease-out">
                    </div>
                    <div class="py-2.5 px-2 text-center bg-white border-t border-[#E8DFD5] group-hover:bg-[#FAF7F2] transition-colors">
                        <span class="text-[10px] sm:text-[11px] font-sans font-bold tracking-[0.16em] uppercase text-[#2A1810] group-hover:text-[#58111A] transition-colors inline-flex items-center justify-center gap-1.5">
                            {{ $occ['name'] }} <span class="text-[#8C713B] group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- SECTION 5: NEW SEASON EDIT (SPLIT 50/50 EDITORIAL BANNER)      -->
    <!-- ============================================================== -->
    <section class="py-6 sm:py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <!-- Left 50% Banner: Festive Edit (Dark Couture) -->
            <div class="relative overflow-hidden rounded-xs min-h-[320px] sm:min-h-[380px] flex items-center bg-[#1F070B] text-white border border-[#D5CBC0]">
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=1200&auto=format&fit=crop"
                         alt="Festive Edit"
                         class="w-full h-full object-cover object-[center_25%] filter brightness-[0.65]">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/40 to-transparent"></div>
                </div>

                <div class="relative z-10 p-6 sm:p-10 space-y-2 max-w-md">
                    <span class="text-[10px] sm:text-[11px] tracking-[0.3em] uppercase font-sans font-semibold text-[#E6CA65] block">
                        NEW SEASON
                    </span>
                    <h3 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-normal text-[#FAF7F2] leading-tight">
                        Festive Edit
                    </h3>
                    <p class="font-serif italic text-sm sm:text-base text-[#E3CE9B] pb-3">
                        Celebrate your roots in style
                    </p>
                    <div>
                        <a href="{{ route('shop.new-arrivals') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 border border-[#E6CA65] text-[#FAF7F2] hover:bg-[#58111A] text-xs font-sans uppercase tracking-[0.2em] font-semibold transition-all shadow-sm">
                            <span>SHOP NOW</span> &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right 50% Banner: Heirloom Jewellery (Champagne / Botanical Canvas) -->
            <div class="relative overflow-hidden rounded-xs min-h-[320px] sm:min-h-[380px] flex items-center bg-[#F7F2E9] text-[#2A1810] border border-[#D5CBC0]">
                <!-- Delicate Botanical Line Art Watermark in Bottom Right -->
                <div class="absolute right-0 bottom-0 pointer-events-none opacity-20 w-48 h-48 sm:w-64 sm:h-64">
                    <svg viewBox="0 0 200 200" fill="none" stroke="#8C713B" stroke-width="1.2">
                        <path d="M20 180 C 60 140, 100 160, 140 100 C 160 70, 180 40, 190 10"/>
                        <path d="M90 130 C 110 110, 130 115, 150 90"/>
                        <path d="M60 150 C 75 135, 95 140, 110 120"/>
                        <circle cx="140" cy="100" r="12" stroke-dasharray="3,3"/>
                        <circle cx="110" cy="120" r="8"/>
                    </svg>
                </div>

                <!-- Product Image of Emerald & Polki Necklace on Left/Center -->
                <div class="absolute inset-y-0 left-0 w-3/5 z-0 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=85&w=900&auto=format&fit=crop"
                         alt="Heirloom Jewellery"
                         class="w-full h-full object-cover object-center filter brightness-[0.95]">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-[#F7F2E9]/60 to-[#F7F2E9]"></div>
                </div>

                <!-- Right Text Overlay matching screenshot -->
                <div class="relative z-10 ml-auto p-6 sm:p-10 space-y-2 text-right max-w-xs sm:max-w-sm">
                    <h3 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-normal text-[#3B0A11] leading-tight">
                        Heirloom<br>Jewellery
                    </h3>
                    <p class="font-serif italic text-sm sm:text-base text-[#6B5E55] pb-3">
                        Pieces that tell your story
                    </p>
                    <div>
                        <a href="{{ route('shop.jewellery') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 border border-[#8C713B] text-[#3B0A11] hover:bg-[#3B0A11] hover:text-[#F7EED9] text-xs font-sans uppercase tracking-[0.2em] font-semibold transition-all shadow-sm">
                            <span>EXPLORE</span> &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
