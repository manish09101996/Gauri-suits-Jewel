@extends('layouts.admin')

@section('title', "Edit Story: {$post->title}")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.blog.index') }}" class="p-2 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Edit Story</h1>
            <p class="text-sm text-slate-400">Update story text, imagery, tags, and search engine previews</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
            <div class="font-semibold mb-1">Please fix the errors below:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 rounded-xl p-6 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Article Title *</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Publication Status *</label>
                    <select name="status" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published (Live)</option>
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft (Private)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Cover Image</label>
                @if($post->featured_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current Image" class="h-24 w-36 object-cover rounded-lg border border-slate-700">
                    </div>
                @endif
                <input type="file" name="featured_image" accept="image/*" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2 text-sm text-slate-300 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-600">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Excerpt / Summary</label>
                <textarea name="excerpt" rows="2" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Article Content *</label>
                <textarea name="content" rows="14" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white font-mono focus:border-amber-400 outline-none">{{ old('content', $post->content) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Tags (Comma separated)</label>
                <input type="text" name="tags" value="{{ old('tags', $post->tags) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-amber-400 outline-none">
            </div>

            <!-- SEO Metadata -->
            <div class="p-4 bg-slate-800/50 border border-slate-700 rounded-xl space-y-4">
                <h3 class="text-xs font-semibold text-amber-400 uppercase tracking-wider">SEO Meta Tags</h3>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">SEO Title</label>
                    <input type="text" name="seo_title" value="{{ old('seo_title', $post->seo_title) }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-xs text-white focus:border-amber-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">SEO Meta Description</label>
                    <textarea name="seo_description" rows="2" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-xs text-white focus:border-amber-400 outline-none">{{ old('seo_description', $post->seo_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.blog.index') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-semibold rounded-lg transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 text-sm font-bold rounded-lg shadow-md transition">
                Update Story
            </button>
        </div>
    </form>
</div>
@endsection
