@extends('layouts.app')

@section('title', 'System Issue - 500 | Gauri Suits & Jewel')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-50 text-brand-maroon mb-2">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Error 500</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-2">Atelier Interruption</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-2">
                Our artisanal servers encountered an unexpected issue while processing your request. Our technical team has been notified.
            </p>
        </div>
        <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-brand-maroon text-white font-serif text-xs uppercase tracking-widest font-semibold hover:bg-brand-maroon-dark transition-colors shadow-sm">
                Return to Atelier
            </a>
            <a href="{{ route('pages.contact') }}" class="inline-block px-6 py-3 border border-brand-maroon text-brand-maroon font-serif text-xs uppercase tracking-widest font-semibold hover:bg-stone-50 transition-colors">
                Contact Concierge
            </a>
        </div>
    </div>
</div>
@endsection
