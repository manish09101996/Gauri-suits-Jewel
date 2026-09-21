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

    <!-- Top Announcement Bar (Slim Royal Emerald & Gold with Responsive Wrapping) -->
    @if(isset($announcement) && $announcement->is_active)
        <aside aria-label="Announcement" class="bg-[#083323] text-[#E6CA65] text-[10px] sm:text-[11px] py-1.5 px-3 sm:px-4 text-center font-sans tracking-[0.14em] sm:tracking-[0.22em] uppercase flex items-center justify-center flex-wrap gap-x-2 gap-y-0.5 border-b border-[#D4AF37]/25 shadow-xs">
            <span>✨ {{ $announcement->title }}</span>
            @if($announcement->link_url)
                <a href="{{ $announcement->link_url }}" class="underline hover:text-white transition-colors underline-offset-4 ml-0.5 font-semibold shrink-0">
                    {{ $announcement->button_text ?: 'Shop Now' }} &rarr;
                </a>
            @endif
        </aside>
    @else
        <aside aria-label="Announcement" class="bg-[#083323] text-[#E6CA65] text-[10px] sm:text-[11px] py-1.5 px-3 sm:px-4 text-center font-sans tracking-[0.14em] sm:tracking-[0.22em] uppercase flex items-center justify-center flex-wrap gap-x-2 gap-y-0.5 border-b border-[#D4AF37]/25 shadow-xs">
            <span>✨ COMPLIMENTARY EXPRESS SHIPPING ABOVE {{ $currencySymbol ?? '$' }}{{ number_format($storeSettings['free_shipping_threshold'] ?? 299) }}</span>
            <a href="{{ route('shop.index') }}" class="underline hover:text-white transition-colors underline-offset-4 ml-0.5 font-semibold shrink-0">EXPLORE &rarr;</a>
        </aside>
    @endif

    <!-- Main Navigation Header (Light Ivory / Champagne with Maroon Accents & Gold Details) -->
    <!-- Main Navigation Header (Light Ivory / Champagne with Maroon Accents & Gold Details) -->
    <header x-data class="sticky top-0 z-40 bg-[#FAF7F2]/95 backdrop-blur-md border-b border-[#E8DFD5] text-[#2D1C1B] transition-all duration-300 shadow-[0_2px_15px_rgba(0,0,0,0.03)]">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 sm:h-20 md:h-24">

                <!-- Left: Mobile Menu Toggle & Brand Logo -->
                <div class="flex items-center gap-1.5 sm:gap-6 min-w-0">
                    <button @click="$dispatch('toggle-mobile-menu')"
                            type="button"
                            class="lg:hidden w-11 h-11 -ml-1 flex items-center justify-center text-[#2D1C1B] hover:text-[#58111A] hover:bg-black/5 active:bg-black/10 rounded-sm focus:outline-none transition-colors cursor-pointer"
                            aria-label="Open Navigation Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Finalized Brand Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3.5 group py-1 min-w-0" title="Gauri Suits & Jewel - Tradition Meets Elegance">
                        <div class="relative w-9 h-9 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-full p-0.5 bg-gradient-to-tr from-[#D4AF37] via-[#0A3828] to-[#D4AF37] shadow-sm shrink-0 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('images/logo.png') }}" alt="Gauri Suits & Jewel" class="w-full h-full object-cover rounded-full">
                        </div>
                        <div class="flex flex-col items-start text-left min-w-0">
                            <span class="font-serif text-lg sm:text-2xl md:text-3xl tracking-[0.12em] sm:tracking-[0.16em] text-[#3B0A11] uppercase font-normal leading-tight transition-colors group-hover:text-[#58111A] truncate">
                                GAURI
                            </span>
                            <span class="text-[7.5px] sm:text-[9.5px] md:text-[10px] tracking-[0.24em] sm:tracking-[0.36em] text-[#8C713B] uppercase font-semibold font-sans -mt-0.5 whitespace-nowrap">
                                SUITS &amp; JEWEL
                            </span>
                            <span class="hidden sm:inline-block text-[7.5px] md:text-[8px] tracking-[0.24em] text-[#6B5E55] uppercase font-sans mt-0.5 font-medium">
                                TRADITION MEETS ELEGANCE
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Center: Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-6 xl:space-x-8 text-xs font-semibold uppercase tracking-[0.18em] text-[#2D1C1B]">
                    <a href="{{ route('home') }}" class="nav-link-royal hover:text-[#58111A] {{ request()->routeIs('home') ? 'is-active text-[#58111A] font-bold' : '' }}">Home</a>
                    <a href="{{ route('shop.new-arrivals') }}" class="nav-link-royal text-[#0A3828] hover:text-[#125B40] font-bold {{ request()->routeIs('shop.new-arrivals') ? 'is-active' : '' }}">New Arrivals</a>
                    <a href="{{ route('shop.suits') }}" class="nav-link-royal hover:text-[#58111A] {{ request()->is('suits*') || request()->is('punjabi-suits*') ? 'is-active text-[#58111A] font-bold' : '' }}">Suits</a>
                    <a href="{{ route('shop.jewellery') }}" class="nav-link-royal hover:text-[#58111A] {{ request()->is('jewellery*') ? 'is-active text-[#58111A] font-bold' : '' }}">Jewellery</a>
                    <a href="{{ route('shop.wedding-collection') }}" class="nav-link-royal hover:text-[#58111A] {{ request()->is('wedding*') || request()->is('bridal*') ? 'is-active text-[#58111A] font-bold' : '' }}">Bridal</a>
                    <a href="{{ route('shop.best-sellers') }}" class="nav-link-royal hover:text-[#58111A] {{ request()->routeIs('shop.best-sellers') ? 'is-active text-[#58111A] font-bold' : '' }}">Best Sellers</a>
                    <a href="{{ route('shop.sale') }}" class="nav-link-royal text-[#7A1D2A] hover:text-[#58111A] font-bold {{ request()->routeIs('shop.sale') ? 'is-active' : '' }}">Sale</a>
                </nav>

                <!-- Right: Minimal Refined Icons (Search, Account, Wishlist, Cart) -->
                <div class="flex items-center gap-0.5 sm:gap-2 text-[#2D1C1B] pr-0.5 sm:pr-0 shrink-0">
                    <!-- Search Trigger -->
                    <button @click="$dispatch('open-search')" type="button" class="p-2 sm:p-2.5 hover:text-[#8C713B] transition-colors focus:outline-none rounded-sm hover:bg-black/5" title="Search" aria-label="Search Products">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>

                    <!-- Account (Shown on sm+ screens, easily accessed in mobile drawer on phones) -->
                    <a href="{{ auth()->check() ? route('account.dashboard') : route('customer.login') }}" class="hidden sm:inline-flex p-2 sm:p-2.5 hover:text-[#8C713B] transition-colors rounded-sm hover:bg-black/5" title="Account" aria-label="Customer Account">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </a>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" class="p-2 sm:p-2.5 hover:text-[#8C713B] transition-colors relative rounded-sm hover:bg-black/5" title="Wishlist" aria-label="Customer Wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span id="header-wishlist-badge" class="absolute -top-0.5 -right-0.5 bg-[#0A3828] text-white text-[9px] sm:text-[10px] min-w-[16px] h-[16px] px-1 rounded-full flex items-center justify-center font-bold shadow-xs border border-white leading-none pointer-events-none" style="display: {{ ($wishlistCount ?? 0) > 0 ? 'flex' : 'none' }};">
                            {{ $wishlistCount ?? 0 }}
                        </span>
                    </a>

                    <!-- Cart Drawer Trigger with Protected Safe Margins and Sharp Badge -->
                    <button @click="$dispatch('open-cart')" type="button" class="p-2 sm:p-2.5 hover:text-[#8C713B] transition-colors relative focus:outline-none flex items-center justify-center rounded-sm hover:bg-black/5 shrink-0" title="Shopping Cart" aria-label="Shopping Bag">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span id="header-cart-badge"
                              class="absolute -top-1 -right-1 bg-[#58111A] text-[#F7EED9] text-[9px] sm:text-[10px] min-w-[17px] h-[17px] sm:min-w-[18px] sm:h-[18px] px-1 rounded-full flex items-center justify-center font-bold shadow-xs border border-[#D4AF37]/50 pointer-events-none z-10 leading-none"
                              style="display: {{ ($cartCount ?? 0) > 0 ? 'flex' : 'none' }};">
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

                <!-- Navigation Links -->
                <nav class="px-5 py-4 space-y-1 text-xs font-semibold tracking-[0.16em] uppercase text-[#2D1C1B]">
                    <a href="{{ route('home') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#58111A] {{ request()->routeIs('home') ? 'text-[#58111A] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Home</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.new-arrivals') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] text-[#0A3828] font-bold">
                        <div class="flex items-center gap-2">
                            <span>New Arrivals</span>
                            <span class="px-1.5 py-0.5 text-[8.5px] bg-[#0A3828] text-[#E6CA65] font-bold tracking-wider rounded-xs">NEW</span>
                        </div>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.suits') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#58111A] {{ request()->is('suits*') || request()->is('punjabi-suits*') ? 'text-[#58111A] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Punjabi Suits</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.jewellery') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#58111A] {{ request()->is('jewellery*') ? 'text-[#58111A] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Heirloom Jewellery</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.wedding-collection') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#58111A] {{ request()->is('wedding*') || request()->is('bridal*') ? 'text-[#58111A] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Bridal Couture</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.best-sellers') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] hover:text-[#58111A] {{ request()->routeIs('shop.best-sellers') ? 'text-[#58111A] font-bold bg-[#FAF7F2]' : '' }}">
                        <span>Best Sellers</span>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>
                    <a href="{{ route('shop.sale') }}" @click="close()" class="flex items-center justify-between py-2.5 px-2 rounded-xs hover:bg-[#FAF7F2] text-[#7A1D2A] font-bold">
                        <div class="flex items-center gap-2">
                            <span>Royal Sale</span>
                            <span class="px-1.5 py-0.5 text-[8.5px] bg-[#7A1D2A] text-white font-bold tracking-wider rounded-xs">OFFERS</span>
                        </div>
                        <span class="text-stone-400">&rsaquo;</span>
                    </a>

                    <div class="pt-3 mt-2 border-t border-[#E8DFD5] space-y-1 text-xs font-normal normal-case tracking-normal">
                        <a href="{{ route('order.track') }}" @click="close()" class="flex items-center gap-2.5 py-2 px-2 text-[#4A3E38] hover:text-[#58111A] rounded-xs hover:bg-[#FAF7F2]">
                            <svg class="w-4 h-4 text-[#8C713B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2"/></svg>
                            <span>Track Your Order</span>
                        </a>
                        <a href="{{ route('pages.about') }}" @click="close()" class="flex items-center gap-2.5 py-2 px-2 text-[#4A3E38] hover:text-[#58111A] rounded-xs hover:bg-[#FAF7F2]">
                            <svg class="w-4 h-4 text-[#8C713B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Our Legacy &amp; Atelier Craft</span>
                        </a>
                        <a href="{{ route('pages.contact') }}" @click="close()" class="flex items-center gap-2.5 py-2 px-2 text-[#4A3E38] hover:text-[#58111A] rounded-xs hover:bg-[#FAF7F2]">
                            <svg class="w-4 h-4 text-[#8C713B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Contact Concierge</span>
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
            </div>
        </div>
    </div>

    <!-- Main Page Content -->
    <main>
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
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <div @click="open = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md bg-[#FDFBF7] shadow-2xl flex flex-col justify-between">

                <!-- Drawer Header (Royal Maroon & Gold) -->
                <div class="p-5 border-b border-[#D4AF37]/30 flex items-center justify-between bg-[#3B0A11] text-[#F7EED9]">
                    <div class="flex items-center gap-2.5">
                        <h2 class="font-serif text-lg font-normal tracking-wider text-[#F7EED9]">YOUR SHOPPING BAG</h2>
                        <span class="text-xs bg-[#D4AF37] text-[#3B0A11] font-bold px-2 py-0.5 rounded-full shadow" x-text="summary.total_items"></span>
                    </div>
                    <button @click="open = false" class="text-[#E6CA65] hover:text-white p-1">
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
                    <div class="h-80 md:h-full bg-[#EFE9DE]">
                        <img :src="product.primary_image" :alt="product.name" class="w-full h-full object-cover">
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
       class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-30 w-12 h-12 sm:w-14 sm:h-14 bg-[#25D366] text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-transform duration-300 group"
       title="Chat with our Personal Stylist on WhatsApp">
        <svg class="w-6 h-6 sm:w-7 sm:h-7 fill-current" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
    </a>

    <!-- Trust / Service Bar (4 Pillars matching screenshot) -->
    <section class="bg-[#F9F6F0] border-t border-b border-[#E3DACD] py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- 1: Free Shipping -->
                <div class="flex items-center gap-3 sm:gap-4 justify-center sm:justify-start">
                    <div class="text-[#8C713B] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M8 17h8m-8 0a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0zm-8-3h12V7a2 2 0 00-2-2H4a2 2 0 00-2 2v8h2m14-5h3l3 4v3h-6v-7z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#3B0A11] uppercase tracking-wider">Free Shipping</h4>
                        <p class="text-[11px] text-[#6B5E55]">Above {{ $currencySymbol ?? '$' }}{{ number_format($storeSettings['free_shipping_threshold'] ?? 299) }}</p>
                    </div>
                </div>

                <!-- 2: Easy Returns -->
                <div class="flex items-center gap-3 sm:gap-4 justify-center sm:justify-start">
                    <div class="text-[#8C713B] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#3B0A11] uppercase tracking-wider">Easy Returns</h4>
                        <p class="text-[11px] text-[#6B5E55]">Hassle Free</p>
                    </div>
                </div>

                <!-- 3: Authentic Products -->
                <div class="flex items-center gap-3 sm:gap-4 justify-center sm:justify-start">
                    <div class="text-[#8C713B] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#3B0A11] uppercase tracking-wider">Authentic Products</h4>
                        <p class="text-[11px] text-[#6B5E55]">Premium Quality</p>
                    </div>
                </div>

                <!-- 4: Dedicated Support -->
                <div class="flex items-center gap-3 sm:gap-4 justify-center sm:justify-start">
                    <div class="text-[#8C713B] shrink-0">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h4 class="font-sans text-xs sm:text-[13px] font-bold text-[#3B0A11] uppercase tracking-wider">Dedicated Support</h4>
                        <p class="text-[11px] text-[#6B5E55]">We're Here to Help</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Light Luxury Brand Footer (Warm Ivory/Champagne Canvas with Maroon & Gold Accents) -->
    <footer x-data="{ shopOpen: false, careOpen: false, atelierOpen: false }" class="bg-[#F9F6F0] text-[#2A1810] pt-14 pb-10 border-t border-[#E3DACD]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 xl:gap-10 pb-12 border-b border-[#E3DACD]">

                <!-- Column 1: Shop -->
                <div class="border-b border-[#E8DFD5] pb-4 lg:border-none lg:pb-0">
                    <button @click="shopOpen = !shopOpen" type="button" class="w-full flex items-center justify-between lg:justify-start lg:cursor-default text-left py-1 lg:py-0">
                        <h3 class="font-serif text-xs uppercase tracking-[0.25em] text-[#58111A] font-bold">Shop</h3>
                        <span class="lg:hidden text-[#8C713B] transition-transform duration-200" :class="shopOpen ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </button>
                    <ul :class="shopOpen ? 'block' : 'hidden lg:block'" class="mt-4 space-y-2.5 text-xs text-[#554740]">
                        <li><a href="{{ route('shop.suits') }}" class="hover:text-[#58111A] transition-colors">Punjabi Suits</a></li>
                        <li><a href="{{ route('shop.designer-suits') }}" class="hover:text-[#58111A] transition-colors">Patiala Salwars</a></li>
                        <li><a href="{{ route('shop.jewellery') }}" class="hover:text-[#58111A] transition-colors">Heirloom Jewellery</a></li>
                        <li><a href="{{ route('shop.wedding-collection') }}" class="hover:text-[#58111A] transition-colors">Bridal Couture</a></li>
                        <li><a href="{{ route('shop.new-arrivals') }}" class="hover:text-[#0A3828] font-semibold transition-colors">New In Atelier</a></li>
                        <li><a href="{{ route('shop.sale') }}" class="hover:text-[#7A1D2A] text-[#7A1D2A] font-semibold transition-colors">Festive Sale</a></li>
                    </ul>
                </div>

                <!-- Column 2: Client Care -->
                <div class="border-b border-[#E8DFD5] pb-4 lg:border-none lg:pb-0">
                    <button @click="careOpen = !careOpen" type="button" class="w-full flex items-center justify-between lg:justify-start lg:cursor-default text-left py-1 lg:py-0">
                        <h3 class="font-serif text-xs uppercase tracking-[0.25em] text-[#58111A] font-bold">Client Care</h3>
                        <span class="lg:hidden text-[#8C713B] transition-transform duration-200" :class="careOpen ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </button>
                    <ul :class="careOpen ? 'block' : 'hidden lg:block'" class="mt-4 space-y-2.5 text-xs text-[#554740]">
                        <li><a href="{{ route('order.track') }}" class="hover:text-[#58111A] transition-colors">Track Order</a></li>
                        <li><a href="{{ route('pages.shipping-policy') }}" class="hover:text-[#58111A] transition-colors">Shipping &amp; Delivery</a></li>
                        <li><a href="{{ route('pages.return-policy') }}" class="hover:text-[#58111A] transition-colors">Returns &amp; Exchanges</a></li>
                        <li><a href="{{ route('pages.refund-policy') }}" class="hover:text-[#58111A] transition-colors">Refund Policy</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-[#58111A] transition-colors">FAQs</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-[#58111A] transition-colors">Contact Concierge</a></li>
                    </ul>
                </div>

                <!-- Column 3: Center Grand Brand Area with Finalized Logo -->
                <div class="col-span-1 md:col-span-2 lg:col-span-1 flex flex-col items-center justify-center text-center space-y-2 py-6 lg:py-0 lg:border-x border-[#E3DACD]/80 px-4">
                    <a href="{{ route('home') }}" class="group inline-block" title="Gauri Suits & Jewel">
                        <div class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-full p-0.5 bg-gradient-to-tr from-[#D4AF37] via-[#0A3828] to-[#D4AF37] shadow-md shrink-0 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('images/logo.png') }}" alt="Gauri Suits & Jewel" class="w-full h-full object-cover rounded-full">
                        </div>
                    </a>
                    <span class="font-serif text-2xl sm:text-3xl tracking-[0.18em] text-[#3B0A11] uppercase font-normal block leading-tight mt-1">
                        GAURI
                    </span>
                    <span class="text-[9.5px] sm:text-[10px] tracking-[0.4em] text-[#8C713B] uppercase font-semibold block -mt-1 font-sans">
                        SUITS &amp; JEWEL
                    </span>
                    <p class="text-xs text-[#6B5E55] font-serif italic max-w-xs pt-1 leading-relaxed">
                        Tradition Meets Elegance
                    </p>
                    <span class="text-[9px] tracking-[0.32em] text-[#0A3828] uppercase font-semibold block pt-0.5 font-sans">
                        CHANDIGARH • AMRITSAR
                    </span>
                </div>

                <!-- Column 4: The Atelier -->
                <div class="border-b border-[#E8DFD5] pb-4 lg:border-none lg:pb-0">
                    <button @click="atelierOpen = !atelierOpen" type="button" class="w-full flex items-center justify-between lg:justify-start lg:cursor-default text-left py-1 lg:py-0">
                        <h3 class="font-serif text-xs uppercase tracking-[0.25em] text-[#58111A] font-bold">The Atelier</h3>
                        <span class="lg:hidden text-[#8C713B] transition-transform duration-200" :class="atelierOpen ? 'rotate-180' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </button>
                    <ul :class="atelierOpen ? 'block' : 'hidden lg:block'" class="mt-4 space-y-2.5 text-xs text-[#554740]">
                        <li><a href="{{ route('pages.about') }}" class="hover:text-[#58111A] transition-colors">Our Legacy &amp; Craft</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-[#58111A] transition-colors">Editorial Journal</a></li>
                        <li><a href="{{ route('pages.privacy-policy') }}" class="hover:text-[#58111A] transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="hover:text-[#58111A] transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Column 5: Social & Newsletter -->
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <h3 class="font-serif text-xs uppercase tracking-[0.25em] text-[#58111A] font-bold mb-3">Stay Connected</h3>
                    <p class="text-xs text-[#6B5E55] mb-4 leading-relaxed">Subscribe for royal seasonal trunk shows and private bridal previews.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2.5">
                        @csrf
                        <div class="relative">
                            <input type="email" name="email" required placeholder="Enter your email" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] placeholder-[#8C713B]/60 focus:outline-none focus:border-[#58111A] focus:ring-1 focus:ring-[#58111A] shadow-2xs">
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-[#083323] hover:bg-[#0A3828] text-[#E6CA65] hover:text-white text-[10.5px] uppercase font-bold tracking-[0.22em] rounded-xs transition-colors border border-[#D4AF37]/35 shadow-xs">
                            JOIN ATELIER
                        </button>
                    </form>
                    <div class="pt-5 flex items-center space-x-3 text-[#58111A]">
                        <a href="{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-[#D5CBC0] flex items-center justify-center hover:border-[#58111A] hover:text-[#C5A869] transition-colors" title="Instagram" aria-label="Instagram">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="{{ \App\Models\Setting::get('facebook_url', 'https://facebook.com') }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-[#D5CBC0] flex items-center justify-center hover:border-[#58111A] hover:text-[#C5A869] transition-colors" title="Facebook" aria-label="Facebook">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.688 5H18V0h-3.808C10.595 0 9 1.582 9 4.615V8z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright & Accepted Payments -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-[#6B5E55] gap-4">
                <p>&copy; {{ date('Y') }} Gauri Suits &amp; Jewel. All Rights Reserved. Handcrafted in Punjab.</p>
                <div class="flex flex-wrap items-center justify-center gap-2 text-[10px] tracking-wider uppercase font-semibold text-[#4A3E38]">
                    <span class="px-2.5 py-1 bg-white rounded-xs border border-[#D5CBC0] shadow-2xs">Razorpay</span>
                    <span class="px-2.5 py-1 bg-white rounded-xs border border-[#D5CBC0] shadow-2xs">UPI</span>
                    <span class="px-2.5 py-1 bg-white rounded-xs border border-[#D5CBC0] shadow-2xs">Visa / Mastercard</span>
                    <span class="px-2.5 py-1 bg-white rounded-xs border border-[#D5CBC0] shadow-2xs">Cash on Delivery</span>
                </div>
            </div>
        </div>
    </footer>

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
