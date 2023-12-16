<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Models\TTK;

class ShowController extends Controller
{
    public function __invoke(TTK $ttk)
    {
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        return view('requirement.show', compact('ttk', 'requirement'));
    }
}
