<?php

namespace App\Http\Controllers\Header;

use App\http\Requests\Header\StoreRequest;
use App\Models\Header;
use App\Models\TTK;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, TTK $ttk)
    {
        $id = $request->route('id');
        $data = $request->validated();
        $data['ttk_id'] = $ttk->id;
        Header::create($data);
        
        return redirect()->route('ttk.menu', $ttk->id);
    }
}
