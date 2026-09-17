@extends('layouts.app')

@section('title', 'Gauri Suits & Jewel | Luxury Punjabi Fashion & Heritage Fine Jewellery')
@section('meta_description', 'Discover handcrafted Punjabi suits, royal Patiala salwars, bespoke bridal couture, and heirloom Kundan & Polki jewellery at Gauri Suits & Jewel. Tradition Meets Elegance.')

@section('content')
<div class="bg-[#FAF7F2] text-[#2A1810]">

    <!-- ============================================================== -->
    <!-- HERO SECTION: DYNAMIC BACKEND-MANAGED EDITORIAL CAROUSEL        -->
    <!-- ============================================================== -->
    @php
        $activeBanners = ($heroBanners && $heroBanners->isNotEmpty()) ? $heroBanners : collect([
            (object)[
                'id' => 1,
                'kicker' => 'TIMELESS TRADITIONS',
                'title' => "HANDCRAFTED\nFOR TODAY",
                'subtitle' => 'Punjabi Suits & Royal Jewels',
                'button_text' => 'SHOP NEW ARRIVALS',
                'link_url' => route('shop.new-arrivals'),
                'tagline' => "Tradition\nMeets\nElegance",
                'image_desktop' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=2400&auto=format&fit=crop',
                'image_mobile' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=1000&auto=format&fit=crop',
                'desktop_image_url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=2400&auto=format&fit=crop',
                'mobile_image_url' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=1000&auto=format&fit=crop',
            ]
        ]);
        $totalSlides = count($activeBanners);
    @endphp

    <section class="relative overflow-hidden bg-[#1E080C] text-white min-h-[560px] sm:min-h-[680px] lg:min-h-[760px] flex items-center"
             x-data="heroSlider({{ $totalSlides }})"
             @mouseenter="stopTimer()"
             @mouseleave="startTimer()">

        <!-- Background Slides -->
        @foreach($activeBanners as $index => $banner)
            <div x-show="activeSlide === {{ $index }}"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-[1.03]"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-[0.98]"
                 class="absolute inset-0 z-0">
                <picture>
                    @if(!empty($banner->image_mobile))
                        <source media="(max-width: 640px)" srcset="{{ $banner->mobile_image_url ?? $banner->image_mobile }}">
                    @endif
                    <img src="{{ $banner->desktop_image_url }}"
                         alt="{{ $banner->title }}"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=85&w=2400&auto=format&fit=crop';"
                         class="w-full h-full object-cover object-center sm:object-[center_35%] filter brightness-[0.88]">
                </picture>
                <!-- Luxury Editorial Vignette Gradients -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-transparent to-black/20"></div>
            </div>
        @endforeach

        <!-- Content Overlay for each slide -->
        @foreach($activeBanners as $index => $banner)
            <div x-show="activeSlide === {{ $index }}"
                 x-transition:enter="transition ease-out duration-700 delay-100"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-3"
                 class="relative z-10 max-w-7xl mx-auto w-full px-5 sm:px-8 lg:px-12 py-16 sm:py-24 flex items-center justify-between">

                <!-- Left Editorial Copy -->
                <div class="max-w-2xl space-y-2 sm:space-y-3">
                    <span class="text-[10px] sm:text-xs tracking-[0.35em] uppercase font-sans font-semibold text-[#E6CA65] block drop-shadow">
                        {{ $banner->kicker ?: 'TIMELESS TRADITIONS' }}
                    </span>

                    <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-normal tracking-[0.06em] text-[#FAF7F2] uppercase leading-[1.05] drop-shadow-md">
                        {!! nl2br(e($banner->title)) !!}
                    </h1>

                    <p class="font-serif italic text-lg sm:text-2xl text-[#E3CE9B] drop-shadow font-light pt-1">
                        {{ $banner->subtitle ?: 'Punjabi Suits & Royal Jewels' }}
                    </p>

                    @if($banner->button_text)
                    <div class="pt-5 sm:pt-7">
                        <a href="{{ $banner->link_url ? (str_starts_with($banner->link_url, 'http') || str_starts_with($banner->link_url, '/') ? $banner->link_url : url($banner->link_url)) : route('shop.new-arrivals') }}"
                           class="inline-flex items-center gap-2.5 px-6 sm:px-8 py-3 border border-[#E6CA65] text-[#FAF7F2] hover:bg-[#58111A] hover:border-[#D4AF37] text-xs font-sans uppercase tracking-[0.24em] font-semibold transition-all duration-300 shadow-lg group">
                            <span>{{ $banner->button_text }}</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                    @endif

                    <!-- Slider Indicators: 01 — 02 — 03 -->
                    @if($totalSlides > 1)
                    <div class="pt-8 sm:pt-12 flex items-center gap-3 text-[11px] sm:text-xs font-sans tracking-[0.2em] text-[#E6CA65]/80 select-none">
                        @foreach($activeBanners as $i => $b)
                            <button type="button" @click="goTo({{ $i }})"
                                    class="transition-all cursor-pointer flex items-center gap-3 group focus:outline-none"
                                    :class="activeSlide === {{ $i }} ? 'font-bold text-[#E6CA65]' : 'opacity-50 hover:opacity-100 text-stone-300'">
                                <span>{{ sprintf('%02d', $i + 1) }}</span>
                                @if(!$loop->last)
                                    <span class="w-6 h-[1px] transition-colors" :class="activeSlide === {{ $i }} ? 'bg-[#E6CA65]' : 'bg-[#E6CA65]/40'"></span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    @else
                    <div class="pt-8 sm:pt-12 flex items-center gap-3 text-[11px] sm:text-xs font-sans tracking-[0.2em] text-[#E6CA65] select-none">
                        <span class="font-bold text-[#E6CA65]">01</span>
                        <span class="w-6 h-[1px] bg-[#E6CA65]/60"></span>
                    </div>
                    @endif
                </div>

                <!-- Right Calligraphic Watermark Accent -->
                <div class="hidden lg:flex flex-col items-center text-center text-[#E6CA65] select-none pr-4">
                    <div class="font-serif text-3xl xl:text-4xl text-[#E6CA65] drop-shadow-md leading-tight" style="font-style: italic; font-family: 'Playfair Display', Georgia, serif;">
                        {!! nl2br(e($banner->tagline ?: "Tradition\nMeets\nElegance")) !!}
                    </div>
                    <div class="mt-3 text-[#D4AF37] text-xl drop-shadow">✦</div>
                </div>
            </div>
        @endforeach
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
                'image' => 'https://images.unsplash.com/photo-1566737236500-c8ac43014a67?q=80&w=600&auto=format&fit=crop',
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
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop';"
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
                ['name' => 'Royal Maroon Embroidered Suit', 'price' => 4999, 'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop'],
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
                    $prodVariantId = ($prod && $prod->variants && $prod->variants->isNotEmpty()) ? $prod->variants->first()->id : 'null';
                    $prodName = $prod ? $prod->name : $fallback['name'];
                    $prodPrice = $prod ? ($prod->sale_price ?? $prod->price) : $fallback['price'];
                    $prodUrl = $prod ? route('product.show', $prod->slug) : route('shop.index');
                    $prodImg = ($prod && !empty($prod->primary_image_url)) ? $prod->primary_image_url : $fallback['image'];
                @endphp

                <div class="group flex flex-col bg-white border border-[#E3DACD] hover:border-[#58111A] transition-all duration-300 shadow-2xs hover:shadow-md">
                    <!-- Image with top-right wishlist heart -->
                    <div class="relative aspect-[3/4] overflow-hidden bg-[#EFE9DE]">
                        <a href="{{ $prodUrl }}" class="block w-full h-full">
                            <img src="{{ $prodImg }}"
                                 alt="{{ $prodName }}"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop';"
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
                                @click="addToCartDirect({{ $prodId }}, {{ $prodVariantId }}, 1, $el)"
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
                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=85&w=2200&auto=format&fit=crop';"
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
                'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop',
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
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop';"
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
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=85&w=1200&auto=format&fit=crop';"
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
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=85&w=900&auto=format&fit=crop';"
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

    <!-- ============================================================== -->
    <!-- SECTION 6: SHOPPABLE INSTAGRAM REELS CAROUSEL                   -->
    <!-- ============================================================== -->
    @if(isset($reels) && $reels->isNotEmpty())
    @php
        $reelsJsonData = $reels->map(function($reel) {
            return [
                'id' => $reel->id,
                'title' => $reel->title,
                'video_url' => $reel->video_url,
                'thumbnail_url' => $reel->thumbnail_url,
                'product' => $reel->product ? [
                    'id' => $reel->product->id,
                    'name' => $reel->product->name,
                    'price' => (float)$reel->product->effective_price,
                    'image' => $reel->product->primary_image_url,
                    'url' => route('product.show', $reel->product->slug),
                ] : null,
            ];
        });
    @endphp

    <section class="py-12 sm:py-16 bg-[#FAF7F2] border-t border-[#E8DFD5] relative"
             x-data="reelsCarousel()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Section Header: Title & Controls -->
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 border-b border-[#E8DFD5] pb-5">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-2 h-2 rounded-full bg-[#D4AF37]"></span>
                        <span class="text-[10px] sm:text-[11px] font-sans font-bold uppercase tracking-[0.25em] text-[#8C713B]">
                            ATELIER STORIES &amp; INSTAGRAM
                        </span>
                    </div>
                    <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-[#2A1810] font-normal tracking-wide flex items-center gap-3">
                        <span>Heritage In Motion</span>
                        <span class="text-xs sm:text-sm text-[#C5A869]">❖</span>
                    </h2>
                    <p class="font-serif italic text-xs sm:text-sm text-[#7A6B63] mt-1">
                        Watch royal Punjabi silhouettes and heirloom jewellery come to life &mdash; tap any reel to shop the look
                    </p>
                </div>

                <!-- Right Side: Instagram Profile & Carousel Nav Controls -->
                <div class="flex items-center gap-3 shrink-0">
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-[#D4AF37]/50 bg-white text-[#58111A] hover:bg-[#58111A] hover:text-[#FAF7F2] text-xs font-semibold transition shadow-2xs group">
                        <svg class="w-3.5 h-3.5 fill-current text-[#D4AF37] group-hover:text-white transition-colors" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <span>@gauri.suits</span>
                    </a>

                    <!-- Left / Right Carousel Controls -->
                    <button type="button" @click="scrollPrev()"
                            class="w-9 h-9 rounded-full border border-[#D4AF37]/60 bg-white hover:bg-[#58111A] hover:text-white text-[#58111A] flex items-center justify-center transition shadow-xs focus:outline-none"
                            aria-label="Previous Reels">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" @click="scrollNext()"
                            class="w-9 h-9 rounded-full border border-[#D4AF37]/60 bg-white hover:bg-[#58111A] hover:text-white text-[#58111A] flex items-center justify-center transition shadow-xs focus:outline-none"
                            aria-label="Next Reels">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <!-- Reels Carousel Track -->
            <div x-ref="track"
                 class="flex gap-4 sm:gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar py-2 -mx-4 px-4 sm:mx-0 sm:px-0">
                @foreach($reels as $reel)
                    <div class="w-[220px] sm:w-[260px] shrink-0 snap-start aspect-[9/16] relative rounded-lg overflow-hidden bg-[#1A0B0E] border border-[#E3DACD] hover:border-[#D4AF37] shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col justify-between select-none">

                        <!-- Poster Image -->
                        <div class="absolute inset-0 z-0">
                            <img src="{{ $reel->thumbnail_url }}"
                                 alt="{{ $reel->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out filter brightness-[0.88]">
                            <!-- Gradient Overlays -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-black/30 pointer-events-none"></div>
                        </div>

                        <!-- Top Tag: Instagram Atelier Tag -->
                        <div class="relative z-10 p-3 flex items-center justify-between pointer-events-none">
                            <span class="bg-black/60 backdrop-blur-sm text-[10px] text-white px-2.5 py-1 rounded-full font-medium flex items-center gap-1.5 border border-white/20">
                                <svg class="w-3 h-3 fill-current text-[#E6CA65]" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                <span>Reel</span>
                            </span>
                            <span class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xs">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                            </span>
                        </div>

                        <!-- Center Play Button Overlay -->
                        <div class="relative z-10 flex items-center justify-center cursor-pointer"
                             @click="openReelModal({{ $reel->id }})">
                            <div class="w-12 h-12 rounded-full bg-black/40 backdrop-blur-md border border-[#D4AF37] text-[#E6CA65] flex items-center justify-center shadow-xl group-hover:scale-110 group-hover:bg-[#58111A] transition-all duration-300">
                                <svg class="w-5 h-5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>

                        <!-- Bottom Copy & Shoppable Card -->
                        <div class="relative z-10 p-3 sm:p-3.5 space-y-2.5">
                            <h3 class="font-serif text-xs sm:text-sm text-white font-semibold line-clamp-2 leading-snug drop-shadow cursor-pointer"
                                @click="openReelModal({{ $reel->id }})">
                                {{ $reel->title }}
                            </h3>

                            @if($reel->product)
                                <div class="bg-white/95 backdrop-blur-md p-2 rounded border border-[#D4AF37]/50 shadow-md flex items-center justify-between gap-2 transition hover:bg-[#FAF7F2]">
                                    <a href="{{ route('product.show', $reel->product->slug) }}" class="flex items-center gap-2 min-w-0 flex-1">
                                        <img src="{{ $reel->product->primary_image_url }}"
                                             alt="{{ $reel->product->name }}"
                                             class="w-8 h-10 object-cover rounded shrink-0 border border-stone-200">
                                        <div class="min-w-0 flex-1">
                                            <div class="text-[11px] font-semibold text-[#2A1810] truncate">{{ $reel->product->name }}</div>
                                            <div class="text-[11px] font-bold text-[#58111A]">₹{{ number_format($reel->product->effective_price) }}</div>
                                        </div>
                                    </a>
                                    <button type="button"
                                            @click.stop="$dispatch('open-quick-view', { id: {{ $reel->product->id }} })"
                                            class="shrink-0 px-2 py-1 bg-[#58111A] hover:bg-[#781924] text-[#FAF7F2] text-[10px] font-bold uppercase tracking-wider rounded transition"
                                            title="Quick View">
                                        Shop
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Reel Video Modal Player -->
        <div x-show="modalOpen"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-black/85 backdrop-blur-md flex items-center justify-center p-3 sm:p-6"
             style="display: none;"
             @keydown.escape.window="closeModal()">

            <div @click.away="closeModal()"
                 class="bg-[#190B0E] border border-[#C5A869]/40 w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden relative flex flex-col md:flex-row">

                <!-- Close Button -->
                <button type="button" @click="closeModal()"
                        class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-black/60 text-white hover:text-amber-400 flex items-center justify-center text-lg font-bold border border-white/20 transition">
                    &times;
                </button>

                <!-- Left: 9:16 Video Player -->
                <div class="w-full md:w-3/5 aspect-[9/16] bg-black relative flex items-center justify-center">
                    <video x-ref="videoPlayer"
                           :src="currentReel ? currentReel.video_url : ''"
                           class="w-full h-full object-cover"
                           playsinline loop autoplay controls></video>
                </div>

                <!-- Right: Linked Product Details -->
                <div class="w-full md:w-2/5 p-6 flex flex-col justify-between bg-[#220D12] text-white border-t md:border-t-0 md:border-l border-[#C5A869]/30">
                    <div class="space-y-4">
                        <div class="text-[10px] tracking-[0.25em] uppercase text-[#E6CA65] font-bold">Featured in Reel</div>
                        <h4 class="font-serif text-base sm:text-lg text-white font-bold leading-snug" x-text="currentReel ? currentReel.title : ''"></h4>

                        <template x-if="currentReel && currentReel.product">
                            <div class="p-3.5 bg-black/40 rounded-lg border border-[#C5A869]/30 space-y-3">
                                <div class="flex items-center gap-3">
                                    <img :src="currentReel.product.image" class="w-12 aspect-[3/4] object-cover rounded border border-stone-600">
                                    <div class="min-w-0 flex-1">
                                        <div class="text-xs font-semibold text-white line-clamp-2" x-text="currentReel.product.name"></div>
                                        <div class="text-sm font-bold text-[#E6CA65] mt-1" x-text="'₹' + Number(currentReel.product.price).toLocaleString('en-IN')"></div>
                                    </div>
                                </div>
                                <div class="pt-1 flex flex-col gap-2">
                                    <a :href="currentReel.product.url"
                                       class="w-full py-2 bg-[#D4AF37] hover:bg-[#C5A869] text-slate-950 text-xs font-bold uppercase tracking-wider text-center rounded transition shadow">
                                        View Product &rarr;
                                    </a>
                                    <button type="button"
                                            @click="$dispatch('open-quick-view', { id: currentReel.product.id }); closeModal()"
                                            class="w-full py-1.5 border border-white/20 hover:border-white text-white text-xs font-semibold uppercase tracking-wider text-center rounded transition">
                                        Quick View
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="pt-4 text-center">
                        <span class="text-[11px] text-stone-400 font-serif italic">Gauri Suits &amp; Jewel &bull; Tradition Meets Elegance</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

</div>
@endsection

@push('scripts')
<script>
function heroSlider(total) {
    return {
        activeSlide: 0,
        totalSlides: total || 1,
        timer: null,
        init() {
            if (this.totalSlides > 1) {
                this.startTimer();
            }
        },
        startTimer() {
            if (this.totalSlides <= 1) return;
            this.stopTimer();
            this.timer = setInterval(() => {
                this.next();
            }, 6500);
        },
        stopTimer() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
        goTo(index) {
            this.activeSlide = index;
            this.startTimer();
        },
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
        }
    };
}

function reelsCarousel() {
    const reelsList = {!! json_encode($reelsJsonData ?? []) !!};
    return {
        modalOpen: false,
        currentReel: null,
        reels: reelsList,
        scrollNext() {
            if (this.$refs.track) {
                this.$refs.track.scrollBy({ left: 320, behavior: 'smooth' });
            }
        },
        scrollPrev() {
            if (this.$refs.track) {
                this.$refs.track.scrollBy({ left: -320, behavior: 'smooth' });
            }
        },
        openReelModal(reelId) {
            this.currentReel = this.reels.find(r => r.id === reelId) || null;
            if (this.currentReel) {
                this.modalOpen = true;
                this.$nextTick(() => {
                    if (this.$refs.videoPlayer) {
                        this.$refs.videoPlayer.play().catch(() => {});
                    }
                });
            }
        },
        closeModal() {
            this.modalOpen = false;
            if (this.$refs.videoPlayer) {
                this.$refs.videoPlayer.pause();
            }
            this.currentReel = null;
        }
    };
}
</script>
@endpush
