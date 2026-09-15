@extends('layouts.app')

@section('title', "Order #{$order->order_number} | Gauri Suits & Jewel")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex items-center gap-3">
        <a href="{{ route('account.orders') }}" class="p-2 rounded-lg hover:bg-stone-100 text-stone-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-brand-charcoal">Order #{{ $order->order_number }}</h1>
            <p class="text-xs text-stone-500">Placed on {{ $order->created_at->format('d M, Y \a\t h:i A') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <aside class="lg:col-span-1">
            @include('storefront.account.partials.nav')
        </aside>

        <main class="lg:col-span-3 space-y-6">
            <!-- Tracking & Status Banner -->
            <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="text-xs text-stone-400 uppercase tracking-wider font-bold">Fulfillment Status</div>
                    <div class="font-serif text-xl font-bold text-brand-charcoal mt-0.5">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</div>
                    @if($order->shipment && $order->shipment->tracking_number)
                        <div class="text-xs text-stone-600 mt-1">
                            Courier: <strong>{{ $order->shipment->carrier }}</strong> • AWB: <strong>{{ $order->shipment->tracking_number }}</strong>
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('order.track', ['order_number' => $order->order_number]) }}" class="px-4 py-2 bg-brand-maroon hover:bg-[#400c13] text-white text-xs font-bold uppercase tracking-wider rounded transition">
                        Live Tracking
                    </a>
                    <a href="{{ route('order.invoice', $order->id) }}" target="_blank" class="px-4 py-2 border border-stone-300 hover:border-brand-maroon text-stone-700 text-xs font-bold uppercase tracking-wider rounded transition">
                        Tax Invoice
                    </a>
                </div>
            </div>

            <!-- Items Table -->
            <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm space-y-4">
                <h2 class="font-serif text-base font-bold text-brand-charcoal border-b pb-3">Items in this Order</h2>
                <div class="divide-y divide-stone-100">
                    @foreach($order->items as $item)
                    <div class="py-4 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 aspect-[3/4] bg-stone-100 rounded-lg overflow-hidden shrink-0 border border-stone-200">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-stone-400">G</div>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-serif text-sm font-bold text-brand-charcoal">{{ $item->product_name }}</h3>
                                @if($item->variant_title)
                                    <div class="text-xs text-stone-500">Option: {{ $item->variant_title }}</div>
                                @endif
                                <div class="text-xs text-stone-400">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</div>
                            </div>
                        </div>
                        <div class="font-serif font-bold text-sm text-brand-charcoal">
                            ₹{{ number_format($item->total, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Addresses and Financials 2-Col -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Shipping Address -->
                <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm space-y-2">
                    <h3 class="font-serif text-sm font-bold text-brand-charcoal border-b pb-2">Delivery Address</h3>
                    <p class="text-xs text-stone-600 leading-relaxed">
                        <strong>{{ $order->shipping_name }}</strong><br>
                        {{ $order->shipping_address_line1 }}<br>
                        @if($order->shipping_address_line2) {{ $order->shipping_address_line2 }}<br> @endif
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_postal_code }}<br>
                        Phone: {{ $order->shipping_phone }}
                    </p>
                </div>

                <!-- Financial Breakdown -->
                <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm space-y-2.5 text-xs text-stone-600">
                    <h3 class="font-serif text-sm font-bold text-brand-charcoal border-b pb-2">Payment Details</h3>
                    <div class="flex justify-between">
                        <span>Payment Method</span>
                        <span class="font-bold text-brand-charcoal uppercase">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Payment Status</span>
                        <span class="font-bold {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }} uppercase">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between text-emerald-600">
                        <span>Discount</span>
                        <span>-₹{{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Shipping Delivery</span>
                        <span>{{ $order->shipping_amount > 0 ? '₹' . number_format($order->shipping_amount, 2) : 'FREE' }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t font-serif text-base font-bold text-brand-charcoal">
                        <span>Total Paid</span>
                        <span class="text-brand-maroon">₹{{ number_format($order->grand_total, 2) }}</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
