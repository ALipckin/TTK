<?php

namespace App\Http\Controllers;

use App\Models\Formulation;
use App\Models\Product;
use App\Models\Ttk;
use App\Models\TtkCategory;
use Illuminate\Routing\Controller;

class MicrobioParamsController extends Controller
{
    public function index($ttk)
    {
        $ttk = Ttk::where('id', $ttk)->first();
        $data = TtkCategory::where('id', $ttk->category_id)->first();

        return response()->json([
            'status' => true,
            'message' => "ne value data",
            'data' => $data,
        ], 200);
    }
}
