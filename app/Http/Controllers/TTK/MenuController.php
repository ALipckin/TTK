<?php

namespace App\Http\Controllers\TTK;

use App\Models\Header;
use App\Models\Ttk;
use App\Models\Requirement;

class MenuController extends BaseController
{
    public function __invoke(ttk $ttk)
    {
        $header = Header::where('ttk_id', $ttk->id)->first();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        return view('ttk.menu', compact('ttk', 'header', 'requirement'));
    }
}
