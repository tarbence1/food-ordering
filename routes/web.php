<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/auth')->group(function () {
    Route::middleware(['only.json'])->group(function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('auth.login');
    });
    Route::get('/who-am-i', [AuthenticationController::class, 'userData'])->name('auth.userData');
});

Route::prefix('/restaurants')->group(function () {
    Route::get('', [RestaurantController::class, 'list'])->name('restaurants.list');
    Route::get('/{id}', [RestaurantController::class, 'details'])->name('restaurants.details');
    Route::get('/{id}/menu', [RestaurantController::class, 'menu'])->name('restaurants.menu');
});

Route::middleware('logged.in')->prefix('/orders')->group(function () {
    Route::middleware(['only.json'])->group(function () {
        Route::post('', [OrderController::class, 'order'])->name('orders.order');
        Route::patch('/{id}', [OrderController::class, 'update'])->name('orders.update');
    });
    Route::get('', [OrderController::class, 'orders'])->name('orders.orders');
    Route::get('/{id}', [OrderController::class, 'details'])->name('orders.details');
});



