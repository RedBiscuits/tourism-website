<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\PaymentController;
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

Route::apiResource('invoices', InvoiceController::class)->middleware('auth:sanctum');

Route::apiResource('reviews', ReviewController::class);
Route::delete('reviews/force/{review}', [ReviewController::class, 'force_delete'])
    ->name('reviews.force_delete');

Route::controller(PaymentController::class)
    ->prefix('payment')
    ->group(function () {
        Route::post('/createInvoice', 'createInvoice');
        Route::post('/webhook_json', 'fawaterak_webhook');
        Route::get('/get-methods', 'getPaymentMethods');
    });
