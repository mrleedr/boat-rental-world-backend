<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
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
Route::get('auth/google', [AuthController::class, 'redirectToAuth']);
Route::get('auth/callback', [AuthController::class, 'handleAuthCallback']);

/* Custom Routes */

/* User Routes */
Route::post('/user', [UserController::class, 'updateUser']);

/* Tour Routes */
Route::post('/tours', [TripController::class, 'getPublishedTours']);
Route::get('/tours/{tour}', [TripController::class, 'showTrip']);

/* Protected Routes */
Route::group(['middleware' => ['auth:sanctum']], function(){
    /* Trip Routes */
    Route::post('/addTrip', [TripController::class, 'addTrip']);
    Route::post('/tour', [TripController::class, 'create']);

    /* Booking Routes */
    Route::post('/inquiry', [BookingController::class, 'createInquiry']);
    Route::get('/inquiry/{inquiry}', [BookingController::class, 'getInquiry']);
    Route::get('/inquiry', [BookingController::class, 'getInquiries']);

    /* File Manager routes */
    Route::post('/upload-file', [FileController::class, 'uploadFile']);
});


/* Dropdown Routes */
Route::get('/dropdown/currency', [DropdownController::class, 'getCurrency']);
Route::get('/dropdown/timezone', [DropdownController::class, 'getTimezone']);
Route::get('/dropdown/language_spoken', [DropdownController::class, 'getLanguageSpoken']);
Route::get('/dropdown/trip_addon', [DropdownController::class, 'getTripAddon']);





