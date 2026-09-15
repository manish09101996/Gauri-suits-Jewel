<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorSession;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // Don't track static assets or admin paths
        if (!$request->is('admin*') && !$request->is('api*') && !$request->is('storage*') && !$request->is('build*')) {
            try {
                $sessionId = $request->session()->getId();
                $ipHash = hash('sha256', $request->ip() ?? '127.0.0.1');
                $userAgent = substr($request->userAgent() ?? '', 0, 255);

                $deviceType = 'desktop';
                if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
                    $deviceType = 'tablet';
                } elseif (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
                    $deviceType = 'mobile';
                }

                VisitorSession::updateOrCreate(
                    ['session_id' => $sessionId],
                    [
                        'ip_hash' => $ipHash,
                        'user_agent' => $userAgent,
                        'device_type' => $deviceType,
                        'current_url' => substr($request->fullUrl(), 0, 255),
                        'referrer' => substr($request->header('referer', ''), 0, 255),
                        'last_activity' => Carbon::now(),
                    ]
                );
            } catch (\Exception $e) {
                // Ignore analytics errors so request continues smoothly
            }
        }

        return $next($request);
    }
}
