<?php

namespace App\Http\Controllers\TP;

use App\http\Requests\Description\StoreRequest;
use App\Models\Org_characteristic;
use App\Models\Product;
use App\Models\Tp;
use Illuminate\Support\Facades\Validator;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $TP = TP::create($data);
        return response()->json($TP, 201);
    }
}
