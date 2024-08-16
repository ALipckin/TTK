<?php

use App\Http\Controllers\ForemulationController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualityRequirementController;
use App\Http\Controllers\ScopeController;
use App\Http\Controllers\TtkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::group(['prefix' => 'profile', 'middleware' => ['role:user']], function () {
        Route::get('/', [ProfileController::class, "index"])->middleware('role:user');
    });

    Route::group(['prefix' => 'products', 'middleware' => ['role:user']], function () {
        Route::get('/', [ProductController::class, "index"])->middleware('role:user');
        Route::post('/', [ProductController::class, "store"])->middleware('role:moderator');
        Route::get('/{product}', [ProductController::class, "show"])->middleware('role:user');
        Route::patch('/{product}', [ProductController::class, "update"])->middleware('role:user');
        Route::delete('/{product}', [ProductController::class, "destroy"])->middleware('role:admin');
    });

    Route::group(['prefix' => 'ttks', 'middleware' => ['role:user']], function () {
        Route::get('/my', [TtkController::class, "myTTKs"]);
        Route::get('/public', [TtkController::class, "public"]);
        Route::patch('/{ttk}/publish', [TtkController::class, "publish"])->middleware(['verifyOwner']);;
        //Route::get('/', [TtkController::class, "index"])->middleware('role:moderator');
        Route::post('/', [TtkController::class, "store"]);
        Route::get('/{ttk}', [TtkController::class, "show"])->middleware(['checkPublicity']);
        Route::patch('/{ttk}', [TtkController::class, "update"])->middleware(['verifyOwner']);
        Route::delete('/{ttk}', [TtkController::class, "destroy"])->middleware(['verifyOwner']);;

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/header', [HeaderController::class, "store"]);
            Route::get('/{ttk}/header', [HeaderController::class, "show"])->middleware(['checkPublicity']);
            Route::patch('/{ttk}/header', [HeaderController::class, "update"])->middleware(['verifyOwner']);
            Route::delete('/{ttk}/header', [HeaderController::class, "destroy"])->middleware(['verifyOwner']);
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/scopes', [ScopeController::class, "store"]);
            Route::get('/{ttk}/scopes', [ScopeController::class, "index"])->middleware(['checkPublicity']);
            Route::patch('/{ttk}/scopes/{id}', [ScopeController::class, "update"])->middleware(['verifyOwner:App\Models\Scope']);
            Route::delete('/{ttk}/scopes/{id}', [ScopeController::class, "destroy"])->middleware(['verifyOwner:App\Models\Scope']);
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/quality-requirements', [QualityRequirementController::class, 'store']);
            Route::get('/{ttk}/quality-requirements', [QualityRequirementController::class, 'index'])->middleware(['checkPublicity']);
            Route::patch('/{ttk}/quality-requirements', [QualityRequirementController::class, 'update'])->middleware(['verifyOwner:App\Models\QualityRequirement']);
            Route::delete('/{ttk}/quality-requirements', [QualityRequirementController::class, 'destroy'])->middleware(['verifyOwner:App\Models\QualityRequirement']);
        });
        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/formulation', [ForemulationController::class, 'store']);
            Route::get('/{ttk}/formulation', [ForemulationController::class, 'show'])->middleware(['checkPublicity']);
            Route::patch('/{ttk}/formulation/', [[ForemulationController::class, 'update']])->middleware(['verifyOwner']);
            Route::delete('/{ttk}/formulation/', [[ForemulationController::class, 'destroy']])->middleware(['verifyOwner']);
        });
    });
});
