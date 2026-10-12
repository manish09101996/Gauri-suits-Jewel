@extends('layouts.admin')

@section('title', 'Create Manual Order')

@section('content')
<div class="space-y-6" x-data="manualOrderForm()">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="p-2 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Create Manual Order</h1>
                    <p class="text-sm text-slate-400">Generate a custom order for phone, WhatsApp, or boutique store sales</p>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
            <div class="font-semibold mb-2">Please resolve the following errors:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.manual-orders.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Customer & Products -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Details -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-base font-semibold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Customer & Delivery Address
                        </h2>
                        <div>
                            <select @change="selectCustomer($event.target.value)" class="text-xs bg-slate-800 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:border-amber-400 outline-none">
                                <option value="">Select Existing Customer (Optional)</option>
                                @foreach($customers as $c)
                                    <option value="{{ json_encode(['name' => $c->name, 'email' => $c->email, 'phone' => $c->phone]) }}">{{ $c->name }} ({{ $c->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Customer Full Name *</label>
                            <input type="text" name="shipping_name" x-model="customer.name" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Customer Phone Number *</label>
                            <input type="text" name="shipping_phone" x-model="customer.phone" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="+91 98765 43210">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Email Address</label>
                            <input type="email" name="customer_email" x-model="customer.email" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="customer@example.com">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Address Line 1 *</label>
                            <input type="text" name="shipping_address_line1" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="House / Flat / Street name">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-slate-300 mb-1">Address Line 2 (Optional)</label>
                            <input type="text" name="shipping_address_line2" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="Landmark, Suite, etc.">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">City *</label>
                            <input type="text" name="shipping_city" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">State *</label>
                            <input type="text" name="shipping_state" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Pincode / Postal Code *</label>
                            <input type="text" name="shipping_postal_code" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Country</label>
                            <input type="text" name="shipping_country" value="India" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                        </div>
                    </div>
                </div>

                <!-- Products Selection -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-semibold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            Order Items
                        </h2>
                        <button type="button" @click="addItem()" class="px-3 py-1.5 bg-amber-500/10 border border-amber-500/30 text-amber-300 hover:bg-amber-500/20 rounded-lg text-xs font-medium transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Product
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="p-4 bg-slate-800/60 border border-slate-700/60 rounded-xl space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider" x-text="`Item #${index + 1}`"></span>
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-rose-400 hover:text-rose-300 text-xs flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Remove
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-medium text-slate-400 mb-1">Select Catalog Product *</label>
                                        <select :name="`items[${index}][product_id]`" x-model="item.product_id" @change="onProductSelect(index, $event.target.value)" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                                            <option value="">-- Choose Product --</option>
                                            @foreach($products as $p)
                                                <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-price="{{ $p->sale_price ?? $p->base_price }}" data-sku="{{ $p->sku }}" data-variants="{{ json_encode($p->variants) }}">
                                                    {{ $p->name }} ({{ $currencySymbol ?? '$' }}{{ number_format($p->sale_price ?? $p->base_price) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400 mb-1">Variant (if applicable)</label>
                                        <select :name="`items[${index}][variant_id]`" x-model="item.variant_id" @change="onVariantSelect(index, $event.target.value)" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                                            <option value="">Default / Standard</option>
                                            <template x-for="v in item.availableVariants" :key="v.id">
                                                <option :value="v.id" x-text="`${v.title || v.name || 'Variant'} (${window.currencySymbol || '$'}${v.price || item.price})`"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div class="col-span-2 sm:col-span-1">
                                        <label class="block text-xs font-medium text-slate-400 mb-1">Product Title</label>
                                        <input type="text" :name="`items[${index}][name]`" x-model="item.name" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400 mb-1">SKU</label>
                                        <input type="text" :name="`items[${index}][sku]`" x-model="item.sku" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400 mb-1">Unit Price ({{ $currencySymbol ?? '$' }}) *</label>
                                        <input type="number" step="0.01" :name="`items[${index}][price]`" x-model.number="item.price" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400 mb-1">Quantity *</label>
                                        <input type="number" min="1" :name="`items[${index}][quantity]`" x-model.number="item.quantity" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                                    </div>
                                </div>

                                <input type="hidden" :name="`items[${index}][variant_title]`" :value="item.variant_title">

                                <div class="text-right text-xs text-slate-400 font-medium">
                                    Line Total: <span class="text-amber-400 font-bold text-sm" x-text="window.formatMoney ? window.formatMoney(item.price * item.quantity) : ('$' + Number(item.price * item.quantity).toFixed(2))"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Internal Notes -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm">
                    <label class="block text-xs font-medium text-slate-300 mb-2">Order Notes / Custom Requests</label>
                    <textarea name="notes" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="Add custom measurements, gift message, or order notes..."></textarea>
                </div>
            </div>

            <!-- Right Col: Payment & Calculations -->
            <div class="space-y-6">
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Payment & Order Status
                    </h2>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Payment Method *</label>
                        <select name="payment_method" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                            <option value="cod">Cash On Delivery (COD)</option>
                            <option value="bank_transfer">Bank Wire / IMPS / NEFT</option>
                            <option value="upi">UPI / GPay / PhonePe</option>
                            <option value="pos">In-Store POS Card</option>
                            <option value="razorpay">Razorpay Online Link</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Payment Status *</label>
                        <select name="payment_status" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid (Received)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Fulfillment Status *</label>
                        <select name="status" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                            <option value="confirmed">Confirmed</option>
                            <option value="processing">Processing (Stitching / Packing)</option>
                            <option value="packed">Packed</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                </div>

                <!-- Shipment Tracking (Optional) -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        Shipping Carrier (Optional)
                    </h2>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Carrier Name</label>
                        <input type="text" name="shipping_carrier" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="Delhivery, BlueDart, DTDC">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Tracking Number (AWB)</label>
                        <input type="text" name="tracking_number" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="e.g. DLV19827391">
                    </div>
                </div>

                <!-- Price Summary Card -->
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-semibold text-white">Summary Breakdown</h2>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Shipping Charges ({{ $currencySymbol ?? '$' }})</label>
                        <input type="number" step="0.01" name="shipping_amount" x-model.number="shippingFee" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="0.00">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Discount Amount ({{ $currencySymbol ?? '$' }})</label>
                        <input type="number" step="0.01" name="discount_amount" x-model.number="discountFee" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none" placeholder="0.00">
                    </div>

                    <div class="pt-4 border-t border-slate-800 space-y-2 text-sm">
                        <div class="flex justify-between text-slate-400">
                            <span>Subtotal</span>
                            <span x-text="window.formatMoney ? window.formatMoney(subtotal()) : ('$' + Number(subtotal()).toFixed(2))">$0.00</span>
                        </div>
                        <div class="flex justify-between text-slate-400">
                            <span>Shipping</span>
                            <span x-text="window.formatMoney ? window.formatMoney(shippingFee || 0) : ('$' + Number(shippingFee || 0).toFixed(2))">$0.00</span>
                        </div>
                        <div class="flex justify-between text-emerald-400" x-show="discountFee > 0">
                            <span>Discount</span>
                            <span x-text="'-' + (window.formatMoney ? window.formatMoney(discountFee || 0) : ('$' + Number(discountFee || 0).toFixed(2)))">-$0.00</span>
                        </div>
                        <div class="flex justify-between text-white font-bold text-lg pt-2 border-t border-slate-800">
                            <span>Grand Total</span>
                            <span class="text-amber-400" x-text="window.formatMoney ? window.formatMoney(grandTotal()) : ('$' + Number(grandTotal()).toFixed(2))">$0.00</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Create Order
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function manualOrderForm() {
    return {
        customer: { name: '', email: '', phone: '' },
        shippingFee: 0,
        discountFee: 0,
        items: [
            { product_id: '', variant_id: '', name: '', sku: '', price: 0, quantity: 1, variant_title: '', availableVariants: [] }
        ],
        addItem() {
            this.items.push({ product_id: '', variant_id: '', name: '', sku: '', price: 0, quantity: 1, variant_title: '', availableVariants: [] });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
            }
        },
        selectCustomer(jsonStr) {
            if (!jsonStr) return;
            try {
                const data = JSON.parse(jsonStr);
                this.customer.name = data.name || '';
                this.customer.email = data.email || '';
                this.customer.phone = data.phone || '';
            } catch (e) {}
        },
        onProductSelect(index, productId) {
            const selectEl = event.target;
            const option = selectEl.options[selectEl.selectedIndex];
            if (!option || !productId) return;

            const name = option.getAttribute('data-name');
            const price = parseFloat(option.getAttribute('data-price')) || 0;
            const sku = option.getAttribute('data-sku') || '';
            const variants = JSON.parse(option.getAttribute('data-variants') || '[]');

            this.items[index].name = name;
            this.items[index].price = price;
            this.items[index].sku = sku;
            this.items[index].availableVariants = variants;
            this.items[index].variant_id = '';
            this.items[index].variant_title = '';
        },
        onVariantSelect(index, variantId) {
            const item = this.items[index];
            const variant = item.availableVariants.find(v => v.id == variantId);
            if (variant) {
                item.variant_title = variant.title || variant.name || '';
                if (variant.price) item.price = parseFloat(variant.price);
                if (variant.sku) item.sku = variant.sku;
            } else {
                item.variant_title = '';
            }
        },
        subtotal() {
            return this.items.reduce((sum, item) => sum + ((item.price || 0) * (item.quantity || 1)), 0);
        },
        grandTotal() {
            const tot = this.subtotal() + (this.shippingFee || 0) - (this.discountFee || 0);
            return Math.max(0, tot);
        }
    }
}
</script>
@endpush
@endsection
