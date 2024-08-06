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
    Route::group(['prefix' => 'products', 'middleware' => ['role:user']], function () {
        Route::get('/', [ProductController::class, "index"])->name('product.index')->middleware('role:user');
        Route::post('/', [ProductController::class, "store"])->name('product.store')->middleware('role:moderator');
        Route::get('/{product}', [ProductController::class, "show"])->name('product.show')->middleware('role:user');
        Route::patch('/{product}', [ProductController::class, "update"])->name('product.update')->middleware('role:user');
        Route::delete('/{product}', [ProductController::class, "destroy"])->name('product.delete')->middleware('role:admin');
    });

    Route::group(['prefix' => 'ttks', 'middleware' => ['role:user']], function () {
        Route::get('/myTtks', [TtkController::class, "myWorks"])->middleware('role:user');
        Route::get('/', [TtkController::class, "index"])->name('ttk.index')->middleware('role:user');
        Route::get('/{ttk}/menu', [TtkController::class, "menu"])->name('ttk.menu')->middleware('role:user');
        Route::post('/', [TtkController::class, "store"])->name('ttk.store')->middleware('role:user');
        Route::get('/{ttk}', [TtkController::class, "show"])->name('ttk.show')->middleware('role:user');
        Route::patch('/{ttk}', [TtkController::class, "update"])->name('ttk.update')->middleware('role:moderator');
        Route::delete('/{ttk}', [TtkController::class, "destroy"])->name('ttk.delete')->middleware('role:admin');

        Route::group(['middleware' => ['role:user']], function () {
            Route::get('{ttk}/header/', [HeaderController::class, "show"])->name('header.show');
            Route::post('{ttk}/header', [HeaderController::class, "store"])->name('header.store');
            Route::patch('{ttk}/header', [HeaderController::class, "update"])->name('header.update')->middleware('role:moderator');
            Route::delete('{ttk}/header', [HeaderController::class, "delete"])->name('header.delete')->middleware('role:admin');
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/requirement', [RequirementController::class, 'store']);
            Route::get('/{ttk}/requirement', [RequirementController::class, 'show']);
            Route::patch('/{ttk}/requirement/', [RequirementController::class, 'update'])->middleware('role:moderator');
            Route::delete('//{ttk}/requirement/', [RequirementController::class, 'destroy'])->middleware('role:admin');
        });
        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/ttks/{ttk}/formulation', [ForemulationController::class, 'store'])->name('formulation.store');
            Route::get('ttks/{ttk}/formulation', [ForemulationController::class, 'show'])->name('formulation.show');
            Route::patch('ttks/{ttk}/formulation/', [[ForemulationController::class, 'update']])->name('formulation.update')->middleware('role:moderator');
            Route::delete('/ttks/{ttk}/formulation/', [[ForemulationController::class, 'destroy']])->name('formulation.delete')->middleware('role:admin');
        });
    });
});
