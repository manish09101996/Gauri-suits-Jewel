@extends('layouts.app')

@section('title', 'Razorpay Payment | Gauri Suits & Jewel')

@section('content')
<div class="max-w-xl mx-auto px-4 py-16 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-amber-50 border border-brand-gold/40 flex items-center justify-center mx-auto text-brand-gold">
        <svg class="w-8 h-8 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
    </div>

    <div class="space-y-2">
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-brand-charcoal">Opening Secure Payment Gateway</h1>
        <p class="text-xs sm:text-sm text-stone-500 font-light">
            Order #{{ $order->order_number }} • Amount: <strong class="text-brand-maroon">₹{{ number_format($order->grand_total, 2) }}</strong>
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
        <div class="flex justify-between font-serif text-sm font-bold text-brand-charcoal pt-1">
            <span>Total to Pay:</span>
            <span class="text-brand-maroon text-base">₹{{ number_format($order->grand_total, 2) }}</span>
        </div>
    </div>

    <!-- Fallback Pay Button -->
    <button id="rzp-button" type="button" class="w-full py-4 bg-brand-maroon hover:bg-[#400c13] text-white font-bold text-xs uppercase tracking-widest rounded shadow-lg transition">
        Click to Pay ₹{{ number_format($order->grand_total, 2) }} via Razorpay
    </button>

    <div>
        <a href="{{ route('cart.index') }}" class="text-xs text-stone-400 hover:text-stone-700 underline">
            Cancel and Return to Shopping Bag
        </a>
    </div>

    <!-- Hidden Callback Form -->
    <form id="razorpay-callback-form" action="{{ route('order.payment.callback') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="order_number" value="{{ $order->order_number }}">
        <input type="hidden" name="razorpay_payment_id" id="callback_payment_id">
        <input type="hidden" name="razorpay_order_id" id="callback_order_id">
        <input type="hidden" name="razorpay_signature" id="callback_signature">
    </form>
</div>

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const options = {
        key: "{{ $keyId }}",
        amount: "{{ ($razorpayOrder['amount'] ?? ($order->grand_total * 100)) }}",
        currency: "INR",
        name: "Gauri Suits & Jewel",
        description: "Order #{{ $order->order_number }} - Punjabi Couture & Fine Jewellery",
        image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=200&auto=format&fit=crop",
        order_id: "{{ $razorpayOrder['id'] ?? '' }}",
        handler: function (response) {
            document.getElementById('callback_payment_id').value = response.razorpay_payment_id;
            document.getElementById('callback_order_id').value = response.razorpay_order_id;
            document.getElementById('callback_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-callback-form').submit();
        },
        prefill: {
            name: "{{ addslashes($order->shipping_name) }}",
            email: "{{ addslashes($order->customer_email) }}",
            contact: "{{ addslashes($order->shipping_phone) }}"
        },
        theme: {
            color: "#58111A"
        },
        modal: {
            ondismiss: function () {
                console.log('Razorpay modal closed by user');
            }
        }
    };

    const rzp = new Razorpay(options);

    document.getElementById('rzp-button').onclick = function (e) {
        rzp.open();
        e.preventDefault();
    };

    // Auto-launch if possible
    setTimeout(() => {
        try {
            rzp.open();
        } catch (e) {
            console.log('Auto open blocked, user can click button');
        }
    }, 500);
});
</script>
@endpush
@endsection
