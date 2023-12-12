<?php

namespace App\Http\Controllers\TTK;

use App\Models\Ttk;

class DestroyController extends BaseController
{
    public function __invoke(ttk $ttk)
    {
        $ttk->delete();
        return redirect()->route('ttk.index');
    }
}
