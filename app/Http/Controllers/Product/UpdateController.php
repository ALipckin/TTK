<?php

namespace App\Http\Controllers\Product;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\http\Requests\Product\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(Product $product, UpdateRequest $request)
    {
        $data = $request->validated();
        $product->update($data);
        $product_json =  json_encode(["data" => new ProductResource($product)], JSON_UNESCAPED_UNICODE);
        return response($product_json, 200);
    }
}
