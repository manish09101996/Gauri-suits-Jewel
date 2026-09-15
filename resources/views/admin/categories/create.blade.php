@extends('layouts.admin')

@section('title', 'Create Category')
@section('header_title', 'Create New Category')
@section('header_subtitle', 'Define root collections or specialized ethnic subcategories')

@section('content')
<div class="max-w-2xl bg-white p-6 rounded-sm shadow-xs border border-[#EFE9DE]">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Category Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Punjabi Suits, Bridal Jewellery..."
                   class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-sm text-[#2A1810]">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Parent Category (Optional)</label>
            <select name="parent_id" class="w-full px-3.5 py-2.5 border border-[#EFE9DE] rounded text-xs text-[#2A1810]">
                <option value="">None (Top-level Root Category)</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">URL Slug (Optional)</label>
            <input type="text" name="slug" value="{{ old('slug') }}" placeholder="punjabi-suits"
                   class="w-full px-3.5 py-2 border border-[#EFE9DE] rounded text-xs text-[#2A1810]">
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Editorial Description</label>
            <textarea name="description" rows="3" class="w-full px-3.5 py-2 border border-[#EFE9DE] rounded text-xs">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-[#2A1810] mb-1.5">Category Card Banner Image</label>
            <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:bg-[#58111A] file:text-white">
        </div>

        <div class="flex items-center gap-6 pt-2">
            <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded text-[#58111A] focus:ring-0">
                <span>Featured on Homepage</span>
            </label>
            <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#58111A] focus:ring-0">
                <span>Active</span>
            </label>
        </div>

        <div class="pt-4 border-t border-[#EFE9DE] flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 text-xs font-semibold rounded">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-[#58111A] hover:bg-[#430D14] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow">Save Category</button>
        </div>
    </form>
</div>
@endsection
