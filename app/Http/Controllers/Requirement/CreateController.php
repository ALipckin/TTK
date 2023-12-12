<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement;

class CreateController extends Controller
{
    public function __invoke(Requirement $req)
    {
        return view('requirement.create', compact('req'));
    }
}