<?php

namespace App\Http\Controllers\Org_characteristic;

use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Models\Org_characteristic;
use App\Models\Ttk;
use Illuminate\Http\Request;
use App\Models\Product;


class DestroyController extends BaseController
{
    public function __invoke(TTK $ttk)
    {
        $org_characteristic = org_characteristic::where('ttk_id', $ttk->id)->first();
        $org_characteristic->delete();
        return response()->json(null, 204);


    }
}
