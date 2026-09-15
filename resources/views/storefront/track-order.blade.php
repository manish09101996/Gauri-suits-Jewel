@extends('layouts.app')

@section('title', 'Track Your Order | Gauri Suits & Jewel')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Delivery Status</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal">Track Your Couture Order</h1>
        <p class="text-xs sm:text-sm text-stone-500 max-w-md mx-auto font-light">
            Enter your order number and registered phone number or email to view real-time tailoring and courier dispatch status.
        </p>
    </div>

    <!-- Search Form -->
    <div class="bg-white border border-stone-200 rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('order.track') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Order Number *</label>
                    <input type="text" name="order_number" value="{{ request('order_number') }}" required placeholder="e.g. GSJ-2026-XXXX" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal font-mono uppercase focus:bg-white focus:outline-none focus:border-brand-maroon">
                </div>
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Phone Number or Email</label>
                    <input type="text" name="contact" value="{{ request('contact') }}" placeholder="Phone or email on order" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-brand-maroon hover:bg-[#400c13] text-white font-bold text-xs uppercase tracking-widest rounded shadow transition">
                Check Order Progress
            </button>
        </form>
    </div>

    @if($searched && $order)
    <!-- Order Result Details -->
    <div class="bg-white border border-stone-200 rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b pb-6 gap-3">
            <div>
                <span class="text-xs text-stone-400 font-mono">Order #{{ $order->order_number }}</span>
                <h2 class="font-serif text-2xl font-bold text-brand-charcoal">Status: {{ ucfirst(str_replace('_', ' ', $order->status)) }}</h2>
                <div class="text-xs text-stone-500 mt-0.5">Placed on {{ $order->created_at->format('d M, Y') }}</div>
            </div>
            @if($order->shipment && $order->shipment->tracking_number)
                <div class="p-3 bg-stone-50 border border-stone-200 rounded-xl text-xs space-y-1">
                    <div class="text-stone-500">Carrier: <strong>{{ $order->shipment->carrier }}</strong></div>
                    <div class="font-mono text-brand-charcoal font-bold">AWB: {{ $order->shipment->tracking_number }}</div>
                    @if($order->shipment->tracking_url)
                        <a href="{{ $order->shipment->tracking_url }}" target="_blank" class="text-brand-gold hover:underline font-semibold block text-[11px]">
                            Track on Courier Website →
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Visual Timeline Stepper -->
        @php
            $steps = [
                'pending' => 'Order Received',
                'confirmed' => 'Confirmed & Sourced',
                'processing' => 'Bespoke Tailoring',
                'packed' => 'Quality Inspected & Packed',
                'shipped' => 'Dispatched with Courier',
                'delivered' => 'Delivered to Customer'
            ];
            $currentStatus = $order->status;
            $statusKeys = array_keys($steps);
            $currentIndex = array_search($currentStatus, $statusKeys);
            if ($currentIndex === false) $currentIndex = 0;
        @endphp

        <div class="space-y-4">
            <h3 class="text-xs uppercase font-bold tracking-wider text-brand-charcoal">Fulfillment Progress</h3>
            <div class="relative flex flex-col sm:flex-row justify-between gap-4">
                @foreach($steps as $key => $label)
                @php
                    $stepIndex = array_search($key, $statusKeys);
                    $isDone = $stepIndex <= $currentIndex;
                    $isCurrent = $stepIndex === $currentIndex;
                @endphp
                <div class="flex sm:flex-col items-center gap-3 sm:gap-2 flex-1 text-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 transition {{ $isDone ? 'bg-brand-maroon text-white ring-4 ring-brand-maroon/15' : 'bg-stone-100 text-stone-400 border border-stone-300' }}">
                        @if($isDone && !$isCurrent)
                            ✓
                        @else
                            {{ $stepIndex + 1 }}
                        @endif
                    </div>
                    <div class="text-left sm:text-center">
                        <div class="text-xs font-bold {{ $isDone ? 'text-brand-charcoal' : 'text-stone-400' }}">{{ $label }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Items In Order -->
        <div class="pt-6 border-t space-y-3">
            <h3 class="text-xs uppercase font-bold tracking-wider text-brand-charcoal">Ensembles in this Package</h3>
            <div class="divide-y divide-stone-100">
                @foreach($order->items as $item)
                <div class="py-3 flex items-center justify-between text-xs">
                    <div>
                        <div class="font-serif font-bold text-brand-charcoal">{{ $item->product_name }}</div>
                        @if($item->variant_title)
                            <div class="text-stone-500">Option: {{ $item->variant_title }}</div>
                        @endif
                    </div>
                    <div class="text-stone-500">Qty: {{ $item->quantity }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @elseif($searched)
    <!-- Not Found Alert -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center space-y-3">
        <div class="text-base font-bold text-amber-900">No matching order record found</div>
        <p class="text-xs text-amber-800 max-w-md mx-auto">
            Please verify the order reference number on your confirmation receipt or WhatsApp our customer concierge for quick manual tracking.
        </p>
        <div class="pt-2">
            <a href="https://wa.me/919876543210" target="_blank" class="inline-flex px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded transition">
                WhatsApp Support
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
