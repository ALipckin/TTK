<?php

namespace App\Http\Controllers;

use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Models\Tp;
use App\Models\Ttk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class TpController extends Controller
{
    public function index(Ttk $Ttk)
    {
        $tps = Tp::Where('Ttk_id', $Ttk->id)->get();
        Log::info($tps);
        return response()->json([
            'status' => true,
            'message' => "requirement data",
            'data' => $tps,
        ], 200);
    }

    public function update(UpdateRequest $request, $ttk, $tp,)
    {
        //$tp = $request->route('requirement') ?? null;

        $data = $request->validated();
        $tp = Tp::where('id', $tp);
        $tp->update($data);
        return response()->json([
            'status' => true,
            'message' => "requirement updated",
            'data' => $tp,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['ttk_id'] = $request->route('ttk');
        $tp = Tp::create($data);
        return response()->json([
            'status' => true,
            'message' => "requirement created",
            'data' => $tp,
        ], 201);
    }

    public function destroy($ttk, $tp,)
    {
        $tp = Tp::where('id', $tp)->first();
        $tp->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted successfully",
        ], 204);
    }
}
