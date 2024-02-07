<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;


class ShowController extends BaseController
{
    public function __invoke(Product $product)
    {
        return json_encode(["data" => new ProductResource($product)], JSON_UNESCAPED_UNICODE);
    }
}
