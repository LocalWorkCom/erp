<?php

use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\BranchController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\FAQController;
use App\Http\Controllers\Dashboard\FloorController;
use App\Http\Controllers\Dashboard\FloorPartitionController;
use App\Http\Controllers\Dashboard\GiftController;
use App\Http\Controllers\Dashboard\LogoController;
use App\Http\Controllers\Dashboard\PositionController;
use App\Http\Controllers\Dashboard\PrivacyPolicyController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ReturnPolicyController;
use App\Http\Controllers\Dashboard\SizeController;
use App\Http\Controllers\Dashboard\SliderController;
use App\Http\Controllers\Dashboard\TableController;
use App\Http\Controllers\Dashboard\TermsAndConditionsController;
use App\Http\Controllers\Dashboard\UnitController;
use App\Http\Controllers\Dashboard\DishCategoryController;
use App\Http\Controllers\Dashboard\RecipeController;
use App\Http\Controllers\Dashboard\AddonCategoryController;
use App\Http\Controllers\Dashboard\DishController;
use App\Http\Controllers\Dashboard\AddonController;
use App\Http\Controllers\Dashboard\CuisineController;

use App\Http\Controllers\Dashboard\BranchMenuCategoryController;
use App\Http\Controllers\Dashboard\LeaveTypeController;
use App\Http\Controllers\Dashboard\LeaveSettingController;

use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\PurchaseController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\VendorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| dashboard  Routes
|--------------------------------------------------------------------------
|
*/


Route::get('/dashboard/login', [LoginController::class, 'showLoginForm'])->name('dashboard.login');
Route::post('/dashboard/login', [LoginController::class, 'login'])->name('dashboard.submitlogin');
Route::post('/dashboard/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard/forgot-password', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('dashboard.password.request');
Route::post('/dashboard/forgot-password', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('dashboard.password.email');
Route::get('/dashboard/reset-password/{token}', [ForgetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/dashboard/reset-password', [ForgetPasswordController::class, 'reset'])->name('dashboard.password.update');

Route::get('/error/403', function () {
    return view('dashboard.error.403');
})->name('dashboard.error.403');


Route::middleware(['auth:admin'])->get('dashboard', function () {
    return view('dashboard.index');
})->name('dashboard.home')->middleware('role_or_permission:view dashboard');


Route::prefix('dashboard')->middleware('auth:admin')->group(function () {
    // product_units
    Route::get('/products/unit/list/{productId}', [ProductController::class, 'unit'])
        ->name('products.units.list')
        ->middleware('role_or_permission:view product_units');

    Route::post('product/{id}/units/save', [ProductController::class, 'saveUnits'])
        ->name('product.units.save')
        ->middleware('role_or_permission:view product_units');

    // product_sizes
    Route::get('/products/size/list/{productId}', [ProductController::class, 'size'])
        ->name('products.sizes.list')
        ->middleware('role_or_permission:view product_sizes');

    Route::post('product/{id}/sizes/save', [ProductController::class, 'saveSizes'])
        ->name('product.sizes.save')
        ->middleware('role_or_permission:view product_sizes');

    // product_colors
    Route::get('/products/color/list/{productId}', [ProductController::class, 'color'])
        ->name('products.colors.list')
        ->middleware('role_or_permission:view product_colors');

    Route::post('product/{id}/colors/save', [ProductController::class, 'saveColors'])
        ->name('product.colors.save')
        ->middleware('role_or_permission:view product_colors');

    Route::get('/products', [ProductController::class, 'index'])->name('products.list')->middleware('role_or_permission:view products');
    Route::group(['prefix' => 'product'], function () {
        Route::get('/create', [ProductController::class, 'create'])->name('product.create')->middleware('role_or_permission:create products');
        Route::post('store', [ProductController::class, 'store'])->name('product.store')->middleware('role_or_permission:create products');
        Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show')->middleware('role_or_permission:view products');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit')->middleware('role_or_permission:update products');
        Route::put('update/{id}', [ProductController::class, 'update'])->name('product.update')->middleware('role_or_permission:update products');
        Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('product.delete')->middleware('role_or_permission:delete products');


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

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.list')->middleware('role_or_permission:view products');
    Route::group(['prefix' => 'category'], function () {
        Route::get('create', [CategoryController::class, 'create'])->name('category.create')->middleware('role_or_permission:create products');
        Route::post('store', [CategoryController::class, 'store'])->name('category.store')->middleware('role_or_permission:create products');
        Route::get('show/{id}', [CategoryController::class, 'show'])->name('category.show')->middleware('role_or_permission:view products');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit')->middleware('role_or_permission:update products');
        Route::put('update/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware('role_or_permission:update products');
        Route::delete('delete/{id}', [CategoryController::class, 'delete'])->name('category.delete')->middleware('role_or_permission:delete categories');
    });
    Route::get('/countries', [CountryController::class, 'index'])->name('countries.list')->middleware('role_or_permission:view countries');
    Route::group(['prefix' => 'country'], function () {
        Route::any('/get', [CountryController::class, 'show'])->name('country.show')->middleware('role_or_permission:view countries');
        Route::post('store', [CountryController::class, 'store'])->name('country.store')->middleware('role_or_permission:create countries');
        Route::put('update/{id}', [CountryController::class, 'update'])->name('country.update')->middleware('role_or_permission:update countries');
        Route::delete('delete/{id}', [CountryController::class, 'destroy'])->name('country.delete')->middleware('role_or_permission:delete countries');
    });

    Route::get('/units', [UnitController::class, 'index'])->name('units.list')->middleware('role_or_permission:view units');
    Route::group(['prefix' => 'unit'], function () {
        Route::post('store', [UnitController::class, 'store'])->name('unit.store')->middleware('role_or_permission:create units');
        Route::put('update/{id}', [UnitController::class, 'update'])->name('unit.update')->middleware('role_or_permission:update units');
        Route::delete('delete/{id}', [UnitController::class, 'delete'])->name('unit.delete')->middleware('role_or_permission:delete units');
    });

    Route::get('/colors', [ColorController::class, 'index'])->name('colors.list')->middleware('role_or_permission:view colors');
    Route::group(['prefix' => 'color'], function () {
        Route::post('store', [ColorController::class, 'store'])->name('color.store')->middleware('role_or_permission:create colors');
        Route::put('update/{id}', [ColorController::class, 'update'])->name('color.update')->middleware('role_or_permission:update colors');
        Route::delete('delete/{id}', [ColorController::class, 'delete'])->name('color.delete')->middleware('role_or_permission:delete colors');
    });

    Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.list')->middleware('role_or_permission:view sizes');
    Route::group(['prefix' => 'size'], function () {
        Route::post('store', [SizeController::class, 'store'])->name('size.store')->middleware('role_or_permission:create sizes');
        Route::put('update/{id}', [SizeController::class, 'update'])->name('size.update')->middleware('role_or_permission:update sizes');
        Route::delete('delete/{id}', [SizeController::class, 'delete'])->name('size.delete')->middleware('role_or_permission:delete sizes');
    });

    Route::get('/branches', [BranchController::class, 'index'])->name('branches.list')->middleware('role_or_permission:view branches');
    Route::group(['prefix' => 'branch'], function () {
        Route::get('create', [BranchController::class, 'create'])->name('branch.create')->middleware('role_or_permission:create branches');
        Route::post('store', [BranchController::class, 'store'])->name('branch.store')->middleware('role_or_permission:create branches');
        Route::get('show/{id}', [BranchController::class, 'show'])->name('branch.show')->middleware('role_or_permission:view branches');
        Route::get('edit/{id}', [BranchController::class, 'edit'])->name('branch.edit')->middleware('role_or_permission:update branches');
        Route::put('update/{id}', [BranchController::class, 'update'])->name('branch.update')->middleware('role_or_permission:update branches');
        Route::delete('delete/{id}', [BranchController::class, 'delete'])->name('branch.delete')->middleware('role_or_permission:delete branches');

        Route::get('/categories', [BranchMenuCategoryController::class, 'index'])->name('branch.categories.list')->middleware('role_or_permission:view branch_menu_categories');
        Route::group(['prefix' => 'categories'], function () {
            Route::post('store', [BranchMenuCategoryController::class, 'store'])->name('branch.categories.store')->middleware('role_or_permission:create branch_menu_categories');
            Route::get('show/{id}', [BranchMenuCategoryController::class, 'show'])->name('branch.categories.show')->middleware('role_or_permission:view branch_menu_categories');
            Route::put('update/{id}', [BranchMenuCategoryController::class, 'update'])->name('branch.categories.update')->middleware('role_or_permission:update branch_menu_categories');
            Route::delete('delete/{id}', [BranchMenuCategoryController::class, 'delete'])->name('branch.categories.delete')->middleware('role_or_permission:delete branch_menu_categories');
            Route::get('showAll/{branch_id}', [BranchMenuCategoryController::class, 'show_branch'])->name('branch.categories.show.all')->middleware('role_or_permission:view branch_menu_categories');
        });
    });

    Route::get('/brands', [BrandController::class, 'index'])->name('brands.list')->middleware('role_or_permission:view brands');
    Route::group(['prefix' => 'brand'], function () {
        Route::get('create', [BrandController::class, 'create'])->name('brand.create')->middleware('role_or_permission:create brands');
        Route::post('store', [BrandController::class, 'store'])->name('brand.store')->middleware('role_or_permission:create brands');
        Route::get('show/{id}', [BrandController::class, 'show'])->name('brand.show')->middleware('role_or_permission:view brands');
        Route::get('edit/{id}', [BrandController::class, 'edit'])->name('brand.edit')->middleware('role_or_permission:update brands');
        Route::put('update/{id}', [BrandController::class, 'update'])->name('brand.update')->middleware('role_or_permission:update brands');
        Route::delete('delete/{id}', [BrandController::class, 'delete'])->name('brand.delete')->middleware('role_or_permission:delete brands');
    });

    Route::get('/floors', [FloorController::class, 'index'])->name('floors.list')->middleware('role_or_permission:view floors');
    Route::group(['prefix' => 'floor'], function () {
        Route::post('store', [FloorController::class, 'store'])->name('floor.store')->middleware('role_or_permission:create floors');
        Route::get('show/{id}', [FloorController::class, 'show'])->name('floor.show')->middleware('role_or_permission:view floors');
        Route::put('update/{id}', [FloorController::class, 'update'])->name('floor.update')->middleware('role_or_permission:update floors');
        Route::delete('delete/{id}', [FloorController::class, 'delete'])->name('floor.delete')->middleware('role_or_permission:delete floors');
        Route::get('branch/{branch_id}', [FloorController::class, 'branch'])->name('floor.branch')->middleware('role_or_permission:view floors');
    });

    Route::get('/floor-partitions', [FloorPartitionController::class, 'index'])->name('floorPartitions.list')->middleware('role_or_permission:view floor_partitions');
    Route::group(['prefix' => 'floor-partition'], function () {
        Route::post('store', [FloorPartitionController::class, 'store'])->name('floorPartition.store')->middleware('role_or_permission:create floor_partitions');
        Route::put('update/{id}', [FloorPartitionController::class, 'update'])->name('floorPartition.update')->middleware('role_or_permission:update floor_partitions');
        Route::delete('delete/{id}', [FloorPartitionController::class, 'delete'])->name('floorPartition.delete')->middleware('role_or_permission:delete floor_partitions');
    });

    Route::get('/tables', [TableController::class, 'index'])->name('tables.list')->middleware('role_or_permission:view tables');
    Route::group(['prefix' => 'table'], function () {
        Route::post('store', [TableController::class, 'store'])->name('table.store')->middleware('role_or_permission:create tables');
        Route::put('update/{id}', [TableController::class, 'update'])->name('table.update')->middleware('role_or_permission:update tables');
        Route::delete('delete/{id}', [TableController::class, 'delete'])->name('table.delete')->middleware('role_or_permission:delete tables');
    });

    Route::get('/leave-types', [LeaveTypeController::class, 'index'])->name('leave-types.list')->middleware('role_or_permission:view leave_types');
    Route::group(['prefix' => 'leave-type'], function () {
        Route::post('store', [LeaveTypeController::class, 'store'])->name('leave-type.store')->middleware('role_or_permission:create leave_types');
        Route::get('show/{id}', [LeaveTypeController::class, 'show'])->name('leave-type.show')->middleware('role_or_permission:view leave_types');
        Route::put('update/{id}', [LeaveTypeController::class, 'update'])->name('leave-type.update')->middleware('role_or_permission:update leave_types');
        Route::delete('delete/{id}', [LeaveTypeController::class, 'delete'])->name('leave-type.delete')->middleware('role_or_permission:delete leave_types');
    });

    Route::get('/leave-settings', [LeaveSettingController::class, 'index'])->name('leave-settings.list')->middleware('role_or_permission:view leave_settings');
    Route::group(['prefix' => 'leave-setting'], function () {
        Route::post('store', [LeaveSettingController::class, 'store'])->name('leave-setting.store')->middleware('role_or_permission:create leave_settings');
        Route::get('show/{id}', [LeaveSettingController::class, 'show'])->name('leave-setting.show')->middleware('role_or_permission:view leave_settings');
        Route::put('update/{id}', [LeaveSettingController::class, 'update'])->name('leave-setting.update')->middleware('role_or_permission:update leave_settings');
        Route::delete('delete/{id}', [LeaveSettingController::class, 'delete'])->name('leave-setting.delete')->middleware('role_or_permission:delete leave_settings');
    });

    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.list')->middleware('role_or_permission:view coupons');
    Route::group(['prefix' => 'coupon'], function () {
        Route::get('create', [CouponController::class, 'create'])->name('coupon.create')->middleware('role_or_permission:create coupons');
        Route::post('store', [CouponController::class, 'store'])->name('coupon.store')->middleware('role_or_permission:create coupons');
        Route::get('show/{id}', [CouponController::class, 'show'])->name('coupon.show')->middleware('role_or_permission:view coupons');
        Route::get('edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit')->middleware('role_or_permission:update coupons');
        Route::put('update/{id}', [CouponController::class, 'update'])->name('coupon.update')->middleware('role_or_permission:update coupons');
        Route::delete('delete/{id}', [CouponController::class, 'delete'])->name('coupon.delete')->middleware('role_or_permission:delete coupons');
    });

    Route::get('/gifts', [GiftController::class, 'index'])->name('gifts.list')->middleware('role_or_permission:view gifts');
    Route::group(['prefix' => 'gift'], function () {
        Route::post('store', [GiftController::class, 'store'])->name('gift.store')->middleware('role_or_permission:create gifts');
        Route::put('update/{id}', [GiftController::class, 'update'])->name('gift.update')->middleware('role_or_permission:update gifts');
        Route::delete('delete/{id}', [GiftController::class, 'delete'])->name('gift.delete')->middleware('role_or_permission:delete gifts');
    });

    Route::get('/clients', [ClientController::class, 'index'])->name('client.index')->middleware('role_or_permission:view client_details');
    Route::group(['prefix' => 'client'], function () {
        Route::get('create', [ClientController::class, 'create'])->name('client.create')->middleware('role_or_permission:create client_details');
        Route::post('store', [ClientController::class, 'store'])->name('client.store')->middleware('role_or_permission:create client_details');
        Route::get('show/{id}', [ClientController::class, 'show'])->name('client.show')->middleware('role_or_permission:view client_details');
        Route::get('edit/{id}', [ClientController::class, 'edit'])->name('client.edit')->middleware('role_or_permission:update client_details');
        Route::put('update/{id}', [ClientController::class, 'update'])->name('client.update')->middleware('role_or_permission:update client_details');
        Route::delete('delete/{id}', [ClientController::class, 'destroy'])->name('client.delete')->middleware('role_or_permission:delete client_details');
    });

    //website setting
    Route::get('/logos', [LogoController::class, 'index'])->name('logos.list')->middleware('role_or_permission:view logos');
    Route::group(['prefix' => 'logo'], function () {
        Route::post('store', [LogoController::class, 'store'])->name('logo.store')->middleware('role_or_permission:create logos');
        Route::get('show/{id}', [LogoController::class, 'show'])->name('logo.show')->middleware('role_or_permission:view logos');
        Route::put('update/{id}', [LogoController::class, 'update'])->name('logo.update')->middleware('role_or_permission:update logos');
        Route::delete('delete/{id}', [LogoController::class, 'destroy'])->name('logo.delete')->middleware('role_or_permission:delete logos');
    });

    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.list')->middleware('role_or_permission:view sliders');
    Route::group(['prefix' => 'slider'], function () {
        Route::get('create', [SliderController::class, 'create'])->name('slider.create')->middleware('role_or_permission:create sliders');
        Route::post('store', [SliderController::class, 'store'])->name('slider.store')->middleware('role_or_permission:create sliders');
        Route::get('show/{id}', [SliderController::class, 'show'])->name('slider.show')->middleware('role_or_permission:view sliders');
        Route::get('edit/{id}', [SliderController::class, 'edit'])->name('slider.edit')->middleware('role_or_permission:update sliders');
        Route::put('update/{id}', [SliderController::class, 'update'])->name('slider.update')->middleware('role_or_permission:update sliders');
        Route::delete('delete/{id}', [SliderController::class, 'destroy'])->name('slider.delete')->middleware('role_or_permission:delete sliders');
    });

    Route::get('/terms', [TermsAndConditionsController::class, 'index'])->name('terms.list')->middleware('role_or_permission:view terms');
    Route::group(['prefix' => 'term'], function () {
        Route::get('create', [TermsAndConditionsController::class, 'create'])->name('term.create')->middleware('role_or_permission:create terms');
        Route::post('store', [TermsAndConditionsController::class, 'store'])->name('term.store')->middleware('role_or_permission:create terms');
        Route::get('show/{id}', [TermsAndConditionsController::class, 'show'])->name('term.show')->middleware('role_or_permission:view terms');
        Route::get('edit/{id}', [TermsAndConditionsController::class, 'edit'])->name('term.edit')->middleware('role_or_permission:update terms');
        Route::put('update/{id}', [TermsAndConditionsController::class, 'update'])->name('term.update')->middleware('role_or_permission:update terms');
        Route::delete('delete/{id}', [TermsAndConditionsController::class, 'destroy'])->name('term.delete')->middleware('role_or_permission:delete terms');
    });

    Route::get('/privacies', [PrivacyPolicyController::class, 'index'])->name('privacies.list')->middleware('role_or_permission:view privacies');
    Route::group(['prefix' => 'privacy'], function () {
        Route::get('create', [PrivacyPolicyController::class, 'create'])->name('privacy.create')->middleware('role_or_permission:create privacies');
        Route::post('store', [PrivacyPolicyController::class, 'store'])->name('privacy.store')->middleware('role_or_permission:create privacies');
        Route::get('show/{id}', [PrivacyPolicyController::class, 'show'])->name('privacy.show')->middleware('role_or_permission:view privacies');
        Route::get('edit/{id}', [PrivacyPolicyController::class, 'edit'])->name('privacy.edit')->middleware('role_or_permission:update privacies');
        Route::put('update/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy.update')->middleware('role_or_permission:update privacies');
        Route::delete('delete/{id}', [PrivacyPolicyController::class, 'destroy'])->name('privacy.delete')->middleware('role_or_permission:delete privacies');
    });

    Route::get('/returns', [ReturnPolicyController::class, 'index'])->name('returns.list')->middleware('role_or_permission:view returns');
    Route::group(['prefix' => 'return'], function () {
        Route::get('create', [ReturnPolicyController::class, 'create'])->name('return.create')->middleware('role_or_permission:create returns');
        Route::post('store', [ReturnPolicyController::class, 'store'])->name('return.store')->middleware('role_or_permission:create returns');
        Route::get('show/{id}', [ReturnPolicyController::class, 'show'])->name('return.show')->middleware('role_or_permission:view returns');
        Route::get('edit/{id}', [ReturnPolicyController::class, 'edit'])->name('return.edit')->middleware('role_or_permission:update returns');
        Route::put('update/{id}', [ReturnPolicyController::class, 'update'])->name('return.update')->middleware('role_or_permission:update returns');
        Route::delete('delete/{id}', [ReturnPolicyController::class, 'destroy'])->name('return.delete')->middleware('role_or_permission:delete returns');
    });

    Route::get('/faqs', [FAQController::class, 'index'])->name('faqs.list')->middleware('role_or_permission:view faqs');
    Route::group(['prefix' => 'faq'], function () {
        Route::get('create', [FAQController::class, 'create'])->name('faq.create')->middleware('role_or_permission:create faqs');
        Route::post('store', [FAQController::class, 'store'])->name('faq.store')->middleware('role_or_permission:create faqs');
        Route::get('show/{id}', [FAQController::class, 'show'])->name('faq.show')->middleware('role_or_permission:view faqs');
        Route::get('edit/{id}', [FAQController::class, 'edit'])->name('faq.edit')->middleware('role_or_permission:update faqs');
        Route::put('update/{id}', [FAQController::class, 'update'])->name('faq.update')->middleware('role_or_permission:update faqs');
        Route::delete('delete/{id}', [FAQController::class, 'destroy'])->name('faq.delete')->middleware('role_or_permission:delete faqs');
    });

    //HR
    Route::get('/positions', [PositionController::class, 'index'])->name('positions.index')->middleware('role_or_permission:view positions');
    Route::group(['prefix' => 'position'], function () {
        Route::post('store', [PositionController::class, 'store'])->name('position.store')->middleware('role_or_permission:create positions');
        Route::put('update/{id}', [PositionController::class, 'update'])->name('position.update')->middleware('role_or_permission:update positions');
        Route::delete('delete/{id}', [PositionController::class, 'destroy'])->name('position.delete')->middleware('role_or_permission:delete positions');
    });

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.list')->middleware('role_or_permission:view employees');
    Route::group(['prefix' => 'employee'], function () {
        Route::get('create', [EmployeeController::class, 'create'])->name('employee.create')->middleware('role_or_permission:create employees');
        Route::post('store', [EmployeeController::class, 'store'])->name('employee.store')->middleware('role_or_permission:create employees');
        Route::get('show/{id}', [EmployeeController::class, 'show'])->name('employee.show')->middleware('role_or_permission:view employees');
        Route::get('edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware('role_or_permission:update employees');
        Route::put('update/{id}', [EmployeeController::class, 'update'])->name('employee.update')->middleware('role_or_permission:update employees');
        Route::delete('delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete')->middleware('role_or_permission:delete employees');
    });

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.list')->middleware('role_or_permission:view departments');
    Route::group(['prefix' => 'department'], function () {
        Route::post('store', [DepartmentController::class, 'store'])->name('department.store')->middleware('role_or_permission:create departments');
        Route::put('update/{id}', [DepartmentController::class, 'update'])->name('department.update')->middleware('role_or_permission:update departments');
        Route::delete('delete/{id}', [DepartmentController::class, 'destroy'])->name('department.delete')->middleware('role_or_permission:delete departments');
    });

    Route::prefix('dish-categories')->group(function () {
        Route::get('/', [DishCategoryController::class, 'index'])->name('dashboard.dish-categories.index')->middleware('role_or_permission:view dish_categories');
        Route::get('/dish-categories/{id}/show', [DishCategoryController::class, 'show'])->name('dashboard.dish-categories.show')->middleware('role_or_permission:view dish_categories');
        Route::get('/create', [DishCategoryController::class, 'create'])->name('dashboard.dish-categories.create')->middleware('role_or_permission:create dish_categories');
        Route::post('/', [DishCategoryController::class, 'store'])->name('dashboard.dish-categories.store')->middleware('role_or_permission:create dish_categories');
        Route::get('/{id}/edit', [DishCategoryController::class, 'edit'])->name('dashboard.dish-categories.edit')->middleware('role_or_permission:update dish_categories');
        Route::put('/{id}', [DishCategoryController::class, 'update'])->name('dashboard.dish-categories.update')->middleware('role_or_permission:update dish_categories');
        Route::delete('/{id}', [DishCategoryController::class, 'delete'])->name('dashboard.dish-categories.delete')->middleware('role_or_permission:delete dish_categories');
        Route::post('/restore/{id}', [DishCategoryController::class, 'restore'])->name('dashboard.dish-categories.restore')->middleware('role_or_permission:create dish_categories');
    });
    // Recipe routes
    Route::prefix('recipes')->group(function () {
        Route::get('/', [RecipeController::class, 'index'])->name('dashboard.recipes.index')->middleware('role_or_permission:view recipes');
        Route::get('/show/{id}', [RecipeController::class, 'show'])->name('dashboard.recipes.show')->middleware('role_or_permission:view recipes');
        Route::get('/create', [RecipeController::class, 'create'])->name('dashboard.recipes.create')->middleware('role_or_permission:create recipes');
        Route::post('/', [RecipeController::class, 'store'])->name('dashboard.recipes.store')->middleware('role_or_permission:create recipes');
        Route::get('/edit/{id}', [RecipeController::class, 'edit'])->name('dashboard.recipes.edit')->middleware('role_or_permission:update recipes');
        Route::put('/{id}', [RecipeController::class, 'update'])->name('dashboard.recipes.update')->middleware('role_or_permission:update recipes');
        Route::delete('/{id}', [RecipeController::class, 'delete'])->name('dashboard.recipes.delete')->middleware('role_or_permission:delete recipes');
        Route::post('/restore/{id}', [RecipeController::class, 'restore'])->name('dashboard.recipes.restore')->middleware('role_or_permission:create recipes');
    });

    //roles routes

    Route::prefix('/addon-categories')->group(function () {
        Route::get('/', [AddonCategoryController::class, 'index'])->name('dashboard.addon_categories.index');
        Route::get('/create', [AddonCategoryController::class, 'create'])->name('dashboard.addon_categories.create');
        Route::post('/', [AddonCategoryController::class, 'store'])->name('dashboard.addon_categories.store');
        Route::get('/{id}', [AddonCategoryController::class, 'show'])->name('dashboard.addon_categories.show');
        Route::get('/{id}/edit', [AddonCategoryController::class, 'edit'])->name('dashboard.addon_categories.edit');
        Route::put('/{id}', [AddonCategoryController::class, 'update'])->name('dashboard.addon_categories.update');
        Route::delete('/{id}', [AddonCategoryController::class, 'destroy'])->name('dashboard.addon_categories.destroy');
        Route::post('/{id}/restore', [AddonCategoryController::class, 'restore'])->name('dashboard.addon_categories.restore');
    });


    //roles routws
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.list')->middleware('role_or_permission:view gifts');
    Route::group(['prefix' => 'role'], function () {
        Route::get('/show/{id}', [RoleController::class, 'show'])->name('role.show')->middleware('role_or_permission:view roles');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create')->middleware('role_or_permission:create roles');
        Route::post('store', [RoleController::class, 'store'])->name('role.store')->middleware('role_or_permission:create roles');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('role_or_permission:update roles');
        Route::put('update/{id}', [RoleController::class, 'update'])->name('role.update')->middleware('role_or_permission:update roles');
        Route::delete('delete/{id}', [RoleController::class, 'destroy'])->name('role.delete')->middleware('role_or_permission:delete roles');
    });

    //permissions routes
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.list')->middleware('role_or_permission:view permissions');
        Route::get('/show/{id}', [PermissionController::class, 'show'])->name('permission.show')->middleware('role_or_permission:view permissions');
        Route::get('/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('role_or_permission:create permissions');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store')->middleware('role_or_permission:create permissions');
        Route::get('{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('role_or_permission:update permissions');
        Route::put('update', [PermissionController::class, 'update'])->name('permission.update')->middleware('role_or_permission:update permissions');
        Route::get('delete/{id}', [PermissionController::class, 'destroy'])->name('permission.delete')->middleware('role_or_permission:delete permissions');
    });


    Route::get('/orders', [OrderController::class, 'index'])->name('orders.list');
    Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::post('/order/change', [OrderController::class, 'changeStatus'])->name('order.change');
    Route::post('/order/change-status/{id}', [OrderController::class, 'changeStatusQr'])->name('order.change.status');
    Route::get('/order/print/{id}', [OrderController::class, 'printOrder'])->name('order.print');

    //Purchases
    Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index')->middleware('role_or_permission:view vendors');
    Route::group(['prefix' => 'vendor'], function () {
        Route::get('create', [VendorController::class, 'create'])->name('vendor.create')->middleware('role_or_permission:create vendors');
        Route::post('store', [VendorController::class, 'store'])->name('vendor.store')->middleware('role_or_permission:create vendors');
        Route::get('show/{id}', [VendorController::class, 'show'])->name('vendor.show')->middleware('role_or_permission:view vendors');
        Route::get('edit/{id}', [VendorController::class, 'edit'])->name('vendor.edit')->middleware('role_or_permission:update vendors');
        Route::put('update/{id}', [VendorController::class, 'update'])->name('vendor.update')->middleware('role_or_permission:update vendors');
        Route::delete('delete/{id}', [VendorController::class, 'destroy'])->name('vendor.delete')->middleware('role_or_permission:delete vendors');
    });

    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index')->middleware('role_or_permission:view purchase_invoices');
    Route::group(['prefix' => 'purchase'], function () {
        Route::get('create', [PurchaseController::class, 'create'])->name('purchase.create')->middleware('role_or_permission:create purchase_invoices');
        Route::post('store', [PurchaseController::class, 'store'])->name('purchase.store')->middleware('role_or_permission:create purchase_invoices');
        Route::get('show/{id}', [PurchaseController::class, 'show'])->name('purchase.show')->middleware('role_or_permission:view purchase_invoices');
        Route::get('edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit')->middleware('role_or_permission:update purchase_invoices');
        Route::put('update/{id}', [PurchaseController::class, 'update'])->name('purchase.update')->middleware('role_or_permission:update purchase_invoices');
        Route::delete('delete/{id}', [PurchaseController::class, 'destroy'])->name('purchase.delete')->middleware('role_or_permission:delete purchase_invoices');
        Route::get('print/{id}', [PurchaseController::class, 'print'])->name('purchase.print'); //->middleware('role_or_permission:print purchase_invoices');
        Route::get('invoice/{id}', [PurchaseController::class, 'showInvoice'])->name('purchase.showInvoice'); //->middleware('role_or_permission:print purchase_invoices');
    });

    Route::prefix('/dishes')->group(function () {
        Route::get('/', [DishController::class, 'index'])->name('dashboard.dishes.index');
        Route::get('/create', [DishController::class, 'create'])->name('dashboard.dishes.create');
        Route::post('/', [DishController::class, 'store'])->name('dashboard.dishes.store');
        Route::get('/{id}', [DishController::class, 'show'])->name('dashboard.dishes.show');
        Route::get('/{id}/edit', [DishController::class, 'edit'])->name('dashboard.dishes.edit');
        Route::put('/{id}', [DishController::class, 'update'])->name('dashboard.dishes.update');
        Route::delete('/{id}', [DishController::class, 'destroy'])->name('dashboard.dishes.destroy');
        Route::post('/{id}/restore', [DishController::class, 'restore'])->name('dashboard.dishes.restore');
    });
    Route::prefix('/addons')->group(function () {
        Route::get('/', [AddonController::class, 'index'])->name('dashboard.addons.index');
        Route::get('/create', [AddonController::class, 'create'])->name('dashboard.addons.create');
        Route::post('/', [AddonController::class, 'store'])->name('dashboard.addons.store');
        Route::get('/{id}', [AddonController::class, 'show'])->name('dashboard.addons.show');
        Route::get('/{id}/edit', [AddonController::class, 'edit'])->name('dashboard.addons.edit');
        Route::put('/{id}', [AddonController::class, 'update'])->name('dashboard.addons.update');
        Route::delete('/{id}', [AddonController::class, 'destroy'])->name('dashboard.addons.destroy');
        Route::post('/{id}/restore', [AddonController::class, 'restore'])->name('dashboard.addons.restore');
    });

    Route::prefix('/cuisines')->group(function () {

        Route::get('/', [CuisineController::class, 'index'])->name('dashboard.cuisines.index');
        Route::get('/create', [CuisineController::class, 'create'])->name('dashboard.cuisines.create');
        Route::post('/', [CuisineController::class, 'store'])->name('dashboard.cuisines.store');
        Route::get('/{id}/edit', [CuisineController::class, 'edit'])->name('dashboard.cuisines.edit');
        Route::put('/{id}', [CuisineController::class, 'update'])->name('dashboard.cuisines.update');
        Route::delete('/{id}', [CuisineController::class, 'destroy'])->name('dashboard.cuisines.destroy');
        Route::post('/restore/{id}', [CuisineController::class, 'restore'])->name('dashboard.cuisines.restore');
    });
});
