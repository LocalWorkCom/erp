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
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\OpeningBalanceController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ProductUnitController;
use App\Http\Controllers\Api\LineController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\ShelfController;
use App\Http\Controllers\Api\FloorController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderRefundController;
use App\Http\Controllers\Api\OrderTrackingController;
use App\Http\Controllers\Api\OrderTransactionController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\pointsController;
use App\Http\Controllers\Api\RecipeCategoryController;
use App\Http\Controllers\Api\CuisineController;
use App\Http\Controllers\Api\AddonController;
use App\Http\Controllers\Api\OrderReportController;
use App\Http\Controllers\Api\PurchaseInvoiceController;

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

    Route::get("profile", [ClientController::class, "viewProfile"]);
    Route::post("profile/update", [ClientController::class, "updateProfile"]);

    Route::get("client/orders", [ClientController::class, "listOrders"]);
    Route::post('client/orders/reorder/{orderId}', [ClientController::class, 'reorder']);
    Route::get('client/orders/track/{orderId}', [ClientController::class, 'trackOrder']);

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

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('store', [OrderController::class, 'store']);
    });
    Route::group(['prefix' => 'order_refund'], function () {
        Route::get('/', [OrderRefundController::class, 'index']);
        Route::post('store', [OrderRefundController::class, 'store']);
        Route::post('change_status', [OrderRefundController::class, 'change_status']);
    });
    Route::group(['prefix' => 'order_tracking'], function () {
        Route::post('/', [OrderTrackingController::class, 'index']);
        Route::post('store', [OrderTrackingController::class, 'store']);
    });
    Route::group(['prefix' => 'order_transaction'], function () {
        Route::post('/', [OrderTransactionController::class, 'index']);
        Route::post('store', [OrderTransactionController::class, 'store']);
    });
    Route::group(['prefix' => 'order-report'], function () {
        Route::post('/', [OrderReportController::class, 'OrderReport']);
        Route::post('/details', [OrderReportController::class, 'OrderReportDetails']);
        Route::post('/refund', [OrderReportController::class, 'OrderRefundReport']);
        Route::post('/refund/details', [OrderReportController::class, 'OrderRefundReportDetails']);
    });
    Route::group(['prefix' => 'unit'], function () {
        Route::get('/', [UnitController::class, 'index']);
        Route::post('store', [UnitController::class, 'store']);
        Route::post('update', [UnitController::class, 'update']);
        Route::get('delete/{id}', [UnitController::class, 'delete']);
    });
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notification/store', [NotificationController::class, 'store']);

    //Transactions
    Route::group(['prefix' => 'transactions'], function () {
        //StoreTransaction
        Route::get('store', [StoreTransactionController::class, 'index']);
        Route::post('add', [StoreTransactionController::class, 'store']);
        Route::get('showStore/{id}', [StoreTransactionController::class, 'show']);
        Route::get('products', [ProductTransactionController::class, 'index']);
        Route::get('showProduct/{id}', [ProductTransactionController::class, 'show']);
    });

    //store
    Route::group(['prefix' => 'stores'], function () {
        //stores handling
        Route::get('storeList', [StoreController::class, 'index']);
        Route::get('showStore/{id}', [StoreController::class, 'show']);
        Route::post('addStore', [StoreController::class, 'store']);
        Route::put('updateStore/{id}', [StoreController::class, 'update']);
        Route::delete('deleteStore/{id}', [StoreController::class, 'destroy']);
        Route::post('restoreStore/{id}', [BranchController::class, 'restore']);
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


    //Lines
    Route::group(['prefix' => 'lines'], function () {
        Route::get('lineList', [LineController::class, 'index']);
        Route::get('showLine/{id}', [LineController::class, 'show']);
        Route::post('addLine', [LineController::class, 'store']);
        Route::put('updateLine/{id}', [LineController::class, 'update']);
        Route::delete('deleteLine/{id}', [LineController::class, 'destroy']);
        Route::post('restoreLine/{id}', [LineController::class, 'restore']); // Restore soft-deleted line
    });


    // Divisions
    Route::group(['prefix' => 'divisions'], function () {
        Route::get('divisionList', [DivisionController::class, 'index']);
        Route::get('showDivision/{id}', [DivisionController::class, 'show']);
        Route::post('addDivision', [DivisionController::class, 'store']);
        Route::put('updateDivision/{id}', [DivisionController::class, 'update']);
        Route::delete('deleteDivision/{id}', [DivisionController::class, 'destroy']);
        Route::post('restoreDivision/{id}', [DivisionController::class, 'restore']); // Restore route
    });

    // Shelves
    Route::group(['prefix' => 'shelves'], function () {
        Route::get('shelfList', [ShelfController::class, 'index']);
        Route::get('showShelf/{id}', [ShelfController::class, 'show']);
        Route::post('addShelf', [ShelfController::class, 'store']);
        Route::put('updateShelf/{id}', [ShelfController::class, 'update']);
        Route::delete('deleteShelf/{id}', [ShelfController::class, 'destroy']);
        Route::post('restoreShelf/{id}', [ShelfController::class, 'restore']);
    });



    Route::group(['prefix' => 'recipes'], function () {
        Route::get('recipeList', [RecipeController::class, 'index'])->name('recipes.index'); // Fetch all recipes
        Route::post('addRecipe', [RecipeController::class, 'store'])->name('recipes.store'); // Create a new recipe (with ingredients)
        Route::get('showRecipe/{id}', [RecipeController::class, 'show'])->name('recipes.show'); // Fetch a specific recipe by ID
        Route::put('updateRecipe/{id}', [RecipeController::class, 'update'])->name('recipes.update'); // Update a recipe (with ingredients)
        Route::delete('deleteRecipe/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy'); // Soft delete a recipe
        Route::post('restoreRecipe/{id}', [RecipeController::class, 'restore'])->name('recipes.restore'); // Restore a soft-deleted recipe
    });


    //floors
    Route::group(['prefix' => 'floors'], function () {
        //StoreTransaction
        Route::get('index', [FloorController::class, 'index']);
        Route::post('add', [FloorController::class, 'add']);
        Route::post('edit', [FloorController::class, 'edit']);
        Route::get('delete/{id}', [FloorController::class, 'delete']);
    });

    //tables
    Route::group(['prefix' => 'tables'], function () {
        //StoreTransaction
        Route::get('index', [TableController::class, 'index']);
        Route::post('add', [TableController::class, 'add']);
        Route::post('edit', [TableController::class, 'edit']);
        Route::get('delete/{id}', [TableController::class, 'delete']);
    });

    // Discounts
    Route::group(['prefix' => 'discounts'], function () {
        Route::get('discountList', [DiscountController::class, 'index']);
        Route::get('showDiscount/{id}', [DiscountController::class, 'show']);
        Route::post('addDiscount', [DiscountController::class, 'store']);
        Route::put('updateDiscount/{id}', [DiscountController::class, 'update']);
        Route::delete('deleteDiscount/{id}', [DiscountController::class, 'destroy']);
        Route::post('restoreDiscount/{id}', [DiscountController::class, 'restore']);
    });

    // Coupons
    Route::group(['prefix' => 'coupons'], function () {
        Route::get('couponList', [CouponController::class, 'index']);
        Route::get('showCoupon/{id}', [CouponController::class, 'show']);
        Route::post('addCoupon', [CouponController::class, 'store']);
        Route::put('updateCoupon/{id}', [CouponController::class, 'update']);
        Route::delete('deleteCoupon/{id}', [CouponController::class, 'destroy']);
        Route::post('restoreCoupon/{id}', [CouponController::class, 'restore']);
    });

    // Recipe Categories
    Route::group(['prefix' => 'recipe-categories'], function () {
        Route::get('categoryList', [RecipeCategoryController::class, 'index']);
        Route::get('showCategory/{id}', [RecipeCategoryController::class, 'show']);
        Route::post('addCategory', [RecipeCategoryController::class, 'store']);
        Route::put('updateCategory/{id}', [RecipeCategoryController::class, 'update']);
        Route::delete('deleteCategory/{id}', [RecipeCategoryController::class, 'destroy']);
        Route::post('restoreCategory/{id}', [RecipeCategoryController::class, 'restore']);
    });

    //cuisines
    Route::prefix('cuisines')->group(function () {
        Route::get('cuisineList', [CuisineController::class, 'index'])->name('cuisines.list');
        Route::post('addCuisine', [CuisineController::class, 'store'])->name('cuisines.add');
        Route::get('showCuisine/{id}', [CuisineController::class, 'show'])->name('cuisines.show');
        Route::put('updateCuisine/{id}', [CuisineController::class, 'update'])->name('cuisines.update');
        Route::delete('deleteCuisine/{id}', [CuisineController::class, 'destroy'])->name('cuisines.delete');
        Route::post('restoreCuisine/{id}', [CuisineController::class, 'restore'])->name('cuisines.restore');
    });

    //addons
    Route::prefix('addons')->group(function () {
        Route::get('/addonList', [AddonController::class, 'index'])->name('addons.index');
        Route::get('/showAddon/{id}', [AddonController::class, 'show'])->name('addons.show');
        Route::post('/addAddon', [AddonController::class, 'store'])->name('addons.store');
        Route::put('/updateAddon/{id}', [AddonController::class, 'update'])->name('addons.update');
        Route::delete('/deleteAddon/{id}', [AddonController::class, 'destroy'])->name('addons.destroy');
        Route::post('/restoreAddon/{id}', [AddonController::class, 'restore'])->name('addons.restore');
    });

    //purchase_invoice
    Route::prefix('purchase-invoices')->group(function () {
        Route::get('/', [PurchaseInvoiceController::class, 'index'])->name('purchase-invoices.index');
        Route::post('/', [PurchaseInvoiceController::class, 'store'])->name('purchase-invoices.store');
        Route::put('/{id}', [PurchaseInvoiceController::class, 'update'])->name('purchase-invoices.update');
        Route::get('/{id}', [PurchaseInvoiceController::class, 'show'])->name('purchase-invoices.show');
    });

    // point-system
    Route::prefix('point_system')->group(function () {
        Route::get('/', [pointsController::class, 'index']);
        // Route::post('/', [pointsController::class, 'store']);// it not allow to add any system
        Route::get('/{id}', [pointsController::class, 'show']);
        Route::post('/{id}', [pointsController::class, 'update']);
        Route::delete('/{id}', [pointsController::class, 'destroy']);
        Route::prefix('transactions')->group(function () {
            
        });
    });

    //Reports
    Route::prefix('reports')->group(function () {
        //purchase-invoices Reports
        Route::prefix('purchase-invoices')->group(function () {
            Route::get('/', [PurchaseInvoiceController::class, 'getPurchaseInvoiceReport']);
        });
    });
});
