<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CheckPublicity
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $ttk = $request->route('ttk');

        //$ttk = \App\Models\Ttk::findOrFail($ttkId);
        if ($ttk->public !== 1) {
            if (!Gate::allows('update-ttk', $ttk)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Access denied',
                ], 403);
            }
        }

        return $next($request);
    }
}
