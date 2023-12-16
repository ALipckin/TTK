<?php

namespace App\Http\Controllers\Requirement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\TTK;

class EditController extends Controller
{
    public function __invoke(TTK $ttk, Requirement $requirement)
    {
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        return view('requirement.edit', compact('ttk', 'requirement'));
    }
}