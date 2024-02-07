<?php

namespace App\Http\Controllers\Requirement;

use App\http\Requests\Description\StoreRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\TTK;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $requirement = Requirement::create($data);
        $json =  json_encode(["data" => $requirement], JSON_UNESCAPED_UNICODE);
        return response( $json, 201);
    }
}
