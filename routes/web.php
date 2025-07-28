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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

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

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/rooms', [App\Http\Controllers\AdminController::class, 'rooms'])->name('admin.rooms.index');
    Route::get('/admin/bookings', [App\Http\Controllers\AdminController::class, 'bookings'])->name('admin.bookings.index');
    Route::get('/admin/ferry/schedules', [App\Http\Controllers\AdminController::class, 'ferrySchedules'])->name('admin.ferry.schedules');
    Route::get('/admin/ferry/tickets', [App\Http\Controllers\AdminController::class, 'ferryTickets'])->name('admin.ferry.tickets');
    Route::get('/admin/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports.index');
});

// Route for visitors to assign ferry schedules to their tickets
Route::middleware(['auth', 'role:visitor'])->group(function () {
    Route::post('/ferry/tickets/assign-schedule', [DashboardController::class, 'assignFerrySchedule'])->name('ferry.tickets.assign-schedule');
    
    // Room booking routes
    Route::get('/rooms', [App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{id}', [App\Http\Controllers\RoomController::class, 'show'])->name('rooms.show');
    Route::post('/rooms/{id}/book', [App\Http\Controllers\RoomController::class, 'book'])->name('rooms.book');
    Route::post('/rooms/check-availability', [App\Http\Controllers\RoomController::class, 'checkAvailability'])->name('rooms.check-availability');
});

Route::get('/register/hotel-owner', [RegisteredUserController::class, 'createHotelOwner']);
Route::post('/register/hotel-owner', [RegisteredUserController::class, 'storeHotelOwner'])->name('register.hotel-owner');

Route::get('/register/ferry-operator', [RegisteredUserController::class, 'createFerryOperator']);
Route::post('/register/ferry-operator', [RegisteredUserController::class, 'storeFerryOperator'])->name('register.ferry-operator');

require __DIR__.'/auth.php';
