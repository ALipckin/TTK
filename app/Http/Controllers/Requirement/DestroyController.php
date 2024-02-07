<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\BaseController;
use App\Models\Header;
use App\Models\Requirement;
use App\Models\Ttk;
use Illuminate\Http\Request;
use App\Models\Product;


class DestroyController extends BaseController
{
    public function __invoke(ttk $ttk)
    {
        $requirement = Header::where('ttk_id', $ttk->id)->first();
        $requirement->delete();
        return response()->json(null, 204);
    }
}
