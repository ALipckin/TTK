<?php

namespace App\Http\Controllers;

use App\Http\Requests\Formulation\StoreRequest;
use App\Http\Requests\Formulation\UpdateRequest;
use App\Http\Resources\Formulation\FormulationResource;
use App\Models\Formulation;
use App\Models\Treatment;
use App\Models\Product;
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

    public function update(UpdateRequest $request, $ttk, $formulation)
    {
        //$formulation = $request->route('requirement') ?? null;
        $data = $request->validated();
        $formulation = Formulation::find($formulation);
        if (!$formulation) {
            return response()->json([
                'status' => false,
                'message' => "Formulation not found",
            ], 404);
        }
        // Обновить данные Formulation
        $formulation->update($data);

        // Обработка массива heat_treatment_ids
        if (isset($data['heat_treatments']) && is_array($data['heat_treatment_ids'])) {
            // Синхронизируем данные в связующей таблице
            $formulation->heatTreatments()->sync($data['heat_treatment_ids']);
        }

        // Обработка массива initial_treatment_ids
        if (isset($data['initial_treatments']) && is_array($data['initial_treatment_ids'])) {
            // Синхронизируем данные в связующей таблице
            $formulation->initialTreatments()->sync($data['initial_treatment_ids']);
        }

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
