<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckPublicity
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $ttkId)
    {
        Log::info("ttkId: " . $ttkId);
        $ttk = \App\Models\ttk::findOrFail($ttkId);
        if ($ttk->public !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Access denied',
            ], 403);
        }

        return $next($request);
    }
}
