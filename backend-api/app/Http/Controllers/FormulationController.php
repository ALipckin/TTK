<?php

namespace App\Http\Controllers;

use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Http\Resources\Formulation\FormulationResource;
use App\Models\Formulation;
use App\Models\Tp;
use App\Models\Ttk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class FormulationController extends Controller
{
    public function index(Ttk $Ttk)
    {
        $formulations = Formulation::Where('Ttk_id', $Ttk->id)->get();
        return response()->json([
            'status' => true,
            'message' => "requirement data",
            'data' => FormulationResource::collection($formulations),
        ], 200);
    }

    public function update(UpdateRequest $request, $ttk, $formulation,)
    {
        //$formulation = $request->route('requirement') ?? null;

        $data = $request->validated();
        $formulation = Formulation::where('id', $formulation);
        $formulation->update($data);
        return response()->json([
            'status' => true,
            'message' => "requirement updated",
            'data' => $formulation,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['ttk_id'] = $request->route('ttk');
        $formulation = Formulation::create($data);
        return response()->json([
            'status' => true,
            'message' => "requirement created",
            'data' => $formulation,
        ], 201);
    }

    public function destroy($ttk, $formulation,)
    {
        $formulation = Formulation::where('id', $formulation)->first();
        $formulation->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted successfully",
        ], 204);
    }
}
