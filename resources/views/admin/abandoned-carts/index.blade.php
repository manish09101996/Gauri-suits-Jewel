@extends('layouts.admin')

@section('title', 'Abandoned Checkouts & Carts')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Abandoned Carts</h1>
            <p class="text-sm text-slate-400">Recover lost revenue by identifying shoppers who abandoned items without checkout</p>
        </div>
    </div>

    <!-- Alert / Explanation -->
    <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-start gap-3">
        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div class="text-xs text-amber-200/90 leading-relaxed">
            These shopping carts have items added but have remained inactive for over 2 hours without completing payment. Use contact details or email reminders to offer an exclusive discount code and convert them.
        </div>
    </div>

    <!-- Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Shopper / User</th>
                        <th class="px-6 py-4">Items in Cart</th>
                        <th class="px-6 py-4">Cart Value</th>
                        <th class="px-6 py-4">Last Activity</th>
                        <th class="px-6 py-4 text-right">Recovery Outreach</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($abandonedCarts as $cart)
                    @php
                        $cartTotal = $cart->items->sum(function($item) {
                            $price = $item->variant?->price ?? ($item->product->sale_price ?? $item->product->base_price);
                            return $price * $item->quantity;
                        });
                    @endphp
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            @if($cart->user)
                                <div class="font-semibold text-white">{{ $cart->user->name }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $cart->user->email }}</div>
                                @if($cart->user->phone)
                                    <div class="text-xs text-amber-400 mt-0.5">{{ $cart->user->phone }}</div>
                                @endif
                            @else
                                <div class="font-medium text-slate-300">Guest Visitor</div>
                                <div class="text-xs text-slate-500 font-mono">Session: {{ substr($cart->session_id, 0, 12) }}...</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-white mb-1.5">{{ $cart->items->count() }} {{ Str::plural('item', $cart->items->count()) }}</div>
                            <div class="flex -space-x-2 overflow-hidden">
                                @foreach($cart->items->take(4) as $it)
                                    @php
                                        $img = $it->product->images->first()?->image_path;
                                    @endphp
                                    @if($img)
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-slate-900 object-cover" src="{{ asset('storage/' . $img) }}" alt="{{ $it->product->name }}" title="{{ $it->product->name }} (Qty: {{ $it->quantity }})">
                                    @else
                                        <div class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-slate-800 ring-2 ring-slate-900 text-[10px] text-slate-300">
                                            {{ substr($it->product->name ?? 'P', 0, 1) }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-base font-bold text-amber-400">₹{{ number_format($cartTotal, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
                            {{ $cart->updated_at->diffForHumans() }}
                            <div class="text-[11px] text-slate-500">{{ $cart->updated_at->format('d M, Y h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($cart->user && $cart->user->phone)
                                @php
                                    $waText = urlencode("Hello {$cart->user->name}, we noticed you left items in your cart at Gauri Suits & Jewel. Would you like assistance with custom sizing or styling?");
                                @endphp
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cart->user->phone) }}?text={{ $waText }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-400 border border-emerald-500/30 rounded-lg text-xs font-semibold transition">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.174.086.275.072.376-.044.102-.115.434-.506.549-.679.116-.173.232-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/></svg>
                                    WhatsApp
                                </a>
                            @elseif($cart->user)
                                <a href="mailto:{{ $cart->user->email }}?subject=Your%20Bag%20at%20Gauri%20Suits%20%26%20Jewel" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-amber-400 rounded-lg text-xs font-semibold border border-slate-700 transition">
                                    Email
                                </a>
                            @else
                                <span class="text-xs text-slate-500 italic">No contact</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            No abandoned carts found in the last 2 hours.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($abandonedCarts->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $abandonedCarts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
