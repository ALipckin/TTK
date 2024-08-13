<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Http\Requests\DescriptionRequest;
use App\Models\Formulation;
use App\Models\ttk;
use Illuminate\Http\Request;

class ForemulationController extends Controller
{
    public function destroy(ttk $ttk)
    {
        $formulation = Formulation::where('ttk_id', $ttk->id)->first();
        $formulation->delete();
        return response()->json(null, 204);
    }

    public function show(ttk $ttk)
    {
        $formulation = Formulation::where('ttk_id', $ttk->id)->get();
        return json_encode(["data" => $formulation], JSON_UNESCAPED_UNICODE);
    }

    public function store(DescriptionRequest $request)
    {
        $data = $request->validated();
        $formulation = Formulation::create($data);
        $json =  json_encode(["data" => $formulation], JSON_UNESCAPED_UNICODE);
        return response( $json, 201);
    }

    public function update(DescriptionRequest $request, ttk $ttk)
    {
        $data = $request->validated();
        $formulation = Formulation::where('ttk_id', $ttk->id)->first();
        try {
            $formulation->update($data);
            $json = json_encode(["data" => $formulation], JSON_UNESCAPED_UNICODE);
            return response()->json($json, 200);
        }
        catch (\Throwable $ex)
        {
            return response()->json(null, 500);
        }
    }
}
