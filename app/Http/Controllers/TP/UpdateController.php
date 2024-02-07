<?php

namespace App\Http\Controllers\TP;

use App\Models\Org_characteristic;
use App\Models\Product;
use App\http\Requests\Description\UpdateRequest;
use App\Models\Tp;

class UpdateController extends BaseController
{
    public function __invoke(TP $tp, UpdateRequest $request)
    {
        $data = $request->validated();
        $tp->update($data);
        return response()->json($tp, 200);
    }
}
