<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class VerifyOwner
{
    protected $deniedResponse;

    public function __construct()
    {
        $this->deniedResponse = response()->json([
            'status' => false,
            'message' => 'Access denied',
        ], 403);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $baseModelClass = null, $childModelClass = null)
    {
        $namespace = "App\\Models\\";
        if ($baseModelClass) {
            $baseModelClass = $namespace.$baseModelClass;
        }
        if ($childModelClass) {
            $childModelClass = $namespace.$childModelClass;
        }
        log::info("baseModelClass = " . $baseModelClass);
        log::info("childModelClass = " . $childModelClass);
        $deniedResponse = response()->json([
            'status' => false,
            'message' => 'Access denied',
        ], 403);
        Log::info("baseModelClass = " . $baseModelClass);
        Log::info("request = " . $request);
        $id = $request->route('id');
        if ($id && $childModelClass) {
            log::info("id = " . $id);
            $model = $childModelClass::where('id', $id)->first();
            $ttkId = $model->ttk_id;
            $ttk = $baseModelClass::findOrFail($ttkId);
            if (!Gate::allows('changeRecord', $ttk)) {
                return ($this->deniedResponse);
            }
        } else {
            if ($id || $baseModelClass) {
                $model = $baseModelClass::where('id', $id)->first();
                if (!Gate::allows('changeRecord', $model)) {
                    return ($this->deniedResponse);
                }
            }
        }
        $ttkId = $request->route('ttk') ?? null;
        if ($ttkId) {
            $ttk = $baseModelClass::findOrFail($ttkId);
            if (!Gate::allows('changeRecord', $ttk)) {
                return ($this->deniedResponse);
            }
        }
        return $next($request);
    }
}
