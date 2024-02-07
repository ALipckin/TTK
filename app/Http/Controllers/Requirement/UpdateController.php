<?php

namespace App\Http\Controllers\Requirement;

use App\http\Requests\Description\UpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Header;
use Illuminate\Http\Request;
use App\Models\TTK;
use App\Models\Requirement;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, TTK $ttk)
    {
        $data = $request->validated();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        dd($ttk->id);
        try {
            $requirement->update($data);
            $json = json_encode(["data" => $requirement], JSON_UNESCAPED_UNICODE);
            return response()->json($json, 200);
        }
        catch (\Throwable $ex)
        {
            return response()->json(null, 500);
        }


    }
}
