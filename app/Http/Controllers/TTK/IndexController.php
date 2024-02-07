<?php

namespace App\Http\Controllers\TTK;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\Ttk;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $ttk = Ttk::all();
        return json_encode(["data" => $ttk], JSON_UNESCAPED_UNICODE);
    }
}
