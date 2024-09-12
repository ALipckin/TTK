<?php

namespace App\Http\Controllers;

use App\Http\Requests\Formulation\StoreRequest;
use App\Http\Requests\Formulation\UpdateRequest;
use App\Http\Resources\Formulation\FormulationResource;
use App\Models\Formulation;
use App\Models\Treatment;
use App\Models\InitialTreatment;
use App\Models\Product;
use App\Models\Ttk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class NeValueController extends Controller
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

    public function result($ttk)
    {
        $result = 0;
        $formulations = Formulation::where('ttk_id', $ttk)->get();
        $grams = 100;

        foreach($formulations as  $i => $formulation ) {
            $product = Product::find($formulation->product_id);
            $id = $formulation->id;
            $elementsIndexes = ['protein', 'fat', 'carbs'];

            $nutritionalElements[$id]['id'] = $formulation->id;
            $nutritionalElements[$id]["elems"]['protein'] = $formulation->netto/$grams*$product->protein;
            $nutritionalElements[$id]["elems"]['fat'] = $formulation->netto/$grams*$product->fat;
            $nutritionalElements[$id]["elems"]['carbs'] = $formulation->netto/$grams*$product->carbs;

            $protein = $formulation->netto/$grams*$product->protein;

            foreach ($nutritionalElements[$id]['elems'] as $j => $elem){
                $result = $elem;
                $heatTreatments = $formulation->heatTreatment()->where('formulation_id',$formulation->id)->get();
                if($heatTreatments) {
                    foreach ($heatTreatments as $item) {
                        log::info("heat treatment = ". $item);
                        log::info('item->heat_treatment_id ='. $item->pivot->heat_treatment_id);
                        $currHeatTreatment = Treatment::find($item->pivot->heat_treatment_id);
                        log::info('currHeatTreatment'. $currHeatTreatment);
                        $result -= $result * $currHeatTreatment->loss;
                    }
                }
                $nutritionalElements[$id]['elems'][$j] = $result;
            }
        }
        $data = [];
        $sumProtein = 0;
        $sumFat = 0;
        $sumCarbs = 0;
        foreach ($nutritionalElements as $item) {
            Log::info("nutritionalElements = ");
            Log::info(json_encode($nutritionalElements));
            $sumProtein += $item['elems']['protein'];
            $sumFat += $item['elems']['fat'];
            $sumCarbs += $item['elems']['carbs'];
        }
        $data['result']['protein'] = $sumProtein;
        $data['result']['fat'] = $sumFat;
        $data['result']['carbs'] = $sumCarbs;

        $data['ne_values'] = array_values($nutritionalElements);

        return response()->json([
            'status' => true,
            'message' => "requirement data",
            'data' => $data,
        ], 200);
    }
}
