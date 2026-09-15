@extends('layouts.admin')

@section('title', 'Product Reviews Moderation')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Customer Reviews Moderation</h1>
            <p class="text-sm text-slate-400">Review, approve, and moderate customer testimonials and feedback</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-800 pb-3">
        <a href="{{ route('admin.reviews.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ !request('status') ? 'bg-amber-500 text-slate-950' : 'text-slate-400 hover:text-white bg-slate-800/60' }}">
            All Reviews
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ request('status') === 'pending' ? 'bg-amber-500 text-slate-950' : 'text-slate-400 hover:text-white bg-slate-800/60' }}">
            Pending Approval
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ request('status') === 'approved' ? 'bg-amber-500 text-slate-950' : 'text-slate-400 hover:text-white bg-slate-800/60' }}">
            Approved & Live
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'rejected']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ request('status') === 'rejected' ? 'bg-amber-500 text-slate-950' : 'text-slate-400 hover:text-white bg-slate-800/60' }}">
            Rejected
        </a>
    </div>

    <!-- Reviews Grid / Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Rating & Review</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Moderation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($reviews as $rev)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-white max-w-xs truncate">{{ $rev->product->name ?? 'Unknown Product' }}</div>
                            <div class="text-xs text-slate-500">ID #{{ $rev->product_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-200">{{ $rev->author_name ?? $rev->user->name ?? 'Anonymous' }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $rev->author_email ?? $rev->user->email ?? 'N/A' }}</div>
                            @if($rev->is_verified_purchase)
                                <span class="inline-flex items-center gap-1 text-[10px] text-emerald-400 mt-1 font-semibold">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Verified Buyer
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 max-w-md">
                            <div class="flex items-center gap-1 text-amber-400 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $rev->rating ? 'text-amber-400 fill-amber-400' : 'text-slate-700' }}" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                                <span class="text-xs text-slate-400 ml-1">({{ $rev->rating }}/5)</span>
                            </div>
                            @if($rev->title)
                                <div class="font-bold text-white text-xs mb-0.5">{{ $rev->title }}</div>
                            @endif
                            <p class="text-xs text-slate-300 line-clamp-2">{{ $rev->comment }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($rev->status === 'approved')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Approved</span>
                            @elseif($rev->status === 'pending')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
                            {{ $rev->created_at->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                            @if($rev->status !== 'approved')
                                <form action="{{ route('admin.reviews.approve', $rev->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" title="Approve" class="p-1.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 rounded transition inline-flex">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                            @endif
                            @if($rev->status !== 'rejected')
                                <form action="{{ route('admin.reviews.reject', $rev->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" title="Reject" class="p-1.5 bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 rounded transition inline-flex">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this review permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="p-1.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 rounded transition inline-flex">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            No customer reviews found matching filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
