@extends('layouts.app')

@section('title', 'Gauri Suits & Jewel | Luxury Punjabi Fashion & Heritage Fine Jewellery')
@section('meta_description', 'Discover handcrafted Punjabi suits, royal Patiala salwars, bespoke bridal couture, and heirloom Kundan & Polki jewellery at Gauri Suits & Jewel. Tradition Meets Elegance.')

@section('content')
<div class="bg-[#FBF6EF] text-[#2A1810]">

    <!-- ============================================================== -->
    <!-- 1. HERO BANNER: ROYAL BURGUNDY & GOLD WITH INDIAN FASHION MODEL -->
    <!-- ============================================================== -->
    <section class="relative overflow-hidden bg-gradient-to-r from-[#4A0612] via-[#5C0B18] to-[#3B030D] text-white min-h-[520px] sm:min-h-[580px] lg:min-h-[640px] flex items-center border-b border-[#D4AF37]/30">
        
        <!-- Left Side Intricate Antique Gold Damask Floral Filigree SVG Pattern -->
        <div class="absolute left-0 top-0 bottom-0 w-64 sm:w-96 pointer-events-none opacity-25 select-none overflow-hidden">
            <svg class="w-full h-full text-[#E8C581]" viewBox="0 0 200 400" fill="currentColor">
                <path d="M0 0 C 40 40, 80 20, 90 60 C 100 100, 40 120, 60 160 C 80 200, 120 180, 130 220 C 140 260, 80 280, 100 320 C 120 360, 160 340, 170 380 L0 400 Z" opacity="0.4"/>
                <path d="M20 30 Q 50 10, 70 40 T 110 50 T 80 90 T 40 80 Z" opacity="0.6"/>
                <path d="M30 140 Q 60 120, 80 150 T 120 160 T 90 200 T 50 190 Z" opacity="0.6"/>
                <path d="M25 250 Q 55 230, 75 260 T 115 270 T 85 310 T 45 300 Z" opacity="0.6"/>
                <!-- Ornamental Paisley Motifs -->
                <circle cx="50" cy="50" r="18" fill="none" stroke="currentColor" stroke-width="2"/>
                <circle cx="60" cy="160" r="22" fill="none" stroke="currentColor" stroke-width="2"/>
                <circle cx="55" cy="270" r="20" fill="none" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10 sm:py-14 lg:py-16 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Editorial Text Content (7 cols on desktop) -->
                <div class="lg:col-span-7 space-y-3 sm:space-y-4 text-center lg:text-left">
                    <p class="font-serif italic text-lg sm:text-xl md:text-2xl text-[#FAF4EC]/95 tracking-wide font-light">
                        Welcome to
                    </p>

                    <h1 class="font-serif text-5xl sm:text-7xl lg:text-8xl xl:text-9xl text-[#E8C581] font-normal tracking-[0.03em] leading-[0.92] drop-shadow-lg select-none">
                        Gauri
                    </h1>

                    <h2 class="font-serif text-2xl sm:text-4xl lg:text-5xl xl:text-6xl text-[#FAF4EC] font-light tracking-[0.06em] leading-tight select-none">
                        Suits &amp; Jewel
                    </h2>

                    <!-- Ornate Gold Filigree Flourish Divider matching reference -->
                    <div class="py-1 flex items-center justify-center lg:justify-start gap-2.5 text-[#E8C581] select-none">
                        <span class="w-8 sm:w-16 h-[1px] bg-gradient-to-r from-transparent via-[#E8C581] to-[#E8C581]"></span>
                        <span class="text-base sm:text-lg">❖</span>
                        <span class="w-8 sm:w-16 h-[1px] bg-gradient-to-l from-transparent via-[#E8C581] to-[#E8C581]"></span>
                    </div>

                    <p class="font-serif italic text-base sm:text-xl lg:text-2xl text-[#E8C581] tracking-wider font-light">
                        Tradition Meets Elegance
                    </p>

                    <div class="pt-4 sm:pt-6">
                        <a href="{{ route('shop.suits') }}"
                           class="inline-flex items-center gap-2.5 px-8 sm:px-10 py-3 sm:py-3.5 rounded-full border border-[#E8C581] text-[#FAF4EC] hover:bg-[#E8C581] hover:text-[#3B030D] transition-all duration-300 font-sans text-xs sm:text-sm uppercase tracking-[0.2em] font-semibold shadow-lg group">
                            <span>Explore Collection</span>
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Right Side: Heritage Palace Archway with Indian Fashion Model (5 cols on desktop) -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-[340px] sm:max-w-[400px] lg:max-w-[440px] aspect-[4/5] rounded-t-full overflow-hidden border-2 border-[#E8C581]/70 shadow-2xl bg-[#2A060C] group">
                        <img src="{{ asset('images/reference/hero_model_2x.jpg') }}"
                             alt="Gauri Suits & Jewel Heritage Model in Maroon Embroidered Royal Suit"
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">
                        <!-- Subtle Gold Gradient Inner Rim -->
                        <div class="absolute inset-0 ring-1 ring-inset ring-[#E8C581]/30 rounded-t-full pointer-events-none"></div>
                        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/60 to-transparent pointer-events-none"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 2. SECTION: OUR COLLECTIONS (6 ATTRACTIVE CATEGORY CARDS)       -->
    <!-- ============================================================== -->
    @php
        $collections = [
            [
                'name' => 'Punjabi Suits',
                'image' => asset('images/reference/cat_punjabi_suits.jpg'),
                'url' => route('shop.suits')
            ],
            [
                'name' => 'Party Wear',
                'image' => asset('images/reference/cat_party_wear.jpg'),
                'url' => route('shop.party-wear')
            ],
            [
                'name' => 'Designer Suits',
                'image' => asset('images/reference/cat_designer_suits.jpg'),
                'url' => route('shop.designer-suits')
            ],
            [
                'name' => 'Jewellery',
                'image' => asset('images/reference/cat_jewellery.jpg'),
                'url' => route('shop.jewellery')
            ],
            [
                'name' => 'Fabric',
                'image' => asset('images/reference/cat_fabric.jpg'),
                'url' => route('shop.suits', ['type' => 'fabric'])
            ]
        ];
    @endphp

    <section class="py-10 sm:py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Heading with Ornate Gold Filigree Flourishes -->
        <div class="text-center space-y-1.5 mb-8 sm:mb-10">
            <div class="flex items-center justify-center gap-2 sm:gap-3 select-none">
                <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-r from-transparent to-[#C5A869]"></div>
                <!-- Left Scroll Flourish -->
                <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#C5A869]" viewBox="0 0 48 16" fill="currentColor">
                    <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                    <circle cx="44" cy="8" r="2.5" fill="#C5A869"/>
                </svg>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-[#2A1810] font-normal tracking-wide px-1">
                    Our Collections
                </h2>
                <!-- Right Scroll Flourish -->
                <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#C5A869] transform rotate-180" viewBox="0 0 48 16" fill="currentColor">
                    <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                    <circle cx="44" cy="8" r="2.5" fill="#C5A869"/>
                </svg>
                <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-l from-transparent to-[#C5A869]"></div>
            </div>
            <p class="text-xs sm:text-sm text-[#6B5E55] font-sans">
                Discover our latest collection of suits &amp; jewellery
            </p>
        </div>

        <!-- 6 Category Cards Grid in One Row on Desktop -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($collections as $col)
                <a href="{{ $col['url'] }}"
                   class="group flex flex-col bg-white border border-[#D4AF37]/35 hover:border-[#D4AF37] rounded-lg overflow-hidden transition-all duration-300 shadow-xs hover:shadow-xl hover:-translate-y-1">
                    <!-- Image Container -->
                    <div class="relative aspect-[4/3] sm:aspect-[5/4] overflow-hidden bg-[#FAF4EC]">
                        <img src="{{ $col['image'] }}"
                             alt="{{ $col['name'] }}"
                             class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500 ease-out">
                    </div>
                    <!-- Dark Green Bottom Button Bar -->
                    <div class="py-2 px-1 text-center bg-[#0B2417] group-hover:bg-[#5C0B18] transition-colors">
                        <span class="text-[11px] sm:text-xs font-sans font-bold tracking-wider text-white uppercase block truncate">
                            {{ $col['name'] }}
                        </span>
                    </div>
                </a>
            @endforeach

            <!-- 6th Special Card: Special Offers (Royal Burgundy Card) -->
            <div class="flex flex-col justify-center items-center text-center p-4 bg-gradient-to-b from-[#5C0B18] via-[#4A0612] to-[#3B030D] text-white border border-[#D4AF37]/50 rounded-lg shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <h3 class="font-serif text-xl sm:text-2xl font-normal leading-tight text-[#FAF4EC]">
                    Special<br>Offers
                </h3>
                <a href="{{ route('shop.sale') }}"
                   class="mt-3.5 inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border border-[#E8C581] text-[#FAF4EC] hover:bg-[#E8C581] hover:text-[#5C0B18] text-[11px] font-sans font-bold uppercase tracking-wider transition-all">
                    <span>Shop Now</span> &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 3. PROMOTIONAL BANNER: PREMIUM COLLECTION (EMERALD GREEN)      -->
    <!-- ============================================================== -->
    <section class="py-6 sm:py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-lg min-h-[140px] sm:min-h-[180px] lg:min-h-[200px] flex items-center bg-[#0D3B26] border border-[#D4AF37]/40 shadow-lg">
            
            <!-- High-Res Green Embroidered Fabric Background -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/reference/premium_banner.jpg') }}"
                     alt="Premium Collection Grace in Every Detail"
                     class="w-full h-full object-cover object-right sm:object-center filter brightness-[0.9]">
                <!-- Subtle Gradient Overlay on Left for pristine text legibility -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#092B1B]/95 via-[#092B1B]/70 to-transparent"></div>
            </div>

            <!-- Left Promotional Editorial Copy -->
            <div class="relative z-10 p-6 sm:p-10 lg:p-12 space-y-1.5 sm:space-y-2 max-w-xl text-left">
                <h3 class="font-serif italic text-3xl sm:text-4xl lg:text-5xl text-[#E8C581] font-normal leading-tight drop-shadow-md">
                    Premium Collection
                </h3>
                <p class="font-serif italic text-sm sm:text-lg lg:text-xl text-[#FAF4EC]/95 drop-shadow">
                    Grace in Every Detail
                </p>
                <div class="pt-2 sm:pt-3">
                    <a href="{{ route('shop.suits', ['featured' => 1]) }}"
                       class="inline-flex items-center gap-2 px-5 sm:px-6 py-2 sm:py-2.5 rounded-full bg-[#E8C581] hover:bg-white text-[#0A2B1B] text-xs sm:text-sm font-sans font-bold uppercase tracking-wider transition-all shadow-md group">
                        <span>Shop the Look</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 4. SECTION: TRENDING COLLECTION (6 PRODUCT CARDS)              -->
    <!-- ============================================================== -->
    @php
        $trendingCards = [
            [
                'name' => 'Royal Maroon Embroidered Suit',
                'image' => asset('images/reference/trending_1.jpg'),
                'price' => 499,
                'slug' => 'gulab-noor-zardozi-patiala-suit'
            ],
            [
                'name' => 'Emerald Green Festive Suit',
                'image' => asset('images/reference/trending_2.jpg'),
                'price' => 389,
                'slug' => 'noor-e-kashmir-velvet-tilla-suit'
            ],
            [
                'name' => 'Blush Rose Handwork Suit',
                'image' => asset('images/reference/trending_3.jpg'),
                'price' => 429,
                'slug' => 'sheesh-mahal-kalidar-bridal-anarkali'
            ],
            [
                'name' => 'Peacock Green Designer Suit',
                'image' => asset('images/reference/trending_4.jpg'),
                'price' => 599,
                'slug' => 'bagh-e-punjab-pure-chanderi-unstitched-suit'
            ],
            [
                'name' => 'Regal Purple Zardozi Suit',
                'image' => asset('images/reference/trending_5.jpg'),
                'price' => 449,
                'slug' => 'nawabi-sapphire-blue-silk-gharara-set'
            ],
            [
                'name' => 'Mustard Gold Shahi Suit',
                'image' => asset('images/reference/trending_6.jpg'),
                'price' => 399,
                'slug' => 'noorjehan-mustard-handloom-georgette-suit'
            ],
        ];

        // Bind with real database products where matching
        $dbProducts = $featuredProducts->take(6);
    @endphp

    <section class="py-10 sm:py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Heading with Ornate Gold Filigree Flourishes -->
        <div class="text-center space-y-1.5 mb-8 sm:mb-10">
            <div class="flex items-center justify-center gap-2 sm:gap-3 select-none">
                <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-r from-transparent to-[#C5A869]"></div>
                <!-- Left Scroll Flourish -->
                <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#C5A869]" viewBox="0 0 48 16" fill="currentColor">
                    <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                    <circle cx="44" cy="8" r="2.5" fill="#C5A869"/>
                </svg>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-[#2A1810] font-normal tracking-wide px-1">
                    Trending Collection
                </h2>
                <!-- Right Scroll Flourish -->
                <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#C5A869] transform rotate-180" viewBox="0 0 48 16" fill="currentColor">
                    <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                    <circle cx="44" cy="8" r="2.5" fill="#C5A869"/>
                </svg>
                <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-l from-transparent to-[#C5A869]"></div>
            </div>
        </div>

        <!-- 6 Trending Product Cards Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4" x-data>
            @for($i = 0; $i < 6; $i++)
                @php
                    $pData = $trendingCards[$i];
                    $dbP = $dbProducts->get($i);

                    $pId = $dbP ? $dbP->id : ($i + 1);
                    $pVariantId = ($dbP && $dbP->variants && $dbP->variants->isNotEmpty()) ? $dbP->variants->first()->id : 'null';
                    $pName = $dbP ? $dbP->name : $pData['name'];
                    $pPrice = $dbP ? ($dbP->sale_price ?? $dbP->price) : $pData['price'];
                    $pUrl = $dbP ? route('product.show', $dbP->slug) : route('shop.index');
                    $pImg = $pData['image'];
                @endphp

                <div class="group flex flex-col bg-white border border-[#D4AF37]/35 hover:border-[#D4AF37] rounded-lg overflow-hidden transition-all duration-300 shadow-xs hover:shadow-xl hover:-translate-y-1">
                    <!-- Image Viewport -->
                    <div class="relative aspect-[4/5] overflow-hidden bg-[#FAF4EC]">
                        <a href="{{ $pUrl }}" class="block w-full h-full">
                            <img src="{{ $pImg }}"
                                 alt="{{ $pName }}"
                                 class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500 ease-out">
                        </a>

                        <!-- Top-Right Wishlist Heart -->
                        <button type="button"
                                @click.prevent="toggleWishlist({{ $pId }}, $el)"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/90 hover:bg-[#5C0B18] hover:text-white text-[#2A1810] flex items-center justify-center transition-all duration-200 z-10 shadow-xs border border-[#D4AF37]/40 cursor-pointer"
                                title="Add to Wishlist"
                                aria-label="Toggle Wishlist">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Product Details -->
                    <div class="p-2.5 sm:p-3 flex-1 flex flex-col justify-between text-left space-y-1.5 bg-[#FAF7F2]">
                        <div>
                            <h3 class="font-sans text-xs font-semibold text-[#2A1810] line-clamp-1 group-hover:text-[#5C0B18] transition-colors">
                                <a href="{{ $pUrl }}">{{ $pName }}</a>
                            </h3>
                            <div class="text-xs font-bold text-[#5C0B18] mt-1">
                                ${{ number_format($pPrice) }} AUD
                            </div>
                        </div>

                        <!-- Add to Cart / Quick Shop Button -->
                        <button type="button"
                                @click.prevent="addToCartDirect({{ $pId }}, {{ $pVariantId }}, 1, $el)"
                                class="w-full mt-1.5 py-1.5 px-2 bg-white hover:bg-[#0B2417] text-[#0B2417] hover:text-white border border-[#0B2417]/40 hover:border-[#0B2417] text-[10px] font-sans uppercase font-bold tracking-wider transition-all rounded-sm shadow-xs text-center cursor-pointer">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 5. SECTION: OUR REELS (BURGUNDY VIDEO GALLERY WITH PLAY ICONS)   -->
    <!-- ============================================================== -->
    @php
        $reelCards = [
            ['id' => 1, 'title' => 'Festive Red Royal Suit', 'thumb' => asset('images/reference/reel_1.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
            ['id' => 2, 'title' => 'Emerald Green Occasion Set', 'thumb' => asset('images/reference/reel_2.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
            ['id' => 3, 'title' => 'Pastel Rose Embroidered Suit', 'thumb' => asset('images/reference/reel_3.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
            ['id' => 4, 'title' => 'Maroon Bridal Zardozi Suit', 'thumb' => asset('images/reference/reel_4.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
            ['id' => 5, 'title' => 'Intricate Sleeve Tilla Work', 'thumb' => asset('images/reference/reel_5.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
            ['id' => 6, 'title' => 'Bottle Green Festive Flare', 'thumb' => asset('images/reference/reel_6.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
            ['id' => 7, 'title' => 'Royal Purple Anarkali Edit', 'thumb' => asset('images/reference/reel_7.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
            ['id' => 8, 'title' => 'Mustard Yellow Punjabi Suit', 'thumb' => asset('images/reference/reel_8.jpg'), 'url' => 'https://www.instagram.com/gaurisuits'],
        ];

        // Prepare reels JSON for Alpine video modal
        $reelsJsonData = collect($reelCards)->map(function($r) {
            return [
                'id' => $r['id'],
                'title' => $r['title'],
                'video_url' => $r['url'],
                'link_url' => $r['url'],
                'thumbnail_url' => $r['thumb'],
                'product' => null
            ];
        });
    @endphp

    <section id="our-reels" class="py-12 sm:py-16 bg-gradient-to-r from-[#4E0713] via-[#45040E] to-[#3B030D] text-white border-t border-b border-[#D4AF37]/40 relative"
             x-data="reelsCarousel()">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Heading with Ornate Gold Flourishes -->
            <div class="text-center space-y-1.5 mb-8 sm:mb-10">
                <div class="flex items-center justify-center gap-2 sm:gap-3 select-none">
                    <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-r from-transparent to-[#E8C581]"></div>
                    <!-- Left Scroll Flourish -->
                    <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#E8C581]" viewBox="0 0 48 16" fill="currentColor">
                        <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                        <circle cx="44" cy="8" r="2.5" fill="#E8C581"/>
                    </svg>
                    <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-[#E8C581] font-normal tracking-wide px-1">
                        Our Reels
                    </h2>
                    <!-- Right Scroll Flourish -->
                    <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#E8C581] transform rotate-180" viewBox="0 0 48 16" fill="currentColor">
                        <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                        <circle cx="44" cy="8" r="2.5" fill="#E8C581"/>
                    </svg>
                    <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-l from-transparent to-[#E8C581]"></div>
                </div>
                <p class="text-xs sm:text-sm text-[#FAF4EC]/85 font-sans">
                    Get Inspired by Our Latest Styles
                </p>
            </div>

            <!-- Carousel Track with Left and Right Circular Nav Buttons matching reference -->
            <div class="relative group/carousel">
                <!-- Left Nav Arrow Button -->
                <button type="button" @click="scrollPrev()"
                        class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/95 hover:bg-[#E8C581] text-[#3B030D] flex items-center justify-center transition-all shadow-xl focus:outline-none cursor-pointer"
                        aria-label="Previous Reels">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <!-- Track of 8 Reels -->
                <div x-ref="track"
                     class="flex gap-3 sm:gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar py-2 px-1">
                    @foreach($reelCards as $rc)
                        <div class="w-[125px] sm:w-[145px] md:w-[155px] shrink-0 snap-start aspect-[3/4] relative rounded-md overflow-hidden bg-[#24060C] border border-[#D4AF37]/50 hover:border-[#E8C581] shadow-md hover:shadow-2xl transition-all duration-300 group select-none cursor-pointer"
                             @click="openReelModal({{ $rc['id'] }})">
                            <!-- Reel Thumbnail -->
                            <img src="{{ $rc['thumb'] }}"
                                 alt="{{ $rc['title'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            
                            <!-- Dark Vignette Overlay -->
                            <div class="absolute inset-0 bg-black/25 group-hover:bg-black/10 transition-colors"></div>

                            <!-- White Circular Play Button in Center matching reference image -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/95 text-[#3B030D] flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#E8C581] transition-transform">
                                    <svg class="w-3.5 h-3.5 fill-current ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right Nav Arrow Button -->
                <button type="button" @click="scrollNext()"
                        class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/95 hover:bg-[#E8C581] text-[#3B030D] flex items-center justify-center transition-all shadow-xl focus:outline-none cursor-pointer"
                        aria-label="Next Reels">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Reel Video Modal Dialog -->
        <div x-show="modalOpen"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4"
             @keydown.escape.window="closeModal()">
            <div @click.away="closeModal()"
                 class="bg-[#1C060B] border border-[#E8C581]/50 w-full max-w-md rounded-xl shadow-2xl overflow-hidden relative p-4 text-white">
                <button type="button" @click="closeModal()"
                        class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-black/60 text-white hover:text-[#E8C581] flex items-center justify-center text-lg font-bold border border-white/20 transition">
                    &times;
                </button>
                <div class="w-full aspect-[9/16] bg-black rounded-lg overflow-hidden flex items-center justify-center mt-2">
                    <img :src="currentReel ? currentReel.thumbnail_url : ''" class="w-full h-full object-contain">
                </div>
                <div class="mt-4 text-center space-y-2">
                    <h4 class="font-serif text-base text-[#E8C581] font-bold" x-text="currentReel ? currentReel.title : ''"></h4>
                    <a :href="currentReel && currentReel.link_url ? currentReel.link_url : 'https://www.instagram.com/gaurisuits'"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-gradient-to-r from-[#833AB4] via-[#FD1D1D] to-[#F77737] text-white text-xs font-semibold shadow-md">
                        <span>Watch on Instagram (@gaurisuits)</span> &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 6. SECTION: HAPPY CUSTOMERS (TESTIMONIALS WITH AVATARS)        -->
    <!-- ============================================================== -->
    @php
        $testimonials = [
            [
                'avatar' => asset('images/reference/avatar_priya.jpg'),
                'stars' => 5,
                'quote' => 'Beautiful collection and amazing quality! Highly recommended.',
                'author' => '— Priya S.'
            ],
            [
                'avatar' => asset('images/reference/avatar_neha.jpg'),
                'stars' => 5,
                'quote' => 'Very elegant suits. Loved the service.',
                'author' => '— Neha K.'
            ],
            [
                'avatar' => asset('images/reference/avatar_simran.jpg'),
                'stars' => 5,
                'quote' => 'Best place for traditional outfits.',
                'author' => '— Simran K.'
            ]
        ];
    @endphp

    <section class="py-12 sm:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Heading with Ornate Gold Filigree Flourishes -->
        <div class="text-center space-y-1.5 mb-8 sm:mb-10">
            <div class="flex items-center justify-center gap-2 sm:gap-3 select-none">
                <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-r from-transparent to-[#C5A869]"></div>
                <!-- Left Scroll Flourish -->
                <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#C5A869]" viewBox="0 0 48 16" fill="currentColor">
                    <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                    <circle cx="44" cy="8" r="2.5" fill="#C5A869"/>
                </svg>
                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-[#2A1810] font-normal tracking-wide px-1">
                    Happy Customers
                </h2>
                <!-- Right Scroll Flourish -->
                <svg class="w-8 sm:w-12 h-3.5 sm:h-4 text-[#C5A869] transform rotate-180" viewBox="0 0 48 16" fill="currentColor">
                    <path d="M48 8 C38 8 32 3 24 3 C16 3 12 7 6 7 C2 7 0 8 0 8 C0 8 2 9 6 9 C12 9 16 13 24 13 C32 13 38 8 48 8 Z M24 6 C28 6 32 8 36 8 C32 8 28 10 24 10 C20 10 16 8 12 8 C16 8 20 6 24 6 Z"/>
                    <circle cx="44" cy="8" r="2.5" fill="#C5A869"/>
                </svg>
                <div class="hidden sm:block w-12 sm:w-20 h-[1.5px] bg-gradient-to-l from-transparent to-[#C5A869]"></div>
            </div>
            <p class="text-xs sm:text-sm text-[#6B5E55] font-sans">
                Real Reviews. Real Happiness
            </p>
        </div>

        <!-- 3 Testimonial Cards in a Row with Left & Right Arrow Buttons matching reference image -->
        <div class="relative group/testimonials">
            <!-- Left Arrow Button -->
            <button type="button"
                    class="absolute -left-2 sm:-left-4 top-1/2 -translate-y-1/2 z-10 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#5C0B18] text-[#E8C581] hover:bg-[#3B030D] flex items-center justify-center shadow-md transition-all focus:outline-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 px-4 sm:px-6">
                @foreach($testimonials as $test)
                    <div class="p-4 sm:p-5 rounded-lg bg-[#FAF4EC] border border-[#D4AF37]/35 shadow-xs flex items-center gap-3.5 transition hover:shadow-md hover:border-[#D4AF37]">
                        <!-- Customer Avatar -->
                        <div class="w-11 h-11 rounded-full overflow-hidden border border-[#D4AF37] shrink-0 bg-stone-200 shadow-2xs">
                            <img src="{{ $test['avatar'] }}" alt="{{ $test['author'] }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Stars, Quote & Author -->
                        <div class="space-y-1 text-left min-w-0 flex-1">
                            <!-- 5 Gold Stars -->
                            <div class="text-[#E8C581] text-xs tracking-widest font-bold">
                                ★★★★★
                            </div>
                            <!-- Quote -->
                            <p class="text-[11px] sm:text-xs text-[#2A1810] font-sans leading-snug">
                                {{ $test['quote'] }}
                            </p>
                            <!-- Author -->
                            <div class="text-[11px] text-[#6B5E55] font-sans font-medium">
                                {{ $test['author'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Arrow Button -->
            <button type="button"
                    class="absolute -right-2 sm:-right-4 top-1/2 -translate-y-1/2 z-10 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#5C0B18] text-[#E8C581] hover:bg-[#3B030D] flex items-center justify-center shadow-md transition-all focus:outline-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
function reelsCarousel() {
    const reelsList = {!! json_encode($reelsJsonData ?? []) !!};
    return {
        modalOpen: false,
        currentReel: null,
        reels: reelsList,
        scrollNext() {
            if (this.$refs.track) {
                this.$refs.track.scrollBy({ left: 300, behavior: 'smooth' });
            }
        },
        scrollPrev() {
            if (this.$refs.track) {
                this.$refs.track.scrollBy({ left: -300, behavior: 'smooth' });
            }
        },
        openReelModal(reelId) {
            this.currentReel = this.reels.find(r => r.id === reelId) || null;
            if (this.currentReel) {
                this.modalOpen = true;
            }
        },
        closeModal() {
            this.modalOpen = false;
            this.currentReel = null;
        }
    };
}
</script>
@endpush
