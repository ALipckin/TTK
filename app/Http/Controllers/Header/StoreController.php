<?php

namespace App\Http\Controllers\Header;

use App\http\Requests\Header\StoreRequest;
use App\Models\Header;
use App\Models\TTK;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $header = Header::create($data);
        $json =  json_encode(["data" => $header], JSON_UNESCAPED_UNICODE);
        return response( $json, 201);
    }
}
