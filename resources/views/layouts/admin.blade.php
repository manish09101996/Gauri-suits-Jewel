<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | Gauri Suits &amp; Jewel</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/admin.js'])

    @stack('styles')
</head>
<body class="h-full bg-[#1B120C]/5 text-[#2A1810] font-sans antialiased"
      x-data="adminLayout">

    <div class="min-h-full flex">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"
             style="display: none;"></div>

        <!-- Sogat-Style Dark Luxury Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-[#1A120B] text-[#E3CE9B] border-r border-[#C5A869]/20 transition-all duration-300 select-none"
               :class="{
                   'w-64': !sidebarCollapsed && sidebarOpen,
                   'w-20': sidebarCollapsed && sidebarOpen,
                   '-translate-x-full lg:translate-x-0': !sidebarOpen
               }">

            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center justify-between px-5 border-b border-[#C5A869]/20 bg-[#140D07]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 overflow-hidden">
                    <div class="w-11 h-11 rounded-full p-0.5 bg-gradient-to-tr from-[#D4AF37] via-[#0A3828] to-[#D4AF37] shadow shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="Gauri Suits & Jewel" class="w-full h-full object-cover rounded-full">
                    </div>
                    <div x-show="!sidebarCollapsed" class="transition-opacity duration-200">
                        <span class="font-serif text-lg font-bold text-[#F7EED9] tracking-wider block leading-tight">GAURI</span>
                        <span class="text-[9px] tracking-[0.3em] text-[#D4AF37] font-bold block uppercase">Command Center</span>
                    </div>
                </a>

                <!-- Collapse Toggle (Desktop only) -->
                <button @click="toggleCollapse()" type="button" class="hidden lg:block text-[#C5A869] hover:text-white p-1 rounded hover:bg-white/5 focus:outline-none" title="Toggle Sidebar">
                    <svg class="w-5 h-5 transition-transform" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links (Scrollable) -->
            <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-1 text-xs tracking-wider font-semibold">

                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.dashboard') || request()->is('admin') ? 'bg-[#58111A] text-[#F7EED9] shadow border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Dashboard' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Dashboard</span>
                </a>

                <!-- 2. Reports -->
                <a href="{{ route('admin.reports.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Reports' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Reports</span>
                </a>

                <!-- 3. Live Visitors -->
                <a href="{{ route('admin.live-visitors.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.live-visitors.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Live Visitors' : ''">
                    <span class="relative flex h-2.5 w-2.5 shrink-0 ml-1 mr-1.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span x-show="!sidebarCollapsed" class="truncate">Live Visitors</span>
                </a>

                <div class="pt-3 pb-1 px-3.5 text-[10px] uppercase font-bold text-[#8C713B] tracking-[0.2em]" x-show="!sidebarCollapsed">Catalog</div>

                <!-- 4. Products -->
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Products' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Products</span>
                </a>

                <!-- 5. Categories -->
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Categories' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Categories</span>
                </a>

                <div class="pt-3 pb-1 px-3.5 text-[10px] uppercase font-bold text-[#8C713B] tracking-[0.2em]" x-show="!sidebarCollapsed">Sales &amp; Clients</div>

                <!-- 6. Orders -->
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.orders.*') && !request()->routeIs('admin.manual-orders.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Orders' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Orders</span>
                </a>

                <!-- 7. Manual Orders -->
                <a href="{{ route('admin.manual-orders.create') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.manual-orders.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Manual Orders' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Manual Orders</span>
                </a>

                <!-- 8. Customers -->
                <a href="{{ route('admin.customers.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Customers' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Customers</span>
                </a>

                <!-- 9. Abandonments -->
                <a href="{{ route('admin.abandoned-carts.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.abandoned-carts.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Abandonments' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Abandonments</span>
                </a>

                <!-- 10. Coupons -->
                <a href="{{ route('admin.coupons.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.coupons.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Coupons' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Coupons</span>
                </a>

                <!-- 11. Reviews -->
                <a href="{{ route('admin.reviews.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Reviews' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Reviews</span>
                </a>

                <div class="pt-3 pb-1 px-3.5 text-[10px] uppercase font-bold text-[#8C713B] tracking-[0.2em]" x-show="!sidebarCollapsed">Content &amp; Operations</div>

                <!-- 12. Blog -->
                <a href="{{ route('admin.blog.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.blog.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Blog' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Blog CMS</span>
                </a>

                <!-- 13. Hero Banners -->
                <a href="{{ route('admin.banners.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Hero Banners' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate font-semibold text-white">Hero Banners</span>
                </a>

                <!-- 13b. Videos -->
                <a href="{{ route('admin.videos.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.videos.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Videos' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Videos</span>
                </a>

                <!-- 14. Reels -->
                <a href="{{ route('admin.reels.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.reels.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Reels' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Reels</span>
                </a>

                <!-- 15. Shipping -->
                <a href="{{ route('admin.shipping.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.shipping.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Shipping' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Shipping</span>
                </a>

                <!-- 16. Settings -->
                <a href="{{ route('admin.settings.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Settings' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Settings</span>
                </a>

                <!-- 17. Admins / Staff -->
                <a href="{{ route('admin.admins.index') }}"
                   class="flex items-center gap-3 px-3.5 py-3 rounded-sm transition-colors {{ request()->routeIs('admin.admins.*') ? 'bg-[#58111A] text-[#F7EED9] border-l-4 border-[#C5A869]' : 'text-[#E3CE9B]/80 hover:bg-white/5 hover:text-white' }}"
                   :title="sidebarCollapsed ? 'Staff & Roles' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate">Staff &amp; Roles</span>
                </a>
            </nav>

            <!-- Bottom: Return to Storefront -->
            <div class="p-4 border-t border-[#C5A869]/20 bg-[#140D07]">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded text-xs text-[#C5A869] hover:text-white hover:bg-white/5 transition-colors" :title="sidebarCollapsed ? 'Back to Store' : ''">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span x-show="!sidebarCollapsed" class="truncate font-bold">Back to Store</span>
                </a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300"
             :class="{
                 'lg:pl-64': !sidebarCollapsed,
                 'lg:pl-20': sidebarCollapsed
             }">

            <!-- Top Header (Sogat Style) -->
            <header class="h-20 bg-white border-b border-[#EFE9DE] flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shadow-xs">
                <!-- Left: Mobile Toggle & Page Title -->
                <div class="flex items-center gap-4">
                    <button @click="toggleMobileSidebar()" type="button" class="lg:hidden p-2 text-[#58111A] hover:bg-gray-100 rounded">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h1 class="font-serif text-xl sm:text-2xl font-bold text-[#2A1810]">@yield('header_title', 'Dashboard')</h1>
                        <p class="text-xs text-[#8C713B]">@yield('header_subtitle', 'Welcome to your administrative command center')</p>
                    </div>
                </div>

                <!-- Right: View Store & Profile Dropdown -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 border border-[#C5A869]/40 text-[#58111A] hover:bg-[#58111A] hover:text-white rounded-sm text-xs font-semibold tracking-wider uppercase transition-colors">
                        <span>View Store</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="flex items-center gap-3 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-[#58111A] text-[#F7EED9] flex items-center justify-center font-bold text-sm border-2 border-[#C5A869] shadow">
                                {{ substr(auth()->guard('admin')->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <span class="block text-xs font-bold text-[#2A1810] leading-tight">{{ auth()->guard('admin')->user()->name ?? 'Administrator' }}</span>
                                <span class="block text-[10px] text-[#8C713B] uppercase tracking-wider font-semibold">{{ ucfirst(str_replace('_', ' ', auth()->guard('admin')->user()->role ?? 'Admin')) }}</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-cloak
                             class="absolute right-0 mt-3 w-48 bg-white rounded-sm shadow-xl py-2 border border-[#EFE9DE] z-50 text-xs">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <span class="block font-bold text-gray-800">{{ auth()->guard('admin')->user()->email ?? '' }}</span>
                            </div>
                            <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-[#F7F4EE]">Store Settings</a>
                            <a href="{{ route('admin.admins.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-[#F7F4EE]">Staff &amp; Roles</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-rose-700 hover:bg-rose-50 font-bold">Sign Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div class="px-4 sm:px-8 mt-4">
                    <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 text-xs font-medium text-emerald-800 flex items-center justify-between rounded-sm shadow-xs">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-700 font-bold">&times;</button>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="px-4 sm:px-8 mt-4">
                    <div class="bg-rose-50 border-l-4 border-rose-600 p-4 text-xs font-medium text-rose-800 flex items-center justify-between rounded-sm shadow-xs">
                        <span>{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-rose-700 font-bold">&times;</button>
                    </div>
                </div>
            @endif
            @if($errors->any())
                <div class="px-4 sm:px-8 mt-4">
                    <div class="bg-rose-50 border-l-4 border-rose-600 p-4 text-xs text-rose-800 rounded-sm shadow-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Main Dynamic Content -->
            <main class="flex-1 p-4 sm:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
