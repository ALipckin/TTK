<?php

namespace App\Http\Controllers\TTK;

use App\Models\Ttk;

class EditController extends BaseController
{
    public function __invoke(ttk $ttk)
    {
        return view('ttk.edit', compact('ttk'));
    }
}
