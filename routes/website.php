<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
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
Route::post('/site/logout', [AuthController::class, 'Logout'])->name('website.logout');
Route::get('/site/profile', [AuthController::class, 'view'])->name('website.profile.view');

Route::get('/', function () {
    return view('website.landing');
})->name('home');
