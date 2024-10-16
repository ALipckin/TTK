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
    public function result($ttk)
    {
        $result = 0;
        $formulations = Formulation::where('ttk_id', $ttk)->get();
        $grams = 100;

        foreach ($formulations as $i => $formulation) {
            $product = Product::find($formulation->product_id);
            $id = $formulation->id;
            $elementsIndexes = ['protein', 'fat', 'carbs'];

            $nutritionalElements[$id]['id'] = $formulation->id;
            $protein = $formulation->netto / $grams * $product->protein;
            $fat = $formulation->netto / $grams * $product->fat;
            $carbs = $formulation->netto / $grams * $product->carbs;
            $nutritionalElements[$id]["elems"]['protein'] = $protein;
            $nutritionalElements[$id]["elems"]['fat'] = $fat;
            $nutritionalElements[$id]["elems"]['carbs'] = $carbs;
            $kcal = ($protein * 4) + ($fat * 9) + ($carbs * 4);
            $nutritionalElements[$id]["elems"]['kcal'] = round($kcal, 3);
            $nutritionalElements[$id]["elems"]['kj'] = round($kcal * 4.184, 3);

            foreach ($nutritionalElements[$id]['elems'] as $j => $elem) {
                $result = $elem;
                $currTreatment = $formulation->treatment;
                $elemName = $j;
                $result -= $result * $currTreatment->cold / 100;
                $result -= $result * $currTreatment->hot / 100;
                if (in_array($elemName, $elementsIndexes)) {
                    $result -= $result * $currTreatment->$elemName / 100;
                }
            }
            $nutritionalElements[$id]['elems'][$j] = $result;
        }

        $data = [];
        $sumProtein = 0;
        $sumFat = 0;
        $sumCarbs = 0;
        $sumKcal = 0;
        $sumKj = 0;
        foreach ($nutritionalElements as $item) {
            $sumProtein += $item['elems']['protein'];
            $sumFat += $item['elems']['fat'];
            $sumCarbs += $item['elems']['carbs'];
            $sumKcal += $item['elems']['kcal'];
            $sumKj += $item['elems']['kj'];
        }
        $data['result']['protein'] = $sumProtein;
        $data['result']['fat'] = $sumFat;
        $data['result']['carbs'] = $sumCarbs;
        $data['result']['kcal'] = $sumKcal;
        $data['result']['kj'] = $sumKj;

        $data['ne_values'] = array_values($nutritionalElements);

        return response()->json([
            'status' => true,
            'message' => "ne value data",
            'data' => $data,
        ], 200);
    }
}
