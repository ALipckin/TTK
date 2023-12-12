<?php

namespace App\Http\Controllers\TTK;

use App\Models\Ttk;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $ttks = Ttk::all();
        return view('ttk.index', compact('ttks'));
    }
}
