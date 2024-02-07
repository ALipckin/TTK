<?php

namespace App\Http\Controllers\Org_characteristic;

use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\Org_characteristic;
use App\Models\Product;
use App\Models\Ttk;


class ShowController extends BaseController
{
    public function __invoke(TTK $ttk)
    {
        $org_characteristic = Header::where('ttk_id', $ttk->id)->first();
        return json_encode(["data" => $org_characteristic], JSON_UNESCAPED_UNICODE);
    }
}
