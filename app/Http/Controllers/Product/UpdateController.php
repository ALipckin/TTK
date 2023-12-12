<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\http\Requests\Product\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(Product $product, UpdateRequest $request)
    {
        $data = $request->validated();
        $product->update($data);
        return redirect()->route('product.show', $product->id);
    }
}
