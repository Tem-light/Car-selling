<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\carController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/cars/search', [carController::class, 'search'])->name('cars.search');
Route::get('/cars/watchlist', [carController::class, 'watchlist'])->name('cars.watchlist');
Route::resource('cars', carController::class);

Route::get('/', [homeController::class, 'index']);
Route::get('/signup', [SignupController::class, 'create'])->name('signup');
Route::get('/login', [loginController::class, 'login'])->name('login');
