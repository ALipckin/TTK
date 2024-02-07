<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
//'middleware' => 'jwt.auth'

Route::group(['namespace' => 'Product'], function(){
    Route::get('/products', 'IndexController')->name('product.index');
    Route::post('/products', 'StoreController')->name('product.store');
    Route::get('/products/{product}', 'ShowController')->name('product.show');
    Route::patch('/products/{product}', 'UpdateController')->name('product.update');
    Route::delete('/products/{product}', 'DestroyController')->name('product.delete');
});

Route::group(['namespace' => 'TTK'], function(){
    Route::get('/ttks', 'IndexController')->name('ttk.index');
    Route::get('/ttks/{ttk}/menu', 'MenuController')->name('ttk.menu');
    Route::post('/ttks', 'StoreController')->name('ttk.store');
    Route::get('/ttks/{ttk}', 'ShowController')->name('ttk.show');
    Route::patch('/ttks/{ttk}', 'UpdateController')->name('ttk.update');
    Route::delete('/ttks/{ttk}', 'DestroyController')->name('ttk.delete');
});

Route::group(['namespace' => 'Header'], function(){
    Route::get('/ttks/{ttk}/header', 'ShowController')->name('header.show');
    Route::post('/ttks/{ttk}/header/', 'StoreController')->name('header.store');
    Route::patch('ttks/{ttk}/header/', 'UpdateController')->name('header.update');
    Route::delete('/ttks/{ttk}/header/', 'DestroyController')->name('header.delete');
});

Route::group(['namespace' => 'Requirement'], function(){
    Route::post('/ttks/{ttk}/requirement', 'StoreController')->name('requirement.store');
    Route::get('ttks/{ttk}/requirement', 'ShowController')->name('requirement.show');;
    Route::patch('ttks/{ttk}/requirement/', 'UpdateController')->name('requirement.update');
    Route::delete('/ttks/{ttk}/requirement/', 'DestroyController')->name('requirement.delete');
});

Route::group(['namespace' => 'Header'], function(){
    Route::post('/ttks/{ttk}/header', 'StoreController')->name('header.store');
    Route::get('ttks/{ttk}/header', 'ShowController')->name('header.show');
    Route::patch('ttks/{ttk}/header/', 'UpdateController')->name('header.update');
    Route::delete('/ttks/{ttk}/header/', 'DestroyController')->name('header.delete');
});
