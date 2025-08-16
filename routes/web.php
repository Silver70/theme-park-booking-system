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

Route::get('/visitor-dashboard', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('visitor-dashboard');

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
    Route::get('/ferry/operator/schedules', [DashboardController::class, 'ferrySchedules'])->name('ferry.schedules');
    Route::get('/ferry/operator/schedules/create', [DashboardController::class, 'createFerrySchedule'])->name('ferry.schedules.create');
    Route::post('/ferry/operator/schedules', [DashboardController::class, 'storeFerrySchedule'])->name('ferry.schedules.store');
    Route::get('/ferry/operator/schedules/{id}/edit', [DashboardController::class, 'editFerrySchedule'])->name('ferry.schedules.edit');
    Route::patch('/ferry/operator/schedules/{id}', [DashboardController::class, 'updateFerrySchedule'])->name('ferry.schedules.update');
    Route::patch('/ferry/operator/schedules/{id}/cancel', [DashboardController::class, 'cancelFerrySchedule'])->name('ferry.schedules.cancel');
    Route::get('/ferry/tickets', [DashboardController::class, 'ferryTickets'])->name('ferry.tickets');
    Route::get('/ferry/tickets/validate', [DashboardController::class, 'validateTicket'])->name('ferry.tickets.validate');
    Route::post('/ferry/tickets/validate', [DashboardController::class, 'submitValidation'])->name('ferry.tickets.validate.submit');
    Route::post('/ferry/tickets/issue', [DashboardController::class, 'issueFerryPass'])->name('ferry.tickets.issue');
    Route::get('/ferry/tickets/create', [DashboardController::class, 'createFerryTicket'])->name('ferry.tickets.create');
    Route::post('/ferry/tickets/create', [DashboardController::class, 'storeFerryTicket'])->name('ferry.tickets.store');
    
    // Ferry ticket request management
    Route::get('/ferry/requests', [DashboardController::class, 'ferryTicketRequests'])->name('ferry.requests');
    Route::patch('/ferry/requests/{id}/approve', [DashboardController::class, 'approveRequest'])->name('ferry.requests.approve');
    Route::patch('/ferry/requests/{id}/deny', [DashboardController::class, 'denyRequest'])->name('ferry.requests.deny');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Users Management
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.destroy');
    Route::patch('/admin/users/{user}/toggle-verification', [App\Http\Controllers\AdminController::class, 'toggleEmailVerification'])->name('admin.users.toggle-verification');
    
    // Rooms Management
    Route::get('/admin/rooms', [App\Http\Controllers\AdminController::class, 'rooms'])->name('admin.rooms.index');
    Route::get('/admin/rooms/{room}', [App\Http\Controllers\AdminController::class, 'showRoom'])->name('admin.rooms.show');
    
    // Bookings Management
    Route::get('/admin/bookings', [App\Http\Controllers\AdminController::class, 'bookings'])->name('admin.bookings.index');
    Route::get('/admin/bookings/{booking}', [App\Http\Controllers\AdminController::class, 'showBooking'])->name('admin.bookings.show');
    
    // Ferry Management
    Route::get('/admin/ferry/schedules', [App\Http\Controllers\AdminController::class, 'ferrySchedules'])->name('admin.ferry.schedules');
    Route::get('/admin/ferry/schedules/{schedule}', [App\Http\Controllers\AdminController::class, 'showFerrySchedule'])->name('admin.ferry.schedules.show');
    Route::get('/admin/ferry/tickets', [App\Http\Controllers\AdminController::class, 'ferryTickets'])->name('admin.ferry.tickets');
    Route::get('/admin/ferry/tickets/{ticket}', [App\Http\Controllers\AdminController::class, 'showFerryTicket'])->name('admin.ferry.tickets.show');
    
    Route::get('/admin/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports.index');
    Route::get('/admin/reports/analytics', [App\Http\Controllers\AdminController::class, 'viewAnalytics'])->name('admin.reports.analytics');
    Route::post('/admin/reports/export', [App\Http\Controllers\AdminController::class, 'exportReports'])->name('admin.reports.export');
    
    // Dashboard Images Management
    Route::resource('/admin/dashboard-images', App\Http\Controllers\AdminDashboardImageController::class, ['as' => 'admin']);
    Route::patch('/admin/dashboard-images/{dashboardImage}/toggle-status', [App\Http\Controllers\AdminDashboardImageController::class, 'toggleStatus'])->name('admin.dashboard-images.toggle-status');
    
    // Location Management
    Route::resource('/admin/locations', App\Http\Controllers\AdminLocationController::class, ['as' => 'admin']);
    Route::patch('/admin/locations/{location}/toggle-status', [App\Http\Controllers\AdminLocationController::class, 'toggleStatus'])->name('admin.locations.toggle-status');
});

// Route for visitors to assign ferry schedules to their tickets
Route::middleware(['auth', 'role:visitor'])->group(function () {
    Route::post('/ferry/tickets/assign-schedule', [DashboardController::class, 'assignFerrySchedule'])->name('ferry.tickets.assign-schedule');
    
    // Ferry ticket request routes for visitors
    Route::get('/ferry/schedules', [App\Http\Controllers\HomeController::class, 'ferrySchedules'])->name('visitor.ferry.schedules');
    Route::get('/ferry/request', [App\Http\Controllers\HomeController::class, 'requestTicket'])->name('ferry.request');
    Route::post('/ferry/request', [App\Http\Controllers\HomeController::class, 'submitRequest'])->name('ferry.submit-request');
    Route::get('/ferry/my-requests', [App\Http\Controllers\HomeController::class, 'myRequests'])->name('ferry.my-requests');
    
    // Room booking routes
    Route::get('/rooms', [App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{id}', [App\Http\Controllers\RoomController::class, 'show'])->name('rooms.show');
    Route::post('/rooms/{id}/book', [App\Http\Controllers\RoomController::class, 'book'])->name('rooms.book');
    Route::post('/rooms/check-availability', [App\Http\Controllers\RoomController::class, 'checkAvailability'])->name('rooms.check-availability');
    Route::get('/bookings/{id}/confirmation', [App\Http\Controllers\RoomController::class, 'confirmation'])->name('bookings.confirmation');
    
    // User bookings route
    Route::get('/my-bookings', [App\Http\Controllers\HomeController::class, 'myBookings'])->name('my.bookings');
    
    // Map route for visitors
    Route::get('/map', [App\Http\Controllers\MapController::class, 'index'])->name('map.index');
});

// Hotel staff routes
Route::middleware(['auth', 'role:hotel_staff'])->prefix('hotelstaff')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HotelStaffController::class, 'dashboard'])->name('hotelstaff.dashboard');
    Route::resource('rooms', App\Http\Controllers\HotelStaffRoomController::class, ['as' => 'hotelstaff']);
    Route::resource('bookings', App\Http\Controllers\HotelStaffBookingController::class, ['as' => 'hotelstaff']);
    Route::resource('promotions', App\Http\Controllers\HotelStaffPromotionController::class, ['as' => 'hotelstaff']);
    Route::get('/reports', [App\Http\Controllers\HotelStaffController::class, 'reports'])->name('hotelstaff.reports.index');
});

Route::get('/register/hotel-owner', [RegisteredUserController::class, 'createHotelOwner']);
Route::post('/register/hotel-owner', [RegisteredUserController::class, 'storeHotelOwner'])->name('register.hotel-owner');

Route::get('/register/ferry-operator', [RegisteredUserController::class, 'createFerryOperator']);
Route::post('/register/ferry-operator', [RegisteredUserController::class, 'storeFerryOperator'])->name('register.ferry-operator');

require __DIR__.'/auth.php';
