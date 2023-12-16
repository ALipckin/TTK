<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\TTK;

class CreateController extends Controller
{
    public function __invoke(TTK $ttk)
    {
        return view('requirement.create', compact('ttk'));
    }
}