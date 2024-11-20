<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UnitController;
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

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('set-locale');

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
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
});
Route::get('/units', [UnitController::class, 'index'])->name('units.list');
Route::group(['prefix' => 'unit'], function () {
    Route::post('store', [UnitController::class, 'store']);
    Route::post('update', [UnitController::class, 'update']);
    Route::get('delete/{id}', [UnitController::class, 'delete']);
});
Route::get('/countries', [CountryController::class, 'index'])->name('countries.list');

Route::group(['prefix' => 'country'], function () {
    Route::any('/add', [CountryController::class, 'store']);
    Route::any('/get', [CountryController::class, 'show']);
    Route::any('/edit', [CountryController::class, 'update']);
    Route::any('/delete', [CountryController::class, 'destroy']);
});