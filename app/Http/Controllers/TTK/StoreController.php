<?php

namespace App\Http\Controllers\TTK;

use App\Http\Requests\TTK\StoreRequest;
use App\Models\ttk;



class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        //dd("test");
        //$data = $request->validated();
        //dd($data);
        //ttk::create($data);
        // ttk::create(array_merge(
        //     $request->validated(),
        //     [
        //         'users_id' => auth()->id(),
        //     ]
        // ));

        $ttk = new ttk;
        $ttk->name = $request->name;
        $ttk->open = $request->open;
        $ttk->users_id = auth()->id();
        if($ttk->open){
            if ($ttk->open=="on"){
                $ttk->open=1;
            }
        }else{
            $ttk->open=0;
        }
        $image = $request->file('image');
        $ttk->save();
        $nextID = $ttk->id;
        $imageName = $nextID . '.'. $image->extension();
        $image->move(public_path('images'), $imageName);
        //$image->storeAs('images', $imageName, 'public');
        $ttk->image = $imageName;
        $ttk->save();

        return response()->json($ttk, 201);
    }
}
