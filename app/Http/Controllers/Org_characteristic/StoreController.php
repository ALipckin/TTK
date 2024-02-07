<?php

namespace App\Http\Controllers\Org_characteristic;

use App\http\Requests\Description\StoreRequest;
use App\Models\Header;
use App\Models\Org_characteristic;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $org_characteristic = org_characteristic::create($data);
        $json =  json_encode(["data" => $org_characteristic], JSON_UNESCAPED_UNICODE);
        return response($json, 201);
    }
}
