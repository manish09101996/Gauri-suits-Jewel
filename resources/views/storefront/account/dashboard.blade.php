@extends('layouts.app')

@section('title', 'My Account | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <h1 class="font-serif text-3xl font-bold text-brand-charcoal">Welcome, {{ $user->name }}</h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">Manage your couture orders, deliveries, and account details</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <aside class="lg:col-span-1">
            @include('storefront.account.partials.nav')
        </aside>

        <main class="lg:col-span-3 space-y-6">
            <!-- Account KPI cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white border border-stone-200 rounded-2xl p-5 shadow-sm">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-stone-400">Total Ensembles Purchased</div>
                    <div class="font-serif text-2xl font-bold text-brand-charcoal mt-1">{{ $totalOrders }}</div>
                    <div class="text-xs text-stone-500 mt-0.5">Completed orders</div>
                </div>

                <div class="bg-white border border-stone-200 rounded-2xl p-5 shadow-sm">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-stone-400">Total Order Value</div>
                    <div class="font-serif text-2xl font-bold text-brand-maroon mt-1">{{ $currencySymbol ?? '$' }}{{ number_format($totalSpent, 2) }}</div>
                    <div class="text-xs text-stone-500 mt-0.5">Lifetime spend</div>
                </div>

                <div class="bg-white border border-stone-200 rounded-2xl p-5 shadow-sm">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-stone-400">Membership Tier</div>
                    <div class="font-serif text-2xl font-bold text-brand-gold mt-1">Royal Circle</div>
                    <div class="text-xs text-stone-500 mt-0.5">VIP Privileges Active</div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                    <h2 class="font-serif text-lg font-bold text-brand-charcoal">Recent Orders</h2>
                    <a href="{{ route('account.orders') }}" class="text-xs font-bold text-brand-maroon hover:underline">View All Orders →</a>
                </div>

                @forelse($recentOrders as $ord)
                <div class="p-4 bg-stone-50/70 border border-stone-200/80 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-bold text-brand-charcoal">#{{ $ord->order_number }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-brand-maroon/10 text-brand-maroon">
                                {{ ucfirst(str_replace('_', ' ', $ord->status)) }}
                            </span>
                        </div>
                        <div class="text-xs text-stone-500 mt-1">
                            {{ $ord->created_at->format('d M, Y') }} • {{ $ord->items->count() }} {{ Str::plural('item', $ord->items->count()) }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto">
                        <div class="font-serif font-bold text-sm text-brand-charcoal">
                            {{ $currencySymbol ?? '$' }}{{ number_format($ord->grand_total, 2) }}
                        </div>
                        <a href="{{ route('account.orders.detail', $ord->id) }}" class="px-4 py-2 bg-brand-maroon hover:bg-[#400c13] text-white text-xs font-bold uppercase tracking-wider rounded transition">
                            Details
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-xs text-stone-400">
                    No orders placed yet. Explore our handcrafted collections!
                </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection
