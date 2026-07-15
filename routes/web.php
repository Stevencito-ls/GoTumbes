<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DestinationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/nosotros', [PublicController::class, 'about'])->name('about');
Route::get('/servicios', [PublicController::class, 'services'])->name('services');
Route::get('/contacto', [PublicController::class, 'contact'])->name('contact');
Route::get('/destinos', [PublicController::class, 'destinations'])->name('destinations.index');
Route::get('/destinations/{id}', [PublicController::class, 'show'])->name('destinations.show');
Route::get('/destinations/{id}/checkout', [PublicController::class, 'checkout'])->name('destinations.checkout');
Route::post('/destinations/{id}/checkout', [PublicController::class, 'processCheckout'])->name('destinations.process_checkout');
Route::get('/reservations/{id}/voucher', [PublicController::class, 'downloadVoucher'])->name('destinations.voucher');
Route::get('/api/destinations', [PublicController::class, 'apiDestinations'])->name('api.destinations');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('destinations', DestinationController::class)->name('index', 'admin.destinations.index')->name('store', 'admin.destinations.store')->name('update', 'admin.destinations.update')->name('destroy', 'admin.destinations.destroy');
    
    // Firebase Users
    Route::get('/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{id}/role', [App\Http\Controllers\AdminUserController::class, 'updateRole'])->name('admin.users.update_role');

    // Reservations
    Route::get('/reservations', [App\Http\Controllers\AdminReservationController::class, 'index'])->name('admin.reservations.index');
    Route::post('/reservations/{id}/status', [App\Http\Controllers\AdminReservationController::class, 'updateStatus'])->name('admin.reservations.update_status');

    // Settings
    Route::get('/settings', [App\Http\Controllers\AdminSettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\AdminSettingsController::class, 'update'])->name('admin.settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/verify-email', [ProfileController::class, 'verifyEmail'])->name('profile.verify-email');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__.'/auth.php';
