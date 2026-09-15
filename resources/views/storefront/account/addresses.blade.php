@extends('layouts.app')

@section('title', 'Saved Addresses | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ showNewModal: false }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-serif text-3xl font-bold text-brand-charcoal">Delivery Addresses</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-1">Manage your home, boutique, and office shipping destinations</p>
        </div>
        <button type="button" @click="showNewModal = true" class="px-5 py-2.5 bg-brand-maroon hover:bg-[#400c13] text-white font-bold text-xs uppercase tracking-wider rounded transition shadow">
            + Add New Address
        </button>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <aside class="lg:col-span-1">
            @include('storefront.account.partials.nav')
        </aside>

        <main class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($addresses as $addr)
                <div class="bg-white border {{ $addr->is_default ? 'border-brand-maroon ring-1 ring-brand-maroon/20' : 'border-stone-200' }} rounded-2xl p-6 shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-serif font-bold text-base text-brand-charcoal">{{ $addr->full_name }}</span>
                            @if($addr->is_default)
                                <span class="px-2 py-0.5 bg-brand-maroon/10 text-brand-maroon text-[10px] font-bold uppercase tracking-wider rounded-full">
                                    Default
                                </span>
                            @endif
                        </div>
                        <div class="text-xs text-stone-600 leading-relaxed">
                            {{ $addr->address_line1 }}<br>
                            @if($addr->address_line2) {{ $addr->address_line2 }}<br> @endif
                            {{ $addr->city }}, {{ $addr->state }} - {{ $addr->postal_code }}<br>
                            Phone: {{ $addr->phone }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-stone-100 text-xs">
                        @if(!$addr->is_default)
                            <form action="{{ route('account.addresses.default', $addr->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-brand-maroon font-semibold hover:underline">Set as Default</button>
                            </form>
                        @else
                            <span class="text-stone-400">Primary Delivery</span>
                        @endif

                        <form action="{{ route('account.addresses.delete', $addr->id) }}" method="POST" onsubmit="return confirm('Delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white border border-stone-200 rounded-2xl p-12 text-center text-xs text-stone-400">
                    No saved addresses yet. Click "+ Add New Address" above to save one.
                </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Modal to add new address -->
    <div x-show="showNewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
        <div @click.away="showNewModal = false" class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-8 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between border-b pb-3">
                <h2 class="font-serif text-lg font-bold text-brand-charcoal">Add New Delivery Address</h2>
                <button type="button" @click="showNewModal = false" class="text-stone-400 hover:text-stone-700">✕</button>
            </div>

            <form action="{{ route('account.addresses.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">First Name *</label>
                        <input type="text" name="first_name" required class="w-full bg-stone-50 border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" class="w-full bg-stone-50 border rounded px-3 py-2">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Phone Number *</label>
                    <input type="tel" name="phone" required placeholder="+91 98765 43210" class="w-full bg-stone-50 border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Address Line 1 *</label>
                    <input type="text" name="address_line1" required placeholder="House / Flat / Street" class="w-full bg-stone-50 border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block font-bold text-stone-700 mb-1">Address Line 2 (Optional)</label>
                    <input type="text" name="address_line2" placeholder="Landmark / Suite" class="w-full bg-stone-50 border rounded px-3 py-2">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">City *</label>
                        <input type="text" name="city" required class="w-full bg-stone-50 border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">State *</label>
                        <input type="text" name="state" required placeholder="Punjab" class="w-full bg-stone-50 border rounded px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">Pincode *</label>
                        <input type="text" name="postal_code" required class="w-full bg-stone-50 border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block font-bold text-stone-700 mb-1">Country</label>
                        <input type="text" name="country" value="India" readonly class="w-full bg-stone-100 border rounded px-3 py-2 text-stone-500">
                    </div>
                </div>

                <div class="pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-stone-700">
                        <input type="checkbox" name="is_default" value="1" class="rounded text-brand-maroon focus:ring-0">
                        <span>Make this my default shipping address</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t">
                    <button type="button" @click="showNewModal = false" class="px-4 py-2 border rounded text-stone-600 font-semibold">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-brand-maroon hover:bg-[#400c13] text-white font-bold uppercase tracking-wider rounded">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
