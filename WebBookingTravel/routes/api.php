<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TourController as ApiTourController;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\BookingController as ApiBookingController;

Route::prefix('v1')->group(function () {
	Route::get('tours', [ApiTourController::class, 'index']);
	Route::get('tours/{id}', [ApiTourController::class, 'show']);
	Route::get('categories', [ApiCategoryController::class, 'index']);
	Route::get('bookings', [ApiBookingController::class, 'index']);
	Route::post('bookings', [ApiBookingController::class, 'store']);
});
