<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\TtkController;
use \App\Http\Controllers\HeaderController;
use \App\Http\Controllers\RequirementController;
use \App\Http\Controllers\ForemulationController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => ["auth:sanctum"]], function (){
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
        Route::patch('/{ttk}/publish', [TtkController::class, "publish"]);
        //Route::get('/', [TtkController::class, "index"])->middleware('role:moderator');
        Route::get('/{ttk}/menu', [TtkController::class, "menu"]);
        Route::post('/', [TtkController::class, "store"]);
        Route::get('/{ttk}', [TtkController::class, "show"]);
        Route::patch('/{ttk}', [TtkController::class, "update"]);
        Route::delete('/{ttk}', [TtkController::class, "destroy"]);

        Route::group(['middleware' => ['role:user']], function () {
            Route::get('{ttk}/header/', [HeaderController::class, "show"]);
            Route::post('{ttk}/header', [HeaderController::class, "store"]);
            Route::patch('{ttk}/header', [HeaderController::class, "update"])->middleware('role:moderator');
            Route::delete('{ttk}/header', [HeaderController::class, "delete"])->middleware('role:admin');
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/requirement', [RequirementController::class, 'store']);
            Route::get('/{ttk}/requirement', [RequirementController::class, 'show']);
            Route::patch('/{ttk}/requirement/', [RequirementController::class, 'update'])->middleware('role:moderator');
            Route::delete('//{ttk}/requirement/', [RequirementController::class, 'destroy'])->middleware('role:admin');
        });
        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/ttks/{ttk}/formulation', [ForemulationController::class, 'store']);
            Route::get('ttks/{ttk}/formulation', [ForemulationController::class, 'show']);
            Route::patch('ttks/{ttk}/formulation/', [[ForemulationController::class, 'update']])->middleware('role:moderator');
            Route::delete('/ttks/{ttk}/formulation/', [[ForemulationController::class, 'destroy']])->middleware('role:admin');
        });
    });
});
