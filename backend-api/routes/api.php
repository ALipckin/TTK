<?php

use App\Http\Controllers\FormulationController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\QualityRequirementController;
use App\Http\Controllers\ScopeController;
use App\Http\Controllers\TpController;
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

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, "index"]);
        Route::post('/', [ProductController::class, "store"])->middleware('role:moderator');
        Route::get('/my', [ProductController::class, "my"]);
        Route::get('/{id}', [ProductController::class, "show"])->middleware('verifyOwner:Product');
        Route::patch('/{id}', [ProductController::class, "update"])->middleware('verifyOwner:Product');
        Route::delete('/{id}', [ProductController::class, "destroy"])->middleware('verifyOwner:Product');
    });

    Route::group(['prefix' => 'packages'], function () {
        Route::get('/', [PackageController::class, "index"]);
        Route::post('/', [PackageController::class, "store"])->middleware('role:moderator');
        Route::get('/{package}', [PackageController::class, "show"])->middleware('role:user');
        Route::patch('/{package}', [PackageController::class, "update"])->middleware('role:admin');
        Route::delete('/{package}', [PackageController::class, "destroy"])->middleware('role:admin');
    });

    Route::group(['prefix' => 'ttks', 'middleware' => ['role:user']], function () {
        Route::get('/my', [TtkController::class, "myTTKs"]);
        Route::get('/', [TtkController::class, "index"]);
        Route::patch('/{ttk}/publish', [TtkController::class, "publish"])->middleware(['verifyOwner']);;
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
            Route::patch('/{ttk}/scopes/{id}', [ScopeController::class, "update"])->middleware(['verifyOwner:Ttk, Scope']);
            Route::delete('/{ttk}/scopes/{id}', [ScopeController::class, "destroy"])->middleware(['verifyOwner:Ttk,Scope']);
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/quality-requirements', [QualityRequirementController::class, 'store']);
            Route::get('/{ttk}/quality-requirements', [QualityRequirementController::class, 'index'])->middleware(['checkPublicity']);
            Route::patch('/{ttk}/quality-requirements/{id}', [QualityRequirementController::class, 'update'])->middleware(['verifyOwner:App\Models\QualityRequirement']);
            Route::delete('/{ttk}/quality-requirements/{id}', [QualityRequirementController::class, 'destroy'])->middleware(['verifyOwner:App\Models\QualityRequirement']);
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/tps', [TpController::class, 'store']);
            Route::get('/{ttk}/tps', [TpController::class, 'index'])->middleware(['checkPublicity']);
            Route::patch('/{ttk}/tps/{id}', [TpController::class, 'update'])->middleware(['verifyOwner:App\Models\Tp']);
            Route::delete('/{ttk}/tps/{id}', [TpController::class, 'destroy'])->middleware(['verifyOwner:App\Models\Tp']);
        });

        Route::group(['middleware' => ['role:user']], function () {
            Route::post('/{ttk}/formulations', [FormulationController::class, 'store']);
            Route::get('/{ttk}/formulations', [FormulationController::class, 'index'])->middleware(['checkPublicity']);
            Route::patch('/{ttk}/formulations/{id}', [[FormulationController::class, 'update']])->middleware(['verifyOwner:App\Models\Formulation']);
            Route::delete('/{ttk}/formulations/{id}', [[FormulationController::class, 'destroy']])->middleware(['verifyOwner:App\Models\Formulation']);
        });
    });
});
