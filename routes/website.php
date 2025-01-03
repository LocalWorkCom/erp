<?php

use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\LocationController;
use App\Http\Controllers\Website\MyFatoorahController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Geocoder\Provider\Nominatim\Nominatim;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Geocoder\StatefulGeocoder;
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
    Route::get('/myaddress/add', [LocationController::class, 'createAddress'])->name('create.Address');
    Route::get('/myaddress/edit/{id}', [LocationController::class, 'createAddress'])->name('edit.Address');
    Route::post('/myaddress/handle', [LocationController::class, 'createOrUpdateAddress'])->name('handle.Address');
    Route::post('/address/delete/{id}', [LocationController::class, 'destroyAddress'])->name('address.delete');
    Route::post('/myaddress/add', [LocationController::class, 'storeAddress'])->name('store.Address');
    Route::get('/myaddress/active/{id}', [LocationController::class, 'activeAddress'])->name('active.Address');
    Route::get('/orders', [CartController::class, 'pastOrders'])->name('orders.show');
    Route::get('/order-tracking/{id}', [CartController::class, 'trackOrder'])->name('order.tracking');
    Route::get('/orders/track', [CartController::class, 'trackOrder'])->name('orders.tracking');
    Route::get('/order/payment/{id}/details', [CartController::class, 'paymentDetails'])->name('order.paymentdetails');
    Route::post('/order-store', [CartController::class, 'store'])->name('web.order.add');

    Route::get('/rate', [HomeController::class, 'showRate'])->name('show.rating');
    Route::post('/rate', [HomeController::class, 'addRate'])->name('store.rating');

    // Route::get('s', function () {
    //     $address = "12   الجيزه , مصر, ميدان سفنكس , المهندسين , الكيت كات ";
    //     $apiKey = 'd3ac216d5e1642aa85e9d0abd8ca2978';  // Your API key from OpenCage

    //     // Construct the API URL with the address and API key
    //     $url = 'https://api.opencagedata.com/geocode/v1/json?q=' . urlencode($address) . '&key=' . $apiKey;

    //     // Make the GET request to OpenCage API
    //     $response = Http::get($url);

    //     // Check if the response is valid
    //     if ($response->successful()) {
    //         // Decode the JSON response from OpenCage
    //         $data = $response->json();

    //         // Check if there are results in the response
    //         if (isset($data['results'][0])) {
    //             $latitude = $data['results'][0]['geometry']['lat'];
    //             $longitude = $data['results'][0]['geometry']['lng'];

    //             return [
    //                 'latitude' => $latitude,
    //                 'longitude' => $longitude
    //             ];
    //         } else {
    //             // Address not found in the response
    //             return "Address not found.";
    //         }
    //     } else {
    //         // Error in the response
    //         return "Error: " . $response->status();
    //     }
    // });
});
Route::get('/get-nearest-branch', [LocationController::class, 'getNearestBranchl']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/faqs', [HomeController::class, 'getfaqs'])->name('shoe.faq');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/return', [HomeController::class, 'return'])->name('return');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/menu', [HomeController::class, 'showMenu'])->name('menu');
Route::get('/offers', [HomeController::class, 'showOffers'])->name('offers.website');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contactUs');
Route::post('/favorite-dish', [HomeController::class, 'addFavorite'])->name('add.favorite');

Route::get('cart', [CartController::class, 'Cart'])->name('cart');
Route::post('cart/coupon-check', [CartController::class, 'isCouponValid'])->name('cart.coupon-check');

Route::get('cart/dish-detail', [CartController::class, 'getDishDetail'])->name('cart.dish-detail');
Route::get('cart/checkout', [CartController::class, 'Checkout'])->name('cart.checkout');
Route::get('/favorites', [HomeController::class, 'showFavorites'])->name('show.favorites');

//myfatoorah
Route::get('/myfatoorah', [MyFatoorahController::class, 'index'])->name('myfatoorah');
// Route::get('/myfatoorah/callback', [MyFatoorahController::class, 'callback'])->name('myfatoorah.callback');
// Route::get('/myfatoorah/webhook', [MyFatoorahController::class, 'webhook'])->name('myfatoorah.webhook');
// Route::get('/myfatoorah/checkout', [MyFatoorahController::class, 'checkout'])->name('myfatoorah.cardView');
