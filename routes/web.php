<?php

use App\Http\Controllers\Dashboard\BranchController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SizeController;
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
    Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
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
    Route::get('show/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
});
Route::get('/countries', [CountryController::class, 'index'])->name('countries.list');
Route::group(['prefix' => 'country'], function () {

    Route::post('store', [CountryController::class, 'store'])->name('country.store');
    Route::post('update/{id}', [CountryController::class, 'update'])->name('country.update');
    Route::get('delete/{id}', [CountryController::class, 'delete'])->name('country.delete');
});

Route::get('/units', [UnitController::class, 'index'])->name('units.list');
Route::group(['prefix' => 'unit'], function () {
    Route::post('store', [UnitController::class, 'store'])->name('unit.store');
    Route::put('update/{id}', [UnitController::class, 'update'])->name('unit.update');
    Route::delete('delete/{id}', [UnitController::class, 'delete'])->name('unit.delete');
});

Route::get('/colors', [ColorController::class, 'index'])->name('colors.list');
Route::group(['prefix' => 'color'], function () {
    Route::post('store', [ColorController::class, 'store'])->name('color.store');
    Route::put('update/{id}', [ColorController::class, 'update'])->name('color.update');
    Route::delete('delete/{id}', [ColorController::class, 'delete'])->name('color.delete');
});

Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.list');
Route::group(['prefix' => 'size'], function () {
    Route::post('store', [SizeController::class, 'store'])->name('size.store');
    Route::put('update/{id}', [SizeController::class, 'update'])->name('size.update');
    Route::delete('delete/{id}', [SizeController::class, 'delete'])->name('size.delete');
});

Route::group(['prefix' => 'country'], function () {
    Route::any('/add', [CountryController::class, 'store']);
    Route::any('/get', [CountryController::class, 'show']);
    Route::any('/edit', [CountryController::class, 'update']);
    Route::any('/delete', [CountryController::class, 'destroy']);
});

Route::get('/branches', [BranchController::class, 'index'])->name('branches.list');
Route::group(['prefix' => 'branch'], function () {
    Route::get('create', [BranchController::class, 'create'])->name('branch.create');
    Route::post('store', [BranchController::class, 'store'])->name('branch.store');
    Route::get('show/{id}', [BranchController::class, 'show'])->name('branch.show');
    Route::get('edit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
    Route::put('update/{id}', [BranchController::class, 'update'])->name('branch.update');
    Route::delete('delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');
});
