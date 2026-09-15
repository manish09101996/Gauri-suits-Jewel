@extends('layouts.admin')

@section('title', 'Live Store Visitors')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <h1 class="text-2xl font-bold text-white tracking-tight">Live Store Traffic</h1>
            </div>
            <p class="text-sm text-slate-400 mt-1">Real-time telemetry of shoppers browsing Gauri Suits & Jewel (last 15 minutes)</p>
        </div>
        <button onclick="window.location.reload()" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold border border-slate-700 transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Refresh Feed
        </button>
    </div>

    <!-- Active Traffic KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Active Now</div>
            <div class="text-3xl font-extrabold text-emerald-400">{{ $totalActive }}</div>
            <div class="text-xs text-slate-500 mt-1">Active shoppers within the last 15 mins</div>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Mobile Shoppers</div>
            <div class="text-3xl font-extrabold text-amber-400">{{ $deviceBreakdown['mobile'] ?? 0 }}</div>
            <div class="text-xs text-slate-500 mt-1">Smartphones & touch devices</div>
        </div>
        <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 shadow-sm">
            <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Desktop & Tablets</div>
            <div class="text-3xl font-extrabold text-indigo-400">{{ ($deviceBreakdown['desktop'] ?? 0) + ($deviceBreakdown['tablet'] ?? 0) }}</div>
            <div class="text-xs text-slate-500 mt-1">Wide screen boutique browsers</div>
        </div>
    </div>

    <!-- Real-time Sessions Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Visitor / IP</th>
                        <th class="px-6 py-4">Current Page URL</th>
                        <th class="px-6 py-4">Device / Platform</th>
                        <th class="px-6 py-4">Referrer</th>
                        <th class="px-6 py-4 text-right">Last Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($visitors as $v)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="font-mono text-xs text-white font-semibold">{{ $v->ip_address ?? 'Anonymous' }}</div>
                            <div class="text-[11px] text-slate-500 truncate max-w-[160px]">ID: {{ substr($v->session_id, 0, 14) }}...</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-mono text-xs text-amber-300 max-w-sm truncate" title="{{ $v->current_url }}">
                                {{ $v->current_url ?: '/' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-800 text-slate-300 border border-slate-700 capitalize">
                                {{ $v->device_type ?? 'desktop' }}
                            </span>
                            <span class="text-slate-500 text-[11px] ml-1">{{ $v->browser }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400 truncate max-w-xs">
                            {{ $v->referer ?: 'Direct / Organic' }}
                        </td>
                        <td class="px-6 py-4 text-xs text-right text-emerald-400 font-medium">
                            {{ $v->last_activity ? \Carbon\Carbon::parse($v->last_activity)->diffForHumans() : 'Just now' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            No active store visitors in the past 15 minutes.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visitors->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $visitors->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
