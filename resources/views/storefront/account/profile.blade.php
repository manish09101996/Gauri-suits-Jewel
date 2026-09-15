@extends('layouts.app')

@section('title', 'Profile Settings | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <h1 class="font-serif text-3xl font-bold text-brand-charcoal">Profile & Security</h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">Manage your contact credentials and password protection</p>
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
            <div class="bg-white border border-stone-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
                <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-6 text-xs">
                    @csrf

                    <div>
                        <h2 class="font-serif text-base font-bold text-brand-charcoal mb-3">Personal Details</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-bold text-stone-700 mb-1">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                            </div>

                            <div>
                                <label class="block font-bold text-stone-700 mb-1">Phone Number *</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block font-bold text-stone-700 mb-1">Email Address</label>
                                <input type="email" value="{{ $user->email }}" readonly class="w-full bg-stone-100 border border-stone-300 rounded px-3.5 py-2.5 text-stone-500 cursor-not-allowed">
                                <p class="text-[11px] text-stone-400 mt-1">To change your primary email address, please contact concierge support.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-stone-100">
                        <h2 class="font-serif text-base font-bold text-brand-charcoal mb-3">Change Security Password</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block font-bold text-stone-700 mb-1">Current Password</label>
                                <input type="password" name="current_password" placeholder="Leave blank if not changing" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                            </div>

                            <div>
                                <label class="block font-bold text-stone-700 mb-1">New Password</label>
                                <input type="password" name="new_password" placeholder="Minimum 6 characters" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                            </div>

                            <div>
                                <label class="block font-bold text-stone-700 mb-1">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" placeholder="Repeat new password" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-stone-100 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-brand-maroon hover:bg-[#400c13] text-white font-bold uppercase tracking-wider rounded shadow transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
