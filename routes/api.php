<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\ProductColorController;
use App\Http\Controllers\Api\ProductSizeController;
use App\Http\Controllers\Api\ProductTransactionController;
use App\Http\Controllers\Api\StoreTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ProductUnitController;

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

Route::group(['prefix' => 'category'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('store', [CategoryController::class, 'store']);
    Route::get('update', [CategoryController::class, 'update']);
    Route::get('delete', [CategoryController::class, 'delete']);
});


Route::group(['prefix' => 'product'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('store', [ProductController::class, 'store']);
    Route::post('update/{id}', [ProductController::class, 'update']);
    Route::get('delete/{id}', [ProductController::class, 'delete']);

    Route::get('units', [ProductUnitController::class, 'index']);
    Route::post('unit/store', [ProductUnitController::class, 'store']);
    Route::post('unit/update/{id}', [ProductUnitController::class, 'update']);
    Route::get('unit/delete/{id}', [ProductUnitController::class, 'delete']);

    Route::get('sizes', [ProductSizeController::class, 'index']);
    Route::post('size/store', [ProductSizeController::class, 'store']);
    Route::post('size/update/{id}', [ProductSizeController::class, 'update']);
    Route::get('size/delete/{id}', [ProductSizeController::class, 'delete']);

    Route::get('colors', [ProductColorController::class, 'index']);
    Route::post('color/store', [ProductColorController::class, 'store']);
    Route::post('color/update/{id}', [ProductColorController::class, 'update']);
    Route::get('color/delete/{id}', [ProductColorController::class, 'delete']);
});

Route::group(['prefix' => 'unit'], function () {
    Route::get('/', [UnitController::class, 'index']);
    Route::post('store', [UnitController::class, 'store']);
    Route::post('update', [UnitController::class, 'update']);
    Route::get('delete', [UnitController::class, 'delete']);
});



Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notification/store', [NotificationController::class, 'store']);

//Product
Route::group(['prefix' => 'products'], function () {

    //ProductTransaction
    Route::get('productTransactions', [ProductTransactionController::class, 'index']);
    Route::get('showProductTransactions/{id}', [ProductTransactionController::class, 'show']);
    Route::post('storeProductTransactions', [ProductTransactionController::class, 'store']);
});


//store
Route::group(['prefix' => 'stores'], function () {

    //StoreTransaction
    Route::get('storeTransactions', [StoreTransactionController::class, 'index']);
    Route::get('showStoreTransactions/{id}', [StoreTransactionController::class, 'show']);
    Route::post('addStoreTransactions', [StoreTransactionController::class, 'store']);
    Route::get('showStoreItems', [StoreTransactionController::class, 'show_products']);
    Route::get('showStoreOneItem/{id}', [StoreTransactionController::class, 'show_one_product']);

    //stores handling
    Route::get('storeList', [StoreController::class, 'index']);
    Route::get('showStore/{id}', [StoreController::class, 'show']);
    Route::post('addStore', [StoreController::class, 'store']);
    Route::put('updateStore/{id}', [StoreController::class, 'update']);
    Route::delete('deleteStore/{id}', [StoreController::class, 'destroy']);
});

//  branches 
Route::group(['prefix' => 'branches'], function () {
    Route::get('branchList', [BranchController::class, 'index']);
    Route::get('showBranch/{id}', [BranchController::class, 'show']);
    Route::post('addBranch', [BranchController::class, 'store']);
    Route::put('updateBranch/{id}', [BranchController::class, 'update']);
    Route::delete('deleteBranch/{id}', [BranchController::class, 'destroy']);
});
