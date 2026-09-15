@extends('layouts.admin')

@section('title', 'Orders Management')
@section('header_title', 'Orders Management')
@section('header_subtitle', 'Fulfilment pipeline, tracking numbers, invoices, and customer transactions')

@section('content')
<div class="space-y-6">

    <!-- Filters Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-sm shadow-xs border border-[#EFE9DE] flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto text-xs">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order #, customer name, phone..."
                   class="px-3.5 py-2 border border-[#EFE9DE] rounded w-64 text-xs focus:ring-1 focus:ring-[#C5A869]">

            <select name="status" class="px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                <option value="">All Fulfilment Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="packed" {{ request('status') == 'packed' ? 'selected' : '' }}>Packed</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out For Delivery</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <select name="payment_status" class="px-3 py-2 border border-[#EFE9DE] rounded text-xs">
                <option value="">All Payment Statuses</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-[#58111A] text-white rounded font-bold hover:bg-[#430D14]">Filter</button>
            @if(request()->hasAny(['search', 'status', 'payment_status']))
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-rose-700 underline font-semibold">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.manual-orders.create') }}" class="px-4 py-2 bg-[#C5A869] hover:bg-[#A88B4D] text-white font-bold text-xs uppercase tracking-wider rounded-sm transition-colors flex items-center gap-2 shadow shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Create Manual Order</span>
        </a>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-sm shadow-xs border border-[#EFE9DE] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F7F4EE] uppercase tracking-wider text-[#8C713B] font-bold border-b border-[#EFE9DE]">
                    <tr>
                        <th class="px-5 py-3.5">Order ID</th>
                        <th class="px-5 py-3.5">Customer</th>
                        <th class="px-5 py-3.5">Date</th>
                        <th class="px-5 py-3.5">Items</th>
                        <th class="px-5 py-3.5">Total (₹)</th>
                        <th class="px-5 py-3.5">Payment</th>
                        <th class="px-5 py-3.5">Fulfilment Status</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EFE9DE]">
                    @forelse($orders as $order)
                        <tr class="hover:bg-[#FCFBF8] transition-colors">
                            <td class="px-5 py-3.5 font-bold text-[#58111A]">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline">
                                    #{{ $order->order_number }}
                                </a>
                                @if($order->is_manual)
                                    <span class="block text-[9px] text-[#C5A869] font-bold uppercase">Manual Order</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-[#2A1810]">{{ $order->customer_name }}</div>
                                <div class="text-[11px] text-gray-500">{{ $order->shipping_phone }}</div>
                            </td>
                            <td class="px-5 py-3.5 text-gray-500">
                                {{ $order->created_at->format('d M Y, h:i A') }}
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-gray-700">
                                {{ $order->items->count() }} item{{ $order->items->count() === 1 ? '' : 's' }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-[#2A1810]">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $order->payment_badge_class }}">
                                    {{ $order->payment_status }}
                                </span>
                                <span class="block text-[10px] text-gray-500 uppercase mt-0.5">{{ $order->payment_method }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $order->status_badge_class }}">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-2.5 py-1 bg-[#F7F4EE] hover:bg-[#58111A] hover:text-white rounded text-[11px] font-bold text-[#58111A] transition-colors">
                                    Manage
                                </a>
                                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="px-2.5 py-1 border border-[#EFE9DE] hover:bg-gray-100 rounded text-[11px] text-gray-600 transition-colors" title="Print Invoice">
                                    Invoice
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                                No orders found matching filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-5 border-t border-[#EFE9DE] bg-[#F7F4EE]">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
