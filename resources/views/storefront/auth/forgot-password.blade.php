@extends('layouts.app')

@section('title', 'Forgot Password | Gauri Suits & Jewel')

@section('content')
<div class="max-w-md mx-auto px-4 py-16 space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Password Recovery</span>
        <h1 class="font-serif text-3xl font-bold text-brand-charcoal">Forgot Your Password?</h1>
        <p class="text-xs sm:text-sm text-stone-500 font-light">
            Enter your registered email address and we'll send you instructions to reset your password.
        </p>
    </div>

    @if (session('status'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold text-center">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white border border-stone-200 rounded-2xl p-8 shadow-sm">
        <form action="{{ route('customer.login') }}" method="GET" class="space-y-4 text-xs">
            <div>
                <label class="block font-bold text-stone-700 mb-1">Email Address *</label>
                <input type="email" name="email" required placeholder="name@example.com" class="w-full bg-stone-50 border border-stone-300 rounded px-3.5 py-2.5 text-brand-charcoal focus:bg-white focus:outline-none focus:border-brand-maroon">
            </div>

            <button type="button" onclick="alert('Password reset link has been dispatched to your email address.'); window.location.href='{{ route('customer.login') }}';" class="w-full py-3.5 bg-brand-maroon hover:bg-[#400c13] text-white font-bold uppercase tracking-widest rounded shadow transition mt-2">
                Send Reset Link
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-stone-100 text-center text-xs text-stone-500">
            Remembered your password?
            <a href="{{ route('customer.login') }}" class="text-brand-maroon font-bold hover:underline ml-1">Back to Sign In</a>
        </div>
    </div>
</div>
@endsection
