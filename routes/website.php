<?php

use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\LocationController;
use App\Http\Controllers\Website\MyFatoorahController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| website  Routes
|--------------------------------------------------------------------------
|
*/

Route::post('/site/register', [AuthController::class, 'Register'])->name('website.register');
Route::post('/site/login', [AuthController::class, 'login'])->name('website.login');
Route::post('/site/check-phone', [AuthController::class, 'checkPhone'])->name('check.phone');
Route::post('/site/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

Route::middleware(['auth:client'])->group(function () {
    Route::get('/site/profile', [AuthController::class, 'viewProfile'])->name('website.profile.view');
    Route::post('/site/profile/update', [AuthController::class, 'updateProfile'])->name('website.profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('website.logout');
    Route::get('/favorites', [HomeController::class, 'showFavorites'])->name('show.favorites');

    Route::get('/myaddress', [LocationController::class, 'showAddress'])->name('showAddress');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/return', [HomeController::class, 'return'])->name('return');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/menu', [HomeController::class, 'showMenu'])->name('menu');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contactUs');
Route::post('/favorite-dish', [HomeController::class, 'addFavorite'])->name('add.favorite');

Route::post('/saveaddress', [LocationController::class, 'saveAddress'])->name('saveAddress');


Route::get('cart', [CartController::class, 'Cart'])->name('cart');
Route::post('cart/coupon-check', [CartController::class, 'isCouponValid'])->name('cart.coupon-check');

Route::get('cart/dish-detail', [CartController::class, 'getDishDetail'])->name('cart.dish-detail');
Route::get('cart/checkout', [CartController::class, 'Checkout'])->name('cart.checkout');
Route::get('/favorites', [HomeController::class, 'showFavorites'])->name('show.favorites');
Route::post('/saveaddress', [LocationController::class, 'saveAddress'])->name('saveAddress');



//myfatoorah
Route::get('/myfatoorah', [MyFatoorahController::class, 'index'])->name('myfatoorah');
Route::get('/myfatoorah/callback', [MyFatoorahController::class, 'callback'])->name('myfatoorah.callback');
Route::get('/myfatoorah/webhook', [MyFatoorahController::class, 'webhook'])->name('myfatoorah.webhook');
Route::get('/myfatoorah/checkout', [MyFatoorahController::class, 'checkout'])->name('myfatoorah.cardView');
Route::get('/order-tracking/{id}', [CartController::class, 'trackOrder'])->name('order.tracking');

Route::get('/favorites', [HomeController::class, 'showFavorites'])->name('show.favorites');
