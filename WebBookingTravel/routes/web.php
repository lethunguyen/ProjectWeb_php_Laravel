<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TourController;

Route::resource('categories', CategoryController::class);
Route::resource('tours', TourController::class)->except(['index','show']);
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('categories.index');
});    