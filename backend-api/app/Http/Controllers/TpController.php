<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Models\Tp;
use Illuminate\Http\Request;

class TpController extends Controller
{
    public function destroy(TP $tp)
    {
        $tp->delete();
        return response()->json(null, 204);
    }

    public function index()
    {
        return tp::all();
    }

    public function show(TP $TP)
    {
        return $TP;
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $TP = TP::create($data);
        return response()->json($TP, 201);
    }

    public function update(TP $tp, UpdateRequest $request)
    {
        $data = $request->validated();
        $tp->update($data);
        return response()->json($tp, 200);
    }

}
