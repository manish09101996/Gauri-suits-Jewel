@extends('layouts.app')

@section('title', 'Shopping Bag | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8"
     x-data="{
        updating: false,
        updateQty(itemId, qty) {
            if (qty < 1) {
                this.removeItem(itemId);
                return;
            }
            this.updating = true;
            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ item_id: itemId, quantity: qty })
            })
            .then(res => res.json())
            .then(data => {
                window.location.reload();
            })
            .catch(err => {
                console.error(err);
                this.updating = false;
            });
        },
        removeItem(itemId) {
            if (!confirm('Remove this piece from your bag?')) return;
            this.updating = true;
            fetch(`/cart/remove/${itemId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                window.location.reload();
            })
            .catch(err => {
                console.error(err);
                this.updating = false;
            });
        }
     }">

    <!-- Page Title -->
    <div class="border-b border-stone-200 pb-6 flex items-center justify-between">
        <div>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal">Your Shopping Bag</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-1">
                You have <span class="font-bold text-brand-charcoal">{{ $summary['total_items'] }}</span> {{ Str::plural('piece', $summary['total_items']) }} in your bag
            </p>
        </div>
        <a href="{{ route('shop.index') }}" class="text-xs font-bold uppercase tracking-wider text-brand-maroon hover:text-amber-700 transition">
            ← Continue Shopping
        </a>
    </div>

    @if(count($summary['items']) > 0)
    <!-- Free Shipping Progress Bar -->
    <div class="bg-stone-50 border border-stone-200/80 rounded-2xl p-5 space-y-2.5">
        <div class="flex items-center justify-between text-xs sm:text-sm">
            @if($summary['free_shipping_unlocked'])
                <span class="font-bold text-[#0A3828] flex items-center gap-1.5">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Congratulations! You have unlocked Complimentary Express Shipping!
                </span>
            @else
                <span class="text-stone-700 font-medium">
                    Add <strong class="text-[#58111A] font-bold">₹{{ number_format($summary['amount_needed_free_shipping']) }}</strong> more to unlock <span class="font-bold text-[#0A3828]">FREE Insured Delivery</span>
                </span>
            @endif
            <span class="text-xs text-[#A88B4D] font-mono font-bold">{{ $summary['free_shipping_percent'] }}%</span>
        </div>
        <div class="w-full bg-stone-200 rounded-full h-2 overflow-hidden">
            <div class="bg-gradient-to-r from-[#0A3828] to-[#125B40] h-full rounded-full transition-all duration-500 shadow-xs" style="width: {{ $summary['free_shipping_percent'] }}%"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <!-- Cart Items List (8 Cols) -->
        <div class="lg:col-span-8 bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm divide-y divide-stone-100 space-y-6">
            @foreach($summary['items'] as $item)
            <div class="pt-6 first:pt-0 flex flex-col sm:flex-row gap-5 items-start sm:items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('product.show', $item['slug']) }}" class="w-20 sm:w-24 aspect-[3/4] bg-stone-100 rounded-lg overflow-hidden shrink-0 border border-stone-200">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    </a>
                    <div class="space-y-1">
                        <h3 class="font-serif text-sm sm:text-base font-bold text-brand-charcoal hover:text-brand-maroon transition">
                            <a href="{{ route('product.show', $item['slug']) }}">{{ $item['name'] }}</a>
                        </h3>
                        @if($item['size'])
                            <div class="text-xs text-stone-500">Size / Option: <span class="font-semibold text-stone-700">{{ $item['size'] }}</span></div>
                        @endif
                        <div class="text-xs font-semibold text-brand-maroon">
                            ₹{{ number_format($item['price']) }} each
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between w-full sm:w-auto sm:gap-8">
                    <!-- Qty Stepper -->
                    <div class="flex items-center border border-stone-300 rounded bg-stone-50">
                        <button type="button" @click="updateQty({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" class="px-2.5 py-1 text-stone-600 hover:bg-stone-200 font-bold text-xs">-</button>
                        <span class="px-3 py-1 text-xs font-bold text-brand-charcoal">{{ $item['quantity'] }}</span>
                        <button type="button" @click="updateQty({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" class="px-2.5 py-1 text-stone-600 hover:bg-stone-200 font-bold text-xs">+</button>
                    </div>

                    <!-- Line Total -->
                    <div class="font-serif font-bold text-base text-brand-charcoal text-right min-w-[90px]">
                        ₹{{ number_format($item['subtotal']) }}
                    </div>

                    <!-- Delete Button -->
                    <button type="button" @click="removeItem({{ $item['id'] }})" class="text-stone-400 hover:text-rose-600 transition p-1" title="Remove">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary & Promo Code (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Promo Code Card -->
            <div class="bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm space-y-3">
                <h3 class="text-xs uppercase font-bold tracking-wider text-brand-charcoal">Promotional Coupon</h3>

                @if($summary['coupon_code'])
                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-emerald-800 font-mono tracking-wider">{{ $summary['coupon_code'] }}</span>
                            <div class="text-[11px] text-emerald-600">Discount applied: ₹{{ number_format($summary['discount']) }}</div>
                        </div>
                        <form action="{{ route('cart.coupon.remove') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">Remove</button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="code" required placeholder="Enter Coupon Code" class="flex-1 bg-stone-50 border border-stone-300 rounded px-3 py-2 text-xs uppercase font-mono tracking-wider focus:outline-none focus:border-brand-maroon">
                        <button type="submit" class="px-4 py-2 bg-stone-800 hover:bg-stone-900 text-white font-bold text-xs uppercase tracking-wider rounded transition">
                            Apply
                        </button>
                    </form>
                @endif
            </div>

            <!-- Order Total Breakdown Card -->
            <div class="bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-lg font-bold text-brand-charcoal border-b border-stone-100 pb-3">Order Summary</h3>

                <div class="space-y-2.5 text-xs sm:text-sm text-stone-600">
                    <div class="flex justify-between">
                        <span>Bag Subtotal</span>
                        <span class="font-semibold text-brand-charcoal">₹{{ number_format($summary['subtotal']) }}</span>
                    </div>

                    @if($summary['discount'] > 0)
                    <div class="flex justify-between text-emerald-600">
                        <span>Coupon Savings</span>
                        <span class="font-bold">-₹{{ number_format($summary['discount']) }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between">
                        <span>Shipping Delivery</span>
                        <span class="font-semibold {{ $summary['free_shipping_unlocked'] ? 'text-emerald-600' : 'text-stone-700' }}">
                            {{ $summary['free_shipping_unlocked'] ? 'FREE' : 'Calculated at checkout' }}
                        </span>
                    </div>

                    <div class="flex justify-between text-[11px] text-stone-400">
                        <span>Applicable Taxes (GST)</span>
                        <span>Included in price</span>
                    </div>

                    <div class="pt-3 border-t border-stone-100 flex justify-between items-baseline font-serif text-lg font-bold text-brand-charcoal">
                        <span>Estimated Total</span>
                        <span class="text-brand-maroon text-2xl">
                            ₹{{ number_format(max(0, $summary['subtotal'] - $summary['discount'])) }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full py-4 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] font-bold text-xs uppercase tracking-[0.2em] text-center rounded-xs shadow-lg transition flex items-center justify-center gap-2">
                    Proceed to Secure Checkout →
                </a>

                <div class="pt-3 border-t border-stone-100 space-y-2 text-[11px] text-stone-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>256-bit SSL Encrypted Secure Checkout</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <span>Razorpay UPI, Cards, NetBanking, and COD</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart State -->
    <div class="bg-white border border-stone-200 rounded-3xl p-16 text-center max-w-2xl mx-auto space-y-6">
        <div class="w-20 h-20 rounded-full bg-stone-100 flex items-center justify-center mx-auto text-stone-400">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <div class="space-y-2">
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-brand-charcoal">Your Bag is Empty</h2>
            <p class="text-sm text-stone-500 font-light">
                Discover our royal Punjabi bridal suits, luxury unstitched chanderi silks, and heirloom Kundan jewellery.
            </p>
        </div>
        <div class="pt-4 flex flex-wrap justify-center gap-4">
            <a href="{{ route('shop.index') }}" class="px-8 py-3.5 bg-brand-maroon hover:bg-brand-gold text-white hover:text-brand-charcoal font-bold text-xs uppercase tracking-widest rounded transition shadow">
                Explore Ensembles
            </a>
            <a href="{{ route('shop.index', ['category' => 'jewellery']) }}" class="px-8 py-3.5 border border-stone-300 hover:border-brand-maroon text-brand-charcoal font-bold text-xs uppercase tracking-widest rounded transition">
                Explore Jewellery
            </a>
        </div>
    </div>
    @endif

</div>
@endsection
