<?php

namespace App\Http\Middleware;

use App\Models\Ttk;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

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
        if (!$ttk instanceof Ttk) {
            $ttk = \App\Models\Ttk::findOrFail($ttk);
        }
        if ($ttk->public !== 1) {
            if (!Gate::allows('changeRecord', $ttk)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Access denied',
                ], 403);
            }
        }

        return $next($request);
    }
}
