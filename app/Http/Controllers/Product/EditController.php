<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class EditController extends BaseController
{
    public function __invoke(Product $product)
    {
        $categories = Category::all();
        return view('product.edit', compact('product'), compact('categories'));
    }
}
