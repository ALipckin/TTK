<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement;

class UpdateController extends Controller
{
    public function __invoke(Requirement $req)
    {
        return view('requirement.update', compact('req'));
    }
}
