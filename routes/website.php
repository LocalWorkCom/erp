<?php

use App\Http\Controllers\Website\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| website  Routes
|--------------------------------------------------------------------------
|
*/

//Route::get('/', function () {
//    return view('website.landing');
//})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');
