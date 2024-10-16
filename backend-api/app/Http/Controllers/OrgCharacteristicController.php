<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Org_characteristic\StoreRequest;
use App\Models\Formulation;
use App\Models\Header;
use App\Models\OrgCharacteristic;
use App\Models\Ttk;
use App\Models\TtkCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrgCharacteristicController extends Controller
{
    public function destroy(Ttk $ttk)
    {
        $org_characteristic = OrgCharacteristic::where('ttk_id', $ttk->id)->first();
        $org_characteristic->delete();
        return response()->json(null, 204);
    }

    public function show(Request $request, Ttk $ttk)
    {
        // Ищем характеристику организации по ttk_id
        $org_characteristic = OrgCharacteristic::where('ttk_id', $ttk->id)->first();

        // Если характеристика не найдена, создаем новую
        if (!$org_characteristic) {
            if ($ttk->category_id) {
                // Ищем категорию по category_id
                $category = TtkCategory::find($ttk->category_id);
                if ($category) {
                    // Преобразуем данные категории в массив
                    $data = $category->only(['view', 'color', 'cons', 'taste']);
                    $data['ttk_id'] = $ttk->id;
                    // Создаем новую характеристику и сохраняем
                    $org_characteristic = new OrgCharacteristic($data);
                    $org_characteristic->save();
                }
            }
        }

        // Возвращаем результат в формате JSON
        return response()->json([
            'status' => true,
            'message' => "formulation data",
            'data' => $org_characteristic,
        ], 200);
    }


    public function createOrUpdate(StoreRequest $request, Ttk $ttk)
    {
        $data = $request->validated();

        $data['ttk_id'] = $ttk->id;
        $currUser = Auth()->user();
        $org_characteristic = $ttk->orgCharacteristics();
        // Обновить данные Formulation
        if ($org_characteristic) {
            //if ($ttk->user_id == $currUser) {
            $org_characteristic->update($data);
            //}
        } else {
            $data = TtkCategory::find($ttk->category_id)->get(['view', 'color', 'cons', 'taste']);
            $data['ttk_id'] = $ttk->id;
            $org_characteristic = new OrgCharacteristic($data);
        }

        return response()->json([
            'status' => true,
            'message' => "formulation updated",
            'data' => $org_characteristic,
        ], 200);
    }

}
