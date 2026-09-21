@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header_title', 'Admin Dashboard')
@section('header_subtitle', 'Real-time sales, inventory, and business operations overview')

@section('content')
<div class="space-y-8">

    <!-- Dashboard Top Bar: Date Range Filter & Export Action -->
    <div class="bg-white p-4 sm:p-5 rounded-sm shadow-xs border border-[#EFE9DE] flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Quick Period Presets -->
        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
            <span class="text-[#8C713B] uppercase tracking-wider mr-1">Period:</span>
            <a href="{{ route('admin.dashboard', ['days' => 7]) }}" class="px-3 py-1.5 rounded border transition-colors {{ $days == 7 ? 'bg-[#58111A] text-white border-[#58111A]' : 'bg-[#F7F4EE] text-[#2A1810] border-[#EFE9DE] hover:border-[#C5A869]' }}">Last 7 Days</a>
            <a href="{{ route('admin.dashboard', ['days' => 30]) }}" class="px-3 py-1.5 rounded border transition-colors {{ $days == 30 ? 'bg-[#58111A] text-white border-[#58111A]' : 'bg-[#F7F4EE] text-[#2A1810] border-[#EFE9DE] hover:border-[#C5A869]' }}">Last 30 Days</a>
            <a href="{{ route('admin.dashboard', ['days' => 90]) }}" class="px-3 py-1.5 rounded border transition-colors {{ $days == 90 ? 'bg-[#58111A] text-white border-[#58111A]' : 'bg-[#F7F4EE] text-[#2A1810] border-[#EFE9DE] hover:border-[#C5A869]' }}">Last 90 Days</a>
        </div>

        <!-- Custom Date Range Form & Export -->
        <div class="flex items-center gap-3 w-full md:w-auto">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2 text-xs">
                <input type="date" name="start_date" value="{{ $kpis['start_date'] }}" class="px-3 py-1.5 border border-[#EFE9DE] rounded text-xs text-[#2A1810] focus:ring-1 focus:ring-[#C5A869]">
                <span class="text-[#8C713B]">to</span>
                <input type="date" name="end_date" value="{{ $kpis['end_date'] }}" class="px-3 py-1.5 border border-[#EFE9DE] rounded text-xs text-[#2A1810] focus:ring-1 focus:ring-[#C5A869]">
                <button type="submit" class="px-3 py-1.5 bg-[#C5A869] text-white rounded font-bold hover:bg-[#A88B4D] transition-colors">Filter</button>
            </form>

            <a href="{{ route('admin.reports.export', ['type' => 'sales', 'start_date' => $kpis['start_date'], 'end_date' => $kpis['end_date']]) }}"
               class="px-3 py-1.5 bg-[#1B120C] text-[#F7EED9] hover:bg-[#58111A] rounded text-xs font-semibold tracking-wider uppercase transition-colors shrink-0 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Export CSV</span>
            </a>
        </div>
    </div>

    <!-- 4 Sogat-Style Dynamic KPI Cards (Calculated directly from MySQL) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- KPI 1: TOTAL SALES -->
        <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] relative overflow-hidden group hover:border-[#C5A869] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-widest font-bold text-[#8C713B]">Total Sales</span>
                <div class="w-10 h-10 rounded-sm bg-[#58111A]/10 text-[#58111A] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-bold font-serif text-[#2A1810]">
                    {{ $currencySymbol ?? '$' }}{{ number_format($kpis['total_sales'], 2) }}
                </div>
                <div class="flex items-center justify-between mt-2 text-xs">
                    <span class="text-gray-500">Lifetime: {{ $currencySymbol ?? '$' }}{{ number_format($kpis['lifetime_sales'], 0) }}</span>
                    @if($kpis['sales_growth'] >= 0)
                        <span class="text-emerald-700 font-bold flex items-center gap-0.5">
                            ▲ +{{ $kpis['sales_growth'] }}%
                        </span>
                    @else
                        <span class="text-rose-700 font-bold flex items-center gap-0.5">
                            ▼ {{ $kpis['sales_growth'] }}%
                        </span>
                    @endif
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#58111A] to-[#C5A869]"></div>
        </div>

        <!-- KPI 2: TOTAL ORDERS -->
        <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] relative overflow-hidden group hover:border-[#C5A869] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-widest font-bold text-[#8C713B]">Total Orders</span>
                <div class="w-10 h-10 rounded-sm bg-[#C5A869]/15 text-[#8C713B] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-bold font-serif text-[#2A1810]">
                    {{ number_format($kpis['total_orders']) }}
                </div>
                <div class="flex items-center justify-between mt-2 text-xs">
                    <span class="text-gray-500">Lifetime: {{ number_format($kpis['lifetime_orders']) }} orders</span>
                    @if($kpis['orders_growth'] >= 0)
                        <span class="text-emerald-700 font-bold">▲ +{{ $kpis['orders_growth'] }}%</span>
                    @else
                        <span class="text-rose-700 font-bold">▼ {{ $kpis['orders_growth'] }}%</span>
                    @endif
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#C5A869] to-[#D4AF37]"></div>
        </div>

        <!-- KPI 3: TOTAL CUSTOMERS -->
        <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] relative overflow-hidden group hover:border-[#C5A869] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-widest font-bold text-[#8C713B]">Total Customers</span>
                <div class="w-10 h-10 rounded-sm bg-blue-50 text-blue-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-bold font-serif text-[#2A1810]">
                    {{ number_format($kpis['total_customers']) }}
                </div>
                <div class="flex items-center justify-between mt-2 text-xs">
                    <span class="text-gray-500">{{ $kpis['new_customers'] }} new this period</span>
                    <span class="text-emerald-700 font-bold">Verified Profiles</span>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
        </div>

        <!-- KPI 4: LOW STOCK ITEMS -->
        <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] relative overflow-hidden group hover:border-[#C5A869] transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs uppercase tracking-widest font-bold text-[#8C713B]">Low Stock Items</span>
                <div class="w-10 h-10 rounded-sm bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl sm:text-3xl font-bold font-serif {{ $kpis['low_stock_count'] > 0 ? 'text-amber-700' : 'text-emerald-700' }}">
                    {{ $kpis['low_stock_count'] }}
                </div>
                <div class="flex items-center justify-between mt-2 text-xs">
                    <span class="text-gray-500">{{ $kpis['out_of_stock_count'] }} completely out of stock</span>
                    <a href="{{ route('admin.products.index', ['stock_status' => 'low']) }}" class="text-[#58111A] font-bold hover:underline">Restock &rarr;</a>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-rose-500"></div>
        </div>
    </div>

    <!-- Charts Row: Revenue Over Time & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Revenue Over Time Line Chart (2 Cols) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE]">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-serif text-lg font-bold text-[#2A1810]">Revenue Over Time</h2>
                    <p class="text-xs text-[#8C713B]">Daily sales revenue trend for the selected period</p>
                </div>
                <div class="text-xs text-gray-500">
                    Currency: <strong class="text-[#58111A]">AUD ($)</strong>
                </div>
            </div>
            <div class="h-72">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Top Products Bar Chart (1 Col) -->
        <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE]">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-serif text-lg font-bold text-[#2A1810]">Top Products</h2>
                    <p class="text-xs text-[#8C713B]">Units sold from actual order items</p>
                </div>
            </div>
            <div class="h-72">
                @if(!empty($topProducts['labels']))
                    <canvas id="topProductsChart"></canvas>
                @else
                    <div class="h-full flex items-center justify-center text-center text-xs text-gray-400">
                        No product sales recorded yet.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Second Charts & Distribution Row: Category Doughnut & Order Status Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Sales by Category (1 Col) -->
        <div class="bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE]">
            <div class="mb-4">
                <h2 class="font-serif text-lg font-bold text-[#2A1810]">Sales by Category</h2>
                <p class="text-xs text-[#8C713B]">Revenue contribution by product category</p>
            </div>
            <div class="h-64">
                @if(!empty($categorySales['labels']))
                    <canvas id="categoryChart"></canvas>
                @else
                    <div class="h-full flex items-center justify-center text-center text-xs text-gray-400">
                        Category breakdown will appear upon paid orders.
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Status Summary Badges (2 Cols) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE] flex flex-col justify-between">
            <div>
                <h2 class="font-serif text-lg font-bold text-[#2A1810] mb-1">Order Pipeline Status</h2>
                <p class="text-xs text-[#8C713B] mb-5">Current distribution of orders across fulfilment stages</p>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                    @php
                        $stages = [
                            'pending' => ['Pending Payment', 'border-amber-400 bg-amber-50 text-amber-900'],
                            'confirmed' => ['Confirmed', 'border-blue-400 bg-blue-50 text-blue-900'],
                            'processing' => ['Processing', 'border-indigo-400 bg-indigo-50 text-indigo-900'],
                            'packed' => ['Packed', 'border-purple-400 bg-purple-50 text-purple-900'],
                            'shipped' => ['Shipped', 'border-cyan-400 bg-cyan-50 text-cyan-900'],
                            'out_for_delivery' => ['Out For Delivery', 'border-teal-400 bg-teal-50 text-teal-900'],
                            'delivered' => ['Delivered', 'border-emerald-400 bg-emerald-50 text-emerald-900'],
                            'cancelled' => ['Cancelled', 'border-rose-400 bg-rose-50 text-rose-900'],
                            'returned' => ['Returned', 'border-gray-400 bg-gray-50 text-gray-900'],
                            'refunded' => ['Refunded', 'border-purple-400 bg-purple-50 text-purple-900'],
                        ];
                    @endphp

                    @foreach($stages as $statusKey => [$statusName, $badgeStyle])
                        <a href="{{ route('admin.orders.index', ['status' => $statusKey]) }}"
                           class="p-3 rounded border {{ $badgeStyle }} transition-transform hover:scale-105">
                            <span class="block text-[11px] font-semibold truncate">{{ $statusName }}</span>
                            <span class="block text-xl font-bold font-serif mt-1">{{ $orderStatuses[$statusKey] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Live Visitors Widget -->
            <div class="mt-6 pt-4 border-t border-[#EFE9DE] flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span class="font-bold text-[#2A1810]">Live Site Traffic:</span>
                    <span class="text-emerald-700 font-bold">{{ $liveVisitorsCount }} Active Shopper{{ $liveVisitorsCount === 1 ? '' : 's' }}</span>
                </div>
                <a href="{{ route('admin.live-visitors.index') }}" class="text-[#58111A] font-bold hover:underline">View Live Traffic Log &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Data Tables Row: Recent Orders & Low Stock Alerts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Recent Orders Table (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-sm shadow-xs border border-[#EFE9DE] overflow-hidden">
            <div class="p-5 border-b border-[#EFE9DE] flex items-center justify-between">
                <div>
                    <h2 class="font-serif text-lg font-bold text-[#2A1810]">Recent Orders</h2>
                    <p class="text-xs text-[#8C713B]">Latest customer transactions</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-[#58111A] hover:underline uppercase tracking-wider">
                    View All Orders &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#F7F4EE] uppercase tracking-wider text-[#8C713B] font-bold border-b border-[#EFE9DE]">
                        <tr>
                            <th class="px-5 py-3">Order Number</th>
                            <th class="px-5 py-3">Customer</th>
                            <th class="px-5 py-3">Amount</th>
                            <th class="px-5 py-3">Payment</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EFE9DE]">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-[#FCFBF8] transition-colors">
                                <td class="px-5 py-3.5 font-bold text-[#58111A]">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="font-semibold text-[#2A1810]">{{ $order->customer_name }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                                </td>
                                <td class="px-5 py-3.5 font-bold text-[#2A1810]">
                                    {{ $currencySymbol ?? '$' }}{{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $order->payment_badge_class }}">
                                        {{ $order->payment_status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $order->status_badge_class }}">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="px-2.5 py-1 bg-[#F7F4EE] hover:bg-[#58111A] hover:text-white rounded text-[11px] font-bold text-[#58111A] transition-colors">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                                    No orders placed yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alerts Table (1 Col) -->
        <div class="bg-white rounded-sm shadow-xs border border-[#EFE9DE] overflow-hidden">
            <div class="p-5 border-b border-[#EFE9DE] flex items-center justify-between">
                <div>
                    <h2 class="font-serif text-lg font-bold text-[#2A1810]">Low Stock Alerts</h2>
                    <p class="text-xs text-[#8C713B]">Items below replenishment threshold</p>
                </div>
                <a href="{{ route('admin.products.index', ['stock_status' => 'low']) }}" class="text-xs font-bold text-[#58111A] hover:underline uppercase tracking-wider">
                    All &rarr;
                </a>
            </div>

            <div class="divide-y divide-[#EFE9DE]">
                @forelse($lowStockItems as $item)
                    <div class="p-4 flex items-center justify-between hover:bg-[#FCFBF8] transition-colors">
                        <div class="min-w-0 flex-1 pr-3">
                            <h4 class="font-semibold text-xs text-[#2A1810] truncate">{{ $item->name }}</h4>
                            <div class="text-[11px] text-gray-500">SKU: {{ $item->sku }}</div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block px-2 py-0.5 rounded text-xs font-bold {{ $item->stock <= 0 ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $item->stock }} Left
                            </span>
                            <div class="mt-1">
                                <a href="{{ route('admin.products.edit', $item->id) }}" class="text-[11px] font-bold text-[#58111A] hover:underline">Update</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-gray-400">
                        ✨ All items are well stocked above thresholds!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const revenueData = @json($revenueChart);
        const topProductsData = @json($topProducts);
        const categoryData = @json($categorySales);

        if (window.initAdminDashboardCharts) {
            window.initAdminDashboardCharts(revenueData, topProductsData, categoryData);
        }
    });
</script>
@endpush
