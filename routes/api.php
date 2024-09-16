<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\ProductColorController;
use App\Http\Controllers\Api\ProductSizeController;
use App\Http\Controllers\Api\ProductUnitontroller;

use App\Http\Controllers\Api\ProductTransactionController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\StoreTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\AuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"])->name('login');

Route::group(["middleware" => ["auth:api"]], function () {

    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("logout", [AuthController::class, "logout"]);


    //Color
    Route::group(['prefix' => 'color'], function () {
        Route::get('/', [ColorController::class, 'index']);
        Route::post('/add', [ColorController::class, 'store']);
        Route::get('/get', [ColorController::class, 'show']);
        Route::post('/edit', [ColorController::class, 'update']);
        Route::get('/delete', [ColorController::class, 'destroy']);
    });
    //Size
    Route::group(['prefix' => 'size'], function () {
        Route::get('/', [SizeController::class, 'index']);
        Route::post('/add', [SizeController::class, 'store']);
        Route::get('/get', [SizeController::class, 'show']);
        Route::post('/edit', [SizeController::class, 'update']);
        Route::get('/delete', [SizeController::class, 'destroy']);
    });
    //Country
    Route::group(['prefix' => 'country'], function () {
        Route::get('/', [CountryController::class, 'index']);
        Route::post('/add', [CountryController::class, 'store']);
        Route::get('/get', [CountryController::class, 'show']);
        Route::post('/edit', [CountryController::class, 'update']);
        Route::get('/delete', [CountryController::class, 'destroy']);
    });

    //Opening balance

});
Route::get('categories', [CategoryController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('notifications', [NotificationController::class, 'index']);
Route::get('units', [UnitController::class, 'index']);
Route::get('productColors', [ProductColorController::class, 'index']);
Route::get('productSizes', [ProductSizeController::class, 'index']);
Route::get('productUnits', [ProductUnitontroller::class, 'index']);

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
