<?php

namespace App\Http\Controllers\Header;

use App\Models\Header;
use App\Models\TTK;
use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke(TTK $ttk)
    {
        return view('header.create', compact('ttk'));
    }
}
