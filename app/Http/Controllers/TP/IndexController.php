<?php

namespace App\Http\Controllers\TP;

use App\Models\Org_characteristic;
use App\Models\Product;
use App\Models\Tp;

class IndexController extends BaseController
{
    public function __invoke()
    {
        return tp::all();
    }
}
