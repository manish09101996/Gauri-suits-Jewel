@extends('layouts.app')

@section('title', 'Secure Checkout | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-28 sm:py-8 space-y-8" x-data="checkoutPage()">

    <!-- Page Header -->
    <div class="bg-gradient-to-b from-[#FAF7F2] to-[#F5EFEB] border border-[#D4AF37]/35 rounded-sm p-6 sm:p-8 text-center relative overflow-hidden shadow-xs">
        <span class="text-[9.5px] sm:text-[10.5px] uppercase tracking-[0.35em] text-[#8C713B] font-bold block mb-1">
            ✦ ATELIER CONCIERGE CHECKOUT ✦
        </span>
        <h1 class="font-serif text-2xl sm:text-4xl font-normal text-[#3B0A11] tracking-wide">
            Secure Royal Checkout
        </h1>
        <p class="text-xs sm:text-sm text-[#6B5E55] font-serif italic max-w-xl mx-auto mt-1">
            Complimentary insured dispatch across Australia &bull; Geelong &bull; Melbourne
        </p>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs sm:text-sm space-y-1">
            <div class="font-bold">Please check the required information below:</div>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Left 7 Cols: Customer, Address & Payment Selection -->
            <div class="lg:col-span-7 space-y-6">

                <!-- Saved Address Quick Picker (for logged-in clients) -->
                @if($addresses->isNotEmpty())
                <div class="bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm space-y-3">
                    <h2 class="text-xs uppercase font-bold tracking-wider text-brand-charcoal flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Saved Delivery Addresses
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($addresses as $addr)
                        <div @click="fillAddress({{ json_encode($addr) }})" class="p-3 border border-stone-200 hover:border-brand-maroon rounded-xl cursor-pointer bg-stone-50/50 hover:bg-stone-50 transition text-xs space-y-1">
                            <div class="font-bold text-brand-charcoal">{{ $addr->full_name }}</div>
                            <div class="text-stone-500 line-clamp-1">{{ $addr->address_line1 }}</div>
                            <div class="text-stone-500">{{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}</div>
                            <div class="text-[11px] text-brand-maroon font-semibold">Click to use this address →</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Shipping Address Form -->
                <div class="bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-6 shadow-xs space-y-4">
                    <h2 class="font-serif text-lg font-normal text-[#3B0A11] flex items-center gap-2 border-b border-[#E8DFD5] pb-3">
                        <span class="w-6 h-6 rounded-full bg-[#58111A] text-[#F7EED9] border border-[#D4AF37]/50 text-xs flex items-center justify-center font-sans font-bold">1</span>
                        Customer &amp; Delivery Information
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">Full Recipient Name *</label>
                            <input type="text" name="name" value="{{ old('name', $user?->name ?? $defaultAddress?->full_name) }}" required placeholder="e.g. Simran Kaur" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">Mobile Phone (For Courier Updates) *</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user?->phone ?? $defaultAddress?->phone) }}" required placeholder="+61 400 000 000" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">Email Address (For Tax Invoice) *</label>
                            <input type="email" name="email" value="{{ old('email', $user?->email) }}" required placeholder="simran@example.com" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">Flat / House No. / Street Address *</label>
                            <input type="text" name="address_line1" value="{{ old('address_line1', $defaultAddress?->address_line1) }}" required placeholder="Apartment 4B, 120 Moorabool St" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">Colony / Landmark (Optional)</label>
                            <input type="text" name="address_line2" value="{{ old('address_line2', $defaultAddress?->address_line2) }}" placeholder="Level 2, Suite 4" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">City / Town *</label>
                            <input type="text" name="city" value="{{ old('city', $defaultAddress?->city) }}" required placeholder="Geelong" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">State / Province *</label>
                            <select name="state" x-model="selectedState" @change="onStateOrPaymentChange()" required class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                                @foreach($states as $st)
                                    <option value="{{ $st }}">{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">Postcode / Postal Code *</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $defaultAddress?->postal_code) }}" required placeholder="3220" class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#3B0A11] mb-1">Country</label>
                            <input type="text" name="country" value="Australia" readonly class="w-full bg-[#EFE9DE] border border-[#D5CBC0] rounded-xs px-3.5 py-2.5 text-xs text-[#3B0A11] font-semibold outline-none">
                        </div>
                    </div>

                    @auth
                        <div class="pt-2">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-[#3B0A11]">
                                <input type="checkbox" name="save_address" value="1" checked class="rounded-xs text-[#58111A] focus:ring-0">
                                <span>Save this address to my account for faster future checkout</span>
                            </label>
                        </div>
                    @endauth
                </div>

                <!-- Payment Method Selection -->
                <div class="bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-6 shadow-xs space-y-4">
                    <h2 class="font-serif text-lg font-normal text-[#3B0A11] flex items-center gap-2 border-b border-[#E8DFD5] pb-3">
                        <span class="w-6 h-6 rounded-full bg-[#58111A] text-[#F7EED9] border border-[#D4AF37]/50 text-xs flex items-center justify-center font-sans font-bold">2</span>
                        Payment Method
                    </h2>

                    <div class="space-y-3">
                        <!-- Stripe Online Option -->
                        <label :class="paymentMethod === 'stripe' ? 'border-[#58111A] ring-2 ring-[#D4AF37]/30 bg-white shadow-xs' : 'border-[#D5CBC0] bg-white/70 hover:border-[#D4AF37]'" class="flex items-start gap-3 p-4 border rounded-xs cursor-pointer transition">
                            <input type="radio" name="payment_method" value="stripe" x-model="paymentMethod" @change="onStateOrPaymentChange()" class="mt-1 text-[#58111A] focus:ring-0">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-xs sm:text-sm text-[#3B0A11]">Credit / Debit Card (Stripe)</span>
                                    <span class="px-2 py-0.5 bg-[#083323] text-[#E6CA65] text-[10px] font-bold rounded-xs uppercase tracking-wider">Instant &amp; Encrypted</span>
                                </div>
                                <p class="text-xs text-[#6B5E55]">
                                    Pay securely with Visa, Mastercard, AMEX, Apple Pay, or Google Pay via Stripe.
                                </p>
                            </div>
                        </label>

                        <!-- Cash on Delivery (COD) Option -->
                        <label :class="paymentMethod === 'cod' ? 'border-[#58111A] ring-2 ring-[#D4AF37]/30 bg-white shadow-xs' : 'border-[#D5CBC0] bg-white/70 hover:border-[#D4AF37]'" class="flex items-start gap-3 p-4 border rounded-xs cursor-pointer transition" :style="!codAvailable ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" :disabled="!codAvailable" @change="onStateOrPaymentChange()" class="mt-1 text-[#58111A] focus:ring-0">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-xs sm:text-sm text-[#3B0A11]">Cash on Delivery (COD)</span>
                                    <template x-if="codAvailable">
                                        <span class="px-2 py-0.5 bg-[#58111A] text-[#F7EED9] text-[10px] font-bold rounded-xs uppercase tracking-wider">Pay at Doorstep</span>
                                    </template>
                                </div>
                                <p class="text-xs text-[#6B5E55]" x-text="codAvailable ? 'Pay in cash upon receiving your order parcel from the courier partner.' : 'COD is not available for this cart value or delivery location.'"></p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Special Instructions / Notes -->
                <div class="bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-6 shadow-xs space-y-2">
                    <label class="block text-xs font-bold text-[#3B0A11]">Special Sizing / Tailoring Notes (Optional)</label>
                    <textarea name="notes" rows="2" placeholder="Custom suit length, specific sleeve preference, or delivery gate instructions..." class="w-full bg-white border border-[#D5CBC0] rounded-xs px-3 py-2 text-xs text-[#2A1810] focus:bg-white focus:outline-none focus:border-[#58111A]">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Right 5 Cols: Bag Summary & Total Payment -->
            <div class="lg:col-span-5 space-y-6 sticky top-24">
                <div class="bg-[#FAF7F2] border border-[#D4AF37]/35 rounded-sm p-6 shadow-xs space-y-5">
                    <div class="flex items-center justify-between border-b border-[#E8DFD5] pb-3">
                        <h2 class="font-serif text-lg font-normal text-[#3B0A11]">Ensembles in Order</h2>
                        <a href="{{ route('cart.index') }}" class="text-xs text-[#8C713B] hover:text-[#58111A] hover:underline font-semibold">Edit Bag</a>
                    </div>

                    <!-- Items mini list -->
                    <div class="space-y-3.5 max-h-72 overflow-y-auto pr-1">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-3">
                            <div class="relative w-14 aspect-[3/4] bg-white rounded-xs overflow-hidden shrink-0 border border-[#D5CBC0]">
                                <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                <span class="absolute top-0 right-0 bg-[#58111A] text-[#F7EED9] text-[9.5px] font-bold px-1.5 rounded-bl">
                                    {{ $item->quantity }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-serif text-xs font-semibold text-[#2A1810] truncate">{{ $item->product->name }}</div>
                                @if($item->variant)
                                    <div class="text-[10.5px] text-[#6B5E55]">{{ $item->variant->size ?: $item->variant->name }}</div>
                                @endif
                                <div class="text-[11px] font-semibold text-[#58111A]">{{ $currencySymbol ?? '$' }}{{ number_format($item->price, 2) }} × {{ $item->quantity }}</div>
                            </div>
                            <div class="font-serif text-xs font-bold text-[#2A1810]">
                                {{ $currencySymbol ?? '$' }}{{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Financial Summary -->
                    <div class="pt-4 border-t border-[#E8DFD5] space-y-2.5 text-xs sm:text-sm text-[#554740]">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold text-[#2A1810]">{{ $currencySymbol ?? '$' }}{{ number_format($totals['subtotal'], 2) }}</span>
                        </div>

                        @if(($totals['discount'] ?? 0) > 0)
                        <div class="flex justify-between text-[#083323]">
                            <span>Coupon Savings</span>
                            <span class="font-bold">-{{ $currencySymbol ?? '$' }}{{ number_format($totals['discount'], 2) }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Insured Delivery</span>
                            <span class="font-semibold" x-text="shippingFee === 0 ? 'FREE' : window.formatMoney(shippingFee)">
                                {{ ($totals['shipping_fee'] ?? 0) == 0 ? 'FREE' : ($currencySymbol ?? '$') . number_format($totals['shipping_fee'], 2) }}
                            </span>
                        </div>

                        <div class="flex justify-between text-[11px] text-[#8C713B]">
                            <span>Applicable Taxes (Included)</span>
                            <span>Included</span>
                        </div>

                        <div class="pt-3 border-t border-[#E8DFD5] flex justify-between items-baseline font-serif text-lg font-bold text-[#2A1810]">
                            <span>Amount Payable</span>
                            <span class="text-[#58111A] text-2xl font-bold" x-text="window.formatMoney(grandTotal)">
                                {{ $currencySymbol ?? '$' }}{{ number_format($totals['grand_total'], 2) }}
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 sm:py-4 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] font-bold text-xs uppercase tracking-[0.12em] sm:tracking-[0.2em] text-center rounded-xs shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span x-text="paymentMethod === 'cod' ? 'Confirm Cash on Delivery Order' : 'Proceed to Stripe Card Payment'"></span>
                    </button>

                    <div class="text-center text-[11px] text-[#8C713B] font-serif italic">
                        Geelong &bull; Melbourne, Australia &bull; Stripe &amp; COD Exclusive
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function checkoutPage() {
    return {
        selectedState: {!! json_encode(old('state', $defaultAddress?->state ?? 'Victoria')) !!},
        paymentMethod: {!! json_encode(old('payment_method', 'stripe')) !!},
        shippingFee: {{ $totals['shipping_fee'] ?? 0 }},
        subtotal: {{ $totals['subtotal'] ?? 0 }},
        discount: {{ $totals['discount'] ?? 0 }},
        codAvailable: {{ $codAvailable ? 'true' : 'false' }},
        grandTotal: {{ $totals['grand_total'] ?? 0 }},
        updatingRates: false,
        onStateOrPaymentChange() {
            this.updatingRates = true;
            fetch(window.apiUrl('/checkout/shipping-rate'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    state: this.selectedState,
                    payment_method: this.paymentMethod
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.shippingFee = data.totals.shipping_fee;
                    this.grandTotal = data.totals.grand_total;
                    this.codAvailable = data.cod_available;
                    if (!this.codAvailable && this.paymentMethod === 'cod') {
                        this.paymentMethod = 'stripe';
                    }
                }
                this.updatingRates = false;
            })
            .catch(err => {
                console.error(err);
                this.updatingRates = false;
            });
        },
        fillAddress(addr) {
            document.querySelector('[name=name]').value = (addr.first_name || '') + ' ' + (addr.last_name || '');
            document.querySelector('[name=phone]').value = addr.phone || '';
            document.querySelector('[name=address_line1]').value = addr.address_line1 || '';
            document.querySelector('[name=address_line2]').value = addr.address_line2 || '';
            document.querySelector('[name=city]').value = addr.city || '';
            document.querySelector('[name=postal_code]').value = addr.postal_code || '';
            this.selectedState = addr.state || 'Victoria';
            this.onStateOrPaymentChange();
        }
    };
}
</script>
@endpush
