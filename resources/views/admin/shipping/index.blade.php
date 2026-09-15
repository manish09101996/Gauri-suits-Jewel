@extends('layouts.admin')

@section('title', 'Shipping & Delivery Settings')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Shipping & COD Rules</h1>
            <p class="text-sm text-slate-400">Configure free shipping thresholds, COD limits, and regional courier rates</p>
        </div>
    </div>

    <!-- Top Settings: Global Shipping & COD -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm">
        <h2 class="text-base font-semibold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Global Shipping Policy & Cash On Delivery
        </h2>

        <form action="{{ route('admin.shipping.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Free Shipping Threshold (₹) *</label>
                    <input type="number" step="0.01" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $freeShippingThreshold) }}" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">Orders at or above this value qualify for free delivery.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Standard Flat Shipping Rate (₹) *</label>
                    <input type="number" step="0.01" name="flat_shipping_rate" value="{{ old('flat_shipping_rate', $flatShippingRate) }}" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">Default fee applied when order is below threshold.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Enable Cash On Delivery (COD) *</label>
                    <select name="cod_enabled" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                        <option value="1" {{ $codEnabled == '1' ? 'selected' : '' }}>Enabled</option>
                        <option value="0" {{ $codEnabled == '0' ? 'selected' : '' }}>Disabled (Prepaid Only)</option>
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1">Controls availability of COD at checkout.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">COD Handling Fee (₹)</label>
                    <input type="number" step="0.01" name="cod_extra_fee" value="{{ old('cod_extra_fee', $codExtraFee) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">Extra fee added if customer selects COD (0 for free).</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">COD Min Order Limit (₹)</label>
                    <input type="number" step="0.01" name="cod_min_order" value="{{ old('cod_min_order', $codMinOrder) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">Minimum cart total to unlock COD.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">COD Max Order Limit (₹)</label>
                    <input type="number" step="0.01" name="cod_max_order" value="{{ old('cod_max_order', $codMaxOrder) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">Maximum allowed order value for COD (e.g. ₹25,000).</p>
                </div>
            </div>

            <div class="flex justify-end pt-3">
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-lg text-sm transition">
                    Save Shipping Policy
                </button>
            </div>
        </form>
    </div>

    <!-- Regional Shipping Zones -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add New Zone -->
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm h-fit">
            <h2 class="text-base font-semibold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Add Shipping Zone
            </h2>
            <form action="{{ route('admin.shipping.zones.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Zone Name *</label>
                    <input type="text" name="name" required placeholder="e.g. North India, Metro Express" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Covered States (Comma separated) *</label>
                    <textarea name="states_text" rows="3" required placeholder="Punjab, Haryana, Delhi, Chandigarh, Himachal Pradesh" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none"></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-700 text-amber-400 border border-amber-500/30 font-semibold rounded-lg text-sm transition">
                        Add Zone
                    </button>
                </div>
            </form>
        </div>

        <!-- Zones List -->
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-base font-semibold text-white">Configured Zones & Specific Rates</h2>

            @forelse($zones as $zone)
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-base font-bold text-white">{{ $zone->name }}</h3>
                        <p class="text-xs text-slate-400 mt-1">
                            States: <span class="text-slate-300">{{ is_array($zone->states) ? implode(', ', $zone->states) : $zone->states }}</span>
                        </p>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        {{ $zone->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <!-- Rates Table inside Zone -->
                <div class="border-t border-slate-800 pt-3">
                    <div class="text-xs font-semibold text-slate-400 mb-2">Zone Courier Rates:</div>
                    @if($zone->rates->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-slate-300">
                                <thead class="bg-slate-800/40 text-slate-400 uppercase">
                                    <tr>
                                        <th class="px-3 py-2">Tier Name</th>
                                        <th class="px-3 py-2">Order Range</th>
                                        <th class="px-3 py-2">Rate</th>
                                        <th class="px-3 py-2">Delivery Time</th>
                                        <th class="px-3 py-2 text-right">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/50">
                                    @foreach($zone->rates as $rate)
                                    <tr>
                                        <td class="px-3 py-2 font-medium text-white">{{ $rate->name }}</td>
                                        <td class="px-3 py-2">₹{{ number_format($rate->min_order_amount) }} - {{ $rate->max_order_amount ? '₹' . number_format($rate->max_order_amount) : 'Above' }}</td>
                                        <td class="px-3 py-2 font-bold text-amber-400">{{ $rate->rate == 0 ? 'FREE' : '₹' . number_format($rate->rate) }}</td>
                                        <td class="px-3 py-2 text-slate-400">{{ $rate->estimated_days ?? '3-5 Days' }}</td>
                                        <td class="px-3 py-2 text-right">
                                            <form action="{{ route('admin.shipping.rates.destroy', $rate->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete rate tier?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-400 hover:text-rose-300">✕</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-xs text-slate-500 italic">No custom rates for this zone yet (default flat rate applies).</p>
                    @endif
                </div>

                <!-- Add Rate to Zone Inline -->
                <form action="{{ route('admin.shipping.zones.rates.store', $zone->id) }}" method="POST" class="pt-3 border-t border-slate-800/60 grid grid-cols-2 sm:grid-cols-5 gap-2 items-end">
                    @csrf
                    <div>
                        <label class="block text-[10px] text-slate-400">Rate Name</label>
                        <input type="text" name="name" required placeholder="Standard / Express" class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-white">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400">Min Spend (₹)</label>
                        <input type="number" step="0.01" name="min_order_amount" required value="0" class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-white">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400">Max Spend (₹)</label>
                        <input type="number" step="0.01" name="max_order_amount" placeholder="Leave empty for ∞" class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-white">
                    </div>
                    <div>
                        <label class="block text-[10px] text-slate-400">Rate (₹)</label>
                        <input type="number" step="0.01" name="rate" required value="0" class="w-full bg-slate-800 border border-slate-700 rounded px-2 py-1.5 text-xs text-white">
                    </div>
                    <div>
                        <button type="submit" class="w-full py-1.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded text-xs transition">
                            + Add Rate
                        </button>
                    </div>
                </form>
            </div>
            @empty
            <div class="bg-slate-900 border border-slate-800 rounded-xl p-8 text-center text-slate-500">
                No custom zones created. The global standard shipping and free shipping threshold will apply nationwide.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
