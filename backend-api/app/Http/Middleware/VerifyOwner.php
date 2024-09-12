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
    public function handle(Request $request, Closure $next, $baseModelClass = null, $childModelClass = null)
    {
        log::info("Verifying owner");
        log::info("Request" . $request);
        $namespace = "App\\Models\\";
        if ($baseModelClass) {
            $baseModelClass = $namespace . $baseModelClass;
        }
        if ($childModelClass) {
            $childModelClass = $namespace . $childModelClass;
        }
        log::info("baseModelClass = " . $baseModelClass);
        //log::info("childModelClass = " . $childModelClass);
        $deniedResponse = response()->json([
            'status' => false,
            'message' => 'Access denied',
        ], 403);
        //Log::info("baseModelClass = " . $baseModelClass);
        //Log::info("request = " . $request);
        if($request->route('id')){
            $id = $request->route('id');
            Log::info("id = " . $id);
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
            Log::info("ttk = ". $ttkId);
            if ($ttkId) {
                if($ttkId instanceof Ttk){
                    $ttk = $ttkId;
                    Log::info("ttk = ". $ttk);
                }
                else {
                    $ttk = $baseModelClass::findOrFail($ttkId);
                }
                if (!Gate::allows('changeRecord', $ttk)) {
                    return ($this->deniedResponse);
                }
            }
            return $next($request);
        }

}
