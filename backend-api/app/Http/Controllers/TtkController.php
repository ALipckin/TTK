<?php

namespace App\Http\Controllers;

use App\Http\Filters\TTKFilter;
use App\Http\Requests\TTK\FilterRequest;
use App\Http\Requests\TTK\StoreRequest;
use App\Http\Resources\TTK\TTKResource;
use App\Models\Header;
use App\Models\Requirement;
use App\Models\Ttk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class TtkController extends Controller
{
    public function menu(ttk $ttk)
    {
        if ($ttk->public === 0) {
            if (!Gate::allows('update-ttk', $ttk)) {
                return response()->json([
                    'status' => false,
                    'message' => "Access denied",
                ], 403);
            }
        }

        $header = Header::where('ttk_id', $ttk->id)->first();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        if ($requirement != null)
            $requirement = 1;
        if ($header != null)
            $header = 1;
        $data = array("requirement" => $requirement, "header" => $header);

        return response()->json([
            'status' => true,
            'message' => "ttk menu",
            'data' => $data,
        ], 200);
    }

    public function public()
    {
        $ttks = ttk::where('public', 1)->get();
        $collection = TTKResource::collection($ttks);
        return response()->json([
            'status' => true,
            'message' => "ttk data",
            'data' => $collection,
        ], 200);
    }

    public function publish(ttk $ttk)
    {
        if (!Gate::allows('update-ttk', $ttk)) {
            return response()->json([
                'status' => false,
                'message' => "Access denied",
            ], 403);
        }
        $ttk->public = 1;
        $ttk->save();
        return response()->json([
            'status' => true,
            'message' => "ttk Published"
        ], 200);
    }

    public function destroy(ttk $ttk)
    {
        if (!Gate::allows('update-ttk', $ttk)) {
            return response()->json([
                'status' => false,
                'message' => "Access denied",
            ], 403);
        }
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
        $ttks = ttk::filter($filter)->paginate($perPage, ['*'], 'page', $page);
        $collection = TTKResource::collection($ttks);
        $paginationData = [
            'current_page' => $collection->currentPage(),
            'per_page' => $collection->perPage(),
            'last_page' => $collection->lastPage(),
            // Другие данные о пагинации, которые вам нужны
        ];

        return response()->json([
            'status' => true,
            'message' => "ttk data",
            'data' => $collection->items(),
            'pagination' => $paginationData
        ], 200);
    }

    public function myTTKs()
    {
        $user = Auth::user();
        $ttks = Ttk::where('user_id', $user->id)->get();
        $collection = TTKResource::collection($ttks);

        return response()->json([
            'status' => true,
            'message' => "ttk data",
            'data' => $collection,
        ], 200);
    }

    public function show(ttk $ttk)
    {
        if ($ttk->public === 0) {
            if (!Gate::allows('update-ttk', $ttk)) {
                return response()->json([
                    'status' => false,
                    'message' => "Access denied",
                ], 403);
            }
        }
        $header = Header::where('ttk_id', $ttk->id)->first();
        $requirement = Requirement::where('ttk_id', $ttk->id)->first();
        if ($requirement != null)
            $requirement = 1;
        if ($header != null)
            $header = 1;
        $data = array("requirement" => $requirement, "header" => $header);

        return response()->json([
            'status' => true,
            'message' => "ttk data",
            'data' => $data,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $ttk = new ttk;
        $ttk->name = $request->name;
        $ttk->public = $request->public;
        $ttk->user_id = auth()->id();
        if ($ttk->public) {
            if ($ttk->public == "on") {
                $ttk->public = 1;
            }
        } else {
            $ttk->public = 0;
        }
        if($request->image) {
            try {
                $image = $request->file('image');
                $ttk->save();
                $nextID = $ttk->id;
                $imageName = $nextID . '.' . $image->extension();
                $image->move(public_path('images'), $imageName);
                //$image->storeAs('images', $imageName, 'public');
                $ttk->image = $imageName;
            } catch (Throwable $e) {
                Log::error($e);
            }
        }
        $ttk->save();

        return response()->json([
            'status' => true,
            'message' => "ttk created",
            'data' => $ttk,
        ], 201);
    }

    public function update(ttk $ttk, \App\Http\Requests\TTK\UpdateRequest $request)
    {
        if (!Gate::allows('update-ttk', $ttk)) {
            return response()->json([
                'status' => false,
                'message' => "Access denied",
            ], 403);
        }
        $data = $request->validated();

        $ttk->name = $data['name'];

        if ($request->public == "on") {
            $ttk->public = 1;
        } else {
            $ttk->public = 0;
        }

        if (array_key_exists('image', $data)) {
            File::delete(asset('images/' . $ttk->image));
            $image = $request->file('image');
            $imageName = $ttk->id . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $ttk->image = $imageName;
        }
        $ttk->save();

        return response()->json([
            'status' => true,
            'message' => "ttk updated",
            'data' => $ttk,
        ], 200);
    }
}
