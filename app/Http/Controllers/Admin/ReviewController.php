<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $reviews = $query->paginate(20)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'status' => 'approved',
            'approved_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Review approved and published.');
    }

    public function reject(Review $review)
    {
        $review->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Review rejected.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
