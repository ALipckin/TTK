<?php

use App\Http\Controllers\FormulationController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualityRequirementController;
use App\Http\Controllers\RealizationRequirementController;
use App\Http\Controllers\ScopeController;
use App\Http\Controllers\TpController;
use App\Http\Controllers\TtkController;
use App\Http\Controllers\NeValueController;
use App\Http\Controllers\OrgCharacteristicController;
use App\Http\Controllers\PhysChemParamsController;
use App\Http\Controllers\MicrobioParamsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => ["auth:sanctum", "updateLastVisit"]], function () {
    //Пользователь
    Route::group(['prefix' => 'profile', 'middleware' => ['role:user']], function () {
        Route::get('/', [ProfileController::class, "index"])->middleware('role:user');
        Route::get('/my', [ProfileController::class, "my"])->middleware('role:user');
        Route::get('/{user}', [ProfileController::class, "show"])->middleware('role:user');
        Route::post('/upload-avatar', [ProfileController::class, 'uploadAvatar']);
    });

    //Продукты
    Route::group(['prefix' => 'products', 'middleware' => ['role:user']], function () {
        Route::get('/', [ProductController::class, "index"]);
        Route::get('/{id}/treatments', [ProductController::class, "treatments"])->middleware('verifyOwner:Product');
        Route::get('/my', [ProductController::class, "my"]);
        Route::get('/all_categories', [ProductController::class, "categories_index"]);
        Route::get('/{id}', [ProductController::class, "show"])->middleware('verifyOwner:Product');
        Route::post('/', [ProductController::class, "store"])->middleware('role:moderator');
        Route::patch('/{id}', [ProductController::class, "update"])->middleware('verifyOwner:Product');
        Route::delete('/{id}', [ProductController::class, "destroy"])->middleware('verifyOwner:Product');
    });
    //Технико технологическая карта
    Route::group(['prefix' => 'ttks', 'middleware' => ['role:user']], function () {
        Route::get('/all_categories', [TtkController::class, "categories_index"]);
        Route::get('/my', [TtkController::class, "myTTKs"]);
        Route::get('/', [TtkController::class, "index"]);
        Route::get('/{ttk}', [TtkController::class, "show"])->middleware(['checkPublicity']);
        Route::post('/', [TtkController::class, "store"]);
        Route::delete('/{ttk}', [TtkController::class, "destroy"])->middleware(['verifyOwner:Ttk']);
        Route::patch('/{ttk}/publish', [TtkController::class, "publish"])->middleware(['verifyOwner:Ttk']);;
        Route::patch('/{ttk}', [TtkController::class, "update"])->middleware(['verifyOwner:Ttk']);

        //Шапка
        Route::group(['middleware' => ['role:user']], function () {
            Route::get('/{ttk}/header', [HeaderController::class, "show"])->middleware(['checkPublicity']);
            Route::post('/{ttk}/header', [HeaderController::class, "store"]);
            Route::patch('/{ttk}/header', [HeaderController::class, "update"])->middleware(['verifyOwner:Ttk']);
            Route::delete('/{ttk}/header', [HeaderController::class, "destroy"])->middleware(['verifyOwner:Ttk']);
        });

        //Область применения
        Route::group(['middleware' => ['role:user']], function () {
            Route::get('/{ttk}/scopes', [ScopeController::class, "index"])->middleware(['checkPublicity']);
            Route::post('/{ttk}/scopes', [ScopeController::class, "store"]);
            Route::patch('/{ttk}/scopes/{id}', [ScopeController::class, "update"])->middleware(['verifyOwner:Ttk,Scope']);
            Route::delete('/{ttk}/scopes/{id}', [ScopeController::class, "destroy"])->middleware(['verifyOwner:Ttk,Scope']);
        });

        //Требования к качеству сырья
        Route::group(['middleware' => ['role:user']], function () {
            Route::get('/{ttk}/quality-requirements', [QualityRequirementController::class, 'index'])->middleware(['checkPublicity']);
            Route::post('/{ttk}/quality-requirements', [QualityRequirementController::class, 'store']);
            Route::patch('/{ttk}/quality-requirements/{id}', [QualityRequirementController::class, 'update'])->middleware(['verifyOwner:Ttk,QualityRequirement']);
            Route::delete('/{ttk}/quality-requirements/{id}', [QualityRequirementController::class, 'destroy'])->middleware(['verifyOwner:Ttk,QualityRequirement']);
        });

        //Требования к оформлению и подаче
        Route::group(['middleware' => ['role:user']], function () {
            Route::get('/{ttk}/realization-requirements', [RealizationRequirementController::class, 'index'])->middleware(['checkPublicity']);
            Route::post('/{ttk}/realization-requirements', [RealizationRequirementController::class, 'store']);
            Route::patch('/{ttk}/realization-requirements/{id}', [RealizationRequirementController::class, 'update'])->middleware(['verifyOwner:Ttk,RealizationRequirement']);
            Route::delete('/{ttk}/realization-requirements/{id}', [RealizationRequirementController::class, 'destroy'])->middleware(['verifyOwner:Ttk,RealizationRequirement']);
        });

        //Описание тех. процесса
        Route::group(['middleware' => ['role:user']], function () {
            Route::get('/{ttk}/tps', [TpController::class, 'index'])->middleware(['checkPublicity']);
            Route::post('/{ttk}/tps', [TpController::class, 'store']);
            Route::patch('/{ttk}/tps/{id}', [TpController::class, 'update'])->middleware(['verifyOwner:Ttk, Tp']);
            Route::delete('/{ttk}/tps/{id}', [TpController::class, 'destroy'])->middleware(['verifyOwner:Ttk, Tp']);
        });

        //Рецептура
        Route::group(['middleware' => ['role:user']], function () {
            Route::get('/{ttk}/formulations', [FormulationController::class, 'index'])->middleware(['checkPublicity']);
            //принадлежности formulation к ttk внутри метода котроллера
            Route::put('/{ttk}/formulations/{id}', [FormulationController::class, 'createOrUpdate']);
            Route::delete('/{ttk}/formulations/{id}', [FormulationController::class, 'destroy'])->middleware(['verifyOwner:Ttk,Formulation']);
        });

        //Показатели качества и безопасности
        //Органолептические показатели
        Route::group(['middleware' => ['role:user']], function () {
            Route::get('/{ttk}/org_characteristics', [OrgCharacteristicController::class, 'show']);
            Route::put('/{ttk}/org_characteristics', [OrgCharacteristicController::class, 'createOrUpdate'])->middleware(['verifyOwner:Ttk']);
            Route::delete('/{ttk}/org_characteristics', [OrgCharacteristicController::class, 'destroy'])->middleware(['verifyOwner:Ttk,OrgCharacteristic']);
        });

        //Пищевая и энергетическая ценность
        Route::get('/{ttk}/ne_value', [NeValueController::class, 'result']);
        Route::get('/{ttk}/phys_chem_params', [PhysChemParamsController::class, 'index']);
        Route::get('/{ttk}/microbio_params', [MicrobioParamsController::class, 'index']);
    });
});
