<?php

namespace App\Http\Controllers\TTK;

use App\Models\Ttk;

class ShowController extends BaseController
{
    public function __invoke(ttk $ttk)
    {
        return view('ttk.show', compact('ttk'));
    }
}
