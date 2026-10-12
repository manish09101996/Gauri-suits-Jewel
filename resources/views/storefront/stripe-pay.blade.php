@extends('layouts.app')

@section('title', 'Stripe Payment | Gauri Suits & Jewel')

@section('content')
<div class="max-w-xl mx-auto px-4 py-16 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-emerald-50 border border-emerald-300 flex items-center justify-center mx-auto text-emerald-700">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
    </div>

    <div class="space-y-2">
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-brand-charcoal">Complete Payment via Stripe</h1>
        <p class="text-xs sm:text-sm text-stone-500 font-light">
            Order #{{ $order->order_number }} • Total: <strong class="text-brand-maroon">{{ $currencySymbol ?? '$' }}{{ number_format($order->grand_total, 2) }} AUD</strong>
        </p>
    </div>

    <div class="p-6 bg-white border border-stone-200 rounded-2xl shadow-sm space-y-4 text-left text-xs text-stone-600">
        <div class="flex justify-between border-b pb-2">
            <span>Customer Name:</span>
            <strong class="text-brand-charcoal">{{ $order->shipping_name }}</strong>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span>Contact Mobile:</span>
            <strong class="text-brand-charcoal">{{ $order->shipping_phone }}</strong>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span>Billing Email:</span>
            <strong class="text-brand-charcoal">{{ $order->customer_email }}</strong>
        </div>
        <div class="flex justify-between border-b pb-2">
            <span>Payment Method:</span>
            <strong class="text-emerald-800 uppercase font-semibold">Stripe (Card / Apple Pay / Google Pay)</strong>
        </div>
        <div class="flex justify-between font-serif text-sm font-bold text-brand-charcoal pt-1">
            <span>Total to Pay:</span>
            <span class="text-brand-maroon text-base">{{ $currencySymbol ?? '$' }}{{ number_format($order->grand_total, 2) }} AUD</span>
        </div>
    </div>

    <div class="space-y-3">
        <a href="{{ route('order.stripe.success', ['session_id' => $sessionId, 'order' => $order->order_number]) }}" class="w-full py-4 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] font-bold text-xs uppercase tracking-widest rounded-xs shadow-lg transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>Complete Payment of {{ $currencySymbol ?? '$' }}{{ number_format($order->grand_total, 2) }} AUD</span>
        </a>

        <div>
            <a href="{{ route('order.stripe.cancel', ['order' => $order->order_number]) }}" class="text-xs text-stone-400 hover:text-stone-700 underline">
                Cancel and return to order
            </a>
        </div>
    </div>
</div>
@endsection
