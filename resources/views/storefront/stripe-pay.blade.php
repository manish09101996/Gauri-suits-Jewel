@extends('layouts.app')

@section('title', "Payment for Order #{$order->order_number} | Gauri Suits & Jewel")

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center space-y-6">
    <div class="bg-white border border-stone-200 rounded-3xl p-8 sm:p-12 shadow-sm space-y-6">
        <div class="w-16 h-16 rounded-full bg-[#58111A]/10 border border-[#58111A]/20 flex items-center justify-center mx-auto text-[#58111A]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        </div>

        <div class="space-y-2">
            <span class="text-xs uppercase tracking-widest text-[#8C713B] font-bold">Stripe Secure Card Checkout</span>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-[#3B0A11]">Order #{{ $order->order_number }}</h1>
            <p class="text-xs sm:text-sm text-stone-500 max-w-md mx-auto">
                Total Amount Payable: <strong class="text-[#58111A] font-bold text-base">{{ $currencySymbol ?? '$' }}{{ number_format($order->total_amount, 2) }} AUD</strong>
            </p>
        </div>

        <div class="p-4 bg-[#F9F6F0] border border-[#E3DACD] rounded-xl text-left text-xs space-y-2 text-stone-600">
            <div class="flex justify-between">
                <span>Customer:</span>
                <span class="font-semibold text-stone-800">{{ $order->customer_name }}</span>
            </div>
            <div class="flex justify-between">
                <span>Email:</span>
                <span class="font-semibold text-stone-800">{{ $order->shipping_email ?: $order->guest_email }}</span>
            </div>
            <div class="flex justify-between">
                <span>Payment Gateway:</span>
                <span class="font-semibold text-[#0A3828]">Stripe PCI-DSS Level 1 Secure</span>
            </div>
        </div>

        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('order.stripe.success', ['order' => $order->order_number, 'session_id' => $sessionId]) }}" class="w-full sm:w-auto px-8 py-3.5 bg-[#58111A] hover:bg-[#3B0A11] text-[#F7EED9] font-bold text-xs uppercase tracking-wider rounded transition shadow flex items-center justify-center gap-2">
                <span>Complete Stripe Payment (Simulate & Confirm)</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="{{ route('order.stripe.cancel', ['order' => $order->order_number]) }}" class="w-full sm:w-auto px-6 py-3.5 border border-stone-300 hover:border-stone-400 text-stone-600 font-bold text-xs uppercase tracking-wider rounded transition">
                Cancel
            </a>
        </div>

        <div class="text-[11px] text-stone-400">
            Payments are encrypted via Stripe 256-bit SSL. Supports Visa, Mastercard, AMEX, Apple Pay, and Google Pay.
        </div>
    </div>
</div>
@endsection
