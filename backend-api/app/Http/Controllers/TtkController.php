<?php

namespace App\Http\Controllers;

use App\Http\Filters\TtkFilter;
use App\Http\Requests\TTK\StoreRequest;
use App\Http\Resources\TTK\TTKResource;
use App\Models\Requirement;
use App\Models\Ttk;
use App\Models\TtkCategory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TtkController extends Controller
{
    public function index(\App\Http\Requests\TTK\FilterRequest $request)
    {
        $data = $request->validated();
        $page = $data['page'] ?? 0;
        $perPage = $data['perPage'] ?? 10;
        $category_id = $request->input("category_id", []);
        $filter = app()->make(TtkFilter::class, ['queryParams' => array_filter($data)]);
        $ttks = Ttk::filter($filter)->where('public', 1)->paginate($perPage, ['*'], 'page', $page);
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

    public function categories_index()
    {
        $categories = TtkCategory::select('id', 'name', 'parent_id')->get();
        $tree = $this->buildTree($categories);

        return response()->json([
            'status' => true,
            'message' => "Ttk categories data",
            'data' => $tree,
        ], 200);
    }
    function buildTree($categories) {
        // Группируем категории по parent_id
        $grouped = $categories->groupBy('parent_id');

        // Строим дерево начиная с корневых категорий (у которых parent_id == null)
        $rootCategories = $grouped->get(null, collect()); // Получаем корневые категории (parent_id == null)

        return $this->buildBranch($grouped, $rootCategories);
    }

    function buildBranch($grouped, $categories) {
        $branch = [];

        foreach ($categories as $category) {
            // Если есть дочерние элементы
            if (isset($grouped[$category->id])) {
                // Рекурсивно строим дерево для дочерних элементов
                $category->children = $this->buildBranch($grouped, $grouped[$category->id]);
            } else {
                // Если нет детей, то устанавливаем пустой массив для children
                $category->children = [];
            }

            $branch[] = $category;
        }

        return $branch;
    }
    public function publish(ttk $ttk)
    {
        $ttk->public = 1;
        $ttk->save();
        return response()->json([
            'status' => true,
            'message' => "Ttk Published"
        ], 200);
    }

    public function destroy(ttk $ttk)
    {
        DB::beginTransaction(); // Начало транзакции
        try {
            // Получаем все связанные записи
            $records = $ttk->getAllRelatedRecords(type: 'model');
            foreach ($records as $record) {
                foreach ($record as $item) {
                }
                //Log::info("record type = " . get_class($record) );
            }

            // Удаляем все связанные записи
            foreach ($records as $record) {
                foreach ($record as $item) {
                    //Log::info("deleting record = " . $item);
                    $item->delete();
                }
                //if ($record instanceof \Illuminate\Database\Eloquent\Model) {
//                    Log::info("deleting record = " . $record );
//                    $record->delete();
//                } else {
//                    Log::warning("Skipping non-model record during deletion.");
//                }
            }

            // Удаляем основную запись
            if ($ttk instanceof \Illuminate\Database\Eloquent\Model) {
                $ttk->delete();
            } else {
                throw new \Exception("The provided ttk is not a valid model.");
            }

            // Если все операции успешны, подтверждаем транзакцию
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "Deleted Successfully",
            ], 204);
        } catch (\Exception $e) {
            // В случае ошибки откатываем транзакцию
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => "Deletion Failed: " . $e->getMessage(),
            ], 500);
        }
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
        //$header = Header::where('ttk_id', $ttk->id)->first();
        //$requirement = Requirement::where('ttk_id', $ttk->id)->first();
        //$form = Form::where('ttk_id', $ttk->id)->first();
        //$formulation = Formulation::where('ttk_id', $ttk->id)->first();
        //$header = Formulation::where('ttk_id', $ttk->id)->first();
        //if ($requirement != null)
        //    $requirement = 1;
        //if ($header != null)
        //    $header = 1;
        //$rTtk =  $ttk->getAllRelatedRecords();

        $data = ["id" => $ttk->id, "name" => $ttk->name, "image" => $ttk->image, 'category_id' => $ttk->category_id,
            'category_name' => $ttk->category->name, 'public' => $ttk->public];

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
        $ttk->category_id = $request->category_id;
        $ttk->user_id = auth()->id();
        if ($ttk->public) {
            if ($ttk->public == "on") {
                $ttk->public = 1;
            }
        } else {
            $ttk->public = 0;
        }
        if ($request->image) {
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
        $data = $request->validated();

        $ttk->name = $data['name'];

        if ($request->public == "1") {
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
            'message' => "Ttk updated",
            'data' => $ttk,
        ], 200);
    }
}
