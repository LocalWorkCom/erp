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
use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\DishCategoryController;
use App\Http\Controllers\Api\ExcuseRequestController;
use App\Http\Controllers\Api\ExcuseSettingController;
use App\Http\Controllers\Api\OvertimeTypeController;
use App\Http\Controllers\Api\OvertimeSettingController;
use App\Http\Controllers\Api\LeaveTypeController;
use App\Http\Controllers\Api\LeaveNationalController;
use App\Http\Controllers\Api\LeaveSettingController;
use App\Http\Controllers\Api\LeaveRequestController;
use App\Http\Controllers\Api\FloorPartitionController;
use App\Http\Controllers\Api\TableReservationController;
use App\Http\Controllers\Api\DeliverySettingController;
use App\Http\Controllers\Api\TimetableController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\EmployeeScheduleController;


use App\Http\Controllers\Api\GiftController;
use App\Http\Controllers\Api\MenuController;


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

//admin
Route::group(['middleware' => ['auth:admin', 'admin']], function () {

    //API_codes
    Route::group(['prefix' => 'api_code'], function () {
        Route::get('/', [ApiCodeController::class, 'index']);
        Route::post('store', [ApiCodeController::class, 'store']);
        Route::post('update/{id}', [ApiCodeController::class, 'update']);
    });

    //purchase_invoice
    Route::prefix('purchase-invoices')->group(function () {
        Route::get('/', [PurchaseInvoiceController::class, 'index'])->name('purchase-invoices.index');
        Route::post('/', [PurchaseInvoiceController::class, 'store'])->name('purchase-invoices.store');
        Route::put('/{id}', [PurchaseInvoiceController::class, 'update'])->name('purchase-invoices.update');
        Route::get('/{id}', [PurchaseInvoiceController::class, 'show'])->name('purchase-invoices.show');
    });

    //Reports
    Route::prefix('reports')->group(function () {
        //purchase-invoices Reports
        Route::prefix('purchase-invoices')->group(function () {
            Route::get('/', [PurchaseInvoiceController::class, 'getPurchaseInvoiceReport']);
        });
    });
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

//client
Route::group(['middleware' => ['auth:client', 'client']], function () {
    Route::get("profile", [ClientController::class, "viewProfile"]);
    Route::post("profile/update", [ClientController::class, "updateProfile"]);

    Route::get("client/orders", [ClientController::class, "listOrders"]);
    Route::post('client/orders/reorder/{orderId}', [ClientController::class, 'reorder']);
    Route::get('client/orders/track/{orderId}', [ClientController::class, 'trackOrder']);
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////

//api(both)
Route::group(["middleware" => ["auth:api"]], function () {
    Route::any("logout", [AuthController::class, "logout"]);


////////////////////////////////////////////////////////////////////////////////////////////////////////////



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



    Route::prefix('recipes')->group(function () {
        Route::get('/list', [RecipeController::class, 'index'])->name('recipes.index');
        Route::post('/create', [RecipeController::class, 'store'])->name('recipes.store');
        Route::get('/view/{id}', [RecipeController::class, 'show'])->name('recipes.show');
        Route::put('/update/{id}', [RecipeController::class, 'update'])->name('recipes.update');
        Route::delete('/delete/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
        Route::post('/restore/{id}', [RecipeController::class, 'restore'])->name('recipes.restore');
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
        Route::get('validateCoupon/{id}', [CouponController::class, 'isCouponValid']);
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



    // point-system
    Route::prefix('point_system')->group(function () {
        Route::get('/', [pointsController::class, 'index']);
        Route::post('/', [pointsController::class, 'store']); // it not allow to add any system
        Route::get('/{id}/{branch}', [pointsController::class, 'show']);
        Route::post('/{id}', [pointsController::class, 'update']);
        Route::delete('/{id}', [pointsController::class, 'destroy']);
        Route::prefix('transactions')->group(function () {});
    });

    //dishes
    Route::prefix('dishes')->group(function () {
        Route::get('/list', [DishController::class, 'index'])->name('dishes.index');
        Route::post('/create', [DishController::class, 'store'])->name('dishes.store');
        Route::get('/view/{id}', [DishController::class, 'show'])->name('dishes.show');
        Route::put('/update/{id}', [DishController::class, 'update'])->name('dishes.update');
        Route::delete('/delete/{id}', [DishController::class, 'destroy'])->name('dishes.destroy');
        Route::post('/restore/{id}', [DishController::class, 'restore'])->name('dishes.restore');
    });

    //brands
    Route::prefix('brands')->group(function () {
        Route::get('/list', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/show/{id}', [BrandController::class, 'show'])->name('brands.show');
        Route::post('/create', [BrandController::class, 'store'])->name('brands.store');
        Route::put('/update/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/delete/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
        Route::post('/restore/{id}', [BrandController::class, 'restore'])->name('brands.restore');
    });

    // dish categories
    Route::prefix('dish-categories')->group(function () {
        Route::get('/list', [DishCategoryController::class, 'index'])->name('dish_categories.index');
        Route::get('/show/{id}', [DishCategoryController::class, 'show'])->name('dish_categories.show');
        Route::post('/create', [DishCategoryController::class, 'store'])->name('dish_categories.store');
        Route::put('/update/{id}', [DishCategoryController::class, 'update'])->name('dish_categories.update');
        Route::delete('/delete/{id}', [DishCategoryController::class, 'destroy'])->name('dish_categories.destroy');
        Route::post('/restore/{id}', [DishCategoryController::class, 'restore'])->name('dish_categories.restore');
    });

    // Gifts
    Route::group(['prefix' => 'gifts'], function () {
        Route::get('/', [GiftController::class, 'index'])->name('gifts.index');
        Route::get('/{id}', [GiftController::class, 'show'])->name('gifts.show');
        Route::post('/', [GiftController::class, 'store'])->name('gifts.store');
        Route::put('/{id}', [GiftController::class, 'update'])->name('gifts.update');
        Route::delete('/{id}', [GiftController::class, 'destroy'])->name('gifts.destroy');
        Route::post('/apply-to-users', [GiftController::class, 'applyGiftToUsers']);
        Route::post('/apply-to-branch', [GiftController::class, 'applyGiftByBranch']);
    });

    //overtime-type
    Route::group(['prefix' => 'overtime-type'], function () {
        Route::get('index', [OvertimeTypeController::class, 'index']);
        Route::post('add', [OvertimeTypeController::class, 'add']);
        Route::post('edit', [OvertimeTypeController::class, 'edit']);
        Route::get('delete/{id}', [OvertimeTypeController::class, 'delete']);
    });

    //overtime-setting
    Route::group(['prefix' => 'overtime-setting'], function () {
        Route::get('index', [OvertimeSettingController::class, 'index']);
        Route::post('add', [OvertimeSettingController::class, 'add']);
        Route::post('edit', [OvertimeSettingController::class, 'edit']);
        Route::get('delete/{id}', [OvertimeSettingController::class, 'delete']);
    });

    //leave-type
    Route::group(['prefix' => 'leave-type'], function () {
        Route::get('index', [LeaveTypeController::class, 'index']);
        Route::post('add', [LeaveTypeController::class, 'add']);
        Route::post('edit', [LeaveTypeController::class, 'edit']);
        Route::get('delete/{id}', [LeaveTypeController::class, 'delete']);
    });

    //leave-national
    Route::group(['prefix' => 'leave-national'], function () {
        Route::get('index', [LeaveNationalController::class, 'index']);
        Route::post('add', [LeaveNationalController::class, 'add']);
        Route::post('edit', [LeaveNationalController::class, 'edit']);
        Route::get('delete/{id}', [LeaveNationalController::class, 'delete']);
    });

    //leave-setting
    Route::group(['prefix' => 'leave-setting'], function () {
        Route::get('index', [LeaveSettingController::class, 'index']);
        Route::post('add', [LeaveSettingController::class, 'add']);
        Route::post('edit', [LeaveSettingController::class, 'edit']);
        Route::get('delete/{id}', [LeaveSettingController::class, 'delete']);
    });

    //leave-request
    Route::group(['prefix' => 'leave-request'], function () {
        Route::post('index', [LeaveRequestController::class, 'index']);
        Route::post('add', [LeaveRequestController::class, 'add']);
        Route::post('edit', [LeaveRequestController::class, 'edit']);
        Route::get('delete/{id}', [LeaveRequestController::class, 'delete']);
        Route::post('change-status', [LeaveRequestController::class, 'change_status']);
    });

    //excussess requests

    Route::prefix('excuse-requests')->group(function () {
        Route::get('list', [ExcuseRequestController::class, 'index'])->name('excuse_requests.index');
        Route::get('view/{id}', [ExcuseRequestController::class, 'show'])->name('excuse_requests.show');
        Route::post('create', [ExcuseRequestController::class, 'store'])->name('excuse_requests.store');
        Route::get('/pending', [ExcuseRequestController::class, 'pendingRequests'])->name('excuse-requests.pending');
        Route::put('approve/{id}', [ExcuseRequestController::class, 'approve'])->name('excuse_requests.approve');
        Route::put('reject/{id}', [ExcuseRequestController::class, 'reject'])->name('excuse_requests.reject');
        Route::put('cancel/{id}', [ExcuseRequestController::class, 'cancel'])->name('excuse_requests.cancel');
        Route::post('restore/{id}', [ExcuseRequestController::class, 'restore'])->name('excuse_requests.restore');
        Route::put('{id}/update', [ExcuseRequestController::class, 'update'])->name('excuse-requests.update');
    });

    // Excuse Settings Routes
    Route::prefix('excuse-settings')->group(function () {
        Route::get('/show', [ExcuseSettingController::class, 'show'])->name('excuse-settings.show');
        Route::put('/update', [ExcuseSettingController::class, 'update'])->name('excuse-settings.update');  
    });

    //floors
    Route::group(['prefix' => 'floors'], function () {
        Route::get('index', [FloorController::class, 'index']);
        Route::post('add', [FloorController::class, 'add']);
        Route::post('edit', [FloorController::class, 'edit']);
        Route::get('delete/{id}', [FloorController::class, 'delete']);
    });

    //floor-partitions
    Route::group(['prefix' => 'floor-partitions'], function () {
        Route::get('index', [FloorPartitionController::class, 'index']);
        Route::post('add', [FloorPartitionController::class, 'add']);
        Route::post('edit', [FloorPartitionController::class, 'edit']);
        Route::get('delete/{id}', [FloorPartitionController::class, 'delete']);
    });

    //tables
    Route::group(['prefix' => 'tables'], function () {
        Route::get('index', [TableController::class, 'index']);
        Route::post('add', [TableController::class, 'add']);
        Route::post('edit', [TableController::class, 'edit']);
        Route::get('delete/{id}', [TableController::class, 'delete']);
    });

    //table-reservations
    Route::group(['prefix' => 'table-reservations'], function () {
        Route::post('index', [TableReservationController::class, 'index']);
        Route::post('add', [TableReservationController::class, 'add']);
        Route::post('edit', [TableReservationController::class, 'edit']);
        Route::get('delete/{id}', [TableReservationController::class, 'delete']);
        Route::post('change-status', [TableReservationController::class, 'change_status']);
    });

    //delivery-settings
    Route::group(['prefix' => 'delivery-settings'], function () {
        Route::get('index', [DeliverySettingController::class, 'index']);
        Route::post('add', [DeliverySettingController::class, 'add']);
        Route::post('edit', [DeliverySettingController::class, 'edit']);
        Route::get('delete/{id}', [DeliverySettingController::class, 'delete']);
    });



    Route::prefix('menu')->group(function () {
        Route::get('/list', [MenuController::class, 'index'])->name('menu.index');                    
        Route::get('/show/{branch_id}', [MenuController::class, 'show'])->name('menu.show');           
        Route::post('/create', [MenuController::class, 'store'])->name('menu.store');     //clone menu            
        Route::put('/update/{branch_id}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/delete', [MenuController::class, 'destroy'])->name('menu.destroy');            
        Route::post('/restore', [MenuController::class, 'restore'])->name('menu.restore');  
    });

    Route::prefix('timetables')->group(function () {
        Route::get('/list', [TimetableController::class, 'index'])->name('timetables.index');
        Route::post('/create', [TimetableController::class, 'store'])->name('timetables.store');
        Route::get('/show/{id}', [TimetableController::class, 'show'])->name('timetables.show');
        Route::put('/update/{id}', [TimetableController::class, 'update'])->name('timetables.update');
        Route::delete('/delete/{id}', [TimetableController::class, 'destroy'])->name('timetables.destroy');
        Route::post('/restore/{id}', [TimetableController::class, 'restore'])->name('timetables.restore');
    });

    Route::prefix('shifts')->group(function () {
        Route::get('/list', [ShiftController::class, 'index'])->name('shifts.index');
        Route::post('/create', [ShiftController::class, 'store'])->name('shifts.store');
        Route::get('/show/{id}', [ShiftController::class, 'show'])->name('shifts.show');
        Route::put('/update/{id}', [ShiftController::class, 'update'])->name('shifts.update');
        Route::delete('/delete/{id}', [ShiftController::class, 'destroy'])->name('shifts.destroy');
        Route::post('/restore/{id}', [ShiftController::class, 'restore'])->name('shifts.restore');
    });
    
    Route::prefix('employee-schedules')->group(function () {
        Route::get('/list', [EmployeeScheduleController::class, 'index'])->name('employee-schedules.index');
        Route::post('/create', [EmployeeScheduleController::class, 'store'])->name('employee-schedules.store');
        Route::get('/show/{id}', [EmployeeScheduleController::class, 'show'])->name('employee-schedules.show');
        Route::put('/update/{id}', [EmployeeScheduleController::class, 'update'])->name('employee-schedules.update');
        Route::delete('/delete/{id}', [EmployeeScheduleController::class, 'destroy'])->name('employee-schedules.destroy');
        Route::post('/restore/{id}', [EmployeeScheduleController::class, 'restore'])->name('employee-schedules.restore');
    });
    
    

});
