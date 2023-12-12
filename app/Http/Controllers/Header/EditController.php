<?php

namespace App\Http\Controllers\Header;

use App\Models\Header;
use App\Models\TTK;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function __invoke(TTK $ttk, Header $headerID)
    {
        $header = Header::where('ttk_id', $ttk->id)->first();
        return view('header.edit', compact('ttk', 'header'));
    }
}
