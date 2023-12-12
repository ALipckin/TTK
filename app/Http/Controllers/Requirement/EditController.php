<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement;

class EditController extends Controller
{
    public function __invoke(Requirement $req)
    {
        return view('requirement.edit', compact('req'));
    }
}