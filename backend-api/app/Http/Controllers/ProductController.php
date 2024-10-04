<?php

namespace App\Http\Controllers;


use App\Http\Filters\ProductFilter;
use App\Http\Requests\Product\FilterRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Treatment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function destroy($id)
    {
        $product = Product::find($id);
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

    public function show($id)
    {
        $product = Product::find($id);
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

    public function update($id, UpdateRequest $request)
    {
        $product = Product::find($id);
        $data = $request->validated();

        $product->update($data);

        return response()->json([
            'status' => true,
            'message' => "ttk updated",
            'data' => new ProductResource($product),
        ], 200);
    }

    public function categories_index()
    {
        $categories = Category::select('id', 'name')->get();

        return response()->json([
            'status' => true,
            'message' => "Categories data",
            'data' => $categories,
        ], 200);
    }

    public function treatments($id)
    {
        $initT = Treatment::Where('product_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Treatments data",
            'data' => $initT,
        ], 200);
    }
}
