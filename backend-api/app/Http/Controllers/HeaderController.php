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
        return response()->json([
            'status' => true,
            'message' => "Header updated",
            'data' => $header,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $header = Header::create($data);
        return response()->json([
            'status' => true,
            'message' => "Header created",
            'data' => $header,
        ], 201);
    }

    public function show(Ttk $Ttk)
    {
        $header = Header::where('Ttk_id', $Ttk->id)->first();

        return response()->json([
            'status' => true,
            'message' => "Header data",
            'data' => $header,
        ], 200);
    }

    public function destroy(Ttk $Ttk)
    {
        $header = Header::where('Ttk_id', $Ttk->id)->first();
        $header->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted successfully",
        ], 204);
    }
}
