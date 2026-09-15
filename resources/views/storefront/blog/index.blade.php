@extends('layouts.app')

@section('title', 'The Gauri Journal | Heritage, Bridal Styling & Crafts')
@section('meta_description', 'Read bridal styling guides, Punjabi textile histories, zardozi embroidery heritage, and royal jewellery advice from Gauri Suits & Jewel.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    <!-- Header -->
    <div class="text-center max-w-2xl mx-auto space-y-3">
        <span class="text-xs uppercase tracking-widest text-brand-gold font-bold">Editorial & Chronicles</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold text-brand-charcoal">The Gauri Journal</h1>
        <div class="w-16 h-0.5 bg-brand-gold mx-auto"></div>
        <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
            Celebrating the poetry of Punjabi textiles, heirloom craftsmanship, wedding trousseau styling, and imperial jewellery traditions.
        </p>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
        <article class="bg-white border border-stone-200/90 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between group hover:shadow-xl transition-all duration-300">
            <div class="space-y-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="block aspect-[16/10] bg-stone-100 overflow-hidden">
                    @if($post->featured_image)
                        <img src="{{ str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-stone-200 text-stone-400 font-serif text-lg">Gauri Editorial</div>
                    @endif
                </a>

                <div class="px-6 space-y-2">
                    <div class="flex items-center gap-2 text-[11px] text-stone-400 uppercase tracking-wider font-semibold">
                        <span>{{ $post->published_at ? $post->published_at->format('d M, Y') : $post->created_at->format('d M, Y') }}</span>
                        <span>•</span>
                        <span>{{ $post->author_name ?? 'Editorial Team' }}</span>
                    </div>

                    <h2 class="font-serif text-lg sm:text-xl font-bold text-brand-charcoal group-hover:text-brand-maroon transition leading-snug">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>

                    <p class="text-xs text-stone-600 font-light line-clamp-3 leading-relaxed">
                        {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 140) }}
                    </p>
                </div>
            </div>

            <div class="px-6 pb-6 pt-4">
                <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-brand-maroon hover:text-amber-700 transition">
                    Read Story
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </article>
        @empty
        <div class="col-span-full py-16 text-center text-xs text-stone-400">
            Journal articles are currently being written. Check back soon for stories of Punjabi craftsmanship.
        </div>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="pt-6 border-t border-stone-200">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
