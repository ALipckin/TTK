<?php

namespace App\Http\Middleware;

use App\Models\Ttk;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VerifyOwner
{
    protected $modelClass;

    public function __construct($modelClass = null)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $modelClass = null)
    {
        $modelClass = $modelClass ?: $this->modelClass;

        $deniedResponse = response()->json([
            'status' => false,
            'message' => 'Access denied',
        ], 403);

        $id = $request->route('id');
        if ($id) {
            $model = $modelClass::where('id', $id)->first();
            $ttkId = $model->ttk_id;
            $ttk = Ttk::findOrFail($ttkId);
            if (!Gate::allows('update-ttk', $ttk)) {
                return $deniedResponse;
            }
        }
        $ttkId = $request->route('ttk') ?? null;
        $ttk = Ttk::findOrFail($ttkId);
        if (!Gate::allows('update-ttk', $ttk)) {
            return $deniedResponse;
        }

        return $next($request);
    }
}
