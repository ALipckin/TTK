<?php

namespace App\Http\Controllers\Header;

use App\Http\Requests\Header\UpdateRequest;
use App\Models\Header;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Header $header)
    {
        $data = $request->validated();

        $header->update($data);

        return redirect()->route('product.show', $header->id);
    }
}