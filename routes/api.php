<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/* Trip Routes */
/* This is to get the list of published tours available for booking */
Route::post('/tours', [TripController::class, 'getPublishTours']);
Route::get('/tours/{tour}', [TripController::class, 'showTrip']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    
    /* Trip Routes */
    Route::post('/addTrip', [TripController::class, 'addTrip']);
});
