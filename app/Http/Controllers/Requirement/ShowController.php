<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Requirement $req)
    {
        dd('show');
        return view('requirement.show', compact('req'));
    }
}
