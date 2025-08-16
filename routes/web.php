<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FerryScheduleController;
use App\Http\Controllers\FerryTicketController;
use App\Models\Room;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    $rooms = Room::all()->take(3);
    return view('welcome', compact('rooms'));
});

Route::get('/hotel/booking', function () {
    $rooms = Room::all();
    return view('hotel.booking', compact('rooms'));
})->name('hotel.booking');

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
    Route::get('/ferry/schedules', [FerryScheduleController::class, 'index'])->name('ferry.schedules');
    Route::get('/ferry/schedules/create', [FerryScheduleController::class, 'create'])->name('ferry.schedules.create');
    Route::post('/ferry/schedules', [FerryScheduleController::class, 'store'])->name('ferry.schedules.store');
    Route::get('/ferry/schedules/{id}/edit', [FerryScheduleController::class, 'edit'])->name('ferry.schedules.edit');
    Route::patch('/ferry/schedules/{id}', [FerryScheduleController::class, 'update'])->name('ferry.schedules.update');
    Route::patch('/ferry/schedules/{id}/cancel', [FerryScheduleController::class, 'cancel'])->name('ferry.schedules.cancel');
    Route::get('/ferry/tickets', [FerryTicketController::class, 'index'])->name('ferry.tickets');
    Route::get('/ferry/tickets/validate', [FerryTicketController::class, 'validateTicket'])->name('ferry.tickets.validate');
    Route::post('/ferry/tickets/validate', [FerryTicketController::class, 'submitValidation'])->name('ferry.tickets.validate.submit');
    Route::post('/ferry/tickets/issue', [FerryTicketController::class, 'issueFerryPass'])->name('ferry.tickets.issue');
    Route::get('/ferry/tickets/create', [FerryTicketController::class, 'create'])->name('ferry.tickets.create');
    Route::post('/ferry/tickets/create', [FerryTicketController::class, 'store'])->name('ferry.tickets.store');
});

Route::get('/register/hotel-owner', [RegisteredUserController::class, 'createHotelOwner']);
Route::post('/register/hotel-owner', [RegisteredUserController::class, 'storeHotelOwner'])->name('register.hotel-owner');

Route::get('/register/ferry-operator', [RegisteredUserController::class, 'createFerryOperator']);
Route::post('/register/ferry-operator', [RegisteredUserController::class, 'storeFerryOperator'])->name('register.ferry-operator');

require __DIR__.'/auth.php';
