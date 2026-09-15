@extends('layouts.app')

@section('title', 'My Wishlist | Gauri Suits & Jewel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div>
        <h1 class="font-serif text-3xl font-bold text-brand-charcoal">My Saved Ensembles</h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">Your curated bridal trousseau and jewellery wishlist</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        <aside class="lg:col-span-1">
            @include('storefront.account.partials.nav')
        </aside>

        <main class="lg:col-span-3">
            @if($items->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-5 sm:gap-6">
                @foreach($items as $item)
                @php $product = $item->product; @endphp
                <div class="bg-white border border-stone-200 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between group">
                    <div class="relative aspect-[3/4] bg-stone-100 overflow-hidden">
                        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </a>

                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="absolute top-2.5 right-2.5">
                            @csrf
                            <button type="submit" class="w-8 h-8 rounded-full bg-white/90 shadow text-rose-500 flex items-center justify-center hover:bg-white transition" title="Remove">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                        </form>
                    </div>

                    <div class="p-4 space-y-3 flex-1 flex flex-col justify-between">
                        <div>
                            @if($product->category)
                                <div class="text-[10px] uppercase font-bold text-stone-400">{{ $product->category->name }}</div>
                            @endif
                            <h3 class="font-serif text-sm font-bold text-brand-charcoal line-clamp-1 mt-0.5">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="font-serif font-bold text-sm text-brand-maroon mt-1">
                                ₹{{ number_format($product->effective_price) }}
                            </div>
                        </div>

                        <div>
                            @if($product->variants->isNotEmpty())
                                <a href="{{ route('product.show', $product->slug) }}" class="w-full block py-2 bg-stone-100 hover:bg-stone-200 text-brand-charcoal text-center text-xs font-bold uppercase tracking-wider rounded transition">
                                    Select Size
                                </a>
                            @else
                                <form action="{{ route('wishlist.move-to-cart', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-brand-maroon hover:bg-[#400c13] text-white text-xs font-bold uppercase tracking-wider rounded transition shadow">
                                        Move to Bag
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white border border-stone-200 rounded-3xl p-16 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center mx-auto text-stone-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="font-serif text-xl font-bold text-brand-charcoal">Your Wishlist is Empty</h3>
                <p class="text-xs text-stone-500 max-w-sm mx-auto font-light">
                    Save your favorite Punjabi salwar suits, bridal lehengas, and royal jewellery sets by clicking the heart icon on any product.
                </p>
                <div class="pt-2">
                    <a href="{{ route('shop.index') }}" class="inline-flex px-6 py-2.5 bg-brand-maroon hover:bg-brand-gold text-white hover:text-brand-charcoal font-bold text-xs uppercase tracking-wider rounded transition">
                        Explore Catalog
                    </a>
                </div>
            </div>
            @endif
        </main>
    </div>
</div>
@endsection
