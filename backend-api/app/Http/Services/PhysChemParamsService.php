<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use App\Models\Formulation;
use App\Models\Product;
use App\Models\Treatment;
use App\Models\Ttk;
use App\Models\TtkCategory;

class PhysChemParamsService extends Controller
{
    public function result(int $ttkId)
    {
        //$result = [];
        //Рецептура
        $formulations = Formulation::where('ttk_id', $ttkId)->get();
        $ttk= Ttk::where('id', $ttkId)->first();
        //Выход на порцию
        //Ищем максимально допустимую соль
        $maxSalt = TtkCategory::Where('id', $ttk->category_id)->first()->smax;
        $result['salt'] = round($maxSalt, 2);
        $portionGrams = (new \App\Models\Formulation)->getPortionNettoGrams($ttk->id);

        $result['dry'] = $this->calculateDry($formulations, $portionGrams, $maxSalt);
        $result['fat'] = $this->calculateFat($formulations, $portionGrams);
        $result['sugar'] = $this->calulateSugar($formulations, $portionGrams);

        // Возвращаем результат в формате JSON
        return $result;
    }

    /**
     * @param $formulations
     * @param int $portionGrams
     * @param $maxSalt
     * @return array
     */
    public function calculateDry($formulations, int $portionGrams, $maxSalt): array
    {
        $allDryResult = 0;
        //Расчет потерь
        foreach ($formulations as $key => $formulation) {
            $product = Product::Where('id', $formulation->product_id)->first();
            //Определяем количество сухих элементов
            $dryNum = $formulation->netto / 100 * $product->dry;
            //Log::info("dryNum = ". $dryNum);
            //Определяем потери при тепловой обработки
            $treatment = Treatment::Where('id', $formulation->treatment_id)->first();
            $hot = $treatment->hot ?? 0;
            //Log::info("treatment hot = ". $hot);
            $allDryResult += $dryNum * (100 - $hot) / 100;
            //Log::info("all dry result = ". $allDryResult);
        }
        //Максимально допустимое
        //Log::info("max sault = ". $maxSault);
        $maxDryResult = 0;
        if($portionGrams) {
            $maxDryResult = $allDryResult * 100 / $portionGrams + $maxSalt;
        }
        //Log::info("max dry result = ". $maxDryResult);
        //Минимально допустимое
        $minDryResult = 0.9 * $maxDryResult;
        $dryResult['max'] = round($maxDryResult, 2);
        $dryResult['min'] = round($minDryResult, 2);
        return $dryResult;
    }

    /**
     * @param $formulations
     * @param int $portionGrams
     * @param array $result
     * @return array
     */
    public function calculateFat($formulations, int $portionGrams): array
    {
        //Рецептура
        $allFatResult = 0;
        //Расчет потерь
        foreach ($formulations as $key => $formulation) {
            //Log::info("formulation = ". json_encode($formulation));
            $product = Product::Where('id', $formulation->product_id)->first();
            //Определяем массовую долю жира - мдж
            $fatNum = $formulation->netto / 100 * $product->fat;
            //Log::info("fatNum = ". $fatNum);
            //Определяем потери при тепловой обработки
            $treatment = Treatment::Where('id', $formulation->treatment_id)->first();
            $hotTreatment = $treatment->hot ?? 0;
            //Log::info("treatment hot = ". $hotTreatment);
            $allFatResult += $fatNum * (100 - $hotTreatment) / 100;
            //Log::info("all fat result = ". $allFatResult);
        }
        //Переводим в процентное содержание
        $maxFatResult = 0;
        if($portionGrams) {
            $maxFatResult = $allFatResult * 100 / $portionGrams;
        }
        //Log::info("max fat result = ". $maxFatResult);
        //Минимально допустимое
        $minFatResult = 0.9 * $maxFatResult;
        $fatResult['max'] = round($maxFatResult, 2);
        $fatResult['min'] = round($minFatResult, 2);
        return $fatResult;
    }
    public function calulateSugar($formulations, int $portionGrams): float
    {
        //Рецептура
        $allSugarResult = 0;
        //Расчет потерь
        foreach ($formulations as $key => $formulation) {
            //Log::info("formulation = ". json_encode($formulation));
            $product = Product::Where('id', $formulation->product_id)->first();
            //Определяем массовую долю жира - мдж
            $sugarNum = $formulation->netto / 100 * $product->sugar;
            //Log::info("sugarNum = ". $sugarNum);
            //Определяем потери при тепловой обработки
            $treatment = Treatment::Where('id', $formulation->treatment_id)->first();
            $hotTreatment = $treatment->hot ?? 0;
            //Log::info("treatment hot = ". $hotTreatment);
            $allSugarResult += $sugarNum * (100 - $hotTreatment) / 100;
            //Log::info("all fat result = ". $allFatResult);
        }
        //Переводим в процентное содержание
        $sugarResult = 0;
        if($portionGrams) {
            $sugarResult = ($allSugarResult * 0.97) * 100 / $portionGrams;
        }
        //Log::info("max fat result = ". $maxFatResult);
        return $sugarResult;
    }
}
