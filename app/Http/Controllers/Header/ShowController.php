<?php

namespace App\Http\Controllers\Header;

use App\Models\Header;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Header $header)
    {
        return view('header.show', compact('header'));
    }
}

