@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)
@section('header_title', 'Order #' . $order->order_number)
@section('header_subtitle', 'Placed on ' . $order->created_at->format('d M Y, h:i A'))

@section('content')
<div class="space-y-8">

    <!-- Top Action Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-sm shadow-xs border border-[#EFE9DE] flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded text-xs font-bold uppercase {{ $order->status_badge_class }}">
                {{ str_replace('_', ' ', $order->status) }}
            </span>
            <span class="px-3 py-1 rounded text-xs font-bold uppercase {{ $order->payment_badge_class }}">
                Payment: {{ $order->payment_status }}
            </span>
            @if($order->is_manual)
                <span class="px-2.5 py-0.5 bg-[#C5A869]/20 text-[#8C713B] rounded text-xs font-bold uppercase">Manual Order</span>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank"
               class="px-4 py-2 border border-[#58111A] text-[#58111A] hover:bg-[#58111A] hover:text-white rounded-sm text-xs font-bold tracking-wider uppercase transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print Official Invoice</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 border border-gray-300 text-xs font-semibold rounded text-gray-700 hover:bg-gray-50">
                Back to Orders
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Ordered Items & Timeline (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Ordered Items Table -->
            <div class="bg-white rounded-sm shadow-xs border border-[#EFE9DE] overflow-hidden">
                <div class="p-5 border-b border-[#EFE9DE] bg-[#F7F4EE]">
                    <h2 class="font-serif text-base font-bold text-[#2A1810]">Ordered Items ({{ $order->items->count() }})</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="uppercase tracking-wider text-[#8C713B] font-bold border-b border-[#EFE9DE]">
                            <tr>
                                <th class="px-5 py-3">Product</th>
                                <th class="px-5 py-3">Variant</th>
                                <th class="px-5 py-3 text-center">Qty</th>
                                <th class="px-5 py-3">Price</th>
                                <th class="px-5 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EFE9DE]">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-[#FCFBF8]">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            @if($item->product && $item->product->primary_image_url)
                                                <img src="{{ $item->product->primary_image_url }}" class="w-12 h-14 object-cover rounded bg-[#EFE9DE]">
                                            @endif
                                            <div>
                                                <div class="font-bold text-[#2A1810]">{{ $item->product_name }}</div>
                                                <div class="text-[11px] text-gray-400">SKU: {{ $item->product_sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-600">
                                        {{ $item->variant_title ?: 'Standard' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-center font-bold text-[#2A1810]">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-5 py-3.5 font-semibold text-gray-700">
                                        {{ $currencySymbol ?? '$' }}{{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-5 py-3.5 text-right font-bold text-[#58111A]">
                                        {{ $currencySymbol ?? '$' }}{{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Financial Summary Box -->
                <div class="p-6 bg-[#FCFBF8] border-t border-[#EFE9DE] space-y-2 text-xs">
                    <div class="flex justify-between text-gray-600">
                        <span>Items Subtotal</span>
                        <span class="font-semibold text-gray-900">{{ $currencySymbol ?? '$' }}{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between text-emerald-700 font-semibold">
                            <span>Coupon Discount ({{ $order->coupon_code ?: 'Promotional' }})</span>
                            <span>-{{ $currencySymbol ?? '$' }}{{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping &amp; Delivery</span>
                        <span class="font-semibold text-gray-900">
                            {{ $order->shipping_amount == 0 ? 'FREE' : ($currencySymbol ?? '$') . number_format($order->shipping_amount, 2) }}
                        </span>
                    </div>
                    @if($order->tax_amount > 0)
                        <div class="flex justify-between text-gray-600">
                            <span>Estimated Tax / GST</span>
                            <span class="font-semibold text-gray-900">{{ $currencySymbol ?? '$' }}{{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="pt-3 border-t border-[#EFE9DE] flex justify-between text-base font-bold text-[#58111A]">
                        <span>Grand Total</span>
                        <span>{{ $currencySymbol ?? '$' }}{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes & Instructions -->
            @if($order->notes || $order->admin_notes)
                <div class="bg-white p-5 rounded-sm shadow-xs border border-[#EFE9DE] space-y-3 text-xs">
                    <h3 class="font-serif font-bold text-[#2A1810]">Order Notes</h3>
                    @if($order->notes)
                        <div class="p-3 bg-amber-50/60 border-l-2 border-amber-500 text-amber-900">
                            <strong>Customer Note:</strong> {{ $order->notes }}
                        </div>
                    @endif
                    @if($order->admin_notes)
                        <div class="p-3 bg-gray-50 border-l-2 border-gray-400 text-gray-700 whitespace-pre-line">
                            <strong>Internal Notes:</strong><br>{{ $order->admin_notes }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Right Column: Status Transition, Shipment & Customer (1 Col) -->
        <div class="space-y-6">

            <!-- Card: Update Fulfilment Status -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h3 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Update Order Status</h3>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Fulfilment Stage</label>
                        <select name="status" class="w-full px-3 py-2 border border-[#EFE9DE] rounded text-xs font-semibold">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="packed" {{ $order->status === 'packed' ? 'selected' : '' }}>Packed</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>Out For Delivery</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancel &amp; Restore Inventory</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Admin Audit Note</label>
                        <input type="text" name="admin_notes" placeholder="Optional audit trail note..." class="w-full px-3 py-1.5 border border-[#EFE9DE] rounded text-xs">
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-[#58111A] hover:bg-[#430D14] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Card: Shipment & Tracking -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4">
                <h3 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Shipment &amp; Tracking</h3>

                <form action="{{ route('admin.orders.shipment', $order->id) }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Carrier Name *</label>
                        <input type="text" name="carrier" value="{{ old('carrier', $order->shipment?->carrier ?: 'BlueDart / Delhivery') }}" required
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Tracking Number (AWB) *</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->shipment?->tracking_number) }}" required placeholder="e.g. BD78291039IN"
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded font-mono font-bold">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-700 mb-1">Carrier Tracking URL</label>
                        <input type="url" name="tracking_url" value="{{ old('tracking_url', $order->shipment?->tracking_url) }}" placeholder="https://..."
                               class="w-full px-3 py-2 border border-[#EFE9DE] rounded">
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#C5A869] hover:bg-[#A88B4D] text-white font-bold text-xs uppercase tracking-wider rounded transition-colors shadow">
                        Save Tracking Details
                    </button>
                </form>
            </div>

            <!-- Card: Customer & Shipping Details -->
            <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] space-y-4 text-xs">
                <h3 class="font-serif text-base font-bold text-[#2A1810] border-b border-[#EFE9DE] pb-3">Client Destination</h3>

                <div>
                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Customer Name</span>
                    <span class="font-bold text-sm text-[#2A1810]">{{ $order->shipping_name }}</span>
                </div>

                <div>
                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Contact Coordinates</span>
                    <span class="font-semibold block text-[#2A1810]">📞 {{ $order->shipping_phone }}</span>
                    @if($order->shipping_email)
                        <span class="font-semibold block text-gray-600">✉️ {{ $order->shipping_email }}</span>
                    @endif
                </div>

                <div>
                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Shipping Address</span>
                    <div class="mt-1 text-[#2A1810] leading-relaxed">
                        {{ $order->shipping_address_line1 }}<br>
                        @if($order->shipping_address_line2) {{ $order->shipping_address_line2 }}<br> @endif
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_postal_code }}<br>
                        {{ $order->shipping_country }}
                    </div>
                </div>

                <!-- Payment Status Action -->
                @if($order->payment_status !== 'paid')
                    <div class="pt-4 border-t border-[#EFE9DE]">
                        <form action="{{ route('admin.orders.mark-paid', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded text-xs uppercase tracking-wider transition-colors">
                                Mark as Received / Paid
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
