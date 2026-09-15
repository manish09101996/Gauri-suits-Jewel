@extends('layouts.app')

@section('title', 'Page Not Found - 404 | Gauri Suits & Jewel')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-brand-maroon/10 text-brand-maroon mb-2">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Error 404</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-brand-charcoal mt-2">Silhouette Not Found</h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-2">
                The royal design or collection page you are seeking seems to have been moved or is no longer available in our atelier.
            </p>
        </div>
        <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-brand-maroon text-white font-serif text-xs uppercase tracking-widest font-semibold hover:bg-brand-maroon-dark transition-colors shadow-sm">
                Return to Atelier
            </a>
            <a href="{{ route('shop.index') }}" class="inline-block px-6 py-3 border border-brand-maroon text-brand-maroon font-serif text-xs uppercase tracking-widest font-semibold hover:bg-stone-50 transition-colors">
                Explore Collections
            </a>
        </div>
    </div>
</div>
@endsection
