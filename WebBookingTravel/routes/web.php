<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\TourController as ClientTourController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use App\Http\Controllers\Client\AuthController;

// Client routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/tours', [ClientTourController::class, 'index'])->name('client.tours.index');
Route::get('/tours/{id}', [ClientTourController::class, 'show'])->name('client.tours.show');
Route::get('/category/{category}', [ClientTourController::class, 'category'])->name('client.tours.category');
Route::get('/booking', [ClientBookingController::class, 'index'])->name('client.booking');

// Auth (client)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// (Tùy chọn) Healthcheck chỉ trong local (giữ lại nếu cần monitor)
if (app()->environment('local')) {
    Route::get('/health', fn() => response()->json(['ok' => true, 'time' => now()->toDateTimeString()]));
}

// Các URL client khác nếu không khai báo sẽ trả 404 mặc định

// Admin routes (dashboard) - áp dụng middleware CheckAdmin
Route::prefix('admin')->name('admin.')->middleware('check.admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tours', [AdminTourController::class, 'index'])->name('tours.index');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/promotions', [AdminPromotionController::class, 'index'])->name('promotions.index');
});

// Không khai báo fallback để Laravel trả về 404 cho đường dẫn không tồn tại