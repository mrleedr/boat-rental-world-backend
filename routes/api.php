<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Authentications */
Route::post('/login', [AuthController::class, 'login'])->name('login');;
Route::post('/register', [AuthController::class, 'register'])->name('register');;
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'passwordReset'])->name('password.reset');

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/authenticate', [AuthController::class, 'authenticate']);
});

/* Social Login */
Route::get('google/auth', [AuthController::class, 'redirectToAuth']);
Route::get('auth/callback', [AuthController::class, 'handleAuthCallback']);


/* Custom Routes */

/* Tour Routes */
Route::post('/tours', [TripController::class, 'getPublishTours']);
Route::get('/tours/{tour}', [TripController::class, 'showTrip']);

/* Protected Routes */
Route::group(['middleware' => ['auth:sanctum']], function(){
    /* Trip Routes */
    Route::post('/addTrip', [TripController::class, 'addTrip']);
    Route::post('/tour', [TripController::class, 'create']);

    /* Booking Routes */
    Route::post('/inquiry', [BookingController::class, 'createInquiry']);
});





