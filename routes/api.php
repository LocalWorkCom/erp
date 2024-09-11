<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductTransactionController;
use App\Http\Controllers\Api\StoreTransactionController;
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
Route::get('categories', [CategoryController::class, 'index']);

//Product
Route::group(['prefix' => 'products'], function(){

    //ProductTransaction
    Route::get('productTransactions', [ProductTransactionController::class, 'index']);
    Route::get('showProductTransactions/{id}', [ProductTransactionController::class, 'show']);
    Route::post('storeProductTransactions', [ProductTransactionController::class, 'store']);
});


//store
Route::group(['prefix' => 'stores'], function(){


    //StoreTransaction
    Route::get('storeTransactions', [StoreTransactionController::class, 'index']);
    Route::get('showStoreTransactions/{id}', [StoreTransactionController::class, 'show']);
    Route::post('addStoreTransactions', [StoreTransactionController::class, 'store']);

});


