<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LiveVisitorController extends Controller
{
    public function index()
    {
        $cutoff = Carbon::now()->subMinutes(15);

        $visitors = VisitorSession::where('last_activity', '>=', $cutoff)
            ->latest('last_activity')
            ->paginate(25);

        $totalActive = VisitorSession::where('last_activity', '>=', $cutoff)->count();
        $deviceBreakdown = VisitorSession::where('last_activity', '>=', $cutoff)
            ->selectRaw('device_type, count(*) as total')
            ->groupBy('device_type')
            ->pluck('total', 'device_type')
            ->toArray();

        return view('admin.live-visitors.index', compact('visitors', 'totalActive', 'deviceBreakdown'));
    }
}
