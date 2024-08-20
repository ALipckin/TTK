<?php

namespace App\Http\Controllers;


use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\FilterRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted Successfully",
        ], 204);
    }

    public function index(FilterRequest $request)
    {
        $data = $request->all();

        $page = $data['page'] ?? 0;
        $perPage = $data['perPage'] ?? 10;
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);

        $products = Product::filter($filter)->where('user_id', null)->paginate($perPage, ['*'], 'page', $page);
        $collection = ProductResource::collection($products);
        $paginationData = [
            'current_page' => $collection->currentPage(),
            'per_page' => $collection->perPage(),
            'last_page' => $collection->lastPage(),
            // Другие данные о пагинации, которые вам нужны
        ];

        return response()->json([
            'status' => true,
            'message' => "Product data",
            'data' => $collection->items(),
            'pagination' => $paginationData
        ], 200);
    }

    public function my(FilterRequest $request)
    {
        $data = $request->all();

        $page = $data['page'] ?? 0;
        $perPage = $data['perPage'] ?? 10;
        $filter = app()->make(ProductFilter::class, ['queryParams' => array_filter($data)]);

        $products = Product::filter($filter)->where("user_id", Auth::user()->id)->paginate($perPage, ['*'], 'page', $page);
        $collection = ProductResource::collection($products);
        $paginationData = [
            'current_page' => $collection->currentPage(),
            'per_page' => $collection->perPage(),
            'last_page' => $collection->lastPage(),
            // Другие данные о пагинации, которые вам нужны
        ];

        return response()->json([
            'status' => true,
            'message' => "Product data",
            'data' => $collection->items(),
            'pagination' => $paginationData
        ], 200);
    }

    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'message' => "Product data",
            'data' => new ProductResource($product),
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data);

        return response()->json([
            'status' => true,
            'message' => "Product created",
            'data' => new ProductResource($product),
        ], 201);
    }

    public function update(Product $product, UpdateRequest $request)
    {
        $data = $request->validated();

        $product->update($data);

        return response()->json([
            'status' => true,
            'message' => "ttk updated",
            'data' => new ProductResource($product),
        ], 200);
    }
}
