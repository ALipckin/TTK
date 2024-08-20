<?php

namespace App\Http\Controllers;


use App\Http\Filters\PackageFilter;
use App\Http\Requests\Package\FilterRequest;
use App\Http\Requests\Package\StoreRequest;
use App\Http\Requests\Package\UpdateRequest;
use App\Http\Resources\Package\PackageResource;
use App\Models\Package;
use Illuminate\Routing\Controller;

class PackageController extends Controller
{
    public function destroy(Package $package)
    {
        $package->delete();
        return response()->json([
            'status' => true,
            'message' => "Deleted Successfully",
        ], 204);
    }

    public function index(FilterRequest $request)
    {
        $data = $request->all();

        $filter = app()->make(PackageFilter::class, ['queryParams' => array_filter($data)]);
        $packages = Package::filter($filter)->get();

        return response()->json([
            'status' => true,
            'message' => "Package data",
            'data' => $packages,
        ], 200);
    }

    public function show(Package $package)
    {
        $package = Package::find($package->id);
        return response()->json([
            'status' => true,
            'message' => "Package data",
            'data' => new $package,
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $package = Package::create($data);

        return response()->json([
            'status' => true,
            'message' => "Package created",
            'data' => $package,
        ], 201);
    }

    public function update(Package $package, UpdateRequest $request)
    {
        $data = $request->validated();

        $package->update($data);

        return response()->json([
            'status' => true,
            'message' => "ttk updated",
            'data' => $package,
        ], 200);
    }
}
