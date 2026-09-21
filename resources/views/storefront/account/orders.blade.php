@extends('layouts.app')

@section('title', 'My Orders | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <h1 class="font-serif text-3xl font-bold text-brand-charcoal">My Couture Orders</h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">Review purchase history, courier tracking, and tax receipts</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <aside class="lg:col-span-1">
            @include('storefront.account.partials.nav')
        </aside>

        <main class="lg:col-span-3 space-y-4">
            @forelse($orders as $order)
            <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-stone-100 pb-3 gap-2">
                    <div>
                        <span class="font-mono text-xs font-bold text-brand-charcoal">#{{ $order->order_number }}</span>
                        <div class="text-xs text-stone-400 mt-0.5">Placed on {{ $order->created_at->format('d M, Y') }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-brand-maroon/10 text-brand-maroon">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <!-- Items Mini List -->
                <div class="divide-y divide-stone-100">
                    @foreach($order->items as $item)
                    <div class="py-3 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 aspect-[3/4] bg-stone-100 rounded overflow-hidden shrink-0 border border-stone-200">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-stone-400">G</div>
                                @endif
                            </div>
                            <div>
                                <div class="font-serif text-xs font-bold text-brand-charcoal">{{ $item->product_name }}</div>
                                @if($item->variant_title)
                                    <div class="text-[11px] text-stone-500">Option: {{ $item->variant_title }}</div>
                                @endif
                                <div class="text-[11px] text-stone-400">Qty: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        <div class="font-serif text-xs font-bold text-brand-charcoal">
                            {{ $currencySymbol ?? '$' }}{{ number_format($item->total, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Footer Summary & Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-3 border-t border-stone-100 gap-3">
                    <div class="text-xs">
                        Total Amount: <strong class="font-serif text-sm font-bold text-brand-maroon">{{ $currencySymbol ?? '$' }}{{ number_format($order->grand_total, 2) }}</strong>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('order.track', ['order_number' => $order->order_number]) }}" class="px-3 py-1.5 border border-stone-300 hover:border-brand-maroon text-stone-700 text-xs font-semibold rounded transition">
                            Track Courier
                        </a>
                        <a href="{{ route('account.orders.detail', $order->id) }}" class="px-4 py-1.5 bg-brand-maroon hover:bg-[#400c13] text-white text-xs font-bold uppercase tracking-wider rounded transition">
                            View Order Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white border border-stone-200 rounded-2xl p-12 text-center text-xs text-stone-400">
                You haven't placed any orders yet.
            </div>
            @endforelse

            @if($orders->hasPages())
                <div class="pt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
