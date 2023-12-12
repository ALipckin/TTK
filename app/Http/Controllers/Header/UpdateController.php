<?php

namespace App\Http\Controllers\Header;

use App\Http\Requests\TTK\UpdateRequest;
use App\Models\Header;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function __invoke(Header $header, UpdateRequest $request)
    {
        $data = $request->validated();

        $header->update($data);
        return redirect()->route('product.show', $header->id);
    }
}