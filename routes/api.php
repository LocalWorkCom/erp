<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\ApiCodeController;
use App\Http\Controllers\Api\ProductColorController;
use App\Http\Controllers\Api\ProductSizeController;
use App\Http\Controllers\Api\ProductTransactionController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\StoreTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\OpeningBalanceController;
use App\Http\Controllers\Api\VendorController;
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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"])->name('login');
Route::post("resetpassword", [AuthController::class, "reset_password"]);
Route::group(['prefix' => 'api_code'], function () {
    Route::get('/', [ApiCodeController::class, 'index']);
    Route::post('store', [ApiCodeController::class, 'store']);
    Route::post('update/{id}', [ApiCodeController::class, 'update']);
});

Route::group(["middleware" => ["auth:api"]], function () {

    Route::any("profile", [AuthController::class, "profile"]);
    Route::any("logout", [AuthController::class, "logout"]);


    //Color
    Route::group(['prefix' => 'color'], function () {
        Route::any('/', [ColorController::class, 'index']);
        Route::any('/add', [ColorController::class, 'store']);
        Route::any('/get', [ColorController::class, 'show']);
        Route::any('/edit', [ColorController::class, 'update']);
        Route::any('/delete', [ColorController::class, 'destroy']);
    });
     //end color
    //Size
    Route::group(['prefix' => 'size'], function () {
        Route::any('/', [SizeController::class, 'index']);
        Route::any('/add', [SizeController::class, 'store']);
        Route::any('/get', [SizeController::class, 'show']);
        Route::any('/edit', [SizeController::class, 'update']);
        Route::any('/delete', [SizeController::class, 'destroy']);
    });
     //end Size
    //Country
    Route::group(['prefix' => 'country'], function () {
        Route::any('/', [CountryController::class, 'index']);
        Route::any('/add', [CountryController::class, 'store']);
        Route::any('/get', [CountryController::class, 'show']);
        Route::any('/edit', [CountryController::class, 'update']);
        Route::any('/delete', [CountryController::class, 'destroy']);
    });
    //end Country

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('store', [CategoryController::class, 'store']);
        Route::post('update/{id}', [CategoryController::class, 'update']);
        Route::get('delete/{id}', [CategoryController::class, 'delete']);
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
    Route::post('notification/store', [NotificationController::class, 'store']);
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
    // start opening balance
    Route::group(['prefix' => 'opiningBalance'], function () {
        Route::any('/', [OpeningBalanceController::class, 'index']);
        Route::any('/add', [OpeningBalanceController::class, 'store']);
        Route::any('/get', [OpeningBalanceController::class, 'show']);
        Route::any('/edit', [OpeningBalanceController::class, 'update']);
        Route::any('/delete', [OpeningBalanceController::class, 'destroy']);
    });
    // end opening balance

});



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
    Route::post('restoreBranch/{id}', [BranchController::class, 'restore']);
});

// vendors
Route::group(['prefix' => 'vendors'], function () {
    Route::get('vendorList', [VendorController::class, 'index']);
    Route::get('showVendor/{id}', [VendorController::class, 'show']);
    Route::post('addVendor', [VendorController::class, 'store']);
    Route::put('updateVendor/{id}', [VendorController::class, 'update']);
    Route::delete('deleteVendor/{id}', [VendorController::class, 'destroy']);
    Route::post('restoreVendor/{id}', [VendorController::class, 'restore']);
});
