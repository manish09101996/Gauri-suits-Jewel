@extends('layouts.app')

@section('title', 'Access Restricted - 403 | Gauri Suits & Jewel')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-brand-gold/10 text-brand-gold mb-2">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Error 403</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-2">Access Restricted</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-2">
                This royal sanctuary or administration vault requires authorized credentials.
            </p>
        </div>
        <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-brand-maroon text-white font-serif text-xs uppercase tracking-widest font-semibold hover:bg-brand-maroon-dark transition-colors shadow-sm">
                Return to Atelier
            </a>
            <a href="{{ route('customer.login') }}" class="inline-block px-6 py-3 border border-brand-maroon text-brand-maroon font-serif text-xs uppercase tracking-widest font-semibold hover:bg-stone-50 transition-colors">
                Customer Sign In
            </a>
        </div>
    </div>
</div>
@endsection
