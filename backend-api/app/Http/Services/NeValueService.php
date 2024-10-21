<?php

namespace App\Http\Services;

use App\Models\Formulation;
use App\Models\Product;
use App\Models\Ttk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class NeValueService extends Controller
{
    public function result(int $ttkId)
    {
        $result = 0;
        $formulations = Formulation::where('ttk_id', $ttkId)->get();
        $grams = 100;
        $percentAlkoInDish = 0;
        //Вычисляем для всех ингредиентов потери элементов
        foreach ($formulations as $i => $formulation) {
            $product = Product::where('id', $formulation->product_id)->first();
            Log::info("product = " . $product);
            $id = $formulation->id;
            $elementsIndexes = ['protein', 'fat', 'carbs'];
            $finTreatment = $formulation->treatment->fin ?? 0;
            $alko = $product->alko ?? 0;
            $percentAlkoInProduct = $formulation->netto/$grams * $alko;
            $percentAlkoInDish += $percentAlkoInProduct;
            $nutritionalElements[$id]['id'] = $formulation->id;
            //Определяем содержание элементов в ингредиенте
            foreach ($elementsIndexes as $elemName) {
                    $percentElemInIngr = $formulation->netto/$grams * $product->$elemName;
                    //Log::info("Calculation percentElemInIngr: ".$formulation->netto."/".$grams . "*" . $product->$elemName ."=".$percentElemInIngr);
                    $withTreatment = $percentElemInIngr;
                    $currTreatment = $formulation->treatment->$elemName ?? 0;
                    //Log::info("curr treatment " . $elemName . " = " . $currTreatment);
                    if($currTreatment > 0) {
                        $withTreatment = $percentElemInIngr * (100 - $currTreatment) / 100;
                        //Log::info("calculation with curr treatment: ".$percentElemInIngr ."*". "(100 - ".$currTreatment.")" ."/100 = " . $withTreatment);
                    }
                    if($finTreatment > 0) {
                        //Log::info("calculation with fin treatment: ".$withTreatment ."*". "(100 - ".$finTreatment.")" ."/100 = " . $withTreatment * (100 - $finTreatment) / 100);
                        $withTreatment = $withTreatment * (100 - $finTreatment) / 100;
                    }
                $nutritionalElements[$id]['elems'][$elemName] =  round($withTreatment, 2) ?? 0;
            }
            //Log::info("nutritionalElements = ", $nutritionalElements);
            //Записываем в массив
            $nutritionalElements[$id]["elems"]['name'] = $product->name;
            $nutritionalElements[$id]["elems"]['netto'] = $formulation->netto;

            //Вычисляем ккал для каждого элемента
            $kcal = ($nutritionalElements[$id]["elems"]['protein'] * 4)
                + ($nutritionalElements[$id]["elems"]['fat'] * 9)
                + ($nutritionalElements[$id]["elems"]['carbs'] * 4) + ($percentAlkoInProduct * 7);
            //Записываем в массив
            $nutritionalElements[$id]["elems"]['kcal'] = round($kcal, 3);
            $nutritionalElements[$id]["elems"]['kj'] = round($kcal * 4.184, 3);
        }

        //суммирование элементов продукта
        $data = [];
        $sumNetto= 0;
        $sumProtein = 0;
        $sumFat = 0;
        $sumCarbs = 0;
        $sumKcal = 0;
        $sumKj = 0;
        foreach ($nutritionalElements as $item) {
            $sumNetto += $item['elems']['netto'];
            $sumProtein += $item['elems']['protein'];
            $sumFat += $item['elems']['fat'];
            $sumCarbs += $item['elems']['carbs'];
            $sumKcal += $item['elems']['kcal'];
            $sumKj += $item['elems']['kj'];
        }
        $data['result']['netto'] = round($sumNetto, 2);
        $data['result']['protein'] = round($sumProtein, 2);
        $data['result']['fat'] = round($sumFat, 2);
        $data['result']['carbs'] = round($sumCarbs, 2);
        $data['result']['kcal'] = round($sumKcal, 2);
        $data['result']['kj'] = round($sumKj, 2);

        $data['ne_values'] = array_values($nutritionalElements);

        return $data;
    }
}
