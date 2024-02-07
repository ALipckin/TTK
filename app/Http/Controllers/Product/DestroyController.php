<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class DestroyController extends BaseController
{
    public function __invoke(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
