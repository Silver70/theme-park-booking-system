<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/hotel/dashboard', function () {
//     return view('hotel.dashboard');
// })->middleware(['auth', 'verified'])->name('hotel.dashboard');

// Route::get('/hotel/dashboard', [DashboardController::class, 'hotelDashboard'])->middleware(['auth', 'verified'])->name('hotel.dashboard');
Route::middleware(['auth', 'role:hotel_owner'])->group(function () {
    Route::get('/hotel/dashboard', [DashboardController::class, 'hotelDashboard'])->name('hotel.dashboard');
});

Route::middleware(['auth', 'role:ferry_operator'])->group(function () {
    Route::get('/ferry/dashboard', [DashboardController::class, 'ferryOperatorDashboard'])->name('ferry.dashboard');
    Route::get('/ferry/schedules', [DashboardController::class, 'ferrySchedules'])->name('ferry.schedules');
    Route::get('/ferry/schedules/create', [DashboardController::class, 'createFerrySchedule'])->name('ferry.schedules.create');
    Route::post('/ferry/schedules', [DashboardController::class, 'storeFerrySchedule'])->name('ferry.schedules.store');
});

Route::get('/register/hotel-owner', [RegisteredUserController::class, 'createHotelOwner']);
Route::post('/register/hotel-owner', [RegisteredUserController::class, 'storeHotelOwner'])->name('register.hotel-owner');

Route::get('/register/ferry-operator', [RegisteredUserController::class, 'createFerryOperator']);
Route::post('/register/ferry-operator', [RegisteredUserController::class, 'storeFerryOperator'])->name('register.ferry-operator');

require __DIR__.'/auth.php';
