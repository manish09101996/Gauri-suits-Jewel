@extends('layouts.app')

@section('title', 'Gauri Suits & Jewel | Luxury Punjabi Couture & Heirloom Fine Jewellery')
@section('meta_description', 'Discover authentic handcrafted Punjabi silhouettes, bespoke bridal anarkalis, pure velvet tilla couture, and heirloom Kundan & Polki fine jewellery at Gauri Suits & Jewel.')

@section('content')
<div class="bg-vintage-parchment map-watermark-overlay relative text-[#2A1810]">

    <!-- ============================================================== -->
    <!-- 1. HERO BANNER: ROOTED IN TRADITION                            -->
    <!-- ============================================================== -->
    <section class="relative overflow-hidden bg-[#241B16] text-white"
             x-data="{
                currentSlide: 0,
                slides: [
                    {
                        title: 'ROOTED IN TRADITION',
                        subtitle: 'THE VIRASAT HERITAGE EDIT',
                        image: 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=2000&auto=format&fit=crop',
                        url: '{{ route('shop.index') }}',
                        button: 'EXPLORE COUTURE'
                    },
                    {
                        title: 'HEIRLOOM KUNDAN & POLKI',
                        subtitle: 'ROYAL BRIDAL ADORNMENTS',
                        image: 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=2000&auto=format&fit=crop',
                        url: '{{ route('shop.jewellery') }}',
                        button: 'SHOP JEWELLERY'
                    }
                ],
                init() {
                    setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    }, 6500);
                }
             }">

        <div class="relative min-h-[580px] sm:min-h-[720px] lg:min-h-[820px] flex items-center justify-center">
            <template x-for="(slide, idx) in slides" :key="idx">
                <div x-show="currentSlide === idx"
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 scale-105"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0">
                    <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover object-top opacity-70">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/40"></div>
                </div>
            </template>

            <!-- Centered Editorial Typography matching reference -->
            <div class="relative z-10 text-center max-w-4xl mx-auto px-4 space-y-4 pt-32 pb-24">
                <p class="text-xs sm:text-sm tracking-[0.4em] uppercase text-[#E3CE9B] font-serif"
                   x-text="slides[currentSlide].subtitle">
                    THE VIRASAT HERITAGE EDIT
                </p>
                <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl xl:text-8xl tracking-[0.1em] font-normal text-white uppercase drop-shadow-lg"
                    x-text="slides[currentSlide].title">
                    ROOTED IN TRADITION
                </h1>
                <div class="pt-6">
                    <a :href="slides[currentSlide].url"
                       class="inline-block px-8 py-3.5 border-2 border-[#D4AF37] text-[#F7EED9] hover:bg-[#58111A] hover:border-[#D4AF37] font-serif text-xs uppercase tracking-[0.3em] transition duration-300 shadow-xl">
                        <span x-text="slides[currentSlide].button">EXPLORE COUTURE</span>
                    </a>
                </div>
            </div>

            <!-- Slide Dots -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                <template x-for="(s, i) in slides" :key="i">
                    <button @click="currentSlide = i"
                            :class="currentSlide === i ? 'w-6 bg-[#D4AF37]' : 'w-2 bg-white/40'"
                            class="h-1 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 2. ADORN EVERY PART OF YOU: 6-CATEGORY ADORNMENTS ROW          -->
    <!-- ============================================================== -->
    <section class="py-16 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-1 mb-10 sm:mb-14">
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.35em] text-[#A88B4D] font-semibold block">COLLECTIONS</span>
            <h2 class="font-serif text-2xl sm:text-4xl text-[#3B0A11] font-normal tracking-wide">Adorn Every Part of You</h2>
            <div class="ornament-flourish text-[#D4AF37] text-xs pt-1">✦</div>
        </div>

        @php
            $adornments = [
                ['name' => 'NECKLACES', 'slug' => 'kundan-necklaces', 'image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'NATH', 'slug' => 'nath-nose-rings', 'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'MAANG TIKKA', 'slug' => 'matha-patti-passa', 'image' => 'https://images.unsplash.com/photo-1602751584552-8ba73aad10e1?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'CHANDBALIS', 'slug' => 'chandbalis-jhumkas', 'image' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'HATHPHOOL', 'slug' => 'hathphool-rings', 'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'PAYAL', 'slug' => 'payal-anklets', 'image' => 'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop'],
            ];
        @endphp

        <!-- 6-Grid Tiles with Dark Outline Frames Matching Screenshot -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($adornments as $adorn)
                <a href="{{ route('shop.index', ['category' => $adorn['slug']]) }}"
                   class="group flex flex-col bg-[#240A0F] border border-[#D4AF37]/35 hover:border-[#D4AF37] overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300">
                    <div class="relative aspect-[3/4] overflow-hidden bg-[#240A0F]">
                        <img src="{{ $adorn['image'] }}" alt="{{ $adorn['name'] }}"
                             class="w-full h-full object-cover object-top opacity-85 group-hover:opacity-100 group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-2.5 inset-x-0 text-center">
                            <span class="text-[11px] sm:text-xs font-serif uppercase tracking-[0.25em] text-[#F7EED9] font-medium group-hover:text-[#D4AF37] transition">
                                {{ $adorn['name'] }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 3. SPOTTED ON ROYALTY: REAL GAURI MUSES (REELS CAROUSEL)       -->
    <!-- ============================================================== -->
    <section class="py-14 sm:py-20 relative"
             x-data="{
                scrollLeft() {
                    this.$refs.reelTrack.scrollBy({ left: -320, behavior: 'smooth' });
                },
                scrollRight() {
                    this.$refs.reelTrack.scrollBy({ left: 320, behavior: 'smooth' });
                }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-1 mb-10">
                <span class="text-[10px] sm:text-xs uppercase tracking-[0.35em] text-[#8C713B] font-semibold block">TAGGED BY TRADITION</span>
                <h2 class="font-serif text-2xl sm:text-4xl text-[#2A1810] font-normal tracking-wide">Spotted on Royalty: Real Gauri Muses</h2>
                <div class="ornament-flourish text-[#C5A869] text-xs pt-1">✦</div>
            </div>

            <!-- Carousel Wrapper with Left & Right Arrow Buttons -->
            <div class="relative group/carousel">
                <!-- Left Nav Button -->
                <button @click="scrollLeft()"
                        type="button"
                        class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-[#2A1810] shadow-md flex items-center justify-center transition border border-[#EFE9DE] focus:outline-none"
                        aria-label="Previous Reels">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <!-- Right Nav Button -->
                <button @click="scrollRight()"
                        type="button"
                        class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-[#2A1810] shadow-md flex items-center justify-center transition border border-[#EFE9DE] focus:outline-none"
                        aria-label="Next Reels">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Horizontal Reels Track -->
                <div x-ref="reelTrack"
                     class="flex gap-4 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory py-2">
                    @forelse($reels as $reel)
                        @php
                            $linkedProd = $reel->product;
                        @endphp
                        <div class="w-48 sm:w-56 lg:w-60 shrink-0 snap-start bg-[#1C1510] rounded-sm overflow-hidden shadow-sm relative group/reel">
                            <!-- 9:16 Video / Thumbnail -->
                            <div class="relative aspect-[9/16] bg-stone-900 overflow-hidden">
                                @if($reel->video_url)
                                    <video src="{{ $reel->video_url }}"
                                           poster="{{ $reel->thumbnail_url ?: 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop' }}"
                                           loop muted playsinline
                                           onmouseover="this.play()"
                                           onmouseout="this.pause()"
                                           class="w-full h-full object-cover"></video>
                                @else
                                    <img src="{{ $reel->thumbnail_url ?: 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop' }}"
                                         alt="{{ $reel->title }}"
                                         class="w-full h-full object-cover">
                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20 pointer-events-none"></div>

                                <!-- Instagram Reel Glyphs -->
                                <div class="absolute top-3 right-3 text-white/80">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </div>

                                <!-- Reel Title -->
                                <div class="absolute top-3 left-3 pr-8">
                                    <span class="text-[11px] font-serif text-white/90 line-clamp-1 drop-shadow">
                                        {{ $reel->title }}
                                    </span>
                                </div>

                                <!-- Bottom Mini Product Chip matching reference screenshot -->
                                @if($linkedProd)
                                    <div class="absolute bottom-3 inset-x-3 bg-[#FAF6EE]/95 border border-[#D4AF37]/35 backdrop-blur-xs p-2 rounded-xs flex items-center gap-2.5 shadow-md">
                                        <img src="{{ $linkedProd->primary_image_url }}" alt="{{ $linkedProd->name }}" class="w-9 h-11 object-cover rounded-xs shrink-0">
                                        <div class="flex-1 min-w-0 text-left">
                                            <div class="font-serif text-[11px] font-semibold text-[#2A1810] truncate">{{ $linkedProd->name }}</div>
                                            <div class="text-[10px] font-bold text-[#58111A]">₹{{ number_format($linkedProd->effective_price) }}</div>
                                        </div>
                                        <a href="{{ route('product.show', $linkedProd->slug) }}" class="shrink-0 text-[10px] uppercase font-bold text-[#E6CA65] bg-[#0A3828] hover:bg-[#0D4732] px-2 py-0.5 rounded-xs border border-[#D4AF37]/40 transition shadow-xs">
                                            Shop
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-xs text-stone-400 w-full">Reels curated shortly.</div>
                    @endforelse
                </div>
            </div>

            <!-- View All Button (Maroon & Gold) -->
            <div class="text-center pt-8">
                <a href="{{ route('shop.index') }}"
                   class="inline-block px-7 py-2.5 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] font-serif text-xs uppercase tracking-[0.25em] transition shadow-md rounded-xs">
                    VIEW ALL
                </a>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 4. EDITORIAL LOOKBOOK COLLAGE: A SYMPHONY OF TRADITION & COUTURE -->
    <!-- ============================================================== -->
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-1 mb-10">
            <span class="text-[10px] sm:text-xs uppercase tracking-[0.35em] text-[#8C713B] font-semibold block">HERITAGE ATELIER</span>
            <h2 class="font-serif text-2xl sm:text-4xl text-[#2A1810] font-normal tracking-wide">A Symphony of Tradition & Couture</h2>
            <div class="ornament-flourish text-[#C5A869] text-xs pt-1">✦</div>
        </div>

        <!-- 8-Photo Editorial Grid matching screenshot (4 on top, 4 on bottom) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <!-- 1. Intricate bridal henna on hands -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=700&auto=format&fit=crop"
                     alt="Artisanal Henna & Zari Craft"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>

            <!-- 2. Braided muse in ivory attire -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=700&auto=format&fit=crop"
                     alt="Royal Punjabi Muse"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>

            <!-- 3. Bridal feet in brass urli with rose petals -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=700&auto=format&fit=crop"
                     alt="Bridal Rose Rituals"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>

            <!-- 4. Muse in crimson couture & Kundan choker -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=700&auto=format&fit=crop"
                     alt="Bridal Kundan Splendour"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>

            <!-- 5. Muse in traditional floral swing -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=700&auto=format&fit=crop"
                     alt="The Shahi Bride"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>

            <!-- 6. Stack of pure gold bangles on wrist -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=700&auto=format&fit=crop"
                     alt="Gold Kadas & Bangles"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>

            <!-- 7. Emerald green silk kurta with tilla needlework -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1583391733975-021c37b679b3?q=80&w=700&auto=format&fit=crop"
                     alt="Emerald Silk Tilla Embroidery"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>

            <!-- 8. Royal muse holding heirloom pearl strings -->
            <div class="relative aspect-square overflow-hidden bg-stone-900 group">
                <img src="https://images.unsplash.com/photo-1630019852942-f89202989a59?q=80&w=700&auto=format&fit=crop"
                     alt="Heirloom Pearls & Jadau"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>
        </div>

        <!-- Explore Button (Emerald & Gold) -->
        <div class="text-center pt-8">
            <a href="{{ route('shop.bridal-collection') }}"
               class="inline-block px-7 py-2.5 bg-[#0A3828] hover:bg-[#0D4732] border border-[#D4AF37]/50 text-[#F7EED9] font-serif text-xs uppercase tracking-[0.25em] transition shadow-md rounded-xs">
                EXPLORE LOOKBOOK
            </a>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 5. MOST LOVED BY YOU (BEST SELLERS 4-COLUMN GRID)              -->
    <!-- ============================================================== -->
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-1 mb-10">
            <h2 class="font-serif text-2xl sm:text-4xl text-[#3B0A11] font-normal tracking-wide">Most Loved by You</h2>
            <div class="ornament-flourish text-[#D4AF37] text-xs pt-1">✦</div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
            @foreach($bestSellers->take(4) as $product)
                @include('storefront.partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 6. JEWELLERY EDIT (4-COLUMN GRID)                              -->
    <!-- ============================================================== -->
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-1 mb-10">
            <h2 class="font-serif text-2xl sm:text-4xl text-[#3B0A11] font-normal tracking-wide">Jewellery</h2>
            <div class="ornament-flourish text-[#D4AF37] text-xs pt-1">✦</div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
            @if($jewelleryProducts->isNotEmpty())
                @foreach($jewelleryProducts->take(4) as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            @else
                @foreach($featuredProducts->take(4) as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            @endif
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 7. FULL-WIDTH CINEMATIC ATELIER VIDEO                          -->
    <!-- ============================================================== -->
    <section class="relative w-full overflow-hidden bg-black aspect-[16/9] max-h-[680px]">
        @if($featuredVideo && $featuredVideo->video_url)
            <video src="{{ $featuredVideo->video_url }}"
                   poster="{{ $featuredVideo->poster_image ?: 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1600&auto=format&fit=crop' }}"
                   controls
                   playsinline
                   class="w-full h-full object-cover"></video>
        @else
            <video src="https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-elegant-dress-41804-large.mp4"
                   poster="https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=1600&auto=format&fit=crop"
                   controls
                   playsinline
                   class="w-full h-full object-cover"></video>
        @endif
    </section>

    <!-- ============================================================== -->
    <!-- 8. ARTISANAL HERITAGE BANNER (CRAFT SPOTLIGHT)                 -->
    <!-- ============================================================== -->
    <section class="py-16 sm:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left: Close-up photo of hathphool & roses matching screenshot -->
            <div class="relative aspect-[4/3] rounded-xs overflow-hidden shadow-md bg-stone-900 border border-[#D4AF37]/30">
                <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=1000&auto=format&fit=crop"
                     alt="Artisanal Hathphool & Heritage Roses"
                     class="w-full h-full object-cover">
            </div>

            <!-- Right: Ornate Framed Parchment Box with Gold Borders -->
            <div class="border-2 border-[#D4AF37]/70 p-8 sm:p-12 bg-[#FAF6EE]/95 backdrop-blur-xs text-center space-y-4 shadow-md relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 bg-[#FAF6EE] text-[#D4AF37] text-xs">
                    ❦
                </div>
                <h3 class="font-serif text-2xl sm:text-3xl font-normal text-[#3B0A11] tracking-wide">
                    Our Heritage Craftsmanship
                </h3>
                <p class="text-xs sm:text-sm text-[#54483A] leading-relaxed max-w-md mx-auto font-serif italic">
                    "Every silhouette and ornament at Gauri Suits & Jewel is shaped by hereditary karigars who have preserved the poetry of Dabka, Kashmiri Tilla, Mukaish, and Jadau Kundan through centuries of Punjabi royal court culture."
                </p>
                <div class="pt-2">
                    <a href="{{ route('pages.about') }}"
                       class="inline-block text-xs uppercase font-bold tracking-[0.25em] text-[#58111A] hover:text-[#0A3828] border-b-2 border-[#58111A] pb-1 transition">
                        Discover Our Story &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================== -->
    <!-- 9. THE ATELIER JOURNAL / "OUR STORIES" STRIP                   -->
    <!-- ============================================================== -->
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-1 mb-10">
            <h2 class="font-serif text-2xl sm:text-4xl text-[#2A1810] font-normal tracking-wide">Our Stories</h2>
            <div class="ornament-flourish text-[#C5A869] text-xs pt-1">✦</div>
        </div>

        <!-- 4 Cultural / Architectural Photos matching screenshot -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('blog.index') }}" class="group relative aspect-square overflow-hidden bg-stone-900">
                <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600&auto=format&fit=crop"
                     alt="The Craft of Phulkari"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition"></div>
            </a>

            <a href="{{ route('blog.index') }}" class="group relative aspect-square overflow-hidden bg-stone-900">
                <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=600&auto=format&fit=crop"
                     alt="Streets of Heritage Punjab"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition"></div>
            </a>

            <a href="{{ route('blog.index') }}" class="group relative aspect-square overflow-hidden bg-stone-900">
                <img src="https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600&auto=format&fit=crop"
                     alt="Royal Haveli Courtyards"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition"></div>
            </a>

            <a href="{{ route('blog.index') }}" class="group relative aspect-square overflow-hidden bg-stone-900">
                <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600&auto=format&fit=crop"
                     alt="The Kundan Artisan Journal"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition"></div>
            </a>
        </div>
    </section>

</div>
@endsection
