<?php

namespace App\Http\Controllers\TP;

use App\Http\Controllers\Controller;
use App\Models\Org_characteristic;
use App\Models\Tp;
use Illuminate\Http\Request;
use App\Models\Product;


class DestroyController extends BaseController
{
    public function __invoke(TP $tp)
    {
        $tp->delete();
        return response()->json(null, 204);
    }
}
