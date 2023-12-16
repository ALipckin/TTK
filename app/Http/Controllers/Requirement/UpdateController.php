<?php

namespace App\Http\Controllers\Requirement;

use App\http\Requests\Description\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TTK;
use App\Models\Requirement;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, TTK $ttk)
    {
        $data = $request->validated();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        $requirement->update($data);
        return redirect()->route('requirement.show', $ttk->id);
    }
}
