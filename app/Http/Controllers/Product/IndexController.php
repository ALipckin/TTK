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

        $page = $data['page'] ?? 0;
        $perPage = $data['perPage'] ?? 10;
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);
        $products = Product::filter($filter)->paginate($perPage, ['*'], 'page', $page);
        $collection = ProductResource::collection($products);
        $jsonData = $collection->toJson();
        $paginationData = [
            'current_page' => $collection->currentPage(),
            'per_page' => $collection->perPage(),
            'last_page' => $collection->lastPage(),
            // Другие данные о пагинации, которые вам нужны
        ];
        $jsonDataWithPagination = json_encode(['data' => $collection->items(), 'pagination' => $paginationData], JSON_UNESCAPED_UNICODE);
        return $jsonDataWithPagination;
    }
}
