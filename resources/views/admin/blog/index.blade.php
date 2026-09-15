@extends('layouts.admin')

@section('title', 'Blog Articles & Stories')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Editorial & Journal</h1>
            <p class="text-sm text-slate-400">Publish bridal guides, styling advice, and heritage craftsmanship stories</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold rounded-lg text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Write New Story
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Article</th>
                        <th class="px-6 py-4">Author</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Published Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($posts as $post)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-12 rounded-lg bg-slate-800 overflow-hidden shrink-0 border border-slate-700">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-600 text-xs">No img</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-white line-clamp-1">{{ $post->title }}</div>
                                    <div class="text-xs text-slate-400 font-mono">/blog/{{ $post->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-300">
                            {{ $post->author_name ?? 'Editorial Team' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($post->status === 'published')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Published</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
                            {{ $post->published_at ? $post->published_at->format('d M, Y') : 'Unpublished' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('storefront.blog.show', $post->slug) }}" target="_blank" class="p-1.5 hover:bg-slate-800 text-slate-400 hover:text-white rounded transition inline-flex" title="View live">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="p-1.5 hover:bg-slate-800 text-slate-400 hover:text-amber-400 rounded transition inline-flex" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-slate-800 text-slate-400 hover:text-rose-400 rounded transition inline-flex" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            No articles written yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
