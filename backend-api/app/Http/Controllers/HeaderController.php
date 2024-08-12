<?php

namespace App\Http\Controllers;

use App\Http\Requests\Header\StoreRequest;
use App\Http\Requests\Header\UpdateRequest;
use App\Models\Header;
use App\Models\Ttk;
use Illuminate\Routing\Controller;

class HeaderController extends Controller
{
    public function update(UpdateRequest $request, Ttk $Ttk)
    {
        $data = $request->validated();
        $header = Header::where('Ttk_id', $Ttk->id)->first();
        $header->update($data);
        $json = json_encode(["data" => $header], JSON_UNESCAPED_UNICODE);
        return response($json, 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $header = Header::create($data);
        $json = json_encode(["data" => $header], JSON_UNESCAPED_UNICODE);
        return response($json, 201);
    }

    public function show(Ttk $Ttk)
    {
        $header = Header::where('Ttk_id', $Ttk->id)->first();
        return json_encode(["data" => $header], JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Ttk $Ttk)
    {
        $header = Header::where('Ttk_id', $Ttk->id)->first();
        $header->delete();
        return response()->json(null, 204);
    }
}
