<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
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
Route::post('/site/login', [AuthController::class, 'Login'])->name('website.login');
Route::get('/site/profile', [AuthController::class, 'view'])->name('website.profile.view');
Route::middleware(['auth', 'client'])->group(function () {
    Route::post( '/logout', [AuthController::class, 'logout'])->name('website.logout');
});
//Route::get('/', function () {
//    return view('website.landing');
//})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

