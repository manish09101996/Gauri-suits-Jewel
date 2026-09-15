@extends('layouts.admin')

@section('title', "Customer: {$customer->name}")

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}" class="p-2 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">{{ $customer->name }}</h1>
                <p class="text-sm text-slate-400">Customer Profile & Order History</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Lifetime Spend</div>
            <div class="text-2xl font-bold text-amber-400">₹{{ number_format($totalSpent, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">Total revenue from completed orders</div>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Total Orders Placed</div>
            <div class="text-2xl font-bold text-white">{{ $customer->orders->count() }}</div>
            <div class="text-xs text-slate-500 mt-1">Across online & store channels</div>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Member Since</div>
            <div class="text-2xl font-bold text-indigo-400">{{ $customer->created_at->format('M Y') }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $customer->created_at->format('d M, Y') }} ({{ $customer->created_at->diffForHumans() }})</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Customer Details & Addresses -->
        <div class="space-y-6">
            <!-- Contact Card -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm">
                <h2 class="text-base font-semibold text-white mb-4">Contact Information</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block mb-0.5">Email Address</span>
                        <a href="mailto:{{ $customer->email }}" class="text-amber-400 hover:underline font-mono">{{ $customer->email }}</a>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-0.5">Phone</span>
                        <span class="text-white">{{ $customer->phone ?? 'Not provided' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block mb-0.5">Account Status</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- Saved Addresses -->
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm">
                <h2 class="text-base font-semibold text-white mb-4">Saved Addresses ({{ $customer->addresses->count() }})</h2>
                @forelse($customer->addresses as $addr)
                <div class="p-3 bg-slate-800/60 border border-slate-700/60 rounded-lg text-xs space-y-1 mb-3 last:mb-0">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-white">{{ $addr->full_name }}</span>
                        @if($addr->is_default)
                            <span class="px-1.5 py-0.5 bg-amber-500/20 text-amber-300 rounded text-[10px] font-semibold">DEFAULT</span>
                        @endif
                    </div>
                    <div class="text-slate-300">{{ $addr->address_line1 }}</div>
                    @if($addr->address_line2)<div class="text-slate-300">{{ $addr->address_line2 }}</div>@endif
                    <div class="text-slate-400">{{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}</div>
                    <div class="text-slate-400">Phone: {{ $addr->phone }}</div>
                </div>
                @empty
                <p class="text-xs text-slate-500">No saved addresses on file.</p>
                @endforelse
            </div>
        </div>

        <!-- Right: Order History -->
        <div class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <h2 class="text-base font-semibold text-white">Purchase History</h2>
                <span class="text-xs text-slate-400">{{ $customer->orders->count() }} records</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-3">Order #</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Payment</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($customer->orders as $ord)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="px-6 py-4 font-mono font-bold text-white">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-amber-400 hover:underline">
                                    #{{ $ord->order_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400">
                                {{ $ord->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                        'confirmed' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                        'processing' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                        'packed' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        'shipped' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20',
                                        'delivered' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        'cancelled' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$ord->status] ?? 'bg-slate-800 text-slate-300 border-slate-700' }}">
                                    {{ ucfirst($ord->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold {{ $ord->payment_status === 'paid' ? 'text-emerald-400' : 'text-amber-400' }}">
                                    {{ ucfirst($ord->payment_status) }}
                                </span>
                                <div class="text-[11px] text-slate-500 uppercase">{{ $ord->payment_method }}</div>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-white">
                                ₹{{ number_format($ord->grand_total, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-xs text-amber-400 hover:text-amber-300 font-semibold">
                                    Details →
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                This customer has not placed any orders yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
