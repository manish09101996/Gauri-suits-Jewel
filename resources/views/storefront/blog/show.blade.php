@extends('layouts.app')

@section('title', "{$post->title} | The Gauri Journal")
@section('meta_description', $post->seo_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->content), 150)))

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-stone-400 uppercase tracking-wider">
        <a href="{{ route('home') }}" class="hover:text-brand-maroon transition">Home</a>
        <span>/</span>
        <a href="{{ route('blog.index') }}" class="hover:text-brand-maroon transition">Journal</a>
        <span>/</span>
        <span class="text-brand-charcoal font-semibold truncate max-w-xs">{{ $post->title }}</span>
    </nav>

    <!-- Header -->
    <header class="space-y-4 text-center">
        <div class="flex items-center justify-center gap-3 text-xs text-stone-400 uppercase tracking-widest font-semibold">
            <span>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
            <span>•</span>
            <span class="text-brand-gold font-bold">By {{ $post->author_name ?? 'Gauri Editorial' }}</span>
        </div>

        <h1 class="font-serif text-3xl sm:text-5xl font-bold text-brand-charcoal tracking-tight leading-tight">
            {{ $post->title }}
        </h1>

        @if($post->excerpt)
            <p class="text-base sm:text-lg text-stone-600 font-light max-w-2xl mx-auto leading-relaxed italic">
                "{{ $post->excerpt }}"
            </p>
        @endif
    </header>

    <!-- Featured Cover Image -->
    @if($post->featured_image)
    <div class="aspect-[16/9] rounded-3xl overflow-hidden shadow-lg border border-stone-200">
        <img src="{{ str_starts_with($post->featured_image, 'http') ? $post->featured_image : asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
    </div>
    @endif

    <!-- Content Body -->
    <div class="prose prose-stone max-w-none font-serif text-stone-800 leading-relaxed text-base sm:text-lg space-y-6">
        {!! $post->content !!}
    </div>

    <!-- Tags -->
    @if($post->tags)
    <div class="pt-6 border-t border-stone-200 flex items-center gap-2 flex-wrap">
        <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Topics:</span>
        @foreach(explode(',', $post->tags) as $tag)
            <span class="px-3 py-1 bg-stone-100 rounded-full text-xs text-stone-600 font-sans">
                #{{ trim($tag) }}
            </span>
        @endforeach
    </div>
    @endif

    <!-- Recent Stories Carousel / Grid -->
    @if($recentPosts->isNotEmpty())
    <div class="pt-12 border-t border-stone-200 space-y-6">
        <h2 class="font-serif text-2xl font-bold text-brand-charcoal text-center">More from The Gauri Journal</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentPosts as $rPost)
            <div class="bg-white border border-stone-200 rounded-xl overflow-hidden shadow-sm space-y-3 p-4">
                <a href="{{ route('blog.show', $rPost->slug) }}" class="block aspect-[16/10] rounded-lg overflow-hidden bg-stone-100">
                    @if($rPost->featured_image)
                        <img src="{{ str_starts_with($rPost->featured_image, 'http') ? $rPost->featured_image : asset('storage/' . $rPost->featured_image) }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xs text-stone-400 font-serif">Gauri</div>
                    @endif
                </a>
                <h3 class="font-serif font-bold text-sm text-brand-charcoal line-clamp-2 hover:text-brand-maroon">
                    <a href="{{ route('blog.show', $rPost->slug) }}">{{ $rPost->title }}</a>
                </h3>
                <div class="text-[11px] text-stone-400">{{ $rPost->created_at->format('d M, Y') }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</article>
@endsection
