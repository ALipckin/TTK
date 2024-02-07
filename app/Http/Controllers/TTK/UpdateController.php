<?php

namespace App\Http\Controllers\TTK;

use App\Http\Requests\TTK\UpdateRequest;
use App\Models\Ttk;
use Illuminate\Support\Facades\File;

class UpdateController extends BaseController
{
    public function __invoke(TTK $ttk, UpdateRequest $request)
    {
        $data = $request->validated();

        $ttk->name= $data['name'];

        if ($request->open == "on"){
            $ttk->open=1;
        }
        else{
            $ttk->open=0;
        }

        if(array_key_exists('image',$data)){
            File::delete(asset('images/'.$ttk->image));
            $image = $request->file('image');
            $imageName = $ttk->id . '.'. $image->extension();
            $image->move(public_path('images'), $imageName);
            $ttk->image = $imageName;
        }
        $ttk->save();

        return response()->json($ttk, 200);
    }
}
