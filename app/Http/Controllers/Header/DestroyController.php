<?php

namespace App\Http\Controllers\Header;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TP\BaseController;
use App\Models\Header;
use App\Models\Org_characteristic;
use App\Models\Tp;
use App\Models\Ttk;
use Illuminate\Http\Request;
use App\Models\Product;


class DestroyController extends BaseController
{
    public function __invoke(TTK $ttk)
    {
        $header = Header::where('ttk_id', $ttk->id)->first();
        $header->delete();
        return response()->json(null, 204);
    }
}
