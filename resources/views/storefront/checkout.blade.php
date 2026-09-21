@extends('layouts.app')

@section('title', 'Secure Checkout | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-28 sm:py-8 space-y-8" x-data="checkoutPage()">

    <!-- Page Header -->
    <div class="border-b border-stone-200 pb-4 text-center sm:text-left">
        <h1 class="font-serif text-3xl font-bold text-brand-charcoal">Secure Checkout</h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">
            Complete your order for bespoke handcrafted Punjabi couture & jewellery
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
                <div class="bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm space-y-4">
                    <h2 class="font-serif text-lg font-bold text-brand-charcoal flex items-center gap-2 border-b border-stone-100 pb-3">
                        <span class="w-6 h-6 rounded-full bg-brand-maroon text-white text-xs flex items-center justify-center font-sans font-bold">1</span>
                        Customer & Delivery Information
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-stone-700 mb-1">Full Recipient Name *</label>
                            <input type="text" name="name" value="{{ old('name', $user?->name ?? $defaultAddress?->full_name) }}" required placeholder="e.g. Simran Kaur" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Mobile Phone (For Courier Updates) *</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user?->phone ?? $defaultAddress?->phone) }}" required placeholder="+91 98765 43210" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Email Address (For Tax Invoice) *</label>
                            <input type="email" name="email" value="{{ old('email', $user?->email) }}" required placeholder="simran@example.com" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-stone-700 mb-1">Flat / House No. / Street Address *</label>
                            <input type="text" name="address_line1" value="{{ old('address_line1', $defaultAddress?->address_line1) }}" required placeholder="Apartment 4B, Heritage Enclave" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-stone-700 mb-1">Colony / Landmark (Optional)</label>
                            <input type="text" name="address_line2" value="{{ old('address_line2', $defaultAddress?->address_line2) }}" placeholder="Near Model Town Gurudwara" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">City / Town *</label>
                            <input type="text" name="city" value="{{ old('city', $defaultAddress?->city) }}" required placeholder="Ludhiana" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">State / Province *</label>
                            <select name="state" x-model="selectedState" @change="onStateOrPaymentChange()" required class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                                @foreach($states as $st)
                                    <option value="{{ $st }}">{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Pincode / Postal Code *</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $defaultAddress?->postal_code) }}" required placeholder="141001" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-700 mb-1">Country</label>
                            <input type="text" name="country" value="India" readonly class="w-full bg-stone-100 border border-stone-300 rounded px-3.5 py-2.5 text-xs text-stone-600 outline-none">
                        </div>
                    </div>

                    @auth
                        <div class="pt-2">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700">
                                <input type="checkbox" name="save_address" value="1" checked class="rounded text-brand-maroon focus:ring-0">
                                <span>Save this address to my account for faster future checkout</span>
                            </label>
                        </div>
                    @endauth
                </div>

                <!-- Payment Method Selection -->
                <div class="bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm space-y-4">
                    <h2 class="font-serif text-lg font-bold text-brand-charcoal flex items-center gap-2 border-b border-stone-100 pb-3">
                        <span class="w-6 h-6 rounded-full bg-brand-maroon text-white text-xs flex items-center justify-center font-sans font-bold">2</span>
                        Payment Method
                    </h2>

                    <div class="space-y-3">
                        <!-- Razorpay Online Option -->
                        <label :class="paymentMethod === 'razorpay' ? 'border-brand-maroon ring-2 ring-brand-maroon/10 bg-stone-50' : 'border-stone-200 hover:border-stone-300'" class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer transition">
                            <input type="radio" name="payment_method" value="razorpay" x-model="paymentMethod" @change="onStateOrPaymentChange()" class="mt-1 text-brand-maroon focus:ring-0">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-xs sm:text-sm text-brand-charcoal">Online Payment (UPI, Cards, NetBanking)</span>
                                    <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded uppercase">Instant & Secure</span>
                                </div>
                                <p class="text-xs text-stone-500">
                                    Pay seamlessly via Google Pay, PhonePe, Paytm, all Debit & Credit cards, and NetBanking via Razorpay.
                                </p>
                            </div>
                        </label>

                        <!-- Cash on Delivery (COD) Option -->
                        <label :class="paymentMethod === 'cod' ? 'border-brand-maroon ring-2 ring-brand-maroon/10 bg-stone-50' : 'border-stone-200 hover:border-stone-300'" class="flex items-start gap-3 p-4 border rounded-xl cursor-pointer transition" :style="!codAvailable ? 'opacity: 0.6; cursor: not-allowed;' : ''">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" :disabled="!codAvailable" @change="onStateOrPaymentChange()" class="mt-1 text-brand-maroon focus:ring-0">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-xs sm:text-sm text-brand-charcoal">Cash on Delivery (COD)</span>
                                    <template x-if="codAvailable">
                                        <span class="px-2 py-0.5 bg-stone-200 text-stone-700 text-[10px] font-bold rounded uppercase">Pay at Doorstep</span>
                                    </template>
                                </div>
                                <p class="text-xs text-stone-500" x-text="codAvailable ? 'Pay in cash or UPI QR upon receiving your order parcel from the courier partner.' : 'COD is not available for this cart value or delivery location.'"></p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Special Instructions / Notes -->
                <div class="bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm space-y-2">
                    <label class="block text-xs font-bold text-stone-700">Special Sizing / Tailoring Notes (Optional)</label>
                    <textarea name="notes" rows="2" placeholder="Custom suit length, specific sleeve preference, or delivery gate instructions..." class="w-full bg-stone-50 border border-stone-300 rounded px-3 py-2 text-xs text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Right 5 Cols: Bag Summary & Total Payment -->
            <div class="lg:col-span-5 space-y-6 sticky top-24">
                <div class="bg-white border border-stone-200/80 rounded-2xl p-6 shadow-sm space-y-5">
                    <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                        <h2 class="font-serif text-lg font-bold text-brand-charcoal">Ensembles in Order</h2>
                        <a href="{{ route('cart.index') }}" class="text-xs text-brand-gold hover:underline font-semibold">Edit Bag</a>
                    </div>

                    <!-- Items mini list -->
                    <div class="space-y-3.5 max-h-72 overflow-y-auto pr-1">
                        @foreach($cart->items as $item)
                        <div class="flex items-center gap-3">
                            <div class="relative w-14 aspect-[3/4] bg-stone-100 rounded overflow-hidden shrink-0 border border-stone-200">
                                <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                <span class="absolute top-0 right-0 bg-brand-charcoal text-white text-[10px] font-bold px-1.5 rounded-bl">
                                    {{ $item->quantity }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-serif text-xs font-bold text-brand-charcoal truncate">{{ $item->product->name }}</div>
                                @if($item->variant)
                                    <div class="text-[11px] text-stone-500">{{ $item->variant->size ?: $item->variant->name }}</div>
                                @endif
                                <div class="text-[11px] font-semibold text-stone-600">₹{{ number_format($item->price) }} × {{ $item->quantity }}</div>
                            </div>
                            <div class="font-serif text-xs font-bold text-brand-charcoal">
                                ₹{{ number_format($item->subtotal) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Financial Summary -->
                    <div class="pt-4 border-t border-stone-100 space-y-2.5 text-xs sm:text-sm text-stone-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold text-brand-charcoal">₹{{ number_format($totals['subtotal']) }}</span>
                        </div>

                        @if(($totals['discount'] ?? 0) > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Coupon Savings</span>
                            <span class="font-bold">-₹{{ number_format($totals['discount']) }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between">
                            <span>Insured Delivery</span>
                            <span class="font-semibold" x-text="shippingFee === 0 ? 'FREE' : '₹' + Number(shippingFee).toLocaleString('en-IN')">
                                {{ ($totals['shipping_fee'] ?? 0) == 0 ? 'FREE' : '₹' . number_format($totals['shipping_fee']) }}
                            </span>
                        </div>

                        <div class="flex justify-between text-[11px] text-stone-400">
                            <span>All-India GST (Included)</span>
                            <span>Included</span>
                        </div>

                        <div class="pt-3 border-t border-stone-100 flex justify-between items-baseline font-serif text-lg font-bold text-brand-charcoal">
                            <span>Amount Payable</span>
                            <span class="text-brand-maroon text-2xl" x-text="'₹' + Number(grandTotal).toLocaleString('en-IN')">
                                ₹{{ number_format($totals['grand_total']) }}
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 sm:py-4 bg-[#58111A] hover:bg-[#3B0A11] border border-[#D4AF37]/50 text-[#F7EED9] font-bold text-xs uppercase tracking-[0.12em] sm:tracking-[0.2em] text-center rounded-xs shadow-lg transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span x-text="paymentMethod === 'cod' ? 'Confirm Cash on Delivery Order' : 'Proceed to Razorpay Payment'"></span>
                    </button>

                    <div class="text-center text-[11px] text-stone-400">
                        By placing your order, you agree to Gauri Suits & Jewel's terms & return policy.
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
        selectedState: {!! json_encode(old('state', $defaultAddress?->state ?? 'Punjab')) !!},
        paymentMethod: {!! json_encode(old('payment_method', 'razorpay')) !!},
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
                        this.paymentMethod = 'razorpay';
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
            this.selectedState = addr.state || 'Punjab';
            this.onStateOrPaymentChange();
        }
    };
}
</script>
@endpush
