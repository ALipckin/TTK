<?php

namespace App\Http\Controllers\Header;

use App\Models\Header;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function __invoke(Header $header)
    {
        return view('header.edit', compact('header'));
    }
}
