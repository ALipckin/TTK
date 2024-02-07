<?php

namespace App\Http\Controllers\Product;

use App\http\Requests\Product\StoreRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        $json =  json_encode(["data" => new ProductResource($product)], JSON_UNESCAPED_UNICODE);
        return response( $json, 201);
    }
}
