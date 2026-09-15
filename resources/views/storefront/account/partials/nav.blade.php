<div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm space-y-6">
    <div class="flex items-center gap-3 pb-6 border-b border-stone-100">
        <div class="w-12 h-12 rounded-full bg-brand-gold/20 text-brand-maroon font-serif font-bold text-lg flex items-center justify-center border border-brand-gold/40">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div class="min-w-0 flex-1">
            <div class="font-serif font-bold text-brand-charcoal truncate">{{ auth()->user()->name }}</div>
            <div class="text-xs text-stone-400 font-mono truncate">{{ auth()->user()->email }}</div>
        </div>
    </div>

    <nav class="space-y-1 text-xs font-semibold">
        <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('account.dashboard') ? 'bg-brand-maroon text-white font-bold' : 'text-stone-600 hover:text-brand-maroon hover:bg-stone-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('account.orders*') ? 'bg-brand-maroon text-white font-bold' : 'text-stone-600 hover:text-brand-maroon hover:bg-stone-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            My Orders
        </a>

        <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('wishlist.*') ? 'bg-brand-maroon text-white font-bold' : 'text-stone-600 hover:text-brand-maroon hover:bg-stone-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            My Wishlist
        </a>

        <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('account.addresses') ? 'bg-brand-maroon text-white font-bold' : 'text-stone-600 hover:text-brand-maroon hover:bg-stone-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Saved Addresses
        </a>

        <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition {{ request()->routeIs('account.profile') ? 'bg-brand-maroon text-white font-bold' : 'text-stone-600 hover:text-brand-maroon hover:bg-stone-50' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profile & Security
        </a>

        <div class="pt-4 border-t border-stone-100">
            <form action="{{ route('customer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2 text-rose-600 hover:bg-rose-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </nav>
</div>
