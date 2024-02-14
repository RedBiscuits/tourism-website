<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\OfferController;
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


Route::controller(ReviewController::class)
    ->prefix('reviews')
    ->name('review.')
    ->group(function () {
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{review}', 'update')->name('update')
            ->middleware('auth:sanctum');
        Route::delete('/{review}', 'destroy')->name('destroy')
            ->middleware('auth:sanctum');
        Route::get('/all', 'index')->name('index');
        Route::get('/{review}', 'show')->name('show');
    });


Route::controller(OfferController::class)
    ->prefix('offers')
    ->name('offer.')
    ->group(function () {

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::post('/update/{offer}', 'update')->name('update');
            Route::delete('/{offer}', 'destroy')->name('destroy');
        });

        Route::get('/all', 'index')->name('index');
        Route::get('/{offer}', 'show')->name('show');
    });


Route::controller(TourController::class)
    ->prefix('tours')
    ->name('tour.')
    ->group(function () {

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::post('/update/{tour}', 'update')->name('update');
            Route::delete('/{tour}', 'destroy')->name('destroy');
        });

        Route::get('/all', 'index')->name('index');
        Route::get('/{tour}', 'show')->name('show');
    });
