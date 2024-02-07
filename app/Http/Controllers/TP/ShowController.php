<?php

namespace App\Http\Controllers\TP;

use App\Http\Controllers\Controller;
use App\Models\Org_characteristic;
use App\Models\Product;
use App\Models\Tp;


class ShowController extends BaseController
{
    public function __invoke(TP $TP)
    {
        return $TP;
    }
}
