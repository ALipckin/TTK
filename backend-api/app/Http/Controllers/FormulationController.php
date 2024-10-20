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
            'message' => "formulation data",
            'data' => FormulationResource::collection($formulations),
        ], 200);
    }

    public function createOrUpdate(UpdateRequest $request, Ttk $ttk, $formulation)
    {
        $data = $request->validated();
        //Логика проверки принадлежности и доступа
        if($ttk->user_id != auth()->user()->id){
            return response()->json([
                'status' => false,
                'message' => "Access denied",
            ], 403);
        }
        if($formulation){
            if(is_numeric($formulation)) {
                $formulation = Formulation::where('id', $formulation)->first();
                if ($formulation->ttk_id != $ttk->id) {
                    return response()->json([
                        'status' => false,
                        'message' => "Access denied",
                    ], 403);
                }
            }
        }
        if (isset($data['product_id']) && isset($formulation->product_id) ) {
            if($formulation->product_id != $data['product_id']) {
                $formulation->treatment_id = null;
                $formulation->save();
            }
        }
        $data['ttk_id'] = $ttk->id;
        $formulationId = $formulation->id ?? null;
        // Обновить данные Formulation
        $formulation = Formulation::updateOrCreate(['id' => $formulationId], $data);

        return response()->json([
            'status' => true,
            'message' => "formulation updated",
            'data' => new FormulationResource($formulation),
        ], 200);
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
