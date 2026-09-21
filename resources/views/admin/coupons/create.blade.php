@extends('layouts.admin')

@section('title', 'Create Coupon')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.coupons.index') }}" class="p-2 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Create Promotional Coupon</h1>
            <p class="text-sm text-slate-400">Configure discount parameters, eligibility thresholds, and active dates</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
            <div class="font-semibold mb-1">Please fix the errors below:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Coupon Code *</label>
                <input type="text" name="code" value="{{ old('code') }}" required placeholder="e.g. GAURI10, WEDDING25" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white uppercase font-mono tracking-wider focus:border-amber-400 outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Discount Type *</label>
                <select name="type" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage (%) Discount</option>
                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount ({{ $currencySymbol ?? '$' }}) Discount</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Discount Value *</label>
                <input type="number" step="0.01" name="value" value="{{ old('value') }}" required placeholder="e.g. 15 for 15% or 50 for {{ $currencySymbol ?? '$' }}50" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Maximum Discount Cap ({{ $currencySymbol ?? '$' }})</label>
                <input type="number" step="0.01" name="max_discount_amount" value="{{ old('max_discount_amount') }}" placeholder="Max discount for percentage coupons (optional)" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Minimum Order Amount ({{ $currencySymbol ?? '$' }})</label>
                <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', 0) }}" placeholder="0.00" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Usage Limit (Global)</label>
                <input type="number" min="1" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Leave blank for unlimited" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">End Date / Expiry</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-800">
            <label class="flex items-center gap-2.5 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-amber-500 focus:ring-0">
                <span class="text-sm font-medium text-slate-300">Activate coupon immediately upon creation</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.coupons.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold rounded-lg transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-sm font-bold rounded-lg shadow-md transition">
                Save Coupon
            </button>
        </div>
    </form>
</div>
@endsection
