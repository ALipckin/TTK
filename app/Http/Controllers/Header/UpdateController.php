<?php

namespace App\Http\Controllers\Header;

use App\Http\Requests\Header\UpdateRequest;
use App\Models\Header;
use App\Models\Requirement;
use App\Models\TTK;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, TTK $ttk)
    {
        $data = $request->validated();
        $header = Header::where('ttk_id', $ttk->id)->first();
        $header->update($data);
        $json = json_encode(["data" => $header], JSON_UNESCAPED_UNICODE);
        return response($json, 200);
    }
}
