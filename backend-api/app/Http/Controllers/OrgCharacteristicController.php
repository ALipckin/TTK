<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Description\StoreRequest;
use App\Http\Requests\Description\UpdateRequest;
use App\Models\Header;
use App\Models\Org_characteristic;
use App\Models\Ttk;
use Illuminate\Http\Request;

class OrgCharacteristicController extends Controller
{
    public function destroy(TTK $ttk)
    {
        $org_characteristic = org_characteristic::where('ttk_id', $ttk->id)->first();
        $org_characteristic->delete();
        return response()->json(null, 204);
    }

    public function show(TTK $ttk)
    {
        $org_characteristic = Header::where('ttk_id', $ttk->id)->first();
        return json_encode(["data" => $org_characteristic], JSON_UNESCAPED_UNICODE);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $org_characteristic = org_characteristic::create($data);
        $json =  json_encode(["data" => $org_characteristic], JSON_UNESCAPED_UNICODE);
        return response($json, 201);
    }

    public function update(TTK $ttk, UpdateRequest $request)
    {
        $data = $request->validated();
        $org_characteristic = Header::where('ttk_id', $ttk->id)->first();
        $org_characteristic->update($data);
        $json = json_encode(["data" => $org_characteristic], JSON_UNESCAPED_UNICODE);
        return response($json, 200);
    }
}
