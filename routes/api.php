<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




/* Authentications */


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/authenticate', [AuthController::class, 'authenticate']);
});

/* Custom Routes */

/* Tour Routes */
Route::post('/tours', [TripController::class, 'getPublishTours']);
Route::get('/tours/{tour}', [TripController::class, 'showTrip']);

/* Protected Routes */
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    
    /* Trip Routes */
    Route::post('/addTrip', [TripController::class, 'addTrip']);
    Route::post('/tour', [TripController::class, 'create']);
});


