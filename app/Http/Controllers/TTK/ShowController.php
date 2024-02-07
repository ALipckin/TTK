<?php

namespace App\Http\Controllers\TTK;

use App\Http\Resources\Product\ProductResource;
use App\Models\Ttk;

class ShowController extends BaseController
{
    public function __invoke(ttk $ttk)
    {
        return json_encode(["data" => $ttk], JSON_UNESCAPED_UNICODE);
    }
}
