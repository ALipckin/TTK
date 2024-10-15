<?php

namespace App\Http\Controllers;

use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Models\QualityRequirement;
use App\Models\Ttk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class QualityRequirementController extends Controller
{
    public function index(Ttk $Ttk)
    {
        $requirements = QualityRequirement::Where('Ttk_id', $Ttk->id)->get();
        Log::info($requirements);
        return response()->json([
            'status' => true,
            'message' => "requirement data",
            'data' => $requirements,
        ], 200);
    }

    public function update(UpdateRequest $request, $ttk, $requirement,)
    {
        //$requirement = $request->route('requirement') ?? null;

        $data = $request->validated();
        $requirement = QualityRequirement::where('id', $requirement);
        $requirement->update($data);
        return response()->json([
            'status' => true,
            'message' => "requirement updated",
            'data' => $requirement,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['ttk_id'] = $request->route('ttk');
        $requirement = QualityRequirement::create($data);
        return response()->json([
            'status' => true,
            'message' => "requirement created",
            'data' => $requirement,
        ], 201);
    }
    
    public function destroy($ttk, $requirement,)
    {
        $requirement = QualityRequirement::where('id', $requirement)->first();
        $requirement->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted successfully",
        ], 204);
    }
}
