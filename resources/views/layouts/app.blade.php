<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Gauri Suits & Jewel | Luxury Punjabi Fashion & Heritage Jewellery')</title>
    <meta name="description" content="@yield('meta_description', 'Discover timeless Punjabi fashion, heavily embroidered designer suits, and heirloom heritage jewellery handcrafted for royalty.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <!-- Open Graph / Social Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Gauri Suits & Jewel | Luxury Punjabi Fashion & Heritage Jewellery')">
    <meta property="og:description" content="@yield('meta_description', 'Discover timeless Punjabi fashion, heavily embroidered designer suits, and heirloom heritage jewellery handcrafted for royalty.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:site_name" content="Gauri Suits & Jewel">

    <!-- Fonts: Cormorant Garamond & Playfair Display (Serif) + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Global App Configuration & Dynamic URL Resolution for Subfolder Environments -->
    <script>
        window.AppConfig = {
            baseUrl: {!! json_encode(rtrim(url('/'), '/')) !!}.replace(/&amp;/g, '&'),
            csrfToken: {!! json_encode(csrf_token()) !!},
            currencySymbol: {!! json_encode($currencySymbol ?? '$') !!},
            currencyCode: {!! json_encode($currencyCode ?? 'AUD') !!},
            routes: {
                cartSummary: {!! json_encode(route('cart.summary')) !!}.replace(/&amp;/g, '&'),
                cartAdd: {!! json_encode(route('cart.add')) !!}.replace(/&amp;/g, '&'),
                cartUpdate: {!! json_encode(route('cart.update')) !!}.replace(/&amp;/g, '&'),
                wishlistToggle: {!! json_encode(route('wishlist.toggle')) !!}.replace(/&amp;/g, '&'),
            }
        };

        window.currencySymbol = (window.AppConfig && window.AppConfig.currencySymbol) || '$';
        window.formatMoney = function(amount) {
            var sym = (window.AppConfig && window.AppConfig.currencySymbol) || '$';
            var num = Number(amount) || 0;
            return sym + num.toLocaleString('en-AU', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
        };

        window.apiUrl = function(path) {
            if (!path) return ((window.AppConfig && window.AppConfig.baseUrl) || '').replace(/&amp;/g, '&');
            var clean = path.replace(/&amp;/g, '&');
            if (clean.startsWith('http://') || clean.startsWith('https://')) return clean;
            var base = (window.AppConfig && window.AppConfig.baseUrl) ? window.AppConfig.baseUrl : '';
            base = base.replace(/\/+$/, '').replace(/&amp;/g, '&');
            clean = clean.replace(/^\/+/, '');
            return base ? (base + '/' + clean) : ('/' + clean);
        };

        window.csrfToken = function() {
            return (window.AppConfig && window.AppConfig.csrfToken) ||
                   (document.querySelector('meta[name=csrf-token]') ? document.querySelector('meta[name=csrf-token]').content : '');
        };
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#FDFBF7] text-[#2A1810] font-sans antialiased selection:bg-[#D4AF37] selection:text-[#3B0A11]">

    <!-- Top Announcement Bar (Deep Emerald Green matching reference) -->
    <aside aria-label="Announcement" class="bg-[#0B2417] text-[#FAF4EC] text-[11px] sm:text-xs py-2 px-4 sm:px-6 border-b border-[#D4AF37]/25 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between flex-wrap gap-2">
            <!-- Left: Free Shipping with delivery van icon -->
            <div class="flex items-center gap-2 text-[#FAF4EC]">
                <svg class="w-4 h-4 text-[#E8C581] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                </svg>
                <span class="font-sans font-medium tracking-wide">Free Shipping on Orders Above ${{ number_format($storeSettings['free_shipping_threshold'] ?? 100) }}</span>
            </div>

            <!-- Right: Track Order, Contact Us & Social Icons -->
            <div class="flex items-center gap-4 text-xs font-sans text-[#FAF4EC]">
                <div class="hidden sm:flex items-center gap-3 tracking-wide">
                    <a href="{{ route('order.track') }}" class="hover:text-[#E8C581] transition-colors">Track Order</a>
                    <span class="text-white/40">|</span>
                    <a href="{{ route('pages.contact') }}" class="hover:text-[#E8C581] transition-colors">Contact Us</a>
                </div>
                <div class="flex items-center gap-2.5 text-[#FAF4EC]">
                    <a href="{{ \App\Models\Setting::get('facebook_url', 'https://facebook.com') }}" target="_blank" rel="noopener" class="hover:text-[#E8C581] transition-colors" title="Facebook" aria-label="Facebook">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.595 0 9 1.582 9 4.615V8z"/></svg>
                    </a>
                    <a href="{{ \App\Models\Setting::get('instagram_url', 'https://www.instagram.com/gaurisuits') }}" target="_blank" rel="noopener" class="hover:text-[#E8C581] transition-colors" title="Instagram" aria-label="Instagram">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="https://youtube.com/@gaurisuits" target="_blank" rel="noopener" class="hover:text-[#E8C581] transition-colors" title="YouTube" aria-label="YouTube">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Navigation Header (Warm Champagne Cream with Burgundy Underline & Logo) -->
    <header x-data class="sticky top-0 z-40 bg-[#F6EFE6]/98 backdrop-blur-md border-b border-[#E8DFD5] text-[#2A1810] transition-all duration-300 shadow-[0_2px_15px_rgba(0,0,0,0.03)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 sm:h-20 md:h-22">

                <!-- Left: Mobile Menu Toggle & Brand Emblem Logo -->
                <div class="flex items-center gap-2 sm:gap-4 min-w-0">
                    <button @click="$dispatch('toggle-mobile-menu')"
                            type="button"
                            class="lg:hidden w-11 h-11 -ml-1 flex items-center justify-center text-[#2A1810] hover:text-[#5C0B18] hover:bg-black/5 active:bg-black/10 rounded-sm focus:outline-none transition-colors cursor-pointer"
                            aria-label="Open Navigation Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Circular Emblem Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group py-1 min-w-0" title="Gauri Suits & Jewel - Tradition Meets Elegance">
                        <div class="relative w-11 h-11 sm:w-13 sm:h-13 md:w-14 md:h-14 rounded-full p-0.5 bg-gradient-to-tr from-[#D4AF37] via-[#5C0B18] to-[#D4AF37] shadow-sm shrink-0 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('images/logo.png') }}" alt="Gauri Suits & Jewel" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="hidden sm:flex flex-col items-start text-left min-w-0">
                            <span class="font-serif text-lg sm:text-xl md:text-2xl tracking-[0.14em] text-[#3B0A11] uppercase font-normal leading-tight transition-colors group-hover:text-[#5C0B18] truncate">
                                GAURI
                            </span>
                            <span class="text-[8px] sm:text-[9px] tracking-[0.3em] text-[#8C713B] uppercase font-semibold font-sans -mt-0.5 whitespace-nowrap">
                                SUITS &amp; JEWEL
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Center: Desktop Navigation matching reference image exactly -->
                <nav class="hidden lg:flex items-center space-x-7 xl:space-x-9 text-xs font-semibold tracking-[0.14em] text-[#2A1810]">
                    <a href="{{ route('home') }}" class="nav-link-royal hover:text-[#5C0B18] transition-colors {{ request()->routeIs('home') ? 'text-[#5C0B18] font-bold border-b-2 border-[#5C0B18] pb-1' : '' }}">Home</a>
                    <a href="{{ route('pages.about') }}" class="nav-link-royal hover:text-[#5C0B18] transition-colors {{ request()->routeIs('pages.about') ? 'text-[#5C0B18] font-bold border-b-2 border-[#5C0B18] pb-1' : '' }}">About</a>
                    <a href="{{ route('shop.suits') }}" class="nav-link-royal hover:text-[#5C0B18] transition-colors {{ request()->is('suits*') || request()->is('punjabi-suits*') ? 'text-[#5C0B18] font-bold border-b-2 border-[#5C0B18] pb-1' : '' }}">Suits</a>
                    <a href="{{ route('shop.jewellery') }}" class="nav-link-royal hover:text-[#5C0B18] transition-colors {{ request()->is('jewellery*') ? 'text-[#5C0B18] font-bold border-b-2 border-[#5C0B18] pb-1' : '' }}">Jewellery</a>
                    <a href="{{ route('shop.sale') }}" class="nav-link-royal hover:text-[#5C0B18] transition-colors {{ request()->routeIs('shop.sale') ? 'text-[#5C0B18] font-bold border-b-2 border-[#5C0B18] pb-1' : '' }}">Offers</a>
                    <a href="#our-reels" class="nav-link-royal hover:text-[#5C0B18] transition-colors">Gallery</a>
                    <a href="{{ route('pages.contact') }}" class="nav-link-royal hover:text-[#5C0B18] transition-colors {{ request()->routeIs('pages.contact') ? 'text-[#5C0B18] font-bold border-b-2 border-[#5C0B18] pb-1' : '' }}">Contact</a>
                </nav>

                <!-- Right: Search & Cart matching reference -->
                <div class="flex items-center gap-1 sm:gap-2.5 text-[#2A1810] pr-0.5 sm:pr-0 shrink-0">
                    <!-- Search Trigger -->
                    <button @click="$dispatch('open-search')" type="button" class="p-2 sm:p-2.5 hover:text-[#5C0B18] transition-colors focus:outline-none rounded-sm hover:bg-black/5" title="Search" aria-label="Search Products">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Cart Drawer Trigger with Red Circular Badge -->
                    <button @click="$dispatch('open-cart')"
                            onclick="window.openCart && window.openCart()"
                            type="button"
                            class="p-2 sm:p-2.5 hover:text-[#5C0B18] transition-colors relative focus:outline-none flex items-center justify-center rounded-sm hover:bg-black/5 shrink-0 cursor-pointer"
                            title="Shopping Cart"
                            aria-label="Shopping Bag">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span id="header-cart-badge"
                              class="absolute -top-1 -right-1 bg-[#B31A2B] text-white text-[9.5px] min-w-[17px] h-[17px] px-1 rounded-full flex items-center justify-center font-bold shadow-xs pointer-events-none z-10 leading-none">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Fullscreen Mobile Navigation Drawer (Root Body Level) -->
    <div x-data="mobileDrawer"
         x-show="open"
         x-cloak
         @keydown.escape.window="close()"
         class="fixed inset-0 z-50 lg:hidden"
         style="display: none;">

        <!-- Backdrop with Smooth Fade -->
        <div x-show="open"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="close()"
             class="fixed inset-0 bg-black/60 backdrop-blur-xs"></div>

        <!-- Drawer Panel with Smooth Slide from Left -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 w-[86%] max-w-sm bg-[#FDFBF7] h-full shadow-2xl z-50 flex flex-col justify-between overflow-y-auto border-r border-[#D4AF37]/30">

            <div>
                <!-- Drawer Header -->
                <div class="p-4 sm:p-5 bg-[#FAF7F2] border-b border-[#E8DFD5] flex items-center justify-between text-[#2D1C1B]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-[#D4AF37] via-[#0A3828] to-[#D4AF37] shadow shrink-0">
                            <img src="{{ asset('images/logo.png') }}" alt="Gauri Suits & Jewel" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div>
                            <span class="font-serif text-lg tracking-[0.16em] text-[#3B0A11] font-normal block leading-tight">GAURI</span>
                            <span class="block text-[8px] tracking-[0.32em] text-[#8C713B] uppercase font-semibold">SUITS &amp; JEWEL</span>
                        </div>
                    </div>
                    <button @click="close()"
                            class="w-9 h-9 flex items-center justify-center text-[#2D1C1B] hover:text-[#58111A] hover:bg-black/5 rounded-full transition-colors focus:outline-none cursor-pointer"
                            aria-label="Close Navigation Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Mobile Search Shortcut -->
                <div class="px-5 pt-4">
                    <button @click="close(); $nextTick(() => $dispatch('open-search'))"
                            type="button"
                            class="w-full flex items-center gap-2.5 px-3.5 py-2.5 bg-[#F5EFEB] border border-[#E8DFD5] rounded-xs text-[#8C713B] text-xs hover:border-[#C5A869] transition-colors text-left cursor-pointer">
                        <svg class="w-4 h-4 text-[#8C713B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="text-stone-500 font-sans">Search suits, jewels, fabrics...</span>
                    </button>
                </div>

                <!-- Quick Links (Bag & Wishlist) -->
                <div class="px-5 pt-3 grid grid-cols-2 gap-2">
                    <button @click="close(); $nextTick(() => $dispatch('open-cart'))"
                            onclick="window.closeMobileMenu && window.closeMobileMenu(); window.openCart && window.openCart();"
                            type="button"
                            class="flex items-center justify-center gap-2 py-2 px-3 bg-[#FAF7F2] border border-[#E8DFD5] rounded-xs text-xs font-semibold uppercase tracking-wider text-[#3B0A11] hover:bg-[#58111A] hover:text-white transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span>Bag</span>
                        <span id="mobile-menu-cart-badge" class="ml-0.5 px-1.5 py-0.2 bg-[#58111A] text-[#F7EED9] text-[9.5px] font-bold rounded-full">
                            {{ $cartCount ?? 0 }}
                        </span>
                    </button>
                    <a href="{{ route('wishlist.index') }}"
                       @click="close()"
                       class="flex items-center justify-center gap-2 py-2 px-3 bg-[#FAF7F2] border border-[#E8DFD5] rounded-xs text-xs font-semibold uppercase tracking-wider text-[#0A3828] hover:bg-[#0A3828] hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span>Wishlist</span>
                        <span class="ml-0.5 px-1.5 py-0.2 bg-[#0A3828] text-white text-[9.5px] font-bold rounded-full">
                            {{ $wishlistCount ?? 0 }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links matching reference image -->
                <nav class="px-5 py-4 space-y-1 text-xs font-semibold tracking-[0.16em] uppercase text-[#2A1810]">
                    <a href="{{ route('home') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#5C0B18] {{ request()->routeIs('home') ? 'text-[#5C0B18] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Home</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('pages.about') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#5C0B18] {{ request()->routeIs('pages.about') ? 'text-[#5C0B18] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>About</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.suits') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#5C0B18] {{ request()->is('suits*') || request()->is('punjabi-suits*') ? 'text-[#5C0B18] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Suits</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.jewellery') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#5C0B18] {{ request()->is('jewellery*') ? 'text-[#5C0B18] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Jewellery</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.sale') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#5C0B18] {{ request()->routeIs('shop.sale') ? 'text-[#5C0B18] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Offers</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="#our-reels" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#5C0B18]">
                        <span>Gallery</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('pages.contact') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#5C0B18] {{ request()->routeIs('pages.contact') ? 'text-[#5C0B18] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Contact</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>

                    <div class="pt-3 mt-2 border-t border-[#E8DFD5] space-y-1 text-xs font-normal normal-case tracking-normal">
                        <a href="{{ route('order.track') }}" @click="close()" class="flex items-center gap-2.5 py-2 px-2 text-[#4A3E38] hover:text-[#5C0B18] rounded-xs hover:bg-[#FAF7F2]">
                            <svg class="w-4 h-4 text-[#8C713B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2"/></svg>
                            <span>Track Your Order</span>
                        </a>
                        <a href="tel:0401365786" class="flex items-center gap-2.5 py-2 px-2 text-[#4A3E38] hover:text-[#5C0B18] rounded-xs hover:bg-[#FAF7F2]">
                            <svg class="w-4 h-4 text-[#8C713B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>0401 365 786 (Geelong, Melbourne)</span>
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Bottom Auth & Concierge Section -->
            <div class="p-5 bg-[#FAF7F2] border-t border-[#E8DFD5] space-y-3">
                @auth
                    <div class="flex items-center justify-between text-xs">
                        <div>
                            <span class="text-[11px] text-stone-500 block">Signed in as</span>
                            <span class="font-bold text-[#2A1810]">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('account.dashboard') }}" @click="close()" class="text-[#8C713B] font-bold hover:underline">My Account</a>
                            <form action="{{ route('customer.logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-[#7A1D2A] font-bold hover:underline">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-2.5 text-center">
                        <a href="{{ route('customer.login') }}" @click="close()" class="py-2.5 px-3 bg-[#58111A] text-[#F7EED9] text-xs tracking-wider uppercase font-bold rounded-xs hover:bg-[#4A0E17] transition-colors shadow-xs">Sign In</a>
                        <a href="{{ route('customer.register') }}" @click="close()" class="py-2.5 px-3 border border-[#58111A] text-[#58111A] text-xs tracking-wider uppercase font-bold rounded-xs hover:bg-[#58111A]/5 transition-colors">Register</a>
                    </div>
                @endauth

                <!-- WhatsApp Quick Action inside Drawer -->
                @php
                    $drawerWa = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('whatsapp_number', '+919984700018'));
                @endphp
                <a href="https://wa.me/{{ $drawerWa }}?text={{ urlencode('Hello Gauri Suits & Jewel, I need personal stylist assistance.') }}"
                   target="_blank"
                   rel="noopener"
                   class="w-full py-2 px-3 bg-[#0A3828] text-white text-xs font-semibold uppercase tracking-wider rounded-xs flex items-center justify-center gap-2 hover:bg-[#083323] transition-colors">
                    <svg class="w-4 h-4 fill-current text-[#25D366]" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.174.086.275.072.376-.044.102-.115.434-.506.549-.679.116-.173.232-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/></svg>
                    <span>Stylist on WhatsApp</span>
                </a>
                <a href="{{ \App\Models\Setting::get('instagram_url', 'https://www.instagram.com/gaurisuits') }}"
                   target="_blank"
                   rel="noopener"
                   class="w-full py-2 px-3 border border-[#D4AF37]/60 bg-white text-[#58111A] hover:bg-[#58111A] hover:text-white text-xs font-semibold uppercase tracking-wider rounded-xs flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-4 h-4 fill-current text-[#D4AF37]" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    <span>Follow @gaurisuits</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Page Content -->
    <main class="pb-16 lg:pb-0">
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 text-sm text-emerald-800 flex items-center justify-between shadow-sm">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-rose-50 border-l-4 border-rose-600 p-4 text-sm text-rose-800 flex items-center justify-between shadow-sm">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Slide-over AJAX Cart Drawer -->
    <div x-data="cartDrawer"
         id="cart-drawer-container"
         @open-cart.window="open = true; fetchSummary()"
         @close-cart.window="open = false"
         @cart-updated.window="fetchSummary()"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <div @click="open = false" onclick="window.closeCart && window.closeCart()" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity cursor-pointer"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-6 sm:pl-10">
            <div class="w-screen max-w-md bg-[#FDFBF7] shadow-2xl flex flex-col justify-between relative z-10">

                <!-- Drawer Header (Royal Maroon & Gold) -->
                <div class="p-5 border-b border-[#D4AF37]/30 flex items-center justify-between bg-[#3B0A11] text-[#F7EED9]">
                    <div class="flex items-center gap-2.5">
                        <h2 class="font-serif text-lg font-normal tracking-wider text-[#F7EED9]">YOUR SHOPPING BAG</h2>
                        <span class="text-xs bg-[#D4AF37] text-[#3B0A11] font-bold px-2 py-0.5 rounded-full shadow" x-text="summary.total_items"></span>
                    </div>
                    <button @click="open = false" onclick="window.closeCart && window.closeCart()" class="text-[#E6CA65] hover:text-white p-1 cursor-pointer" aria-label="Close Shopping Bag">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Free Shipping Progress Indicator (Royal Emerald & Gold) -->
                <div class="bg-[#FCFBF8] border-b border-[#EFE9DE] px-6 py-3">
                    <div class="text-xs text-center font-medium text-[#2A1810]">
                        <template x-if="summary.free_shipping_unlocked">
                            <span class="text-[#0A3828] font-bold">🎉 Congratulations! You have unlocked FREE Express Shipping!</span>
                        </template>
                        <template x-if="!summary.free_shipping_unlocked">
                            <span>Add <strong class="text-[#58111A]"><span x-text="window.formatMoney(summary.amount_needed_free_shipping)"></span></strong> more to unlock <strong class="text-[#0A3828]">FREE SHIPPING</strong></span>
                        </template>
                    </div>
                    <div class="w-full bg-[#EFE9DE] rounded-full h-2 mt-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-[#0A3828] to-[#125B40] h-2 transition-all duration-500 rounded-full shadow-xs" :style="'width: ' + summary.free_shipping_percent + '%'"></div>
                    </div>
                </div>

                <!-- Items List -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <template x-if="summary.items.length === 0">
                        <div class="text-center py-16">
                            <svg class="w-12 h-12 text-[#C5A869]/50 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <p class="font-serif text-lg text-[#58111A]">Your cart is waiting for something beautiful.</p>
                            <a href="{{ route('shop.index') }}" @click="open = false" class="inline-block mt-4 text-xs font-bold uppercase tracking-widest text-[#C5A869] hover:underline">Explore Collections &rarr;</a>
                        </div>
                    </template>

                    <template x-for="item in summary.items" :key="item.id">
                        <div class="flex gap-4 pb-4 border-b border-[#EFE9DE] items-start">
                            <img :src="item.image" :alt="item.name" class="w-20 h-24 object-cover rounded-sm bg-[#EFE9DE]">
                            <div class="flex-1 min-w-0">
                                <a :href="item.url || (item.slug ? (window.apiUrl ? window.apiUrl('/product/' + item.slug) : '/product/' + item.slug) : '#')" class="font-serif text-sm font-semibold text-[#2A1810] hover:text-[#58111A] truncate block" x-text="item.name"></a>
                                <div class="text-xs text-[#6B5E55] mt-0.5 space-x-2">
                                    <span x-show="item.size" x-text="'Size: ' + item.size"></span>
                                    <span x-show="item.colour" x-text="'Colour: ' + item.colour"></span>
                                </div>
                                <div class="text-sm font-bold text-[#58111A] mt-1" x-text="window.formatMoney(item.price)"></div>

                                <!-- Quantity Stepper & Remove -->
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex items-center border border-[#C5A869]/40 rounded-sm">
                                        <button @click="updateQty(item.id, item.quantity - 1)" type="button" class="px-2 py-0.5 text-xs text-[#58111A] hover:bg-[#C5A869]/10">-</button>
                                        <span class="px-2 py-0.5 text-xs font-semibold" x-text="item.quantity"></span>
                                        <button @click="updateQty(item.id, item.quantity + 1)" type="button" class="px-2 py-0.5 text-xs text-[#58111A] hover:bg-[#C5A869]/10">+</button>
                                    </div>
                                    <button @click="removeItem(item.id)" type="button" class="text-xs text-[#7A1D2A] hover:underline">Remove</button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Footer Summary & Checkout -->
                <div class="p-6 bg-[#F7F4EE] border-t border-[#EFE9DE]" x-show="summary.items.length > 0">
                    <div class="space-y-2 mb-4 text-sm">
                        <div class="flex justify-between text-[#6B5E55]">
                            <span>Subtotal</span>
                            <span class="font-bold text-[#2A1810]" x-text="window.formatMoney(summary.subtotal)"></span>
                        </div>
                        <div class="flex justify-between text-emerald-700" x-show="summary.discount > 0">
                            <span>Discount <span x-show="summary.coupon_code" x-text="'(' + summary.coupon_code + ')'"></span></span>
                            <span class="font-bold" x-text="'-' + window.formatMoney(summary.discount)"></span>
                        </div>
                        <div class="flex justify-between text-xs text-[#8C713B]">
                            <span>Shipping &amp; Taxes</span>
                            <span>Calculated at checkout</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <a href="{{ route('checkout.index') }}" class="w-full block py-3.5 bg-[#58111A] hover:bg-[#430D14] text-[#F7EED9] text-center text-xs tracking-[0.2em] uppercase font-bold rounded-sm transition-colors shadow-md">
                            PROCEED TO CHECKOUT
                        </a>
                        <a href="{{ route('cart.index') }}" class="w-full block py-2.5 border border-[#58111A] text-[#58111A] text-center text-xs tracking-[0.15em] uppercase font-semibold rounded-sm hover:bg-[#58111A]/5 transition-colors">
                            VIEW FULL BAG
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Instant Search Modal -->
    <div x-data="searchModal"
         @open-search.window="open = true; $nextTick(() => $refs.searchInput.focus())"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-black/70 backdrop-blur-md flex items-start justify-center p-4 sm:p-6 md:p-20"
         style="display: none;">

        <div @click.away="open = false" class="bg-[#FDFBF7] w-full max-w-2xl rounded-sm shadow-2xl overflow-hidden border border-[#C5A869]/30">
            <div class="p-4 sm:p-6 border-b border-[#EFE9DE] flex items-center gap-3">
                <svg class="w-5 h-5 text-[#C5A869]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input x-ref="searchInput"
                       x-model="query"
                       @input="onInput"
                       type="text"
                       placeholder="Search royal suits, lehengas, jewellery, jhumkas, fabrics..."
                       class="w-full bg-transparent border-none text-base text-[#2A1810] focus:ring-0 placeholder-[#8C713B]/60">
                <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Suggestions Dropdown -->
            <div class="p-6 max-h-96 overflow-y-auto">
                <template x-if="loading">
                    <div class="py-6 text-center text-xs text-[#C5A869] font-medium animate-pulse">Searching royal archive...</div>
                </template>

                <template x-if="!loading && results.products.length === 0 && query.length >= 2">
                    <div class="py-6 text-center">
                        <p class="text-sm text-[#6B5E55]">We couldn't find matches for "<span x-text="query"></span>".</p>
                        <a href="{{ route('shop.index') }}" class="inline-block mt-3 text-xs font-bold text-[#58111A] hover:underline uppercase tracking-wider">Browse All Collections &rarr;</a>
                    </div>
                </template>

                <div x-show="results.products.length > 0">
                    <h3 class="text-xs uppercase font-bold tracking-widest text-[#8C713B] mb-3">Matching Products</h3>
                    <div class="space-y-3">
                        <template x-for="prod in results.products" :key="prod.id">
                            <a :href="prod.url" class="flex items-center gap-3 p-2 hover:bg-[#F7F4EE] rounded transition-colors">
                                <img :src="prod.image" :alt="prod.name" class="w-12 h-14 object-cover rounded bg-[#EFE9DE]">
                                <div class="flex-1">
                                    <h4 class="font-serif text-sm font-semibold text-[#2A1810]" x-text="prod.name"></h4>
                                    <span class="text-xs text-[#8C713B]" x-text="prod.category"></span>
                                </div>
                                <span class="text-sm font-bold text-[#58111A]" x-text="window.formatMoney(prod.price)"></span>
                            </a>
                        </template>
                    </div>
                </div>

                <div x-show="results.categories.length > 0" class="mt-4 pt-4 border-t border-[#EFE9DE]">
                    <h3 class="text-xs uppercase font-bold tracking-widest text-[#8C713B] mb-2">Categories</h3>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="cat in results.categories" :key="cat.name">
                            <a :href="cat.url" class="px-3 py-1 bg-[#F7F4EE] hover:bg-[#58111A] hover:text-white text-xs font-semibold rounded text-[#2A1810] transition-colors" x-text="cat.name"></a>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div x-data="quickViewModal"
         @open-quick-view.window="show($event.detail.id)"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-black/70 backdrop-blur-md flex items-center justify-center p-4"
         style="display: none;">

        <div @click.away="open = false" class="bg-[#FDFBF7] w-full max-w-3xl rounded-sm shadow-2xl overflow-hidden border border-[#C5A869]/30 relative">
            <button @click="open = false" class="absolute top-4 right-4 text-gray-500 hover:text-black z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <template x-if="loading">
                <div class="p-16 text-center text-[#58111A] font-serif text-lg">Loading details...</div>
            </template>

            <template x-if="!loading && product">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="h-80 md:h-full bg-[#FAF7F2] flex items-center justify-center border-b md:border-b-0 md:border-r border-[#E8DFD5]">
                        <img :src="product.primary_image" :alt="product.name" class="w-full h-full object-contain p-3">
                    </div>
                    <div class="p-6 sm:p-8 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] tracking-[0.25em] uppercase font-bold text-[#C5A869]" x-text="product.category_name"></span>
                            <h2 class="font-serif text-xl sm:text-2xl font-bold text-[#58111A] mt-1" x-text="product.name"></h2>
                            <div class="text-xs text-[#8C713B] mt-1" x-text="'SKU: ' + product.sku"></div>

                            <div class="flex items-baseline gap-3 mt-3">
                                <span class="text-xl font-bold text-[#58111A]" x-text="window.formatMoney(selectedVariant ? selectedVariant.price : product.effective_price)"></span>
                                <span x-show="product.sale_price" class="text-sm text-gray-400 line-through" x-text="window.formatMoney(product.price)"></span>
                                <span x-show="product.discount_percent > 0" class="text-xs font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded" x-text="product.discount_percent + '% OFF'"></span>
                            </div>

                            <p class="text-xs text-[#4A3E38] mt-3 leading-relaxed" x-text="product.short_description"></p>

                            <!-- Variant sizes if any -->
                            <div x-show="product.variants && product.variants.length > 0" class="mt-4">
                                <span class="text-xs font-bold text-[#2A1810] block mb-2">Select Variant:</span>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="v in product.variants" :key="v.id">
                                        <button @click="selectVariant(v)"
                                                type="button"
                                                class="px-3 py-1.5 text-xs font-semibold border rounded-sm transition-all"
                                                :class="selectedVariant && selectedVariant.id === v.id ? 'border-[#58111A] bg-[#58111A] text-[#F7EED9]' : 'border-[#EFE9DE] bg-white text-[#2A1810] hover:border-[#C5A869]'">
                                            <span x-text="(v.size || '') + (v.size && v.colour ? ' / ' : '') + (v.colour || '')"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#EFE9DE] space-y-3">
                            <button @click="addToCart" type="button" class="w-full py-3 bg-[#58111A] hover:bg-[#430D14] text-[#F7EED9] text-xs font-bold tracking-[0.2em] uppercase rounded-sm transition-colors shadow">
                                Add to Cart
                            </button>
                            <a :href="product.url" class="block text-center text-xs font-semibold text-[#8C713B] hover:text-[#58111A] uppercase tracking-wider">
                                View Full Product Details &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Floating WhatsApp Concierge Button -->
    @php
        $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '+919984700018');
        $cleanWa = preg_replace('/[^0-9]/', '', $whatsappNumber);
    @endphp
    <a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Hello Gauri Suits & Jewel, I would like to inquire about your collections.') }}"
       target="_blank"
       rel="noopener"
       class="fixed bottom-20 right-4 sm:bottom-6 sm:right-6 z-30 w-12 h-12 sm:w-14 sm:h-14 bg-[#25D366] text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-transform duration-300 group"
       title="Chat with our Personal Stylist on WhatsApp">
        <svg class="w-6 h-6 sm:w-7 sm:h-7 fill-current" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
    </a>

    <!-- Benefits Bar (4 Pillars Dark Emerald Green matching reference image) -->
    <section class="bg-[#0B2417] text-[#FAF4EC] border-t border-b border-[#D4AF37]/30 py-5 sm:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- 1: Free Shipping -->
                <div class="flex items-center gap-3 justify-center sm:justify-start">
                    <div class="text-[#E8C581] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#FAF4EC] uppercase tracking-wider">Free Shipping</h4>
                        <p class="text-[11px] text-[#E8C581]/90">On Orders Above ${{ number_format($storeSettings['free_shipping_threshold'] ?? 100) }}</p>
                    </div>
                </div>

                <!-- 2: Premium Quality -->
                <div class="flex items-center gap-3 justify-center sm:justify-start">
                    <div class="text-[#E8C581] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#FAF4EC] uppercase tracking-wider">Premium Quality</h4>
                        <p class="text-[11px] text-[#E8C581]/90">Always</p>
                    </div>
                </div>

                <!-- 3: 24/7 Support -->
                <div class="flex items-center gap-3 justify-center sm:justify-start">
                    <div class="text-[#E8C581] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#FAF4EC] uppercase tracking-wider">24/7 Support</h4>
                        <p class="text-[11px] text-[#E8C581]/90">We're Here to Help</p>
                    </div>
                </div>

                <!-- 4: Easy Returns -->
                <div class="flex items-center gap-3 justify-center sm:justify-start">
                    <div class="text-[#E8C581] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8v13m0-13V3.5a2.5 2.5 0 10-5 0V8m5 0V3.5a2.5 2.5 0 115 0V8m-10 0h10a2 2 0 012 2v9a2 2 0 01-2 2H7a2 2 0 01-2-2v-9a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#FAF4EC] uppercase tracking-wider">Easy Returns</h4>
                        <p class="text-[11px] text-[#E8C581]/90">Hassle-Free</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Dark Green Footer matching reference image -->
    <footer class="bg-[#061A10] text-[#FAF4EC] pt-12 pb-6 relative overflow-hidden border-t border-[#D4AF37]/30">
        <!-- Subtle Palace Domes Watermark on the Right -->
        <div class="absolute right-0 bottom-0 pointer-events-none opacity-20 w-48 sm:w-72 h-48 sm:h-64 bg-right-bottom bg-no-repeat bg-contain"
             style="background-image: url('{{ asset('images/reference/footer_palace.jpg') }}'); filter: brightness(1.5) contrast(1.2);"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 xl:gap-10 pb-10 border-b border-white/10">

                <!-- Column 1: Brand Info & Logo -->
                <div class="space-y-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-14 h-14 rounded-full p-0.5 bg-gradient-to-tr from-[#D4AF37] via-[#5C0B18] to-[#D4AF37] shadow-md shrink-0">
                            <img src="{{ asset('images/logo.png') }}" alt="Gauri Suits & Jewel" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div>
                            <span class="font-serif text-2xl tracking-[0.14em] text-[#E8C581] uppercase font-normal block leading-tight">
                                GAURI
                            </span>
                            <span class="text-[9px] tracking-[0.3em] text-[#FAF4EC] uppercase font-semibold font-sans block">
                                SUITS &amp; JEWEL
                            </span>
                        </div>
                    </a>
                    <p class="text-xs text-[#FAF4EC]/80 font-serif italic pt-1">
                        Tradition Meets Elegance
                    </p>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h3 class="font-sans text-xs uppercase tracking-[0.2em] text-[#E8C581] font-bold mb-3">Quick Links</h3>
                    <ul class="space-y-2 text-xs text-[#FAF4EC]/85 font-sans">
                        <li><a href="{{ route('home') }}" class="hover:text-[#E8C581] transition-colors">Home</a></li>
                        <li><a href="{{ route('pages.about') }}" class="hover:text-[#E8C581] transition-colors">About</a></li>
                        <li><a href="{{ route('shop.suits') }}" class="hover:text-[#E8C581] transition-colors">Suits</a></li>
                        <li><a href="{{ route('shop.jewellery') }}" class="hover:text-[#E8C581] transition-colors">Jewellery</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-[#E8C581] transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Column 3: Contact Us -->
                <div>
                    <h3 class="font-sans text-xs uppercase tracking-[0.2em] text-[#E8C581] font-bold mb-3">Contact Us</h3>
                    <ul class="space-y-2.5 text-xs text-[#FAF4EC]/85 font-sans">
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#E8C581] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.24 1.01l-2.21 2.2z"/></svg>
                            <a href="tel:0401365786" class="hover:text-[#E8C581] transition-colors">0401 365 786</a>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#E8C581] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                            <span>Geelong, Melbourne</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#E8C581] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            <a href="mailto:info@gaurisuits.com" class="hover:text-[#E8C581] transition-colors">info@gaurisuits.com</a>
                        </li>
                    </ul>
                </div>

                <!-- Column 4: Follow Us & Newsletter -->
                <div>
                    <h3 class="font-sans text-xs uppercase tracking-[0.2em] text-[#E8C581] font-bold mb-2">Follow Us</h3>
                    <div class="flex items-center space-x-3 text-[#FAF4EC] mb-4">
                        <a href="{{ \App\Models\Setting::get('facebook_url', 'https://facebook.com') }}" target="_blank" rel="noopener" class="w-7 h-7 rounded-full bg-white/10 hover:bg-[#E8C581] hover:text-[#061A10] flex items-center justify-center transition-colors" title="Facebook" aria-label="Facebook">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.595 0 9 1.582 9 4.615V8z"/></svg>
                        </a>
                        <a href="{{ \App\Models\Setting::get('instagram_url', 'https://www.instagram.com/gaurisuits') }}" target="_blank" rel="noopener" class="w-7 h-7 rounded-full bg-white/10 hover:bg-[#E8C581] hover:text-[#061A10] flex items-center justify-center transition-colors" title="Instagram" aria-label="Instagram">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://youtube.com/@gaurisuits" target="_blank" rel="noopener" class="w-7 h-7 rounded-full bg-white/10 hover:bg-[#E8C581] hover:text-[#061A10] flex items-center justify-center transition-colors" title="YouTube" aria-label="YouTube">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>

                    <h4 class="font-sans text-xs text-[#FAF4EC] font-semibold mb-2">Subscribe to our Newsletter</h4>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex items-center gap-1.5">
                        @csrf
                        <input type="email" name="email" required placeholder="Your Email Address" class="bg-white text-[#2A1810] placeholder-stone-500 text-xs px-3 py-2 rounded-xs focus:outline-none w-full border-0">
                        <button type="submit" class="bg-[#E8C581] hover:bg-white text-[#061A10] font-sans font-bold text-xs uppercase px-3 py-2 rounded-xs tracking-wider transition-colors shrink-0">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Sub-Footer Bar matching reference image -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-[#FAF4EC]/70 gap-2">
                <p>&copy; 2025 Gauri Suits &amp; Jewel. All Rights Reserved.</p>
                <p class="text-right">Designed with <span class="text-rose-400">&hearts;</span> in Melbourne</p>
            </div>
        </div>
    </footer>

    <!-- Mobile App Bottom Navigation Bar (Fixed for Mobile Screens) -->
    <nav aria-label="Mobile Bottom Navigation" class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-[#FAF7F2]/95 backdrop-blur-md border-t border-[#D4AF37]/35 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] py-1.5 px-3 flex items-center justify-around text-[#3B0A11]">
        <!-- 1: Home -->
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center text-center py-1 px-2.5 transition-colors {{ request()->routeIs('home') ? 'text-[#58111A]' : 'text-[#6B5E55] hover:text-[#58111A]' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('home') ? 'stroke-[2.2] text-[#58111A]' : 'stroke-[1.6]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[9.5px] uppercase tracking-wider font-semibold mt-0.5 {{ request()->routeIs('home') ? 'text-[#58111A] font-bold' : '' }}">Home</span>
        </a>

        <!-- 2: Suits -->
        <a href="{{ route('shop.suits') }}" class="flex flex-col items-center justify-center text-center py-1 px-2.5 transition-colors {{ request()->is('suits*') || request()->is('punjabi-suits*') ? 'text-[#58111A]' : 'text-[#6B5E55] hover:text-[#58111A]' }}">
            <svg class="w-5 h-5 {{ request()->is('suits*') || request()->is('punjabi-suits*') ? 'stroke-[2.2] text-[#58111A]' : 'stroke-[1.6]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10l2 14H5L7 7z M9 7V4a3 3 0 016 0v3"/>
            </svg>
            <span class="text-[9.5px] uppercase tracking-wider font-semibold mt-0.5 {{ request()->is('suits*') ? 'text-[#58111A] font-bold' : '' }}">Suits</span>
        </a>

        <!-- 3: Jewellery -->
        <a href="{{ route('shop.jewellery') }}" class="flex flex-col items-center justify-center text-center py-1 px-2.5 transition-colors {{ request()->is('jewellery*') ? 'text-[#58111A]' : 'text-[#6B5E55] hover:text-[#58111A]' }}">
            <svg class="w-5 h-5 {{ request()->is('jewellery*') ? 'stroke-[2.2] text-[#58111A]' : 'stroke-[1.6]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            <span class="text-[9.5px] uppercase tracking-wider font-semibold mt-0.5 {{ request()->is('jewellery*') ? 'text-[#58111A] font-bold' : '' }}">Jewels</span>
        </a>

        <!-- 4: Wishlist -->
        <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center justify-center text-center py-1 px-2.5 transition-colors relative {{ request()->routeIs('wishlist.*') ? 'text-[#083323]' : 'text-[#6B5E55] hover:text-[#083323]' }}">
            <div class="relative">
                <svg class="w-5 h-5 {{ request()->routeIs('wishlist.*') ? 'stroke-[2.2] text-[#083323]' : 'stroke-[1.6]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span id="mobile-bottom-wishlist-badge" class="absolute -top-1 -right-2 bg-[#083323] text-white text-[8px] min-w-[14px] h-[14px] px-0.5 rounded-full flex items-center justify-center font-bold" style="display: {{ ($wishlistCount ?? 0) > 0 ? 'flex' : 'none' }};">
                    {{ $wishlistCount ?? 0 }}
                </span>
            </div>
            <span class="text-[9.5px] uppercase tracking-wider font-semibold mt-0.5 {{ request()->routeIs('wishlist.*') ? 'text-[#083323] font-bold' : '' }}">Saved</span>
        </a>

        <!-- 5: Bag Trigger -->
        <button @click="$dispatch('open-cart')"
                onclick="window.openCart && window.openCart()"
                type="button"
                class="flex flex-col items-center justify-center text-center py-1 px-2.5 transition-colors relative text-[#6B5E55] hover:text-[#58111A] cursor-pointer"
                aria-label="Open Shopping Bag">
            <div class="relative">
                <svg class="w-5 h-5 stroke-[1.6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span id="mobile-bottom-cart-badge" class="absolute -top-1 -right-2 bg-[#58111A] text-[#F7EED9] text-[8px] min-w-[14px] h-[14px] px-0.5 rounded-full flex items-center justify-center font-bold border border-[#D4AF37]/50" style="display: {{ ($cartCount ?? 0) > 0 ? 'flex' : 'none' }};">
                    {{ $cartCount ?? 0 }}
                </span>
            </div>
            <span class="text-[9.5px] uppercase tracking-wider font-semibold mt-0.5">Bag</span>
        </button>
    </nav>

    <!-- Global Toast Container -->
    <div x-data="{ toasts: [] }"
         @toast-message.window="toasts.push({ id: Date.now(), message: $event.detail.message, type: $event.detail.type }); setTimeout(() => toasts.shift(), 3500)"
         class="fixed bottom-6 left-6 z-50 space-y-2 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div class="pointer-events-auto px-4 py-3 rounded shadow-xl text-xs font-semibold tracking-wide flex items-center gap-2 border transition-all duration-300"
                 :class="toast.type === 'error' ? 'bg-rose-900 text-rose-100 border-rose-700' : 'bg-[#58111A] text-[#F7EED9] border-[#C5A869]'">
                <span x-text="toast.type === 'error' ? '⚠️' : '✨'"></span>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    @stack('scripts')
</body>
</html>
