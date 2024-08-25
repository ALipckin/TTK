<?php

namespace App\Http\Controllers;

use App\Models\Formulation;
use App\Models\HeatTreatment;
use App\Models\InitialTreatment;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class HeatTreatmentController extends Controller
{
    public function index($id)
    {
        $heatT = HeatTreatment::where('product_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Heat treatments data",
            'data' => $heatT,
        ], 200);
    }

    public function store(\Illuminate\Http\Request $request, $ttk, $id)
    {
        // Извлечение данных из запроса
        $heats = $request->input('heat_treatments');

        // Убедитесь, что данные heat_treatments - это массив
        if (!is_array($heats)) {
            return response()->json(['message' => 'Invalid heat treatments data'], 400);
        }

        // Получение экземпляра модели Formulation
        $formulation = Formulation::findOrFail($id);
        Log::info("Formulation = ". $formulation);
        if (!$formulation) {
            return response()->json(['message' => 'Formulation not found'], 404);
        }

        // Извлечение только идентификаторов для синхронизации
        $heatTreatmentIds = array_column($heats, 'id');

        // Синхронизация данных
        $formulation->heatTreatment()->sync($heatTreatmentIds);

        return response()->json(['status' => true, 'message' => 'Heat treatments successfully added']);
    }

}
