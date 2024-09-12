<?php

namespace App\Http\Controllers;

use App\Models\Formulation;
use App\Models\Treatment;
use App\Models\InitialTreatment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class InitialTreatmentController extends Controller
{
    public function index($id)
    {
        $initT = InitialTreatment::Where('product_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Initial treatments data",
            'data' => $initT,
        ], 200);
    }

    public function store(Request $request, $ttk, $id)
    {
        $inits = $request->input('initial_treatments');

        // Убедитесь, что данные heat_treatments - это массив
        if (!is_array($inits)) {
            return response()->json(['message' => 'Invalid initials treatments data'], 400);
        }

        // Получение экземпляра модели Formulation
        $formulation = Formulation::findOrFail($id);
        Log::info("Formulation = ". $formulation);
        if (!$formulation) {
            return response()->json(['message' => 'Formulation not found'], 404);
        }

        // Извлечение только идентификаторов для синхронизации
        $treatmentIds = array_column($inits, 'id');

        // Синхронизация данных
        $formulation->initialTreatment()->sync($treatmentIds);

        return response()->json(['status' => true, 'message' => 'Initial treatments successfully added']);
    }
}
