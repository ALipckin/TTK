<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Requirement\RequirementResource;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Models\TTK;

class ShowController extends Controller
{
    public function __invoke(TTK $ttk)
    {
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        return json_encode(["data" => $requirement], JSON_UNESCAPED_UNICODE);
    }
}
