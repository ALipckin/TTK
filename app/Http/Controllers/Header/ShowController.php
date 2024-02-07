<?php

namespace App\Http\Controllers\Header;

use App\Models\Header;
use App\Models\Requirement;
use App\Models\TTK;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(TTK $ttk)
    {
        $header = Header::where('ttk_id', $ttk->id)->first();
        return json_encode(["data" => $header], JSON_UNESCAPED_UNICODE);
    }
}

