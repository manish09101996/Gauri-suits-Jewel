@extends('layouts.app')

@section('title', "Order #{$order->order_number} Confirmed | Gauri Suits & Jewel")

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <!-- Success Banner -->
    <div class="bg-white border border-stone-200 rounded-3xl p-8 sm:p-12 text-center shadow-sm space-y-4">
        <div class="w-16 h-16 rounded-full bg-emerald-50 border-2 border-emerald-500/30 flex items-center justify-center mx-auto text-emerald-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>

        <div>
            <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Order Received</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-1">
                Thank You, {{ $order->shipping_name }}!
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-2 font-light max-w-md mx-auto">
                Your order <strong class="font-mono text-brand-charcoal font-bold">#{{ $order->order_number }}</strong> has been confirmed. A receipt and order notification has been sent to {{ $order->customer_email }}.
            </p>
        </div>

        <div class="pt-4 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('order.track', ['order_number' => $order->order_number, 'contact' => $order->shipping_phone]) }}" class="px-6 py-2.5 bg-brand-maroon hover:bg-[#400c13] text-white font-bold text-xs uppercase tracking-wider rounded transition shadow">
                Track Shipment Live
            </a>
            <a href="{{ route('order.invoice', $order->id) }}" target="_blank" class="px-6 py-2.5 border border-stone-300 hover:border-brand-maroon text-stone-700 font-bold text-xs uppercase tracking-wider rounded transition">
                Print Tax Invoice
            </a>
        </div>
    </div>

    <!-- Order Items & Summary Details -->
    <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b pb-4">
            <div>
                <h2 class="font-serif text-lg font-bold text-brand-charcoal">Order Summary</h2>
                <div class="text-xs text-stone-400">Placed on {{ $order->created_at->format('d M, Y \a\t h:i A') }}</div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    Payment: {{ ucfirst($order->payment_status) }} ({{ strtoupper($order->payment_method) }})
                </span>
            </div>
        </div>

        <!-- Items list -->
        <div class="divide-y divide-stone-100">
            @foreach($order->items as $item)
            <div class="py-4 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 aspect-[3/4] bg-stone-100 rounded overflow-hidden shrink-0 border border-stone-200">
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

        <!-- Totals Table -->
        <div class="pt-4 border-t border-stone-100 space-y-2 text-xs text-stone-600">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>₹{{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount_amount > 0)
            <div class="flex justify-between text-emerald-600">
                <span>Discount ({{ $order->coupon_code ?? 'Promo' }})</span>
                <span>-₹{{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span>Insured Courier Delivery</span>
                <span>{{ $order->shipping_amount > 0 ? '₹' . number_format($order->shipping_amount, 2) : 'FREE' }}</span>
            </div>
            <div class="pt-2 border-t flex justify-between font-serif text-base font-bold text-brand-charcoal">
                <span>Grand Total</span>
                <span class="text-brand-maroon">₹{{ number_format($order->grand_total, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Shipping Destination Card -->
    <div class="bg-white border border-stone-200 rounded-2xl p-6 shadow-sm">
        <h3 class="font-serif text-base font-bold text-brand-charcoal mb-3">Shipping Destination</h3>
        <p class="text-xs text-stone-600 leading-relaxed">
            <strong>{{ $order->shipping_name }}</strong><br>
            {{ $order->shipping_address_line1 }}<br>
            @if($order->shipping_address_line2) {{ $order->shipping_address_line2 }}<br> @endif
            {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_postal_code }}<br>
            Phone: {{ $order->shipping_phone }}
        </p>
    </div>

    <!-- WhatsApp Support CTA -->
    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-center sm:text-left">
            <div class="text-xs font-bold text-emerald-900">Need immediate customization or delivery update?</div>
            <div class="text-[11px] text-emerald-700">Connect directly with our Ludhiana boutique concierge on WhatsApp.</div>
        </div>
        <a href="https://wa.me/919876543210?text={{ urlencode("Hello, I am inquiring about Order #{$order->order_number}") }}" target="_blank" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider rounded-lg transition shrink-0">
            WhatsApp Support
        </a>
    </div>
</div>
@endsection
