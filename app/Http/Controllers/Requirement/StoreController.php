<?php

namespace App\Http\Controllers\Requirement;

use App\http\Requests\Description\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\TTK;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, TTK $ttk)
    {
        $id = $request->route('id');
        $data = $request->validated();
        $data['ttk_id'] = $ttk->id;
        Requirement::create($data);
        
        return redirect()->route('ttk.menu', $ttk->id);
    }
}
