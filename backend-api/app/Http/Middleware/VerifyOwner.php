<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyOwner
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $ttkId)
    {
        $ttk = \App\Models\ttk::findOrFail($ttkId);

        if (!Gate::allows('update-ttk', $ttk)) {
            return response()->json([
                'status' => false,
                'message' => 'Access denied',
            ], 403);
        }

        return $next($request);
    }
}
