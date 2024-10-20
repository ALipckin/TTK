<?php

namespace App\Http\Middleware;

use App\Models\Ttk;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isType;

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
    public function handle(Request $request, Closure $next,$baseModelClass = null, $childModelClass = null)
    {
        //        $allParams = $request->route()->parameters();
        //        Log::info("allParams = ", $allParams);
        $namespace = "App\\Models\\";
        $modelClass = [];
        //        $modelsArray = explode(',', $models);
        //        foreach ($modelsArray as $key => $model) {
        //            $modelClass[$key] = $namespace . $model;
        //        }
        //        Log::info("model class", $modelClass);
        if ($baseModelClass) {
            $baseModelClass = $namespace . $baseModelClass;
        }
        if ($childModelClass) {
            $childModelClass = $namespace . $childModelClass;
        }
        //log::info("childModelClass = " . $childModelClass);
        $deniedResponse = response()->json([
            'status' => false,
            'message' => 'Access denied',
        ], 403);
        //Log::info("baseModelClass = " . $baseModelClass);
        //Log::info("request = " . $request);
        if ($request->route('id')) {
            $id = $request->route('id');
            if ($id && $childModelClass) {
                $model = $childModelClass::where('id', $id)->first();
                $ttkId = $model->ttk_id;
                $ttk = $baseModelClass::findOrFail($ttkId);
                if (!Gate::allows('changeRecord', $ttk)) {
                    return ($this->deniedResponse);
                }
            } else {
                if ($id && $baseModelClass) {
                    $model = $baseModelClass::where('id', $id)->first();
                    if ($model) {
                        if (!Gate::allows('changeRecord', $model)) {
                            return ($this->deniedResponse);
                        }
                    }
                }
            }
        }

        $ttkId = $request->route('ttk') ?? null;
        if ($ttkId) {
            if ($ttkId instanceof Ttk) {
                $ttk = $ttkId;
            } else {
                $ttk = $baseModelClass::findOrFail($ttkId);
            }
            if (!Gate::allows('changeRecord', $ttk)) {
                return ($this->deniedResponse);
            }
        }
        return $next($request);
    }

}
