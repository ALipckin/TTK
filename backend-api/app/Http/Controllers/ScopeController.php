<?php

namespace App\Http\Controllers;

use App\Http\Requests\DescriptionRequest;
use App\Models\Scope;
use App\Models\Ttk;
use Illuminate\Routing\Controller;

class ScopeController extends Controller
{
    public function update(DescriptionRequest $request, Ttk $Ttk)
    {
        $data = $request->validated();
        $scope = scope::where('Ttk_id', $Ttk->id)->first();
        $scope->update($data);
        return response()->json([
            'status' => true,
            'message' => "scope updated",
            'data' => $scope,
        ], 200);
    }

    public function store(DescriptionRequest $request)
    {
        $data = $request->validated();
        $scope = scope::create($data);
        return response()->json([
            'status' => true,
            'message' => "scope created",
            'data' => $scope,
        ], 201);
    }

    public function show(Ttk $Ttk)
    {
        $scope = scope::where('Ttk_id', $Ttk->id)->first();

        return response()->json([
            'status' => true,
            'message' => "scope data",
            'data' => $scope,
        ], 200);
    }

    public function destroy(Ttk $Ttk)
    {
        $scope = scope::where('Ttk_id', $Ttk->id)->first();
        $scope->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted successfully",
        ], 204);
    }
}
