<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
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
    return view('dashboards.index5');
})->name('home');
// Route::middleware('auth:web')->group(function () {

Route::get('/products', [ProductController::class, 'index'])->name('products.list');
Route::group(['prefix' => 'product'], function () {
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('store', [ProductController::class, 'store'])->name('product.store');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    // Route::get('units', [ProductUnitController::class, 'index']);
    // Route::post('unit/store', [ProductUnitController::class, 'store']);
    // Route::post('unit/update/{id}', [ProductUnitController::class, 'update']);
    // Route::get('unit/delete/{id}', [ProductUnitController::class, 'delete']);
    // Route::get('sizes', [ProductSizeController::class, 'index']);
    // Route::post('size/store', [ProductSizeController::class, 'store']);
    // Route::post('size/update/{id}', [ProductSizeController::class, 'update']);
    // Route::get('size/delete/{id}', [ProductSizeController::class, 'delete']);
    // Route::get('colors', [ProductColorController::class, 'index']);
    // Route::post('color/store', [ProductColorController::class, 'store']);
    // Route::post('color/update/{id}', [ProductColorController::class, 'update']);
    // Route::get('color/delete/{id}', [ProductColorController::class, 'delete']);
    // Route::get('{id}/inventory', [ProductInventoryController::class, 'getInventory']);
});
// });
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.list');
Route::group(['prefix' => 'category'], function () {
    Route::get('create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
});
