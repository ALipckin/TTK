<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;


class ShowController extends BaseController
{
    public function __invoke(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
