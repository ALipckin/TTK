<?php

namespace App\Http\Controllers;

use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Http\Requests\DescriptionRequest;
use App\Models\Scope;
use App\Models\Ttk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ScopeController extends Controller
{
    public function index(Ttk $Ttk)
    {
        $scopes = Scope::Where('Ttk_id', $Ttk->id)->get();
        Log::info($scopes);
        return response()->json([
            'status' => true,
            'message' => "scope data",
            'data' => $scopes,
        ], 200);
    }

    public function update(UpdateRequest $request, $ttk, $scope,)
    {
        //$scope = $request->route('scope') ?? null;

        $data = $request->validated();
        $scope = Scope::where('id', $scope);
        $scope->update($data);
        return response()->json([
            'status' => true,
            'message' => "scope updated",
            'data' => $scope,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['ttk_id'] = $request->route('ttk');
        $scope = scope::create($data);
        return response()->json([
            'status' => true,
            'message' => "scope created",
            'data' => $scope,
        ], 201);
    }


    public function destroy($ttk, $scope,)
    {
        $scope = scope::where('id', $scope)->first();
        $scope->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted successfully",
        ], 204);
    }
}
