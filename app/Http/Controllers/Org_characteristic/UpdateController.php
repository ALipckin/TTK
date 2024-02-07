<?php

namespace App\Http\Controllers\Org_characteristic;

use App\Models\Header;
use App\Models\Org_characteristic;
use App\Models\Product;
use App\http\Requests\Description\UpdateRequest;
use App\Models\Ttk;

class UpdateController extends BaseController
{
    public function __invoke(TTK $ttk, UpdateRequest $request)
    {
        $data = $request->validated();
        $org_characteristic = Header::where('ttk_id', $ttk->id)->first();
        $org_characteristic->update($data);
        $json = json_encode(["data" => $org_characteristic], JSON_UNESCAPED_UNICODE);
        return response($json, 200);
    }
}
