<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['namespace' => 'Product'], function(){
    Route::get('/products', 'IndexController')->name('product.index');
    Route::get('/products/create',"CreateController")->name("product.create");
    Route::post('/products', 'StoreController')->name(name:'product.store');
    Route::get('/products/{product}', 'ShowController')->name('product.show');
    Route::get('/products/{product}/edit', 'EditController')->name('product.edit');
    Route::patch('/products/{product}', 'UpdateController')->name('product.update');
    Route::delete('/products/{product}', 'DestroyController')->name('product.delete');
});

Route::group(['namespace' => 'TTK'], function(){
    Route::get('/ttks', 'IndexController')->name('ttk.index');
    Route::get('/ttks/create', 'CreateController')->name('ttk.create');
    Route::get('/ttks/store', 'StoreController')->name('ttk.store');
    Route::get('/ttks/{ttk}/menu', 'MenuController')->name('ttk.menu');
    Route::post('/ttks', 'StoreController')->name(name:'ttk.store');
    Route::get('/ttks/{ttk}', 'ShowController')->name('ttk.show');
    Route::get('/ttks/{ttk}/edit', 'EditController')->name('ttk.edit');
    Route::patch('/ttks/{ttk}', 'UpdateController')->name('ttk.update');
    Route::delete('/ttks/{ttk}', 'DestroyController')->name('ttk.delete');
    Route::get('/ttks/{id}', 'ImageController')->name('ttk.image');
});

Route::group(['namespace' => 'Header'], function(){
    Route::get('ttks/{ttk}/header/create', 'CreateController')->name('header.create');
    Route::post('/ttks/{ttk}/header/store', 'StoreController')->name('header.store');
    Route::get('ttks/{ttk}/header', 'ShowController')->name('header.show');
    Route::get('ttks/{ttk}/header/edit', 'EditController')->name('header.edit');
    Route::patch('ttks/{ttk}/header/', 'UpdateController')->name('header.update');
});

Route::group(['namespace' => 'Requirement'], function(){
    Route::get('ttks//requirement/create', 'CreateController')->name('requirement.create');
    Route::get('ttks/requirement', 'ShowController')->name('requirement.show');
    Route::get('ttks/requirement/edit', 'EditController')->name('requirement.edit');
    Route::patch('ttks/requirement/', 'UpdateController')->name('requirement.update');
}); 

require __DIR__.'/auth.php';

