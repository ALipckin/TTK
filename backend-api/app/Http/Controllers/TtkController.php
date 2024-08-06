<?php

namespace App\Http\Controllers;

use App\Http\Filters\TTKFilter;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Requests\TTK\FilterRequest;
use App\Http\Requests\TTK\StoreRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\TTK\TTKResource;
use App\Models\Header;
use App\Models\Product;
use App\Models\Requirement;
use App\Models\Ttk;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TtkController extends Controller
{
    public function menu(ttk $ttk)
    {
        $header = Header::where('ttk_id', $ttk->id)->first();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        if($requirement != null)
            $requirement = 1;
        if($header != null)
            $header = 1;
        $data = array("requirement" => $requirement, "header" => $header);

        return response()->json([
            'status' => true,
            'message' => "TTK Menu data",
            'data' => $data,
        ], 200);
    }
    public function destroy(ttk $ttk)
    {
        $ttk->delete();

        return response()->json([
            'status' => true,
            'message' => "Deleted Successfully",
        ], 204);
    }

    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $page = $data['page'] ?? 0;
        $perPage = $data['perPage'] ?? 10;
        $filter = app()->make(TTKFilter::class, ['queryParams' => array_filter($data)]);
        $ttks = TTK::filter($filter)->paginate($perPage, ['*'], 'page', $page);
        $collection = TTKResource::collection($ttks);
        $paginationData = [
            'current_page' => $collection->currentPage(),
            'per_page' => $collection->perPage(),
            'last_page' => $collection->lastPage(),
            // Другие данные о пагинации, которые вам нужны
        ];

        return response()->json([
            'status' => true,
            'message' => "Ttk data",
            'data' => $collection->items(),
            'pagination' => $paginationData
        ], 200);
    }

    public function myWorks()
    {
        $user = Auth::user();
        $ttks = Ttk::where('user_id', $user->id)->get();
        $collection = TTKResource::collection($ttks);

        return response()->json([
            'status' => true,
            'message' => "Ttk data",
            'data' => $collection,
        ], 200);
    }

    public function show(ttk $ttk)
    {
        $header = Header::where('ttk_id', $ttk->id)->first();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        if($requirement != null)
            $requirement = 1;
        if($header != null)
            $header = 1;
        $data = array("requirement" => $requirement, "header" => $header);

        return response()->json([
            'status' => true,
            'message' => "Ttk data",
            'data' => $data,
        ], 200);
    }

    public function store(StoreRequest $request)
    {

        $ttk = new ttk;
        $ttk->name = $request->name;
        $ttk->public = $request->public;
        $ttk->user_id = auth()->id();
        if($ttk->public){
            if ($ttk->public=="on"){
                $ttk->public=1;
            }
        }else{
            $ttk->public=0;
        }
        $image = $request->file('image');
        $ttk->save();
        $nextID = $ttk->id;
        $imageName = $nextID . '.'. $image->extension();
        $image->move(public_path('images'), $imageName);
        //$image->storeAs('images', $imageName, 'public');
        $ttk->image = $imageName;
        $ttk->save();

        return response()->json([
            'status' => true,
            'message' => "Ttk created",
            'data' => $ttk,
        ], 201);
    }

    public function update(TTK $ttk, \App\Http\Requests\TTK\UpdateRequest $request)
    {
        $data = $request->validated();

        $ttk->name= $data['name'];

        if ($request->public == "on"){
            $ttk->public=1;
        }
        else{
            $ttk->public=0;
        }

        if(array_key_exists('image',$data)){
            File::delete(asset('images/'.$ttk->image));
            $image = $request->file('image');
            $imageName = $ttk->id . '.'. $image->extension();
            $image->move(public_path('images'), $imageName);
            $ttk->image = $imageName;
        }
        $ttk->save();

        return response()->json([
            'status' => true,
            'message' => "Ttk updated",
            'data' => $ttk,
        ], 200);
    }
}
