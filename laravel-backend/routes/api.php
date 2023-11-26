<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\RoomsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
    // Auth
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rooms
    Route::get('/rooms', [RoomsController::class, 'index']);

    // Room details
    Route::get('/rooms/{id}', [RoomsController::class, 'show']);

    // Room search
    Route::post('/rooms/search', [RoomsController::class, 'search']);

// Protected routes //
    // User //
    Route::group(['middleware'=> ['auth:sanctum']], function () {
        // Reservations
        Route::get('/reservations', [ReservationsController::class, 'index']);

        // Make reservation
        Route::post('/reservations', [ReservationsController::class, 'store']);

        // Delete reservation
        Route::delete('/reservations/{id}', [ReservationsController::class, 'destroy']);
    });

    // Manager //
    Route::group(['middleware'=> ['auth:sanctum','isManager']], function () {
        // Reservations
        Route::get('/reservations', [ReservationsController::class, 'indexManager']);

        // Update reservation
        Route::put('/reservations/{id}', [ReservationsController::class, 'update']);
    });