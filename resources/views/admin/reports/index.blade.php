@extends('layouts.admin')

@section('title', 'Financial & Operational Reports')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Analytics & Business Reports</h1>
            <p class="text-sm text-slate-400">Generate and export verified financial, product sales, customer, and stock reports</p>
        </div>
        <div>
            <a href="{{ route('admin.reports.export', ['type' => $type, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV Report
            </a>
        </div>
    </div>

    <!-- Filter & Date Controls -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Report Domain</label>
                <select name="type" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                    <option value="sales" {{ $type === 'sales' ? 'selected' : '' }}>Paid Sales & Revenue</option>
                    <option value="orders" {{ $type === 'orders' ? 'selected' : '' }}>All Orders (All Statuses)</option>
                    <option value="products" {{ $type === 'products' ? 'selected' : '' }}>Product Performance & Sales</option>
                    <option value="customers" {{ $type === 'customers' ? 'selected' : '' }}>Customer Acquisitions</option>
                    <option value="inventory" {{ $type === 'inventory' ? 'selected' : '' }}>Inventory Audit Trail</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">From Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">To Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
            </div>
            <div>
                <button type="submit" class="w-full py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-lg text-sm transition">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($type === 'sales' || $type === 'orders')
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-4">Order #</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($data as $row)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="px-6 py-4 font-mono font-bold text-amber-400">
                                <a href="{{ route('admin.orders.show', $row->id) }}">#{{ $row->order_number }}</a>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $row->created_at->format('d M, Y h:i A') }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $row->shipping_name }}</div>
                                <div class="text-xs text-slate-400">{{ $row->shipping_phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold {{ $row->payment_status === 'paid' ? 'text-emerald-400' : 'text-amber-400' }}">
                                    {{ ucfirst($row->payment_status) }}
                                </span>
                                <div class="text-[11px] text-slate-500 uppercase">{{ $row->payment_method }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs">{{ ucfirst($row->status) }}</td>
                            <td class="px-6 py-4 text-right font-bold text-white">₹{{ number_format($row->grand_total, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-500">No orders found for the chosen date range.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif($type === 'products')
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-4">Product Name</th>
                            <th class="px-6 py-4">SKU</th>
                            <th class="px-6 py-4 text-center">Units Sold</th>
                            <th class="px-6 py-4 text-right">Revenue Generated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($data as $row)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="px-6 py-4 font-semibold text-white">{{ $row->product_name }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400 font-mono">{{ $row->product_sku }}</td>
                            <td class="px-6 py-4 text-center font-bold text-white">{{ $row->total_qty }}</td>
                            <td class="px-6 py-4 text-right font-bold text-amber-400">₹{{ number_format($row->total_sales, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No product sales recorded in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif($type === 'customers')
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-4">Customer Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Phone</th>
                            <th class="px-6 py-4 text-center">Total Orders</th>
                            <th class="px-6 py-4">Registered Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($data as $row)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="px-6 py-4 font-semibold text-white">{{ $row->name }}</td>
                            <td class="px-6 py-4 text-xs font-mono text-slate-300">{{ $row->email }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $row->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center font-bold text-indigo-400">{{ $row->orders_count }}</td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $row->created_at->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">No customers registered in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif($type === 'inventory')
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-4">Timestamp</th>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Action / Reason</th>
                            <th class="px-6 py-4 text-center">Change</th>
                            <th class="px-6 py-4 text-center">New Balance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($data as $row)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $row->created_at->format('d M, Y h:i A') }}</td>
                            <td class="px-6 py-4 font-medium text-white">{{ $row->product->name ?? 'Product #' . $row->product_id }}</td>
                            <td class="px-6 py-4 text-xs text-slate-300">{{ ucfirst(str_replace('_', ' ', $row->reason ?? $row->type)) }}</td>
                            <td class="px-6 py-4 text-center font-bold {{ $row->quantity_change > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $row->quantity_change > 0 ? '+' . $row->quantity_change : $row->quantity_change }}
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-white">{{ $row->new_quantity }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">No inventory movements recorded in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>

        @if($data->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $data->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
