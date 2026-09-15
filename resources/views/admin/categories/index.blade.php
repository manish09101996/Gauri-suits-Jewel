@extends('layouts.admin')

@section('title', 'Categories')
@section('header_title', 'Category Hierarchy')
@section('header_subtitle', 'Manage product collections, subcategories, and visual banners')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-[#C5A869] hover:bg-[#A88B4D] text-white font-bold text-xs uppercase tracking-wider rounded-sm transition-colors flex items-center gap-2 shadow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Add Category</span>
        </a>
    </div>

    <div class="bg-white rounded-sm shadow-xs border border-[#EFE9DE] overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-[#F7F4EE] uppercase tracking-wider text-[#8C713B] font-bold border-b border-[#EFE9DE]">
                <tr>
                    <th class="px-5 py-3.5">Category</th>
                    <th class="px-5 py-3.5">Slug</th>
                    <th class="px-5 py-3.5">Parent</th>
                    <th class="px-5 py-3.5">Products</th>
                    <th class="px-5 py-3.5">Featured</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#EFE9DE]">
                @forelse($categories as $category)
                    <tr class="hover:bg-[#FCFBF8]">
                        <td class="px-5 py-3.5 font-bold text-[#2A1810]">
                            {{ $category->name }}
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 font-mono">
                            {{ $category->slug }}
                        </td>
                        <td class="px-5 py-3.5 text-gray-600">
                            {{ $category->parent ? $category->parent->name : '— (Root Category)' }}
                        </td>
                        <td class="px-5 py-3.5 font-bold text-[#58111A]">
                            {{ $category->products_count }} items
                        </td>
                        <td class="px-5 py-3.5">
                            @if($category->is_featured)
                                <span class="px-2 py-0.5 bg-[#C5A869]/20 text-[#8C713B] rounded text-[10px] font-bold">Homepage</span>
                            @else
                                <span class="text-gray-400">&mdash;</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $category->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-1 text-gray-500 hover:text-[#58111A]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-rose-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-gray-400">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
