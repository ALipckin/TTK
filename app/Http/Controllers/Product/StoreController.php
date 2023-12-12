<?php

namespace App\Http\Controllers\Product;

use App\http\Requests\Product\StoreRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
  
        $data = $request->validated();

        Product::create($data);
        
        return redirect()->route('product.index');
    }
}
