<?php

use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\HomeController;
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
    Route::get('/site/profile', [AuthController::class, 'view'])->name('website.profile.view');

    Route::post('/logout', [AuthController::class, 'logout'])->name('website.logout');
});
//Route::get('/', function () {
//    return view('website.landing');
//})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/return', [HomeController::class, 'return'])->name('return');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/menu', [HomeController::class, 'showMenu'])->name('menu');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contactUs');
