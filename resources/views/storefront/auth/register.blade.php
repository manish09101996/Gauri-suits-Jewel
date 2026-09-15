@extends('layouts.app')

@section('title', 'Create Account | Gauri Suits & Jewel')

@section('content')
<div class="max-w-md mx-auto px-4 py-16 space-y-8">
    <div class="text-center space-y-3">
        <div class="inline-block relative w-20 h-20 rounded-full p-0.5 bg-gradient-to-tr from-[#D4AF37] via-[#0A3828] to-[#D4AF37] shadow-xl">
            <img src="{{ asset('images/logo.png') }}" alt="Gauri Suits & Jewel" class="w-full h-full object-cover rounded-full">
        </div>
        <span class="text-xs uppercase tracking-[0.25em] text-[#D4AF37] font-bold block">Client Privileges</span>
        <h1 class="font-serif text-3xl font-normal text-[#3B0A11]">Join Gauri Suits & Jewel</h1>
        <p class="text-xs text-[#8C713B] font-serif italic">
            "Tradition Meets Elegance" • Unlock bespoke bridal previews and concierge tracking.
        </p>
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

    <div class="bg-white border border-stone-200 rounded-2xl p-8 shadow-sm">
        <form action="{{ route('customer.register') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-stone-700 mb-1">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Jaspreet Kaur" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
            </div>

            <div>
                <label class="block font-bold text-stone-700 mb-1">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="jaspreet@example.com" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
            </div>

            <div>
                <label class="block font-bold text-stone-700 mb-1">Mobile Phone Number *</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+91 98765 43210" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
            </div>

            <div>
                <label class="block font-bold text-stone-700 mb-1">Password *</label>
                <input type="password" name="password" required placeholder="Minimum 6 characters" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
            </div>

            <div>
                <label class="block font-bold text-stone-700 mb-1">Confirm Password *</label>
                <input type="password" name="password_confirmation" required placeholder="Repeat password" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
            </div>

            <button type="submit" class="w-full py-3.5 bg-brand-maroon hover:bg-[#400c13] text-white font-bold uppercase tracking-widest rounded shadow transition mt-2">
                Create Account
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-stone-100 text-center text-xs text-stone-500">
            Already have an account?
            <a href="{{ route('customer.login') }}" class="text-brand-maroon font-bold hover:underline ml-1">Sign In</a>
        </div>
    </div>
</div>
@endsection
