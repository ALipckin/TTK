<?php

namespace App\Http\Controllers;

use App\Models\HeatTreatment;
use App\Models\InitialTreatment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class TreatmentController extends Controller
{
    public function heatTreatment($id)
    {
        $initT = HeatTreatment::where('product_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Heat treatments data",
            'data' => $initT,
        ], 200);
    }

    public function initialTreatment($id)
    {
        $initT = InitialTreatment::Where('product_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Initial treatments data",
            'data' => $initT,
        ], 200);
    }
}
