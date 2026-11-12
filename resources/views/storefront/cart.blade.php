@extends('layouts.app')

@section('title', 'Shopping Bag | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-28 sm:py-8 space-y-8" x-data="cartPage()">

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
    <!-- Free Shipping Progress Bar (Royal Emerald & Gold) -->
    <div class="bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-5 space-y-2.5 shadow-xs">
        <div class="flex items-center justify-between text-xs sm:text-sm">
            @if($summary['free_shipping_unlocked'])
                <span class="font-bold text-[#083323] flex items-center gap-1.5">
                    <svg class="w-4 h-4 fill-current text-[#25D366]" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Congratulations! You have unlocked Complimentary Express Shipping!
                </span>
            @else
                <span class="text-[#3B0A11] font-medium">
                    Add <strong class="text-[#58111A] font-bold">{{ $currencySymbol ?? '$' }}{{ number_format($summary['amount_needed_free_shipping']) }}</strong> more to unlock <span class="font-bold text-[#083323]">FREE Insured Delivery</span>
                </span>
            @endif
            <span class="text-xs text-[#8C713B] font-mono font-bold">{{ $summary['free_shipping_percent'] }}%</span>
        </div>
        <div class="w-full bg-[#EFE9DE] rounded-full h-2 overflow-hidden">
            <div class="bg-gradient-to-r from-[#083323] to-[#125B40] h-full rounded-full transition-all duration-500 shadow-xs" style="width: {{ $summary['free_shipping_percent'] }}%"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Cart Items List (8 Cols) -->
        <div class="lg:col-span-8 bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-6 shadow-xs divide-y divide-[#E8DFD5] space-y-6">
            @foreach($summary['items'] as $item)
            <div class="pt-6 first:pt-0 flex flex-col sm:flex-row gap-5 items-start sm:items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('product.show', $item['slug']) }}" class="w-20 sm:w-24 aspect-[3/4] bg-white rounded-xs overflow-hidden shrink-0 border border-[#D5CBC0]">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    </a>
                    <div class="space-y-1">
                        <h3 class="font-serif text-sm sm:text-base font-semibold text-[#2A1810] hover:text-[#58111A] transition">
                            <a href="{{ route('product.show', $item['slug']) }}">{{ $item['name'] }}</a>
                        </h3>
                        @if($item['size'])
                            <div class="text-xs text-[#6B5E55]">Size / Option: <span class="font-semibold text-[#3B0A11]">{{ $item['size'] }}</span></div>
                        @endif
                        <div class="text-xs font-semibold text-[#58111A]">
                            {{ $currencySymbol ?? '$' }}{{ number_format($item['price']) }} each
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between w-full sm:w-auto sm:gap-8">
                    <!-- Qty Stepper -->
                    <div class="flex items-center border border-[#D5CBC0] rounded-xs bg-white">
                        <button type="button" @click="updateQty({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" class="px-2.5 py-1 text-[#58111A] hover:bg-[#FAF7F2] font-bold text-xs cursor-pointer">-</button>
                        <span class="px-3 py-1 text-xs font-bold text-[#3B0A11]">{{ $item['quantity'] }}</span>
                        <button type="button" @click="updateQty({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" class="px-2.5 py-1 text-[#58111A] hover:bg-[#FAF7F2] font-bold text-xs cursor-pointer">+</button>
                    </div>

                    <!-- Line Total -->
                    <div class="font-serif font-bold text-base text-[#2A1810] text-right min-w-[90px]">
                        {{ $currencySymbol ?? '$' }}{{ number_format($item['subtotal']) }}
                    </div>

                    <!-- Delete Button -->
                    <button type="button" @click="removeItem({{ $item['id'] }})" class="text-stone-400 hover:text-rose-600 transition p-1 cursor-pointer" title="Remove">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary & Promo Code (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Promo Code Card -->
            <div class="bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-6 shadow-xs space-y-3">
                <h3 class="text-xs uppercase font-bold tracking-wider text-[#3B0A11]">Promotional Coupon</h3>

                @if($summary['coupon_code'])
                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xs flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-[#083323] font-mono tracking-wider">{{ $summary['coupon_code'] }}</span>
                            <div class="text-[11px] text-emerald-700">Discount applied: {{ $currencySymbol ?? '$' }}{{ number_format($summary['discount']) }}</div>
                        </div>
                        <form action="{{ route('cart.coupon.remove') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline cursor-pointer">Remove</button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="code" required placeholder="Enter Coupon Code" class="flex-1 bg-white border border-[#D5CBC0] rounded-xs px-3 py-2 text-xs uppercase font-mono tracking-wider text-[#2A1810] focus:outline-none focus:border-[#58111A]">
                        <button type="submit" class="px-4 py-2 bg-[#58111A] hover:bg-[#3B0A11] text-[#F7EED9] font-bold text-xs uppercase tracking-wider rounded-xs transition cursor-pointer">
                            Apply
                        </button>
                    </form>
                @endif
            </div>

            <!-- Order Total Breakdown Card -->
            <div class="bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-6 shadow-xs space-y-4">
                <h3 class="font-serif text-lg font-normal text-[#3B0A11] border-b border-[#E8DFD5] pb-3">Order Summary</h3>

                <div class="space-y-2.5 text-xs sm:text-sm text-[#554740]">
                    <div class="flex justify-between">
                        <span>Bag Subtotal</span>
                        <span class="font-semibold text-[#2A1810]">{{ $currencySymbol ?? '$' }}{{ number_format($summary['subtotal']) }}</span>
                    </div>

                    @if($summary['discount'] > 0)
                    <div class="flex justify-between text-[#083323]">
                        <span>Coupon Savings</span>
                        <span class="font-bold">-{{ $currencySymbol ?? '$' }}{{ number_format($summary['discount']) }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between">
                        <span>Shipping Delivery</span>
                        <span class="font-semibold {{ $summary['free_shipping_unlocked'] ? 'text-[#083323]' : 'text-[#554740]' }}">
                            {{ $summary['free_shipping_unlocked'] ? 'FREE EXPRESS' : 'Calculated at checkout' }}
                        </span>
                    </div>

                    <div class="flex justify-between text-[11px] text-[#8C713B]">
                        <span>Applicable Taxes (GST)</span>
                        <span>Included in price</span>
                    </div>

                    <div class="pt-3 border-t border-[#E8DFD5] flex justify-between items-baseline font-serif text-lg font-bold text-[#2A1810]">
                        <span>Estimated Total</span>
                        <span class="text-[#58111A] text-2xl font-bold">
                            {{ $currencySymbol ?? '$' }}{{ number_format(max(0, $summary['subtotal'] - $summary['discount'])) }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full py-3.5 sm:py-4 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] font-bold text-xs uppercase tracking-[0.12em] sm:tracking-[0.2em] text-center rounded-xs shadow-lg transition flex items-center justify-center gap-2">
                    Proceed to Secure Checkout →
                </a>

                <div class="pt-3 border-t border-stone-100 space-y-2 text-[11px] text-stone-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>256-bit SSL Encrypted Secure Checkout</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-brand-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        <span>Stripe (Cards & Digital Wallets) and Cash on Delivery</span>
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

@push('scripts')
<script>
function cartPage() {
    return {
        updating: false,
        updateQty(itemId, qty) {
            if (qty < 1) {
                this.removeItem(itemId);
                return;
            }
            this.updating = true;
            fetch(window.apiUrl('/cart/update'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken(),
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
            fetch(window.apiUrl('/cart/remove/' + itemId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken(),
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
    };
}
</script>
@endpush
