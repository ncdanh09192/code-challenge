<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoansApiController;
use App\Http\Controllers\ScheduledRepaymentsApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\RouteCompiler;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated route
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('loans')->group(function () {
        Route::resource('/', LoansApiController::class);
        Route::post('/approve-loan/{id}',[LoansApiController::class,'approve']);
    });

    Route::prefix('repayments')->group(function () {
        Route::post('/add/{id}',[ScheduledRepaymentsApiController::class,'addRepayment']);
    });
});
