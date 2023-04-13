<?php

use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Filament Routes
|--------------------------------------------------------------------------
|
| Here is where you can register filament routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "filament" middleware group. Now create something great!
|
*/

Route::domain(config('filament.domain'))->middleware(config('filament.middleware.base'))->group(function () {
    if ($loginPage = config('filament.auth.pages.newLogin')) {
        Route::get('/login', $loginPage)->name('login');
    }

    if ($requestPasswordReset = config('filament.auth.pages.request-password-reset')) {
        Route::get('/request-password-reset', $requestPasswordReset)->name('password.request');
    }

    if ($passwordReset = config('filament.auth.pages.password-reset')) {
        Route::get('/reset-password/{token}', $passwordReset)->name('password.reset');
    }
});

Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))->name('filament.')->group(function () {
        Route::prefix(config('filament.path'))->group(function () {

            Route::redirect('/admin/login', '/login')->name('auth.login');
        });
    });
