<?php

namespace App\Http\Controllers\Product;

use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\FilterRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;


class IndexController extends BaseController
{
    public function __invoke(FilterRequest $request)
    {

        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['perPage'] ?? 5;
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);
        $products = Product::filter($filter)->paginate($perPage, ['*'], 'page', $page);

        return ProductResource::collection($products);
    }
}
