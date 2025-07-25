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
    Route::get('/ferry/schedules/{id}/edit', [DashboardController::class, 'editFerrySchedule'])->name('ferry.schedules.edit');
    Route::patch('/ferry/schedules/{id}', [DashboardController::class, 'updateFerrySchedule'])->name('ferry.schedules.update');
    Route::patch('/ferry/schedules/{id}/cancel', [DashboardController::class, 'cancelFerrySchedule'])->name('ferry.schedules.cancel');
    Route::get('/ferry/tickets', [DashboardController::class, 'ferryTickets'])->name('ferry.tickets');
    Route::get('/ferry/tickets/validate', [DashboardController::class, 'validateTicket'])->name('ferry.tickets.validate');
    Route::post('/ferry/tickets/validate', [DashboardController::class, 'submitValidation'])->name('ferry.tickets.validate.submit');
    Route::post('/ferry/tickets/issue', [DashboardController::class, 'issueFerryPass'])->name('ferry.tickets.issue');
    Route::get('/ferry/tickets/create', [DashboardController::class, 'createFerryTicket'])->name('ferry.tickets.create');
    Route::post('/ferry/tickets/create', [DashboardController::class, 'storeFerryTicket'])->name('ferry.tickets.store');
});

Route::get('/register/hotel-owner', [RegisteredUserController::class, 'createHotelOwner']);
Route::post('/register/hotel-owner', [RegisteredUserController::class, 'storeHotelOwner'])->name('register.hotel-owner');

Route::get('/register/ferry-operator', [RegisteredUserController::class, 'createFerryOperator']);
Route::post('/register/ferry-operator', [RegisteredUserController::class, 'storeFerryOperator'])->name('register.ferry-operator');

require __DIR__.'/auth.php';
