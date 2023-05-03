<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/{type}')->group(function () {
    Route::post('/request-otp', [AuthController::class, 'requestOTP']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
})->where('type', 'email|mobile');

Route::middleware('auth:api')->group(function () {
    Route::post('point-claimed', [QrCodeController::class, 'index']);
});
