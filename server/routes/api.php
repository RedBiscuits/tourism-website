<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/register', 'register')->name('register');
    });

Route::apiResource('tours', TourController::class);

Route::apiResource('reservations', ReservationController::class);

Route::apiResource('offers', OfferController::class);

Route::apiResource('options', OptionsController::class);

Route::apiResource('reviews', ReviewController::class);
Route::delete('reviews/force/{review}', [ReviewController::class, 'destroy'])
    ->name('reviews.destroy');








