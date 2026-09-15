@extends('layouts.admin')

@section('title', 'Customers Directory')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Customer Directory</h1>
            <p class="text-sm text-slate-400">Manage client profiles, past purchases, contact data, and loyalty</p>
        </div>
    </div>

    <!-- Search / Filter Bar -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-4 shadow-sm">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customer by name, email, or phone..." class="w-full bg-slate-800/80 border border-slate-700/80 rounded-lg pl-10 pr-4 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-400">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold rounded-lg text-sm transition">
                    Search
                </button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-sm transition">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Contact Info</th>
                        <th class="px-6 py-4 text-center">Orders</th>
                        <th class="px-6 py-4">Registered Date</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500/20 to-rose-500/20 text-amber-400 font-bold flex items-center justify-center border border-amber-500/30">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-white">{{ $customer->name }}</div>
                                    <div class="text-xs text-slate-400">ID: #CUS-{{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-slate-300 font-mono">{{ $customer->email }}</div>
                            <div class="text-xs text-slate-400 mt-0.5">{{ $customer->phone ?? 'No phone' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                {{ $customer->orders_count }} {{ Str::plural('order', $customer->orders_count) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
                            {{ $customer->created_at->format('d M, Y') }}
                            <div class="text-[11px] text-slate-500">{{ $customer->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-amber-400 hover:text-amber-300 rounded-lg text-xs font-medium border border-slate-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View Profile
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            No customers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
