@extends('layouts.admin')

@section('title', 'Coupons & Promotions')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Coupons & Discounts</h1>
            <p class="text-sm text-slate-400">Configure promotional discount codes, validity, and usage limits</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold rounded-lg text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Coupon
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Code</th>
                        <th class="px-6 py-4">Type & Discount</th>
                        <th class="px-6 py-4">Min. Spend</th>
                        <th class="px-6 py-4">Usage / Limit</th>
                        <th class="px-6 py-4">Valid Period</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($coupons as $coupon)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-300 font-mono font-bold rounded-lg text-sm tracking-wider">
                                {{ $coupon->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">
                                {{ $coupon->type === 'percentage' ? $coupon->value . '%' : '₹' . number_format($coupon->value) }} OFF
                            </div>
                            @if($coupon->max_discount_amount)
                                <div class="text-[11px] text-slate-400">Up to ₹{{ number_format($coupon->max_discount_amount) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-300">
                            {{ $coupon->min_order_amount > 0 ? '₹' . number_format($coupon->min_order_amount) : 'None' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-slate-300">
                                <strong>{{ $coupon->usages_count }}</strong> / {{ $coupon->usage_limit ?? '∞' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
                            @if($coupon->start_date || $coupon->end_date)
                                {{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('d M') : 'Start' }} -
                                {{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('d M, Y') : 'No expiry' }}
                            @else
                                <span class="text-slate-500">Always active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($coupon->is_active)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">Disabled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="p-1.5 hover:bg-slate-800 text-slate-400 hover:text-amber-400 rounded transition inline-flex">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this coupon?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-slate-800 text-slate-400 hover:text-rose-400 rounded transition inline-flex">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            No coupons created yet. Click "Create Coupon" above.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($coupons->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $coupons->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
