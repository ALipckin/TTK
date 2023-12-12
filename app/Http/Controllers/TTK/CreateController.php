<?php

namespace App\Http\Controllers\TTK;

class CreateController extends BaseController
{
    public function __invoke()
    {
        return view('ttk.create');
    }
}
