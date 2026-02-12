<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars/search', [CarController::class, 'search'])->name('cars.search');
Route::get('/cars/models/{maker}', [CarController::class, 'getModels'])->name('cars.models');
Route::get('/cars/cities/{state}',  [CarController::class, 'getCities'])->name('cars.cities');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show')->where('car', '[0-9]+');
// Actually resource route handles 'create' before 'show' if defined correctly. 
// Use resource for cars but exclude index/show if customized? The original code had resource. 
// But conflict risk: /cars/search vs /cars/{car}. If {car} matches "search", it breaks.
// "search" is not an integer ID, so it might be safe if constraints are used, but explicit is better.
// Better order: Specific paths first.

// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/signup', [RegisterController::class, 'SignUp'])->name('signup');
    Route::post('/signup', [RegisterController::class, 'register'])->name('signup.post');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.post');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    
    // User Dashboard (role-based: admin redirects, seller/buyer see respective dashboards)
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Car Management (seller + admin only for create/edit/delete)
    Route::get('/my-cars', [CarController::class, 'index'])->name('cars.index');
    Route::middleware('seller')->group(function () {
        Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
        Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
        Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
        Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
        Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    });
  // Watchlist page
Route::middleware(['auth'])->group(function () {
    Route::post('/watchlist/{car}', [CarController::class, 'toggleWatchlist'])
        ->name('watchlist.toggle');

    Route::get('/watchlist', [CarController::class, 'watchlist'])
        ->name('cars.watchlist');
});

// Watchlist toggle
Route::post('/cars/{car}/toggle-watchlist', [CarController::class, 'toggleWatchlist'])
    ->middleware('auth')
    ->name('cars.toggleWatchlist');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/cars', [AdminController::class, 'allCars'])->name('cars.index');
        Route::delete('/cars/{car}', [AdminController::class, 'deleteCar'])->name('cars.delete');
    });
});
