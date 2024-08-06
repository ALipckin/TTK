<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Models\Header;
use App\Models\Requirement;
use App\Models\Ttk;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function destroy(ttk $ttk)
    {
        $requirement = Header::where('ttk_id', $ttk->id)->first();
        $requirement->delete();
        return response()->json(null, 204);
    }

    public function show(TTK $ttk)
    {
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        return json_encode(["data" => $requirement], JSON_UNESCAPED_UNICODE);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $requirement = Requirement::create($data);
        $json =  json_encode(["data" => $requirement], JSON_UNESCAPED_UNICODE);
        return response( $json, 201);
    }

    public function update(UpdateRequest $request, TTK $ttk)
    {
        $data = $request->validated();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        try {
            $requirement->update($data);
            $json = json_encode(["data" => $requirement], JSON_UNESCAPED_UNICODE);
            return response()->json($json, 200);
        }
        catch (\Throwable $ex)
        {
            return response()->json(null, 500);
        }
    }
}
